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
    //SUPERCONTROLLER
    Route::get("/control", "SuperController@index")->name('control');
    Route::get("/users", "SuperController@show")->name('users');
    Route::post('/adduser', "SuperController@adduser")->name('adduser');
    Route::get('/getuser/{id}', "SuperController@getuser")->name('getuser');
    Route::get("/getpermissions/{role}", "SuperController@getpermissions")->name('getpermissions');
    Route::get("/getroles", "SuperController@getroles")->name("getroles");
    Route::post('/updateuser', "SuperController@updateuser")->name('updateuser');
    Route::post("/deleteuser", "SuperController@deleteuser")->name("deleteuser");
    
    //ROLECONTROLLER
    Route::get("/roles", "RoleController@index")->name("roles");
    Route::post("/addrole", "RoleController@addrole")->name("addrole");
    Route::get("/getallperm", "RoleController@getallperm")->name('getallperm');
    Route::post("/updrole", "RoleController@updrole")->name("updrole");
    Route::get("/getrole/{id}", "RoleController@getrole")->name('getrole');
    Route::post("/deleterole", "RoleController@deleterole")->name('deleterole');
});

Route::group(["middleware" => "App\Http\Middleware\AdminCheck"], function(){
    //admin
    Route::get('/admin', 'AdminController@index')->name('admin')->middleware('can:view item');
    //ITEMCONTROLLER
    Route::post('/additem', 'ItemController@store')->name('additem')->middleware("can:add item");
    Route::get('/get', 'ItemController@get')->name('get')->middleware('can:edit item');
    Route::post('/updateitem', "ItemController@update")->name('updateitem')->middleware('can:edit item');
    Route::post('/delitem', 'ItemController@destroy' )->name('delitem')->middleware('can:delete item');
    Route::get('/orders', 'OrderController@allorders')->name('orders')->middleware('can:view order');
});
Route::group(["middleware" => "App\Http\Middleware\ClientCheck"], function(){
    //client
    //ITEMCONTROLLER - RETRIEVE
    Route::get('/client', 'ItemController@show')->name('showitems')->middleware('can:order item');
    Route::get('/details', 'ItemController@details')->name('details')->middleware('can:order item');

    //ORDERCONTROLLER
    Route::post('/addtocart', 'OrderController@stage')->name('addtocart')->middleware('can:order item');
    Route::get('/cart', 'OrderController@index')->name('cart')->middleware('can:view order');
    Route::post('/orderpull', 'OrderController@pull')->name('orderpull')->middleware('can:order item');
    Route::get('/addorders', 'OrderController@addorders')->name('addorders')->middleware('can:order item');
    Route::get('/myorders', 'OrderController@myorders')->name('myorders')->middleware('can:view order');
});

//GUESTS
Route::get('/client', 'ItemController@show')->name('showitems');
Route::get('/details', 'ItemController@details')->name('details');