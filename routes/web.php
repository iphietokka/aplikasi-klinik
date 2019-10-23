<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/', 'Admin\HomeController@index')->name('admin-home');

    Route::get('user', 'Admin\UserController@index')->name('user');
    Route::post('user/store', 'Admin\UserController@store')->name('user-store');
    Route::post('user/update/{id}', 'Admin\UserController@update')->name('user-update');
    Route::delete('user/{id}', 'Admin\UserController@destroy')->name('user-delete');

    Route::get('member', 'Admin\MemberController@index')->name('member');
    Route::post('member/store', 'Admin\MemberController@store')->name('member-store');
    Route::post('member/update/{id}', 'Admin\MemberController@update')->name('member-update');
    Route::delete('member/{id}', 'Admin\MemberController@destroy')->name('member-delete');

    Route::get('pegawai', 'Admin\PegawaiController@index')->name('pegawai');
    Route::post('pegawai/store', 'Admin\PegawaiController@store')->name('pegawai-store');
    Route::post('pegawai/update/{id}', 'Admin\PegawaiController@update')->name('pegawai-update');
    Route::delete('pegawai/{id}', 'Admin\PegawaiController@destroy')->name('pegawai-delete');

    Route::get('settings', 'Admin\SettingController@index')->name('settings');
    Route::post('settings/update/{id}', 'Admin\SettingController@update')->name('settings-update');

    Route::get('supplier', 'Admin\SupplierController@index')->name('supplier');
    Route::post('supplier/store', 'Admin\SupplierController@store')->name('supplier-store');
    Route::post('supplier/update/{id}', 'Admin\SupplierController@update')->name('supplier-update');
    Route::delete('supplier/{id}', 'Admin\SupplierController@destroy')->name('supplier-delete');

    Route::get('product', 'Admin\ProductController@index')->name('product');
    Route::get('product/show/{id}', 'Admin\ProductController@show')->name('product-show');
    Route::get('product/create', 'Admin\ProductController@create')->name('product-create');
    Route::post('product/store', 'Admin\ProductController@store')->name('product-store');
    Route::get('product/edit/{id}', 'Admin\ProductController@edit')->name('product-edit');
    Route::post('product/edit', 'Admin\ProductController@update')->name('product-update');
    Route::delete('product/{id}', 'Admin\ProductController@destroy')->name('product-delete');
    Route::post('product/update-price/{id}', 'Admin\ProductController@updatePrice')->name('product-update-price');
    Route::post('product/import', 'Admin\ProductController@import')->name('product-import');
    Route::post('product/correction/{id}', 'Admin\ProductController@stockCorrection')->name('product-stock-correction');
    Route::get('product/alert', 'Admin\ProductController@alert')->name('product-alert');

    Route::get('purchase', 'Admin\PurchaseController@index')->name('purchase');
    Route::get('purchase/create', 'Admin\PurchaseController@create')->name('purchase-create');
    Route::post('purchase/store', 'Admin\PurchaseController@store')->name('purchase-store');
    Route::get('purchase/edit/{id}', 'Admin\PurchaseController@edit')->name('purchase-edit');
    Route::match(array('PUT', 'PATCH'), '/purchase/{id}', 'Admin\PurchaseController@update')->name('purchase-update');
    Route::delete('purchase/{id}', 'Admin\PurchaseController@destroy')->name('purchase-delete');
    Route::get('purchase/details/{id}', 'Admin\PurchaseController@show')->name('purchase-show');
    Route::post('purchase/payment/{id}', 'Admin\PurchaseController@payment')->name('purchase-payment');;
    Route::post('purchase/received/{id}', 'Admin\PurchaseController@received')->name('purchase-received');
    Route::get('purchase/item-search', 'Admin\PurchaseController@search')->name('purchase-search');
    Route::get('purchase/invoice/{id}', 'Admin\PurchaseController@invoice')->name('purchase-invoice');
    Route::get('purchase/receipt/{id}', 'Admin\PurchaseController@printReceipt')->name('purchase-receipt');
});

//user protected routes
Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user'], function () {
    Route::get('/', 'User\HomeController@index')->name('user-home');
});
