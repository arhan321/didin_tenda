<?php
use App\Http\Controllers\frontend;
use App\Http\Controllers\Admin\OrderController;

// Route::get('/error', function () {
//     return view('frontend.error');
// });

// Route::get('/', 'frontend@home')->name('frontend.index');
Route::get('/contact', 'frontend@post')->name('frontend.contact');
Route::post('/contact', [frontend::class, 'post']);
Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
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

    //position
    Route::delete('positions/destroy', 'PositionController@massDestroy')->name('positions.massDestroy');
    Route::post('positions/media', 'PositionController@storeMedia')->name('positions.storeMedia');
    Route::post('positions/ckmedia', 'PositionController@storeCKEditorImages')->name('positions.storeCKEditorImages');
    Route::resource('positions', 'PositionController');
  
    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');


    // CETAK INOVICE
    Route::delete('orders/destroy', 'OrderController@massDestroy')->name('orders.massDestroy');
    Route::post('orders/media', 'OrderController@storeMedia')->name('orders.storeMedia');
    Route::post('orders/ckmedia', 'OrderController@storeCKEditorImages')->name('orders.storeCKEditorImages');
    Route::resource('orders', 'OrderController');
    
    //vendor
    Route::delete('vendors/destroy', 'VendorController@massDestroy')->name('vendors.massDestroy');
    Route::post('vendors/media', 'VendorController@storeMedia')->name('vendors.storeMedia');
    Route::post('vendors/ckmedia', 'VendorController@storeCKEditorImages')->name('vendors.storeCKEditorImages');
    Route::resource('vendors', 'VendorController');

    //categoryproducts
    Route::delete('categoryproducts/destroy', 'CategoryProductController@massDestroy')->name('categoryproducts.massDestroy');
    Route::post('categoryproducts/media', 'CategoryProductController@storeMedia')->name('categoryproducts.storeMedia');
    Route::post('categoryproducts/ckmedia', 'CategoryProductController@storeCKEditorImages')->name('categoryproducts.storeCKEditorImages');
    Route::resource('categoryproducts', 'CategoryProductController');


    //surat jalan DO
    Route::delete('deliveryorders/destroy', 'DeliveryOrderController@massDestroy')->name('deliveryorders.massDestroy');
    Route::post('deliveryorders/media', 'DeliveryOrderController@storeMedia')->name('deliveryorders.storeMedia');
    Route::post('deliveryorders/ckmedia', 'DeliveryOrderController@storeCKEditorImages')->name('deliveryorders.storeCKEditorImages');
    Route::resource('deliveryorders', 'DeliveryOrderController');

    //homes
    Route::delete('homes/destroy', 'HomefController@massDestroy')->name('homes.massDestroy');
    Route::post('homes/media', 'HomefController@storeMedia')->name('homes.storeMedia');
    Route::post('homes/ckmedia', 'HomefController@storeCKEditorImages')->name('homes.storeCKEditorImages');
    Route::resource('homes', 'HomefController');

    //abouts
    Route::delete('abouts/destroy', 'AboutController@massDestroy')->name('abouts.massDestroy');
    Route::post('abouts/media', 'AboutController@storeMedia')->name('abouts.storeMedia');
    Route::post('abouts/ckmedia', 'AboutController@storeCKEditorImages')->name('abouts.storeCKEditorImages');
    Route::resource('abouts', 'AboutController');

    //abouts2
    Route::delete('about2s/destroy', 'About2Controller@massDestroy')->name('about2s.massDestroy');
    Route::post('about2s/media', 'About2Controller@storeMedia')->name('about2s.storeMedia');
    Route::post('about2s/ckmedia', 'About2Controller@storeCKEditorImages')->name('about2s.storeCKEditorImages');
    Route::resource('about2s', 'About2Controller');

    //services
    Route::delete('services/destroy', 'ServiceController@massDestroy')->name('services.massDestroy');
    Route::post('services/media', 'ServiceController@storeMedia')->name('services.storeMedia');
    Route::post('services/ckmedia', 'ServiceController@storeCKEditorImages')->name('services.storeCKEditorImages');
    Route::resource('services', 'ServiceController');

    //productfs
    Route::delete('productfs/destroy', 'ProductFController@massDestroy')->name('productfs.massDestroy');
    Route::post('productfs/media', 'ProductFController@storeMedia')->name('productfs.storeMedia');
    Route::post('productfs/ckmedia', 'ProductFController@storeCKEditorImages')->name('productfs.storeCKEditorImages');
    Route::resource('productfs', 'ProductFController');

    //teams
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::post('teams/media', 'TeamController@storeMedia')->name('teams.storeMedia');
    Route::post('teams/ckmedia', 'TeamController@storeCKEditorImages')->name('teams.storeCKEditorImages');
    Route::resource('teams', 'TeamController');

    //clientfs
    Route::delete('clientfs/destroy', 'ClientfController@massDestroy')->name('clientfs.massDestroy');
    Route::post('clientfs/media', 'ClientfController@storeMedia')->name('clientfs.storeMedia');
    Route::post('clientfs/ckmedia', 'ClientfController@storeCKEditorImages')->name('clientfs.storeCKEditorImages');
    Route::resource('clientfs', 'ClientfController');

    //settings
    Route::delete('settings/destroy', 'SettingController@massDestroy')->name('settings.massDestroy');
    Route::post('settings/media', 'SettingController@storeMedia')->name('settings.storeMedia');
    Route::post('settings/ckmedia', 'SettingController@storeCKEditorImages')->name('settings.storeCKEditorImages');
    Route::resource('settings', 'SettingController');

    //socialmedias
    Route::delete('socialmedias/destroy', 'SocialMediaController@massDestroy')->name('socialmedias.massDestroy');
    Route::post('socialmedias/media', 'SocialMediaController@storeMedia')->name('socialmedias.storeMedia');
    Route::post('socialmedias/ckmedia', 'SocialMediaController@storeCKEditorImages')->name('socialmedias.storeCKEditorImages');
    Route::resource('socialmedias', 'SocialMediaController');

    //contacts
    Route::delete('contacts/destroy', 'ContactController@massDestroy')->name('contacts.massDestroy');
    Route::post('contacts/media', 'ContactController@storeMedia')->name('contacts.storeMedia');
    Route::post('contacts/ckmedia', 'ContactController@storeCKEditorImages')->name('contacts.storeCKEditorImages');
    Route::resource('contacts', 'ContactController');
    // Route::match(['get', 'post'], '/', [frontend::class, 'home'])->name('home');

    //reimburs
    Route::delete('reimburs/destroy', 'ReimbursController@massDestroy')->name('reimburs.massDestroy');
    Route::post('reimburs/media', 'ReimbursController@storeMedia')->name('reimburs.storeMedia');
    Route::post('reimburs/ckmedia', 'ReimbursController@storeCKEditorImages')->name('reimburs.storeCKEditorImages');
    Route::resource('reimburs', 'ReimbursController');

    // Productbarangs
    Route::delete('productbarangs/destroy', 'ProductBarangController@massDestroy')->name('productbarangs.massDestroy');
    Route::post('productbarangs/media', 'ProductBarangController@storeMedia')->name('productbarangs.storeMedia');
    Route::post('productbarangs/ckmedia', 'ProductBarangController@storeCKEditorImages')->name('productbarangs.storeCKEditorImages');
    Route::resource('productbarangs', 'ProductBarangController');

    // ordersbarang
    Route::delete('orderbarangs/destroy', 'OrdersBarangController@massDestroy')->name('orderbarangs.massDestroy');
    Route::post('orderbarangs/media', 'OrdersBarangController@storeMedia')->name('orderbarangs.storeMedia');
    Route::post('orderbarangs/ckmedia', 'OrdersBarangController@storeCKEditorImages')->name('orderbarangs.storeCKEditorImages');
    Route::resource('orderbarangs', 'OrdersBarangController');

    // ordersbarang
    Route::delete('deliveryorderbarang/destroy', 'DeliveryOrderBarangController@massDestroy')->name('deliveryorderbarang.massDestroy');
    Route::post('deliveryorderbarang/media', 'DeliveryOrderBarangController@storeMedia')->name('deliveryorderbarang.storeMedia');
    Route::post('deliveryorderbarang/ckmedia', 'DeliveryOrderBarangController@storeCKEditorImages')->name('deliveryorderbarang.storeCKEditorImages');
    Route::resource('deliveryorderbarang', 'DeliveryOrderBarangController');

    // ordersbarang
    Route::delete('deliveryordertech/destroy', 'DeliveryOrderTechController@massDestroy')->name('deliveryordertech.massDestroy');
    Route::post('deliveryordertech/media', 'DeliveryOrderTechController@storeMedia')->name('deliveryordertech.storeMedia');
    Route::post('deliveryordertech/ckmedia', 'DeliveryOrderTechController@storeCKEditorImages')->name('deliveryordertech.storeCKEditorImages');
    Route::resource('deliveryordertech', 'DeliveryOrderTechController');

    // cetakinvoicedgpro
    Route::delete('invoicedgpros/destroy', 'InvoicedgproController@massDestroy')->name('invoicedgpros.massDestroy');
    Route::post('invoicedgpros/media', 'InvoicedgproController@storeMedia')->name('invoicedgpros.storeMedia');
    Route::post('invoicedgpros/ckmedia', 'InvoicedgproController@storeCKEditorImages')->name('invoicedgpros.storeCKEditorImages');
    Route::resource('invoicedgpros', 'InvoicedgproController');

    // cetakinvoicedgpro
    Route::delete('tests/destroy', 'TestController@massDestroy')->name('tests.massDestroy');
    Route::post('tests/media', 'TestController@storeMedia')->name('tests.storeMedia');
    Route::post('tests/ckmedia', 'TestController@storeCKEditorImages')->name('tests.storeCKEditorImages');
    Route::resource('tests', 'TestController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
