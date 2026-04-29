<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class FrontendController extends Controller
{
    public function home()
    {
        $packages = Package::with([
                'items' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('sort_order');
                }
            ])
            ->where('type', 'fixed')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $customPackage = Package::where('type', 'custom')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();

        $cartCount = count(session('booking_cart', []));

        return view('frontend.index', compact(
            'packages',
            'customPackage',
            'cartCount'
        ));
    }

    public function paket()
    {
        return view('frontend.paket-custom');
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    public function history()
    {
        return view('frontend.history');
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
            }
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
        return view('frontend.profile');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Email atau password salah.',
                    'errors'  => [
                        'email' => ['Email atau password salah.'],
                    ],
                ], 422);
            }

            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return $this->authResponse(
            $request,
            'Login berhasil.',
            route('frontend.index')
        );
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'                 => ['nullable', 'string', 'max:30'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'terms'                 => ['accepted'],
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'terms.accepted'        => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        $phone = $validated['phone'] ?? null;
        $phone = $phone ? preg_replace('/[^0-9+]/', '', $phone) : null;

        $userData = [
            'name'     => $validated['name'],
            'email'    => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ];

        if (Schema::hasColumn('users', 'phone')) {
            $userData['phone'] = $phone;
        }

        if (Schema::hasColumn('users', 'whatsapp')) {
            $userData['whatsapp'] = $phone;
        }

        $userModel = class_exists(\App\Models\User::class)
            ? \App\Models\User::class
            : \App\User::class;

        $user = $userModel::create($userData);

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
                'status'   => true,
                'message'  => 'Logout berhasil.',
                'redirect' => route('frontend.index'),
            ]);
        }

        return redirect()
            ->route('frontend.index')
            ->with('success', 'Logout berhasil.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'phone'    => ['nullable', 'string', 'max:30'],
            'alamat'   => ['nullable', 'string', 'max:255'],
            'kota'     => ['nullable', 'string', 'max:255'],
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
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'whatsapp' => $whatsapp,
            'phone'    => $phone,
            'alamat'   => $request->alamat,
            'kota'     => $request->kota,
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
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
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

    private function authResponse(Request $request, string $message, string $redirect)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status'   => true,
                'message'  => $message,
                'redirect' => $redirect,
            ]);
        }

        return redirect($redirect)->with('success', $message);
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
            ?? $firstItem?->snapshot['slug']
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
            'rating' => $order->review?->rating,
            'review' => $order->review?->review,
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
            'review' => $order->review?->comment ?? $order->review?->review,
        ];
    })->values();

    $cartCount = count(session('booking_cart', []));

    return view('frontend.pesanan', compact('ordersForJs', 'cartCount'));
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