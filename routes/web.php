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

// Posts
Route::get('posts/user', 'PostController@user')->name('posts.user');
Route::resource('posts', 'PostController')->except([
    'index'
]);

// Users
Route::group(['middleware' => ['auth']], function () {
    Route::get('profile', 'UserController@profile')->name('profile');
});
Route::resource('users', 'UserController')->except([
    'index'
]);

// Login
Route::group(['middleware' => ['guest']], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login')->name('login');
});
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Passwords
Route::group(['middleware' => ['guest']], function () {
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

// Countries
Route::get('/', 'CountryController@index')->name('home');
Route::get('{country}', 'CountryController@show')->name('countries.show');

// Regions
Route::get('{country}/{region}', 'RegionController@show')->name('regions.show');

// Groups
Route::get('groups/user', 'GroupController@user')->name('groups.user');
Route::get('{country}/{region}/{group}', 'GroupController@show')->name('groups.show');
