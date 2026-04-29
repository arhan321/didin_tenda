<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MidtransPaymentController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'home'])->name('frontend.index');
Route::get('/paket-custom', [FrontendController::class, 'paket'])->name('frontend.paket-custom');
Route::get('/history', [FrontendController::class, 'history'])->name('frontend.history');
Route::get('/paket', [FrontendController::class, 'detail_paket'])->name('frontend.paket');
Route::get('/pesanan', [FrontendController::class, 'pesanan'])
    ->middleware('auth')
    ->name('frontend.pesanan');
Route::get('/pesanan/{order}/invoice', [InvoiceController::class, 'download'])
    ->middleware('auth')
    ->name('frontend.invoice.download');

Route::get('/cart', [BookingController::class, 'index'])->name('frontend.cart');
Route::post('/cart/add', [BookingController::class, 'add'])->name('frontend.cart.add');
Route::delete('/cart/{key}', [BookingController::class, 'remove'])->name('frontend.cart.remove');
Route::delete('/cart', [BookingController::class, 'clear'])->name('frontend.cart.clear');
Route::post('/checkout', [BookingController::class, 'checkout'])->name('frontend.checkout');
Route::post('/quick-check', [BookingController::class, 'quickCheck'])->name('frontend.quick-check');
Route::get('/cart-count', [BookingController::class, 'count'])->name('frontend.cart.count');

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

Route::get('/profile', [FrontendController::class, 'profile'])
    ->middleware('auth')
    ->name('frontend.profile');

Route::post('/profile/update', [FrontendController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('frontend.profile.update');

Route::post('/profile/update-password', [FrontendController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('frontend.profile.updatePassword');

Route::middleware('auth')->group(function () {
    Route::post('/pesanan/{order}/pay', [MidtransPaymentController::class, 'pay'])
        ->name('frontend.midtrans.pay');

    Route::post('/pesanan/{order}/check-status', [MidtransPaymentController::class, 'checkStatus'])
        ->name('frontend.midtrans.check-status');
});

Route::post('/pesanan/{order}/review', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('frontend.review.store');

// Notification/callback Midtrans lewat web.php
Route::post('/midtrans/notification', [MidtransPaymentController::class, 'notification'])
    ->name('midtrans.notification');
    
/*
|--------------------------------------------------------------------------
| Laravel Auth Routes
|--------------------------------------------------------------------------
| Tetap dipakai untuk fitur forgot password.
| Register Laravel default dimatikan karena register memakai modal custom.
*/

Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Redirect /home
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['auth']
], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    Route::delete('vendors/destroy', 'VendorController@massDestroy')->name('vendors.massDestroy');
    Route::post('vendors/media', 'VendorController@storeMedia')->name('vendors.storeMedia');
    Route::post('vendors/ckmedia', 'VendorController@storeCKEditorImages')->name('vendors.storeCKEditorImages');
    Route::resource('vendors', 'VendorController');

    Route::delete('homes/destroy', 'HomefController@massDestroy')->name('homes.massDestroy');
    Route::post('homes/media', 'HomefController@storeMedia')->name('homes.storeMedia');
    Route::post('homes/ckmedia', 'HomefController@storeCKEditorImages')->name('homes.storeCKEditorImages');
    Route::resource('homes', 'HomefController');

    Route::delete('tests/destroy', 'TestController@massDestroy')->name('tests.massDestroy');
    Route::post('tests/media', 'TestController@storeMedia')->name('tests.storeMedia');
    Route::post('tests/ckmedia', 'TestController@storeCKEditorImages')->name('tests.storeCKEditorImages');
    Route::resource('tests', 'TestController');
});

/*
|--------------------------------------------------------------------------
| Profile Password Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => 'profile',
    'as' => 'profile.',
    'namespace' => 'Auth',
    'middleware' => ['auth']
], function () {
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroyProfile')->name('password.destroyProfile');
    }
});
