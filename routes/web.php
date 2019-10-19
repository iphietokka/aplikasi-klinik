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
});

//user protected routes
Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user'], function () {
    Route::get('/', 'User\HomeController@index')->name('user-home');
});
