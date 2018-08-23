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


Auth::routes();

Route::middleware(['auth'])->group(function() {
    
    Route::view('/', 'dashboard')->name('dashboard');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::view('/test', 'test');
    
    Route::prefix('/item')->group(function () {
        Route::get('/index', 'ItemController@index')->name('item.index');
        Route::get('/create', 'ItemController@create')->name('item.create');
        Route::post('/create', 'ItemController@processCreate')->name('item.create');
        Route::get('/update/{item}', 'ItemController@update')->name('item.update');
        Route::post('/update/{item}', 'ItemController@processUpdate')->name('item.update');
        Route::post('/delete/{item}', 'ItemController@delete')->name('item.delete');
    });
    
    Route::prefix('/vendor')->group(function () {
        Route::get('/index', 'VendorController@index')->name('vendor.index');
        Route::get('/create', 'VendorController@create')->name('vendor.create');
        Route::post('/create', 'VendorController@processCreate')->name('vendor.create');
        Route::get('/update/{vendor}', 'VendorController@update')->name('vendor.update');
        Route::post('/update/{vendor}', 'VendorController@processUpdate')->name('vendor.update');
        Route::post('/delete/{vendor}', 'VendorController@delete')->name('vendor.delete');
    });
});