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

    Route::prefix('/storage')->group(function () {
        Route::get('/index', 'StorageController@index')->name('storage.index');
        Route::get('/create', 'StorageController@create')->name('storage.create');
        Route::post('/create', 'StorageController@processCreate')->name('storage.create');
        Route::get('/update/{storage}', 'StorageController@update')->name('storage.update');
        Route::post('/update/{storage}', 'StorageController@processUpdate')->name('storage.update');
        Route::post('/delete/{storage}', 'StorageController@delete')->name('storage.delete');
    });

    Route::prefix('/invoice')->group(function () {
        Route::get('/index', 'InvoiceController@index')->name('invoice.index');
        Route::get('/create', 'InvoiceController@create')->name('invoice.create');
        Route::post('/create', 'InvoiceController@processCreate')->name('invoice.create');
        Route::get('/update/{invoice}', 'InvoiceController@update')->name('invoice.update');
        Route::post('/update/{invoice}', 'InvoiceController@processUpdate')->name('invoice.update');
        Route::post('/delete/{invoice}', 'InvoiceController@delete')->name('invoice.delete');

        Route::get('/detail/{invoice}/', 'InvoiceController@detail')->name('invoice.detail');

        Route::post('/detail/{invoice}/allocation/delete/{allocation}', 'InvoiceController@deleteAllocation')->name('allocation.delete');
        Route::post('/detail/{invoice}/allocation/create', 'InvoiceController@createAllocation')->name('allocation.create');
    });
});