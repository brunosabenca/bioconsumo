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

Route::get('/', 'ProductsController@index');

Route::get('/products', 'ProductsController@index');
Route::post('/products', 'ProductsController@store');
Route::get('/products/create', 'ProductsController@create');
Route::get('/products/{product}', 'ProductsController@show');
Route::delete('/products/{product}', 'ProductsController@destroy');
Route::patch('/products/{product}', 'ProductsController@update');

Route::get('/orders', 'GroupOrdersController@index');
Route::post('/orders', 'GroupOrdersController@store');
Route::get('/orders/create', 'GroupOrdersController@create');
Route::get('/orders/{order}', 'GroupOrdersController@show');
Route::delete('/orders/{group_order}', 'GroupOrdersController@destroy');
Route::patch('/orders/{order}', 'GroupOrdersController@update');

Route::get('/user/orders', 'UserOrdersController@index');
Route::post('/user/orders', 'UserOrdersController@store');
Route::get('/user/orders/create', 'UserOrdersController@create');
Route::get('/user/orders/{user_order}', 'UserOrdersController@show');
Route::delete('/user/orders/{user_order}', 'UserOrdersController@destroy');

Route::post('/cart/add/{product}', 'CartController@store');
Route::get('/cart', 'CartController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
