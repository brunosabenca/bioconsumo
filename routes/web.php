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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);


Route::get('/products', 'ProductsController@index');
Route::get('/products/create', 'ProductsController@create');
Route::get('/products/{product}', 'ProductsController@show');
Route::post('/products', 'ProductsController@store');
Route::delete('/products/{product}', 'ProductsController@destroy');
Route::patch('/products/{product}', 'ProductsController@update');
