<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::apiResource('categories', 'CategoryController');
Route::apiResource('users', 'UserController');
Route::apiResource('products', 'ProductController');
Route::apiResource('files', 'FileController');

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('/bestsellers', 'ProductController@bestsellers');
    Route::get('/nova', 'ProductController@nova');
    Route::get('/search', 'ProductController@search');
    Route::get('{product_id}/also', 'ProductController@mightAlsoLike');
});


Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::get('/history', 'PurchaseController@history')->name('user.history');
Route::get('/history-all', 'PurchaseController@index')->name('all_history');

Route::group(['prefix' => 'purchases', 'as' => 'purchases.'], function () {
    Route::post('/add', 'PurchaseController@authBuy')->name('auth_buy');
    Route::post('/add-guest', 'PurchaseController@guestBuy')->name('guest_buy');
});

Route::group(['prefix' => 'cart', 'as' => 'cart.', 'middleware' => ['user.auth']], function () {
    Route::get('/', 'CartItemController@index')->name('index');
    Route::post('/add', 'CartItemController@add')->name('add');
    Route::put('/change-qty/{product_id}', 'CartItemController@changeQty')->name('change-qty');
    Route::delete('/delete/{product_id}', 'CartItemController@delete')->name('delete');
    Route::delete('/clear', 'CartItemController@clearAll')->name('clear');
});

Route::group(['prefix' => 'favorites', 'as' => 'favorites.', 'middleware' => ['user.auth']], function () {
    Route::get('/', 'FavoritesController@index')->name('index');
    Route::post('/add', 'FavoritesController@add')->name('add');
    Route::delete('/delete/{product_id}', 'FavoritesController@delete')->name('delete');
});

Route::get('/filter', 'FilterController@filter')->name('filter');


