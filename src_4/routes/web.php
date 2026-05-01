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
// Route::get('/', [FrontendController::class, 'getberanda'])->name('frontend.index');
Route::get('/paket-custom', [FrontendController::class, 'paketCustom'])
    ->name('frontend.paket-custom');
Route::post('/paket-custom/add-to-cart', [BookingController::class, 'addCustomToCart'])
    ->middleware('auth')
    ->name('frontend.custom.add-to-cart');
// Route::get('/history', [FrontendController::class, 'history'])->name('frontend.history');
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
    
Route::get('/history', [FrontendController::class, 'history'])
    ->middleware('auth')
    ->name('frontend.history');
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


    // Route::delete('packages/destroy', 'PackagesController@massDestroy')->name('packages.massDestroy');
    // Route::post('packages/media', 'PackagesController@storeMedia')->name('packages.storeMedia');
    // Route::post('packages/ckmedia', 'PackagesController@storeCKEditorImages')->name('packages.storeCKEditorImages');
    // Route::resource('packages', 'PackagesController');

    Route::delete('packages/destroy', 'PackagesController@massDestroy')->name('packages.massDestroy');
    Route::resource('packages', 'PackagesController');

    Route::delete('package-items/destroy', 'PackageItemsController@massDestroy')->name('package-items.massDestroy');
    Route::resource('package-items', 'PackageItemsController')->parameters([
        'package-items' => 'packageItem',
    ]);
    
    Route::delete('addons/destroy', 'AddonController@massDestroy')->name('addons.massDestroy');
    Route::resource('addons', 'AddonController');

    Route::delete('custom-items/destroy', 'CustomItemController@massDestroy')->name('custom-items.massDestroy');
    Route::resource('custom-items', 'CustomItemController')->parameters([
        'custom-items' => 'customItem',
    ]);
    Route::delete('orders/destroy', 'OrderController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrderController');
    
    Route::delete('order-addons/destroy', 'OrderAddonController@massDestroy')->name('order-addons.massDestroy');
    Route::resource('order-addons', 'OrderAddonController')->parameters([
        'order-addons' => 'orderAddon',
    ]);
    
    Route::delete('order-items/destroy', 'OrderItemController@massDestroy')->name('order-items.massDestroy');
    Route::resource('order-items', 'OrderItemController')->parameters([
        'order-items' => 'orderItem',
    ]);

    Route::delete('berandas/destroy', 'BerandaController@massDestroy')->name('berandas.massDestroy');
    Route::resource('berandas', 'BerandaController')->parameters([
        'berandas' => 'beranda',
]);
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
