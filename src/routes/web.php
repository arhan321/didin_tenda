<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

// ==================== FRONTEND ROUTES ====================

Route::get('/', [FrontendController::class, 'home'])->name('frontend.index');

Route::get('/paket-custom', [FrontendController::class, 'paket'])->name('frontend.paket-custom');

Route::get('/cart', [FrontendController::class, 'cart'])->name('frontend.cart');

Route::get('/history', [FrontendController::class, 'history'])->name('frontend.history');

Route::get('/paket', [FrontendController::class, 'detail_paket'])->name('frontend.paket');

Route::get('/pesanan', [FrontendController::class, 'pesanan'])->name('frontend.pesanan');

Route::get('/profile', [FrontendController::class, 'profile'])->name('frontend.profile');

// ==================== AUTH ROUTES ====================

Auth::routes(['register' => false]);

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});


// ==================== ADMIN ROUTES ====================

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['auth']
], function () {
    Route::get('/', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Vendors
    Route::delete('vendors/destroy', 'VendorController@massDestroy')->name('vendors.massDestroy');
    Route::post('vendors/media', 'VendorController@storeMedia')->name('vendors.storeMedia');
    Route::post('vendors/ckmedia', 'VendorController@storeCKEditorImages')->name('vendors.storeCKEditorImages');
    Route::resource('vendors', 'VendorController');

    // Homes
    Route::delete('homes/destroy', 'HomefController@massDestroy')->name('homes.massDestroy');
    Route::post('homes/media', 'HomefController@storeMedia')->name('homes.storeMedia');
    Route::post('homes/ckmedia', 'HomefController@storeCKEditorImages')->name('homes.storeCKEditorImages');
    Route::resource('homes', 'HomefController');

    // Tests
    Route::delete('tests/destroy', 'TestController@massDestroy')->name('tests.massDestroy');
    Route::post('tests/media', 'TestController@storeMedia')->name('tests.storeMedia');
    Route::post('tests/ckmedia', 'TestController@storeCKEditorImages')->name('tests.storeCKEditorImages');
    Route::resource('tests', 'TestController');
});


// ==================== PROFILE ROUTES ADMIN/AUTH ====================

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
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});