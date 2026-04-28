<?php

namespace App\Http\Controllers;

use App\Models\Addon;
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

    public function pesanan()
    {
        return view('frontend.pesanan');
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
}