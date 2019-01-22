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
Route::get('/products/create', 'ProductsController@create');
Route::get('/products/{product}', 'ProductsController@show');
Route::post('/products', 'ProductsController@store');
Route::delete('/products/{product}', 'ProductsController@destroy');
Route::patch('/products/{product}', 'ProductsController@update');

Route::get('/orders', 'GroupOrdersController@index');
Route::get('/orders/create', 'GroupOrdersController@create');
Route::get('/orders/{order}', 'GroupOrdersController@show');
Route::post('/orders', 'GroupOrdersController@store');
Route::delete('/orders/{order}', 'GroupOrdersController@destroy');
Route::patch('/orders/{order}', 'GroupOrdersController@update');


Route::get('/user/order', 'UserOrdersController@create');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
