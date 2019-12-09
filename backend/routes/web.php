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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/add-to-cart/{id}', 'PurchaseController@addToCart');



//Route::group(['prefix' => 'cart', 'as' => 'cart.'], function(){
//    Route::get('/', 'CartController2@show')->name('show');
//    Route::post('/add', 'CartController2@add')->name('add');
//    Route::delete('/delete/{id}', 'CartController2@delete')->name('delete');
//    Route::delete('/clear', 'CartController2@clearAll')->name('clear');
//});
