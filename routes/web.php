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

Route::get('/products', 'ProductsController@index')->name('products.index');
Route::post('/products', 'ProductsController@store')->middleware('permission:create products')->name('products.store');
Route::get('/products/create', 'ProductsController@create')->middleware('permission:create products')->name('products.create');
Route::get('/products/{product}', 'ProductsController@show');
Route::delete('/products/{product}', 'ProductsController@destroy')->middleware('permission:delete products')->name('products.destroy');
Route::patch('/products/{product}', 'ProductsController@update')->middleware('permission:edit products')->name('products.update');

Route::get('/orders', 'GroupOrdersController@index')->name('group_orders.index');
Route::post('/orders', 'GroupOrdersController@store')->name('group_orders.store');
Route::get('/orders/create', 'GroupOrdersController@create')->middleware('permission:create group orders')->name('group_orders.create');
Route::get('/orders/{order}', 'GroupOrdersController@show')->name('group_orders.show');
Route::delete('/orders/{group_order}', 'GroupOrdersController@destroy')->middleware('permission:cancel group orders')->name('group_orders.destroy');
Route::patch('/orders/{group_order}', 'GroupOrdersController@update')->middleware('permission:edit group orders')->name('group_orders.update');

Route::get('/user/orders', 'UserOrdersController@index')->middleware('permission:create orders')->name('user_order.index');
Route::post('/user/orders', 'UserOrdersController@store')->middleware('permission:create orders')->name('user_order.store');
Route::get('/user/orders/create', 'UserOrdersController@create')->middleware('permission:create orders')->name('user_order.create');
Route::get('/user/orders/current', 'UserOrdersController@showCurrent')->middleware('permission:create orders')->name('user_order.showCurrent');
Route::get('/user/orders/{user_order}', 'UserOrdersController@show')->middleware('permission:create orders')->name('user_order.show');
Route::get('/user/orders/{user_order}/price', 'UserOrdersController@showPrice');
Route::delete('/user/orders/{user_order}', 'UserOrdersController@destroy')->middleware('permission:cancel orders')->name('user_order.destroy');
Route::patch('/user/orders/{user_order}', 'UserOrdersController@update')->middleware('permission:edit orders')->name('user_order.update');

Route::post('/cart/add/{product}', 'CartItemController@store')->middleware('permission:add items to cart');
Route::delete('/cart/item/{item}', 'CartItemController@destroy')->middleware('permission:remove items from cart');
Route::patch('/cart/item/{item}', 'CartItemController@update')->middleware('permission:edit cart contents');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
