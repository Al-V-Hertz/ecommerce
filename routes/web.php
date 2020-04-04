<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(["middleware" => "App\Http\Middleware\AdminCheck"], function(){
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::get('/getitem', 'ItemController@index')->name('getitem');
    Route::post('/additem', 'ItemController@store')->name('additem');
    Route::get('/get', 'ItemController@get')->name('get');
    Route::post('/updateitem', "ItemController@update")->name('updateitem');
    Route::post('/delitem', 'ItemController@destroy' )->name('delitem');
});
Route::group(["middleware" => "App\Http\Middleware\ClientCheck"], function(){
    Route::get('/client', 'ItemController@show')->name('showitems');
    Route::get('/details', 'ItemController@details')->name('details');
    Route::post('/addtocart', 'OrderController@stage')->name('addtocart');
    Route::get('/cart', 'OrderController@index')->name('cart');
    Route::post('/orderpull', 'OrderController@pull')->name('orderpull');
    Route::get('/gettotal', 'OrderController@total')->name('gettotal');
});