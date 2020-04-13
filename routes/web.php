<?php

use Illuminate\Support\Facades\Route;


// Delete Confirmation DONE
// Grandtotal  DONE
// Zero Cart Error fix DONE
// Merge same item DONE

// Proceed to Checkout  DONE
// Ordered Items Table  (relational) DONE
// Quantity-Stocks Restrictions DONE
// [Optional] Automated email DONE

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(["middleware" => "App\Http\Middleware\SuperCheck"], function(){
    
    Route::get("/control", "SuperController@index")->name('control');
    Route::get("/users", "SuperController@show")->name('users');
    Route::post('/adduser', "SuperController@adduser")->name('adduser');
    Route::get('/getuser/{id}', "SuperController@getuser")->name('getuser');
    Route::get("/getpermissions/{role}", "SuperController@getpermissions")->name('getpermissions');
    Route::get("/getroles", "SuperController@getroles")->name("getroles");
    Route::post('/updateuser', "SuperController@updateuser")->name('updateuser');
    Route::post("/deleteuser", "SuperController@deleteuser")->name("deleteuser");

    Route::get("/roles", "RoleController@index")->name("roles");
    Route::post("/addrole", "RoleController@addrole")->name("addrole");
    Route::get("/getallperm", "RoleController@getallperm")->name('getallperm');
    Route::get("/getrole/{id}", "RoleController@getrole")->name('getrole');
    Route::post("/updrole", "RoleController@updrole")->name('updrole');
    Route::post("/deleterole", "RoleController@deleterole")->name('deleterole');
});

Route::group(["middleware" => "App\Http\Middleware\AdminCheck"], function(){
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::get('/getitem', 'ItemController@index')->name('getitem');
    Route::post('/additem', 'ItemController@store')->name('additem');
    Route::get('/get', 'ItemController@get')->name('get');
    Route::post('/updateitem', "ItemController@update")->name('updateitem');
    Route::post('/delitem', 'ItemController@destroy' )->name('delitem');
    Route::get('/orders', 'OrderController@allorders');
});

Route::get('/client', 'ItemController@show')->name('showitems');
Route::get('/details', 'ItemController@details')->name('details');
Route::get('/myorders', 'OrderController@myorders')->name('myorders');
Route::post('/addtocart', 'OrderController@stage')->name('addtocart');
Route::get('/cart', 'OrderController@index')->name('cart');
Route::post('/orderpull', 'OrderController@pull')->name('orderpull');
Route::get('/addorders', 'OrderController@addorders')->name('addorders');
