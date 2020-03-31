<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@index')->name('admin');
Route::post('/additem', 'ItemController@store')->name('additem');
Route::get('/getitem', 'ItemController@index')->name('getitem');

