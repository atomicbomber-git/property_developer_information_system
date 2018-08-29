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

    Route::prefix('/vendor')->group(function () {
        Route::get('/index', 'VendorController@index')->name('vendor.index');
        Route::get('/create', 'VendorController@create')->name('vendor.create');
        Route::post('/create', 'VendorController@processCreate')->name('vendor.create');
        Route::get('/update/{vendor}', 'VendorController@update')->name('vendor.update');
        Route::post('/update/{vendor}', 'VendorController@processUpdate')->name('vendor.update');
        Route::post('/delete/{vendor}', 'VendorController@delete')->name('vendor.delete');
        Route::get('/unbilled_delivery_orders/{vendor}', 'VendorController@unbilledDeliveryOrders')->name('vendor.unbilled_delivery_orders');
    });

    Route::prefix('/storage')->group(function () {
        Route::get('/index', 'StorageController@index')->name('storage.index');
        Route::get('/create', 'StorageController@create')->name('storage.create');
        Route::post('/create', 'StorageController@processCreate')->name('storage.create');
        Route::get('/update/{storage}', 'StorageController@update')->name('storage.update');
        Route::post('/update/{storage}', 'StorageController@processUpdate')->name('storage.update');
        Route::post('/delete/{storage}', 'StorageController@delete')->name('storage.delete');
        Route::get('/stock/{storage}', 'StorageController@stock')->name('storage.stock');
    });

    Route::prefix('/category')->group(function () {
        Route::get('/index', 'CategoryController@index')->name('category.index');
        Route::get('/create', 'CategoryController@create')->name('category.create');
        Route::post('/create', 'CategoryController@processCreate')->name('category.create');
        Route::get('/update/{category}', 'CategoryController@update')->name('category.update');
        Route::post('/update/{category}', 'CategoryController@processUpdate')->name('category.update');
        Route::post('/delete/{category}', 'CategoryController@delete')->name('category.delete');

        Route::prefix('/items/{category}')->group(function() {
            Route::get('/index', 'ItemController@index')->name('item.index');
            Route::get('/create', 'ItemController@create')->name('item.create');
            Route::post('/create', 'ItemController@processCreate')->name('item.create');
            Route::get('/update/{item}', 'ItemController@update')->name('item.update');
            Route::post('/update/{item}', 'ItemController@processUpdate')->name('item.update');
            Route::post('/delete/{item}', 'ItemController@delete')->name('item.delete');
        });
    });

    Route::prefix('/delivery_order')->group(function () {
        Route::get('/index', 'DeliveryOrderController@index')->name('delivery_order.index');
        Route::get('/create', 'DeliveryOrderController@create')->name('delivery_order.create');
        Route::post('/create', 'DeliveryOrderController@processCreate')->name('delivery_order.create');
        Route::get('/update/{delivery_order}', 'DeliveryOrderController@update')->name('delivery_order.update');
        Route::post('/update/{delivery_order}', 'DeliveryOrderController@processUpdate')->name('delivery_order.update');
        Route::post('/delete/{delivery_order}', 'DeliveryOrderController@delete')->name('delivery_order.delete');

        Route::prefix('/detail/{delivery_order}/')->group(function() {
            Route::get('/', 'DeliveryOrderController@detail')->name('delivery_order.detail');
            Route::post('/item/create', 'DeliveryOrderController@createItem')->name('delivery_order.create_item');
            Route::post('/item/delete/{delivery_order_item}', 'DeliveryOrderController@deleteItem')->name('delivery_order.delete_item');
        });
    });

    Route::prefix('/invoice')->group(function () {
        Route::get('/index', 'InvoiceController@index')->name('invoice.index');
        Route::get('/create', 'InvoiceController@create')->name('invoice.create');
        Route::post('/create', 'InvoiceController@processCreate')->name('invoice.create');
        Route::get('/update/{invoice}', 'InvoiceController@update')->name('invoice.update');
        Route::post('/attach_delivery_order/{invoice}', 'InvoiceController@processAttachDeliveryOrder')->name('invoice.attach_delivery_order');
        Route::post('/remove_delivery_order/{invoice}', 'InvoiceController@processRemoveDeliveryOrder')->name('invoice.remove_delivery_order');
        Route::post('/delete/{invoice}', 'InvoiceController@delete')->name('invoice.delete');
        Route::get('/pay/{invoice}', 'InvoiceController@pay')->name('invoice.pay');
        Route::post('/pay/{invoice}', 'InvoiceController@processPay')->name('invoice.pay');
    });

    Route::prefix('/giro')->group(function() {
        Route::get('/index', 'GiroController@index')->name('giro.index');
        Route::get('/update/{giro}', 'GiroController@update')->name('giro.update');
        Route::post('/update/{giro}', 'GiroController@processUpdate')->name('giro.update');
        Route::post('/delete/{giro}', 'GiroController@delete')->name('giro.delete');
        Route::get('/search', 'GiroController@search')->name('giro.search');
        Route::get('/detail/{giro}', 'GiroController@detail')->name('giro.detail');
    });

    Route::prefix('/user')->group(function() {
        Route::get('/index', 'UserController@index')->name('user.index');
        Route::get('/create', 'UserController@create')->name('user.create');
        Route::post('/create', 'UserController@processCreate')->name('user.create');
        Route::get('/update/{user}', 'UserController@update')->name('user.update');
        Route::post('/update/{user}', 'UserController@processUpdate')->name('user.update');
        Route::post('/delete/{user}', 'UserController@delete')->name('user.delete');
    });
});