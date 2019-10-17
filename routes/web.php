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
});

//user protected routes
Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user'], function () {
    Route::get('/', 'User\HomeController@index')->name('user-home');
});
