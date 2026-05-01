<?php

declare(strict_types=1);

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MidtransPaymentController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'home'])
    ->name('frontend.index');

/*
|--------------------------------------------------------------------------
| Default Login Redirect Route
|--------------------------------------------------------------------------
| Middleware auth Laravel otomatis mencari route bernama "login"
| kalau user belum login. Jadi route ini wajib ada.
*/

Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route('frontend.index');
    }

    return redirect()
        ->route('frontend.index')
        ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.')
        ->with('open_auth_modal', 'login');
})->name('login');

Route::get('/paket-custom', [FrontendController::class, 'paketCustom'])
    ->name('frontend.paket-custom');

Route::get('/paket', [FrontendController::class, 'detail_paket'])
    ->name('frontend.paket');

/*
|--------------------------------------------------------------------------
| Cart & Booking
|--------------------------------------------------------------------------
*/

Route::get('/cart', [BookingController::class, 'index'])
    ->name('frontend.cart');

Route::post('/cart/add', [BookingController::class, 'add'])
    ->name('frontend.cart.add');

Route::delete('/cart/{key}', [BookingController::class, 'remove'])
    ->name('frontend.cart.remove');

Route::delete('/cart', [BookingController::class, 'clear'])
    ->name('frontend.cart.clear');

Route::post('/checkout', [BookingController::class, 'checkout'])
    ->name('frontend.checkout');

Route::post('/quick-check', [BookingController::class, 'quickCheck'])
    ->name('frontend.quick-check');

Route::get('/cart-count', [BookingController::class, 'count'])
    ->name('frontend.cart.count');

/*
|--------------------------------------------------------------------------
| Frontend Auth Routes
|--------------------------------------------------------------------------
*/

Route::post('/frontend-login', [FrontendController::class, 'login'])
    ->middleware('guest')
    ->name('frontend.login');

Route::post('/frontend-register', [FrontendController::class, 'register'])
    ->middleware('guest')
    ->name('frontend.register');

Route::post('/frontend-logout', [FrontendController::class, 'logout'])
    ->middleware('auth')
    ->name('frontend.logout');

/*
|--------------------------------------------------------------------------
| Password Reset Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::post('/forgot-password', [FrontendController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [FrontendController::class, 'showResetPasswordForm'])
        ->name('password.reset');

    Route::post('/reset-password', [FrontendController::class, 'resetPassword'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Frontend Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/paket-custom/add-to-cart', [BookingController::class, 'addCustomToCart'])
        ->name('frontend.custom.add-to-cart');

    Route::get('/pesanan', [FrontendController::class, 'pesanan'])
        ->name('frontend.pesanan');

    Route::get('/pesanan/{order}/invoice', [InvoiceController::class, 'download'])
        ->name('frontend.invoice.download');

    Route::post('/pesanan/{order}/pay', [MidtransPaymentController::class, 'pay'])
        ->name('frontend.midtrans.pay');

    Route::post('/pesanan/{order}/check-status', [MidtransPaymentController::class, 'checkStatus'])
        ->name('frontend.midtrans.check-status');

    Route::post('/pesanan/{order}/review', [ReviewController::class, 'store'])
        ->name('frontend.review.store');

    Route::get('/profile', [FrontendController::class, 'profile'])
        ->name('frontend.profile');

    Route::post('/profile/update', [FrontendController::class, 'updateProfile'])
        ->name('frontend.profile.update');

    Route::post('/profile/update-password', [FrontendController::class, 'updatePassword'])
        ->name('frontend.profile.updatePassword');

    Route::get('/history', [FrontendController::class, 'history'])
        ->name('frontend.history');
});

/*
|--------------------------------------------------------------------------
| Midtrans Notification
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/notification', [MidtransPaymentController::class, 'notification'])
    ->name('midtrans.notification');
