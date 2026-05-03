<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Addon;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Transaction;
use Illuminate\Http\Request;
use App\Mail\InvoicePaidMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

final class MidtransPaymentController extends Controller
{
    /**
     * Membuat / mengambil Snap Token Midtrans.
     * Dipanggil saat user klik tombol "Lanjut Bayar".
     */
    public function pay(Order $order)
    {
        $this->authorizeCustomerOrder($order);

        if ($order->payment_status === 'paid') {
            $this->sendInvoiceEmailIfPaid($order);

            return response()->json([
                'status' => true,
                'already_paid' => true,
                'message' => 'Pesanan ini sudah lunas.',
            ]);
        }

        try {
            $payment = DB::transaction(function () use ($order) {
                return $this->createOrReuseSnapPayment($order);
            });

            return response()->json([
                'status' => true,
                'already_paid' => false,
                'snap_token' => $payment->snap_token,
                'redirect_url' => $payment->redirect_url,
                'message' => 'Snap token berhasil dibuat.',
            ]);
        } catch (Throwable $error) {
            Log::error('Gagal membuat pembayaran Midtrans.', [
                'order_id' => $order->id,
                'invoice_number' => $order->invoice_number,
                'error' => $error->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat pembayaran: '.$error->getMessage(),
            ], 500);
        }
    }

    /**
     * Mengecek status pembayaran ke Midtrans.
     * Dipanggil saat user klik tombol "Check Status".
     */
    public function checkStatus(Order $order)
    {
        $this->authorizeCustomerOrder($order);

        $payment = $order->payment;

        if (! $payment || ! $payment->midtrans_order_id) {
            return response()->json([
                'status' => false,
                'message' => 'Data pembayaran belum ditemukan. Klik Lanjut Bayar terlebih dahulu.',
            ], 404);
        }

        $this->setupMidtrans();

        try {
            $statusResponse = Transaction::status($payment->midtrans_order_id);
            $statusData = json_decode(json_encode($statusResponse), true);

            $this->syncPaymentStatus($order, $payment, $statusData);

            /*
             * Kirim invoice email setelah status disinkronkan.
             * Aman dipanggil berkali-kali karena dicegah oleh invoice_sent_at.
             */
            $this->sendInvoiceEmailIfPaid($order);

            $freshOrder = $order->fresh();
            $freshPayment = $payment->fresh();

            return response()->json([
                'status' => true,
                'message' => 'Status pembayaran berhasil diperbarui.',
                'order_status' => $freshOrder->status,
                'payment_status' => $freshOrder->payment_status,
                'midtrans' => [
                    'transaction_status' => $freshPayment->transaction_status,
                    'fraud_status' => $freshPayment->fraud_status,
                    'payment_type' => $freshPayment->payment_type,
                    'bank' => $freshPayment->bank,
                    'va_number' => $freshPayment->va_number,
                ],
            ]);
        } catch (Throwable $error) {
            Log::error('Gagal mengecek status pembayaran Midtrans.', [
                'order_id' => $order->id,
                'invoice_number' => $order->invoice_number,
                'error' => $error->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Gagal mengecek status pembayaran: '.$error->getMessage(),
            ], 500);
        }
    }

    /**
     * Callback notification dari Midtrans.
     * URL ini dimasukkan ke dashboard Midtrans.
     */
    public function notification(Request $request)
    {
        $payload = $request->all();

        $midtransOrderId = $payload['order_id'] ?? null;

        if (! $midtransOrderId) {
            return response()->json([
                'status' => false,
                'message' => 'order_id tidak ditemukan.',
            ], 400);
        }

        $payment = Payment::where('midtrans_order_id', $midtransOrderId)->first();

        if (! $payment) {
            return response()->json([
                'status' => false,
                'message' => 'Payment tidak ditemukan.',
            ], 404);
        }

        $order = $payment->order;

        if (! $order) {
            return response()->json([
                'status' => false,
                'message' => 'Order tidak ditemukan.',
            ], 404);
        }

        if (! $this->isValidMidtransSignature($payload)) {
            return response()->json([
                'status' => false,
                'message' => 'Signature tidak valid.',
            ], 403);
        }

        try {
            $this->syncPaymentStatus($order, $payment, $payload);

            /*
             * Kirim invoice email dari jalur callback Midtrans.
             * Ini penting kalau callback Midtrans datang lebih dulu daripada tombol Check Status.
             */
            $this->sendInvoiceEmailIfPaid($order);

            return response()->json([
                'status' => true,
                'message' => 'Notification processed.',
            ]);
        } catch (Throwable $error) {
            Log::error('Gagal memproses notification Midtrans.', [
                'midtrans_order_id' => $midtransOrderId,
                'order_id' => $order->id ?? null,
                'error' => $error->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Gagal memproses notification: '.$error->getMessage(),
            ], 500);
        }
    }

    /**
     * Buat Snap Token baru atau gunakan token lama jika masih pending.
     */
    private function createOrReuseSnapPayment(Order $order): Payment
    {
        $this->setupMidtrans();

        $order->load([
            'items',
            'addons',
            'payment',
        ]);

        $existingPayment = $order->payment;

        if (
            $existingPayment &&
            $existingPayment->snap_token &&
            in_array($existingPayment->payment_status, ['pending', 'unpaid'], true)
        ) {
            return $existingPayment;
        }

        $midtransOrderId = $this->generateMidtransOrderId($order);

        $params = $this->buildSnapParams($order, $midtransOrderId);

        $snapTransaction = Snap::createTransaction($params);

        $payment = Payment::updateOrCreate(
            [
                'order_id' => $order->id,
            ],
            [
                'payment_gateway' => 'midtrans',

                'midtrans_order_id' => $midtransOrderId,
                'transaction_id' => null,
                'snap_token' => $snapTransaction->token,
                'redirect_url' => $snapTransaction->redirect_url,

                'gross_amount' => (int) $order->total_price,
                'currency' => 'IDR',

                'payment_type' => null,
                'bank' => null,
                'va_number' => null,
                'permata_va_number' => null,
                'bill_key' => null,
                'biller_code' => null,
                'pdf_url' => null,

                'transaction_status' => 'pending',
                'fraud_status' => null,
                'status_code' => null,
                'status_message' => null,

                'payment_status' => 'pending',
                'raw_response' => json_decode(json_encode($snapTransaction), true),

                'paid_at' => null,
                'expired_at' => null,
                'cancelled_at' => null,
            ]
        );

        $order->update([
            'payment_status' => 'pending',
        ]);

        return $payment;
    }

    /**
     * Parameter yang dikirim ke Midtrans Snap.
     */
    private function buildSnapParams(Order $order, string $midtransOrderId): array
    {
        return [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $order->total_price,
            ],

            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email ?: Auth::user()?->email,
                'phone' => $order->customer_phone,

                'billing_address' => [
                    'first_name' => $order->customer_name,
                    'email' => $order->customer_email ?: Auth::user()?->email,
                    'phone' => $order->customer_phone,
                    'address' => $order->event_address,
                    'country_code' => 'IDN',
                ],

                'shipping_address' => [
                    'first_name' => $order->customer_name,
                    'phone' => $order->customer_phone,
                    'address' => $order->event_address,
                    'country_code' => 'IDN',
                ],
            ],

            'item_details' => $this->buildItemDetails($order),

            'callbacks' => [
                'finish' => route('frontend.pesanan'),
            ],
        ];
    }

    /**
     * Detail item Midtrans harus totalnya sama dengan gross_amount.
     */
    private function buildItemDetails(Order $order): array
    {
        $items = [];

        foreach ($order->items as $item) {
            $items[] = [
                'id' => 'ITEM-'.$item->id,
                'price' => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name' => mb_substr($item->name, 0, 50),
            ];
        }

        foreach ($order->addons as $addon) {
            $items[] = [
                'id' => 'ADDON-'.$addon->id,
                'price' => (int) $addon->price,
                'quantity' => (int) $addon->quantity,
                'name' => mb_substr($addon->name, 0, 50),
            ];
        }

        if ((int) $order->shipping_fee > 0) {
            $items[] = [
                'id' => 'SHIPPING-'.$order->id,
                'price' => (int) $order->shipping_fee,
                'quantity' => 1,
                'name' => 'Biaya Pengiriman',
            ];
        }

        $itemsTotal = collect($items)->sum(function ($item) {
            return (int) $item['price'] * (int) $item['quantity'];
        });

        $orderTotal = (int) $order->total_price;

        if ($itemsTotal !== $orderTotal) {
            $difference = $orderTotal - $itemsTotal;

            if ($difference !== 0) {
                $items[] = [
                    'id' => 'ADJUST-'.$order->id,
                    'price' => $difference,
                    'quantity' => 1,
                    'name' => 'Penyesuaian Total',
                ];
            }
        }

        return $items;
    }

    /**
     * Sinkron status Midtrans ke tabel payments dan orders.
     */
    private function syncPaymentStatus(Order $order, Payment $payment, array $statusData): void
    {
        $transactionStatus = $statusData['transaction_status'] ?? null;
        $fraudStatus = $statusData['fraud_status'] ?? null;

        $paymentStatus = $this->mapPaymentStatus($transactionStatus, $fraudStatus);

        DB::transaction(function () use (
            $order,
            $payment,
            $statusData,
            $paymentStatus,
            $transactionStatus,
            $fraudStatus
        ) {
            $previousPaymentStatus = $order->payment_status;
            $previousOrderStatus = $order->status;

            $vaData = $this->extractVaData($statusData);

            $paymentUpdate = [
                'transaction_id' => $statusData['transaction_id'] ?? $payment->transaction_id,

                'payment_type' => $statusData['payment_type'] ?? $payment->payment_type,
                'bank' => $vaData['bank'] ?? $payment->bank,
                'va_number' => $vaData['va_number'] ?? $payment->va_number,

                'permata_va_number' => $statusData['permata_va_number'] ?? $payment->permata_va_number,
                'bill_key' => $statusData['bill_key'] ?? $payment->bill_key,
                'biller_code' => $statusData['biller_code'] ?? $payment->biller_code,
                'pdf_url' => $statusData['pdf_url'] ?? $payment->pdf_url,

                'transaction_status' => $transactionStatus ?? $payment->transaction_status,
                'fraud_status' => $fraudStatus,
                'status_code' => $statusData['status_code'] ?? null,
                'status_message' => $statusData['status_message'] ?? null,

                'payment_status' => $paymentStatus,
                'raw_response' => $statusData,
            ];

            if ($paymentStatus === 'paid') {
                $paymentUpdate['paid_at'] = $payment->paid_at ?? now();
            }

            if ($paymentStatus === 'expired') {
                $paymentUpdate['expired_at'] = $payment->expired_at ?? now();
            }

            if ($paymentStatus === 'cancelled' || $paymentStatus === 'failed') {
                $paymentUpdate['cancelled_at'] = $payment->cancelled_at ?? now();
            }

            $payment->update($paymentUpdate);

            $orderUpdate = [
                'payment_status' => $paymentStatus,
            ];

            if ($paymentStatus === 'paid') {
                $orderUpdate['status'] = 'confirmed';
                $orderUpdate['paid_at'] = $order->paid_at ?? now();
                $orderUpdate['confirmed_at'] = $order->confirmed_at ?? now();
            }

            if ($paymentStatus === 'pending') {
                $orderUpdate['payment_status'] = 'pending';
            }

            if ($paymentStatus === 'expired') {
                $orderUpdate['status'] = 'expired';
                $orderUpdate['payment_status'] = 'expired';
                $orderUpdate['cancelled_at'] = $order->cancelled_at ?? now();
                $orderUpdate['cancelled_reason'] = $order->cancelled_reason ?? 'Pembayaran expired dari Midtrans.';
            }

            if (in_array($paymentStatus, ['failed', 'cancelled'], true)) {
                $orderUpdate['status'] = 'cancelled';
                $orderUpdate['payment_status'] = $paymentStatus;
                $orderUpdate['cancelled_at'] = $order->cancelled_at ?? now();
                $orderUpdate['cancelled_reason'] = $order->cancelled_reason ?? 'Pembayaran gagal atau dibatalkan.';
            }

            if ($paymentStatus === 'refunded') {
                $orderUpdate['payment_status'] = 'refunded';
            }

            // Jika pembayaran gagal/expired/cancelled, kembalikan stok add-on yang sebelumnya
            // sudah dikurangi saat booking. Guard ini mencegah stok dikembalikan berkali-kali
            // ketika callback/check-status dipanggil ulang.
            if (
                in_array($paymentStatus, ['expired', 'failed', 'cancelled'], true) &&
                ! in_array($previousPaymentStatus, ['expired', 'failed', 'cancelled'], true) &&
                ! in_array($previousOrderStatus, ['expired', 'cancelled'], true)
            ) {
                $this->restoreAddonStocksFromOrder($order);
            }

            $order->update($orderUpdate);
        });
    }

    private function restoreAddonStocksFromOrder(Order $order): void
    {
        $order->loadMissing('addons');

        foreach ($order->addons as $orderAddon) {
            $addonId = (int) ($orderAddon->addon_id ?? 0);
            $quantity = (int) ($orderAddon->quantity ?? 0);

            if ($addonId <= 0 || $quantity <= 0) {
                continue;
            }

            $addon = Addon::query()
                ->whereKey($addonId)
                ->whereNotNull('stock')
                ->lockForUpdate()
                ->first();

            if (! $addon) {
                continue;
            }

            $addon->increment('stock', $quantity);
        }
    }

    /**
     * Kirim email invoice jika pembayaran sudah paid.
     *
     * Catatan:
     * - Email hanya dikirim satu kali.
     * - Pencegahan double-send memakai kolom orders.invoice_sent_at.
     * - Jika email gagal dikirim, invoice_sent_at dikosongkan lagi supaya bisa dicoba ulang.
     */
    private function sendInvoiceEmailIfPaid(Order $order): void
    {
        $freshOrder = $order->fresh([
            'user',
            'package',
            'items',
            'addons',
            'payment',
        ]);

        if (! $freshOrder) {
            return;
        }

        if ($freshOrder->payment_status !== 'paid') {
            return;
        }

        if (! empty($freshOrder->invoice_sent_at)) {
            return;
        }

        $email = $freshOrder->customer_email ?: $freshOrder->user?->email;

        if (! $email) {
            Log::warning('Invoice email tidak dikirim karena email pelanggan kosong.', [
                'order_id' => $freshOrder->id,
                'invoice_number' => $freshOrder->invoice_number,
            ]);

            return;
        }

        /*
         * Lock sederhana agar kalau check-status dan callback Midtrans masuk bersamaan,
         * email tidak terkirim dobel.
         */
        $reserved = Order::where('id', $freshOrder->id)
            ->where('payment_status', 'paid')
            ->whereNull('invoice_sent_at')
            ->update([
                'invoice_sent_at' => now(),
            ]);

        if ($reserved === 0) {
            return;
        }

        try {
            $orderForEmail = Order::with([
                'user',
                'package',
                'items',
                'addons',
                'payment',
            ])->find($freshOrder->id);

            if (! $orderForEmail) {
                throw new Exception('Order tidak ditemukan saat akan mengirim invoice email.');
            }

            Mail::to($email)->send(new InvoicePaidMail($orderForEmail));

            Log::info('Invoice email berhasil dikirim.', [
                'order_id' => $orderForEmail->id,
                'invoice_number' => $orderForEmail->invoice_number,
                'email' => $email,
            ]);
        } catch (Throwable $error) {
            Order::where('id', $freshOrder->id)->update([
                'invoice_sent_at' => null,
            ]);

            Log::error('Gagal mengirim invoice email.', [
                'order_id' => $freshOrder->id,
                'invoice_number' => $freshOrder->invoice_number,
                'email' => $email,
                'error' => $error->getMessage(),
            ]);
        }
    }

    /**
     * Mapping status Midtrans ke status internal sistem.
     */
    private function mapPaymentStatus(?string $transactionStatus, ?string $fraudStatus): string
    {
        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept' ? 'paid' : 'pending';
        }

        if ($transactionStatus === 'settlement') {
            return 'paid';
        }

        if ($transactionStatus === 'pending') {
            return 'pending';
        }

        if ($transactionStatus === 'expire') {
            return 'expired';
        }

        if (in_array($transactionStatus, ['deny', 'failure'], true)) {
            return 'failed';
        }

        if ($transactionStatus === 'cancel') {
            return 'cancelled';
        }

        if (in_array($transactionStatus, ['refund', 'partial_refund'], true)) {
            return 'refunded';
        }

        return 'pending';
    }

    /**
     * Ambil VA bank dan nomor VA dari response Midtrans.
     */
    private function extractVaData(array $statusData): array
    {
        $result = [
            'bank' => null,
            'va_number' => null,
        ];

        if (isset($statusData['va_numbers'][0])) {
            $result['bank'] = $statusData['va_numbers'][0]['bank'] ?? null;
            $result['va_number'] = $statusData['va_numbers'][0]['va_number'] ?? null;
        }

        if (isset($statusData['permata_va_number'])) {
            $result['bank'] = 'permata';
            $result['va_number'] = $statusData['permata_va_number'];
        }

        return $result;
    }

    /**
     * ID transaksi khusus Midtrans.
     * Jangan pakai invoice_number karena ada karakter slash (/).
     */
    private function generateMidtransOrderId(Order $order): string
    {
        return 'DT-'.$order->id.'-'.now()->format('YmdHis');
    }

    /**
     * Setup config Midtrans dari config/midtrans.php.
     */
    private function setupMidtrans(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized = (bool) config('midtrans.is_sanitized', true);
        Config::$is3ds = (bool) config('midtrans.is_3ds', true);
    }

    /**
     * Pastikan user cuma bisa bayar pesanan miliknya.
     */
    private function authorizeCustomerOrder(Order $order): void
    {
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
    }

    /**
     * Validasi signature notification dari Midtrans.
     */
    private function isValidMidtransSignature(array $payload): bool
    {
        if (! isset(
            $payload['order_id'],
            $payload['status_code'],
            $payload['gross_amount'],
            $payload['signature_key']
        )) {
            return false;
        }

        $serverKey = config('midtrans.server_key');

        $signature = hash(
            'sha512',
            $payload['order_id'].
            $payload['status_code'].
            $payload['gross_amount'].
            $serverKey
        );

        return hash_equals($signature, $payload['signature_key']);
    }
}
