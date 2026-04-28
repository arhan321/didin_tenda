<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $cart = session('booking_cart', []);
        $totals = $this->calculateCartTotals($cart);
        $cartCount = count($cart);

        return view('frontend.cart', compact('cart', 'totals', 'cartCount'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'package_id' => ['required', 'exists:packages,id'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_location_name' => ['required', 'string', 'max:255'],
            'event_address' => ['required', 'string'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
            'addons' => ['nullable', 'array'],
            'addons.*.quantity' => ['nullable', 'integer', 'min:0'],
            'distance_km' => ['nullable', 'numeric', 'min:0'],
            'shipping_fee' => ['nullable', 'integer', 'min:0'],
            'checkout_now' => ['nullable'],
        ]);

        $package = Package::with('items')
            ->where('id', $validated['package_id'])
            ->where('type', 'fixed')
            ->where('is_active', true)
            ->firstOrFail();

        if ($this->isDateBooked($package->id, $validated['event_date'])) {
            return back()
                ->withInput()
                ->with('error', 'Tanggal tersebut sudah dibooking untuk paket ini. Silakan pilih tanggal lain.');
        }

        $selectedAddons = $this->prepareSelectedAddons($request->input('addons', []));
        $subtotalAddons = collect($selectedAddons)->sum('total_price');

        $distanceKm = $request->filled('distance_km')
            ? (float) $request->distance_km
            : $this->estimateDistanceFromAddress($validated['event_address']);

        $shippingFee = $request->filled('shipping_fee')
            ? (int) $request->shipping_fee
            : $this->calculateShippingFee($distanceKm);

        $subtotalPackage = (int) $package->price;
        $totalPrice = $subtotalPackage + $subtotalAddons + $shippingFee;

        $cartItem = [
            'key' => (string) Str::uuid(),
            'order_type' => 'package',

            'package' => [
                'id' => $package->id,
                'slug' => $package->slug,
                'name' => $package->name,
                'price' => (int) $package->price,
                'price_unit' => $package->price_unit,
                'main_image' => $package->main_image,
                'short_description' => $package->short_description,
            ],

            'customer_name' => $validated['customer_name'],
            'customer_phone' => $this->normalizePhone($validated['customer_phone']),
            'customer_email' => $validated['customer_email'] ?? Auth::user()?->email,

            'event_date' => $validated['event_date'],
            'event_location_name' => $validated['event_location_name'],
            'event_address' => $validated['event_address'],

            'distance_km' => $distanceKm,
            'shipping_fee' => $shippingFee,

            'addons' => $selectedAddons,

            'subtotal_package' => $subtotalPackage,
            'subtotal_custom' => 0,
            'subtotal_addons' => $subtotalAddons,
            'total_price' => $totalPrice,

            'notes' => $validated['notes'] ?? null,
        ];

        if ($request->boolean('checkout_now')) {
            if (! Auth::check()) {
                $cart = session('booking_cart', []);
                $cart[$cartItem['key']] = $cartItem;
                session(['booking_cart' => $cart]);

                return redirect()
                    ->route('frontend.index')
                    ->with('error', 'Silakan login terlebih dahulu untuk melanjutkan booking dan pembayaran.');
            }

            $order = DB::transaction(function () use ($cartItem) {
                return $this->createOrderFromCartItem($cartItem);
            });

            return redirect()
                ->route('frontend.pesanan')
                ->with('success', 'Booking berhasil dibuat. Silakan lanjutkan pembayaran untuk invoice ' . $order->invoice_number . '.');
        }

        $cart = session('booking_cart', []);
        $cart[$cartItem['key']] = $cartItem;

        session(['booking_cart' => $cart]);

        return redirect()
            ->route('frontend.cart')
            ->with('success', 'Paket berhasil ditambahkan ke keranjang.');
    }

    public function remove(string $key)
    {
        $cart = session('booking_cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['booking_cart' => $cart]);
        }

        return redirect()
            ->route('frontend.cart')
            ->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('booking_cart');

        return redirect()
            ->route('frontend.cart')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function checkout()
    {
        if (! Auth::check()) {
            return redirect()
                ->route('frontend.index')
                ->with('error', 'Silakan login terlebih dahulu untuk melanjutkan pembayaran.');
        }

        $cart = session('booking_cart', []);

        if (count($cart) === 0) {
            return redirect()
                ->route('frontend.cart')
                ->with('error', 'Keranjang masih kosong.');
        }

        $orders = DB::transaction(function () use ($cart) {
            $createdOrders = [];

            foreach ($cart as $cartItem) {
                if ($this->isDateBooked($cartItem['package']['id'], $cartItem['event_date'])) {
                    throw new \Exception('Tanggal ' . $cartItem['event_date'] . ' sudah dibooking. Silakan hapus item tersebut dan pilih tanggal lain.');
                }

                $createdOrders[] = $this->createOrderFromCartItem($cartItem);
            }

            return $createdOrders;
        });

        session()->forget('booking_cart');

        return redirect()
            ->route('frontend.pesanan')
            ->with('success', count($orders) . ' booking berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    public function quickCheck(Request $request)
    {
        $validated = $request->validate([
            'package_id' => ['required', 'exists:packages,id'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $package = Package::where('id', $validated['package_id'])
            ->where('is_active', true)
            ->firstOrFail();

        $available = ! $this->isDateBooked($package->id, $validated['event_date']);

        return response()->json([
            'status' => true,
            'available' => $available,
            'message' => $available
                ? 'Tanggal tersedia. Silakan lanjut booking.'
                : 'Tanggal sudah dibooking. Silakan pilih tanggal lain.',
            'package' => [
                'id' => $package->id,
                'slug' => $package->slug,
                'name' => $package->name,
                'price' => $package->price,
            ],
        ]);
    }

    public function count()
    {
        return response()->json([
            'count' => count(session('booking_cart', [])),
        ]);
    }

    private function prepareSelectedAddons(array $addonsInput): array
    {
        $selected = [];

        foreach ($addonsInput as $addonId => $addonData) {
            $quantity = (int) ($addonData['quantity'] ?? 0);

            if ($quantity <= 0) {
                continue;
            }

            $addon = Addon::where('id', $addonId)
                ->where('is_active', true)
                ->first();

            if (! $addon) {
                continue;
            }

            if ($addon->stock !== null && $quantity > $addon->stock) {
                $quantity = $addon->stock;
            }

            $selected[] = [
                'addon_id' => $addon->id,
                'name' => $addon->name,
                'detail' => $addon->detail,
                'unit' => $addon->unit,
                'quantity' => $quantity,
                'price' => (int) $addon->price,
                'total_price' => (int) $addon->price * $quantity,
                'snapshot' => [
                    'slug' => $addon->slug,
                    'image' => $addon->image,
                    'icon' => $addon->icon,
                    'is_quantity_based' => $addon->is_quantity_based,
                ],
            ];
        }

        return $selected;
    }

    private function createOrderFromCartItem(array $cartItem): Order
    {
        $order = Order::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'user_id' => Auth::id(),
            'package_id' => $cartItem['package']['id'] ?? null,
            'order_type' => $cartItem['order_type'] ?? 'package',

            'customer_name' => $cartItem['customer_name'],
            'customer_phone' => $cartItem['customer_phone'],
            'customer_email' => $cartItem['customer_email'] ?? Auth::user()?->email,

            'event_date' => $cartItem['event_date'],
            'event_location_name' => $cartItem['event_location_name'],
            'event_address' => $cartItem['event_address'],

            'distance_km' => $cartItem['distance_km'] ?? null,
            'shipping_fee' => $cartItem['shipping_fee'] ?? 0,

            'subtotal_package' => $cartItem['subtotal_package'] ?? 0,
            'subtotal_custom' => $cartItem['subtotal_custom'] ?? 0,
            'subtotal_addons' => $cartItem['subtotal_addons'] ?? 0,
            'total_price' => $cartItem['total_price'] ?? 0,

            'status' => 'waiting_payment',
            'payment_status' => 'unpaid',
            'payment_deadline' => now()->addDay(),

            'notes' => $cartItem['notes'] ?? null,
        ]);

        $order->items()->create([
            'item_type' => 'package',
            'source_id' => $cartItem['package']['id'] ?? null,
            'name' => $cartItem['package']['name'] ?? 'Paket',
            'unit' => $cartItem['package']['price_unit'] ?? 'paket',
            'quantity' => 1,
            'price' => $cartItem['subtotal_package'] ?? 0,
            'total_price' => $cartItem['subtotal_package'] ?? 0,
            'snapshot' => $cartItem['package'],
        ]);

        foreach (($cartItem['addons'] ?? []) as $addon) {
            $order->addons()->create([
                'addon_id' => $addon['addon_id'] ?? null,
                'name' => $addon['name'],
                'detail' => $addon['detail'] ?? null,
                'unit' => $addon['unit'] ?? null,
                'quantity' => $addon['quantity'],
                'price' => $addon['price'],
                'total_price' => $addon['total_price'],
                'snapshot' => $addon['snapshot'] ?? null,
            ]);
        }

        return $order;
    }

    private function calculateCartTotals(array $cart): array
    {
        return [
            'subtotal_package' => collect($cart)->sum('subtotal_package'),
            'subtotal_custom' => collect($cart)->sum('subtotal_custom'),
            'subtotal_addons' => collect($cart)->sum('subtotal_addons'),
            'shipping_fee' => collect($cart)->sum('shipping_fee'),
            'grand_total' => collect($cart)->sum('total_price'),
        ];
    }

    private function isDateBooked(int $packageId, string $eventDate): bool
    {
        return Order::where('package_id', $packageId)
            ->whereDate('event_date', $eventDate)
            ->whereNotIn('status', ['cancelled', 'expired'])
            ->exists();
    }

    private function generateInvoiceNumber(): string
    {
        do {
            $number = 'INV/' . now()->format('Y') . '/' .
                str_pad((string) (Order::whereYear('created_at', now()->year)->count() + 1), 4, '0', STR_PAD_LEFT) .
                '-' . strtoupper(Str::random(4));
        } while (Order::where('invoice_number', $number)->exists());

        return $number;
    }

    private function estimateDistanceFromAddress(string $address): float
    {
        $address = strtolower(trim($address));

        if ($address === '') {
            return 0;
        }

        $hash = 0;

        for ($i = 0; $i < strlen($address); $i++) {
            $hash = (($hash << 5) - $hash) + ord($address[$i]);
        }

        $distance = (abs($hash) % 50) + 1;

        if (str_contains($address, 'tangerang') || str_contains($address, 'jakarta')) {
            return (float) min($distance, 15);
        }

        if (
            str_contains($address, 'bogor') ||
            str_contains($address, 'bekasi') ||
            str_contains($address, 'depok')
        ) {
            return (float) min($distance, 30);
        }

        return (float) $distance;
    }

    private function calculateShippingFee(float $distanceKm): int
    {
        if ($distanceKm <= 10) {
            return 0;
        }

        if ($distanceKm <= 30) {
            return (int) ceil($distanceKm - 10) * 5000;
        }

        return (20 * 5000) + ((int) ceil($distanceKm - 30) * 10000);
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/[^0-9+]/', '', $phone);
    }
}