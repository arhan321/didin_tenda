<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\Addon;
use App\Models\Order;
use App\Models\Review;
use App\Models\Beranda;
use App\Models\Package;
use App\Models\CustomItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

final class FrontendController extends Controller
{
    public function home()
    {
        $packages = Package::with(['items'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $reviews = Review::with([
            'user',
            'order.package',
        ])
            ->where('is_visible', true)
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed')
                    ->where('payment_status', 'paid');
            })
            ->latest()
            ->take(6)
            ->get();

        $cartCount = count(session('booking_cart', []));

        return view('frontend.index', compact(
            'packages',
            'reviews',
            'cartCount'
        ));
    }

    public function paket()
    {
        // Fallback: kalau masih ada route lama yang memanggil method paket(),
        // tetap arahkan ke method paketCustom() supaya data customItems/addons terkirim ke view.
        return $this->paketCustom();
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    public function detail_paket(Request $request)
    {
        $slug = $request->query('id');

        if (! $slug) {
            return redirect()
                ->route('frontend.index')
                ->with('error', 'Paket tidak ditemukan.');
        }

        $package = Package::with([
            'items' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('sort_order');
            },
        ])
            ->where('slug', $slug)
            ->where('type', 'fixed')
            ->where('is_active', true)
            ->firstOrFail();

        $addons = Addon::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $cartCount = count(session('booking_cart', []));

        return view('frontend.paket', compact(
            'package',
            'addons',
            'cartCount'
        ));
    }

    public function profile()
    {
        $cartCount = count(session('booking_cart', []));

        return view('frontend.profile', compact('cartCount'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('frontend.index')
                ->withErrors($validator)
                ->with('open_auth_modal', 'login')
                ->withInput($request->only('email'));
        }

        $email = mb_strtolower(mb_trim((string) $request->email));
        $password = (string) $request->password;
        $remember = $request->boolean('remember');

        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return redirect()
                ->route('frontend.index')
                ->with('error', 'Email atau password salah.')
                ->with('open_auth_modal', 'login')
                ->withInput($request->only('email'));
        }

        Auth::login($user, $remember);

        $request->session()->regenerate();

        return redirect()
            ->intended(route('frontend.index'))
            ->with('success', 'Login berhasil.');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms' => ['accepted'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('frontend.index')
                ->withErrors($validator)
                ->with('open_auth_modal', 'register')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $validated = $validator->validated();

        $phone = $validated['phone'] ?? null;
        $phone = $phone ? preg_replace('/[^0-9+]/', '', $phone) : null;

        $userData = [
            'name' => $validated['name'],
            'email' => mb_strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ];

        if (Schema::hasColumn('users', 'phone')) {
            $userData['phone'] = $phone;
        }

        if (Schema::hasColumn('users', 'whatsapp')) {
            $userData['whatsapp'] = $phone;
        }

        $user = User::create($userData);

        Auth::login($user);

        $request->session()->regenerate();

        return $this->authResponse(
            $request,
            'Register berhasil. Anda sudah login.',
            route('frontend.profile')
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Logout berhasil.',
                'redirect' => route('frontend.index'),
            ]);
        }

        return redirect()
            ->route('frontend.index')
            ->with('success', 'Logout berhasil.');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('frontend.index')
                ->withErrors($validator)
                ->with('open_auth_modal', 'forgot')
                ->withInput($request->only('email'));
        }

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (Throwable $exception) {
            return redirect()
                ->route('frontend.index')
                ->with('error', 'Link reset password belum bisa dikirim. Silakan cek konfigurasi MAIL di file .env.')
                ->with('open_auth_modal', 'forgot')
                ->withInput($request->only('email'));
        }

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()
                ->route('frontend.index')
                ->with('success', 'Link reset password berhasil dikirim ke email Anda. Silakan cek inbox atau spam.');
        }

        return redirect()
            ->route('frontend.index')
            ->withErrors([
                'email' => 'Email tidak ditemukan atau link reset belum bisa dikirim.',
            ])
            ->with('open_auth_modal', 'forgot')
            ->withInput($request->only('email'));
    }

public function showResetPasswordForm(Request $request, string $token)
{
    return redirect()->route('frontend.index', [
        'reset_token' => $token,
        'email' => $request->query('email'),
    ]);
}

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'token.required' => 'Token reset password tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('frontend.index', [
                    'reset_token' => $request->token,
                    'email' => $request->email,
                ])
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('frontend.index')
                ->with('success', 'Password berhasil direset. Silakan login kembali.');
        }

        return redirect()
            ->route('frontend.index', [
                'reset_token' => $request->token,
                'email' => $request->email,
            ])
            ->withErrors([
                'email' => 'Token reset password tidak valid, sudah expired, atau email tidak sesuai.',
            ])
            ->withInput($request->only('email'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'phone' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'kota' => ['nullable', 'string', 'max:255'],
            'kode_pos' => ['nullable', 'numeric'],
        ]);

        $whatsapp = $request->whatsapp
            ? preg_replace('/[^0-9+]/', '', $request->whatsapp)
            : null;

        $phone = $request->phone
            ? preg_replace('/[^0-9+]/', '', $request->phone)
            : null;

        $kodePos = $request->filled('kode_pos')
            ? $request->kode_pos
            : null;

        $user->update([
            'name' => $request->name,
            'email' => mb_strtolower($request->email),
            'whatsapp' => $whatsapp,
            'phone' => $phone,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'kode_pos' => $kodePos,
        ]);

        return redirect()
            ->route('frontend.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('frontend.profile')
            ->with('success', 'Password berhasil diperbarui.');
    }

    public function pesanan()
    {
        if (! Auth::check()) {
            return redirect()
                ->route('frontend.index')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat pesanan Anda.');
        }

        $orders = Order::with([
            'package',
            'items',
            'addons',
            'review',
            'payment',
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $ordersForJs = $orders->map(function ($order) {
            $firstItem = $order->items->first();

            $packageName = $order->package?->name
                ?? $firstItem?->name
                ?? 'Paket';

            $packageSlug = $order->package?->slug
                ?? data_get($firstItem?->snapshot, 'slug')
                ?? null;

            $statusCode = $this->normalizeOrderStatusForFrontend($order->status, $order->payment_status);
            $statusLabel = $this->getOrderStatusLabel($statusCode);

            return [
                'id' => $order->id,
                'orderId' => $order->invoice_number,
                'orderDate' => optional($order->created_at)->toIso8601String(),
                'status' => $statusLabel,
                'statusCode' => $statusCode,
                'paymentStatus' => $order->payment_status,
                'invoiceUrl' => route('frontend.invoice.download', $order->id),
                'paymentUrl' => route('frontend.midtrans.pay', $order->id),
                'paymentCheckUrl' => route('frontend.midtrans.check-status', $order->id),
                'reviewUrl' => route('frontend.review.store', $order->id),

                'items' => [
                    [
                        'id' => $packageSlug,
                        'name' => $packageName,
                        'price' => (int) $order->total_price,
                        'basePrice' => (int) $order->subtotal_package,
                        'date' => optional($order->event_date)->format('Y-m-d'),
                        'location' => $order->event_location_name,
                        'fullAddress' => $order->event_address,
                        'customerName' => $order->customer_name,
                        'customerPhone' => $order->customer_phone,
                        'customerEmail' => $order->customer_email,
                        'shippingFee' => (int) $order->shipping_fee,
                        'distance' => (float) $order->distance_km,
                        'latitude' => $order->event_latitude,
                        'longitude' => $order->event_longitude,

                        'addons' => $order->addons->map(function ($addon) {
                            return [
                                'id' => $addon->addon_id,
                                'name' => $addon->name,
                                'detail' => $addon->detail,
                                'unit' => $addon->unit,
                                'quantity' => (int) $addon->quantity,
                                'price' => (int) $addon->price,
                                'totalPrice' => (int) $addon->total_price,
                            ];
                        })->values(),
                    ],
                ],

                'subtotalPackage' => (int) $order->subtotal_package,
                'subtotalCustom' => (int) $order->subtotal_custom,
                'subtotalAddons' => (int) $order->subtotal_addons,
                'shippingFee' => (int) $order->shipping_fee,
                'totalPrice' => (int) $order->total_price,

                'paymentDeadline' => optional($order->payment_deadline)->toIso8601String(),
                'paidAt' => optional($order->paid_at)->toIso8601String(),
                'notes' => $order->notes,

                'rating' => $order->review?->rating,
                'review' => $order->review?->review,
            ];
        })->values();

        $cartCount = count(session('booking_cart', []));

        return view('frontend.pesanan', compact('ordersForJs', 'cartCount'));
    }

    public function history()
    {
        if (! Auth::check()) {
            return redirect()
                ->route('frontend.index')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat history booking Anda.');
        }

        $orders = Order::with([
            'package',
            'items',
            'addons',
            'review',
            'payment',
        ])
            ->where('user_id', Auth::id())
            ->where(function ($query) {
                $query->whereIn('status', ['completed', 'cancelled', 'expired'])
                    ->orWhereIn('payment_status', ['cancelled', 'expired', 'failed']);
            })
            ->latest()
            ->get();

        $historyForJs = $orders->map(function ($order) {
            $firstItem = $order->items->first();

            $packageName = $order->package?->name
                ?? $firstItem?->name
                ?? 'Paket';

            $packageSlug = $order->package?->slug
                ?? data_get($firstItem?->snapshot, 'slug')
                ?? null;

            $statusCode = $order->status === 'completed' ? 'completed' : 'cancelled';

            $statusLabel = match ($order->status) {
                'completed' => 'Selesai',
                'expired' => 'Expired',
                default => 'Dibatalkan',
            };

            return [
                'id' => $order->id,
                'orderId' => $order->invoice_number,
                'invoiceUrl' => route('frontend.invoice.download', $order->id),

                'orderDate' => optional($order->created_at)->toIso8601String(),
                'status' => $statusLabel,
                'statusCode' => $statusCode,
                'paymentStatus' => $order->payment_status,

                'items' => [
                    [
                        'id' => $packageSlug,
                        'name' => $packageName,
                        'price' => (int) $order->total_price,
                        'basePrice' => (int) $order->subtotal_package,
                        'date' => optional($order->event_date)->format('Y-m-d'),
                        'location' => $order->event_location_name,
                        'fullAddress' => $order->event_address,
                        'customerName' => $order->customer_name,
                        'customerPhone' => $order->customer_phone,
                        'customerEmail' => $order->customer_email,
                        'shippingFee' => (int) $order->shipping_fee,
                        'distance' => (float) $order->distance_km,

                        'addons' => $order->addons->map(function ($addon) {
                            return [
                                'id' => $addon->addon_id,
                                'name' => $addon->name,
                                'detail' => $addon->detail,
                                'unit' => $addon->unit,
                                'quantity' => (int) $addon->quantity,
                                'price' => (int) $addon->price,
                                'totalPrice' => (int) $addon->total_price,
                            ];
                        })->values(),
                    ],
                ],

                'subtotalPackage' => (int) $order->subtotal_package,
                'subtotalCustom' => (int) $order->subtotal_custom,
                'subtotalAddons' => (int) $order->subtotal_addons,
                'shippingFee' => (int) $order->shipping_fee,
                'totalPrice' => (int) $order->total_price,

                'cancelledReason' => $order->cancelled_reason,
                'notes' => $order->notes,

                'rating' => $order->review?->rating,
                'review' => $order->review?->review,
            ];
        })->values();

        $cartCount = count(session('booking_cart', []));

        return view('frontend.history', compact('historyForJs', 'cartCount'));
    }

    public function paketCustom()
    {
        $customItems = CustomItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $addons = Addon::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $cartCount = count(session('booking_cart', []));

        return view('frontend.paket-custom', compact(
            'customItems',
            'addons',
            'cartCount'
        ));
    }

    public function getberanda()
    {
        $beranda = Beranda::all();

        return view('frontend.index', compact('beranda'));
    }

    private function authResponse(Request $request, string $message, string $redirect)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => $message,
                'redirect' => $redirect,
            ]);
        }

        return redirect($redirect)->with('success', $message);
    }

    private function normalizeOrderStatusForFrontend(?string $status, ?string $paymentStatus): string
    {
        if ($status === 'cancelled' || $paymentStatus === 'cancelled' || $paymentStatus === 'expired') {
            return 'cancelled';
        }

        if ($status === 'completed') {
            return 'completed';
        }

        if ($status === 'ongoing') {
            return 'ongoing';
        }

        if ($status === 'processing' || $status === 'processed') {
            return 'processing';
        }

        if ($status === 'confirmed' || $paymentStatus === 'paid') {
            return 'confirmed';
        }

        return 'waiting_payment';
    }

    private function getOrderStatusLabel(string $statusCode): string
    {
        return match ($statusCode) {
            'waiting_payment' => 'Menunggu Pembayaran',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Pesanan Diproses',
            'ongoing' => 'Pelaksanaan Acara',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Menunggu Pembayaran',
        };
    }
}
