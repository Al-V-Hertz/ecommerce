<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/getitem', 'ItemController@index')->name('getitem');
Route::post('/additem', 'ItemController@store')->name('additem');
Route::get('/get', 'ItemController@get')->name('get');
Route::post('/updateitem', "ItemController@update")->name('updateitem');
Route::delete('/delitem', 'ItemController@destroy' )->name('delitem');

Route::get("/client", "ClientController@index")->name('client');
Route::get('/showitems', 'ItemController@show')->name('showitems');