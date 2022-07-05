<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\IndexController@index');
Route::get('/lookBook', 'App\Http\Controllers\IndexController@lookbook');
Route::get('/address', 'App\Http\Controllers\IndexController@address');
Route::get('/catalog/{id}', 'App\Http\Controllers\CatalogController@catalogItem');
Route::get('/catalog/{uri}', 'App\Http\Controllers\CatalogController@catalogItemByUri');
Route::get('/contacts', 'App\Http\Controllers\IndexController@contacts');


Route::get('/shipping', 'App\Http\Controllers\IndexController@shipping');
Route::get('/catalog', 'App\Http\Controllers\CatalogController@index');
Route::get('/returns', 'App\Http\Controllers\IndexController@returns');
Route::get('/cart', 'App\Http\Controllers\CartController@index');
Route::get('/privacyPolicy', 'App\Http\Controllers\IndexController@privacyPolicy');
Route::post('/changeQuantity', 'App\Http\Controllers\CartController@changeQuantity');
Route::post('/promoCheck', 'App\Http\Controllers\CartController@promoCheck');
Route::post('/makeOrder', 'App\Http\Controllers\OrdersController@makeOrder');


Route::group(array('before' => 'csrf'), function () {
    Route::post('/addToCart', 'App\Http\Controllers\CatalogController@addToCart');
});

