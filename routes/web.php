<?php
use App\Http\Controllers\CategoryItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemPriceHistoryController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\StorageStockController;

Auth::routes();

Route::redirect('/', '/dashboard/show', 301);

Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function() {
    Route::get('/show', [DashboardController::class, 'show'])->name('show');
});

Route::group(['prefix' => '/item', 'as' => 'item.'], function() {
    Route::get('/index', [ItemController::class, 'index'])->name('index');
    Route::get('/create', [ItemController::class, 'create'])->name('create');
    Route::post('/store', [ItemController::class, 'store'])->name('store');
    Route::get('/edit/{item}', [ItemController::class, 'edit'])->name('edit');
    Route::post('/update/{item}', [ItemController::class, 'update'])->name('update');
    Route::post('/delete/{item}', [ItemController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => '/item-price-history', 'as' => 'item-price-history.'], function() {
    Route::get('/index/{item}', [ItemPriceHistoryController::class, 'index'])->name('index');
});

Route::group(['prefix' => '/storage', 'as' => 'storage.'], function() {
    Route::get('/index', [StorageController::class, 'index'])->name('index');
    Route::get('/create', [StorageController::class, 'create'])->name('create');
    Route::post('/store', [StorageController::class, 'store'])->name('store');
    Route::get('/edit/{storage}', [StorageController::class, 'edit'])->name('edit');
    Route::post('/update/{storage}', [StorageController::class, 'update'])->name('update');
    Route::post('/delete/{storage}', [StorageController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => '/storage-stock-adjustment', 'as' => 'storage-stock-adjustment.'], function() {
    Route::get('/create/{storage}', [\App\Http\Controllers\StorageStockAdjustmentController::class, 'create'])->name('create');
});

Route::group(['prefix' => '/storage-stock', 'as' => 'storage-stock.'], function() {
    Route::get('/index/{storage}', [StorageStockController::class, 'index'])->name('index');
});

Route::group(['prefix' => '/delivery-order', 'as' => 'delivery-order.'], function() {
    Route::get('/index', [DeliveryOrderController::class, 'index'])->name('index');
    Route::get('/create', [DeliveryOrderController::class, 'create'])->name('create');
    Route::post('/store', [DeliveryOrderController::class, 'store'])->name('store');
    Route::get('/edit/{delivery_order}', [DeliveryOrderController::class, 'edit'])->name('edit');
    Route::post('/update/{delivery_order}', [DeliveryOrderController::class, 'update'])->name('update');

    Route::get('/update_price/{delivery_order}', [DeliveryOrderController::class, 'updatePrice'])->name('update_price');
    Route::post('/update_price/{delivery_order}', [DeliveryOrderController::class, 'processUpdatePrice'])->name('update_price');

    Route::post('/delete/{delivery_order}', [DeliveryOrderController::class, 'delete'])->name('delete');
});

Route::middleware(['auth'])->group(function() {
    Route::prefix('/vendor')->group(function () {
        Route::get('/index', 'VendorController@index')->name('vendor.index');
        Route::get('/create', 'VendorController@create')->name('vendor.create');
        Route::post('/create', 'VendorController@processCreate')->name('vendor.create');

        Route::get('/edit/{vendor}', 'VendorController@edit')->name('vendor.edit');
        Route::post('/update/{vendor}', 'VendorController@update')->name('vendor.update');

        Route::post('/delete/{vendor}', 'VendorController@delete')->name('vendor.delete');
        Route::get('/transaction_history/{vendor}', 'VendorController@transactionHistory')->name('vendor.transaction_history');
        Route::get('/item/{vendor}', 'VendorController@item')->name('vendor.item');

        Route::prefix('/contact_persons')->group(function() {
            Route::post('/{vendor}/create', 'VendorContactPersonController@create')->name('vendor_contact_person.create');
            Route::post('/{vendor}/delete/{contact_person}', 'VendorContactPersonController@delete')->name('vendor_contact_person.delete');
            Route::post('/{vendor}/update', 'VendorContactPersonController@update')->name('vendor_contact_person.update');
        });

        Route::prefix('/api')->group(function() {
            Route::get('/index', 'VendorApiController@index')->name('vendor.api.index');
            Route::get('/unbilled', 'VendorController@unbilled')->name('vendor.unbilled');
            Route::get('/unbilled_delivery_orders/{vendor}', 'VendorController@unbilledDeliveryOrders')->name('vendor.unbilled_delivery_orders');
        });
    });

    Route::prefix('/category')->group(function () {
        Route::get('/index', 'CategoryController@index')->name('category.index');
        Route::get('/create', 'CategoryController@create')->name('category.create');
        Route::post('/create', 'CategoryController@processCreate')->name('category.create');
        Route::get('/update/{category}', 'CategoryController@update')->name('category.update');
        Route::post('/update/{category}', 'CategoryController@processUpdate')->name('category.update');
        Route::post('/delete/{category}', 'CategoryController@delete')->name('category.delete');

        Route::prefix('/items/{category}')->group(function() {
            Route::get('/index', [CategoryItemController::class, 'index'])->name('category-item.index');
            Route::get('/create', [CategoryItemController::class, 'create'])->name('category-item.create');
            Route::post('/create', [CategoryItemController::class, 'processCreate'])->name('category-item.create');
            Route::get('/update/{item}', [CategoryItemController::class, 'update'])->name('category-item.update');
            Route::post('/update/{item}', [CategoryItemController::class, 'processUpdate'])->name('category-item.update');
            Route::post('/delete/{item}', [CategoryItemController::class, 'delete'])->name('category-item.delete');
            Route::get('/price_history/{item}', [CategoryItemController::class, 'priceHistory'])->name('category-item.price_history');
        });
    });

    Route::prefix('/invoice')->group(function () {
        Route::get('/index', 'InvoiceController@index')->name('invoice.index');
        Route::get('/create', 'InvoiceController@create')->name('invoice.create');
        Route::post('/create', 'InvoiceController@processCreate')->name('invoice.create');
        Route::get('/update/{invoice}', 'InvoiceController@update')->name('invoice.update');
        Route::post('/update/{invoice}', 'InvoiceController@processUpdate')->name('invoice.update');
        Route::post('/attach_delivery_order/{invoice}', 'InvoiceController@processAttachDeliveryOrder')->name('invoice.attach_delivery_order');
        Route::post('/remove_delivery_order/{invoice}', 'InvoiceController@processRemoveDeliveryOrder')->name('invoice.remove_delivery_order');
        Route::post('/delete/{invoice}', 'InvoiceController@delete')->name('invoice.delete');
        Route::get('/pay/{invoice}', 'InvoiceController@pay')->name('invoice.pay');
        Route::post('/pay/{invoice}', 'InvoiceController@processPay')->name('invoice.pay');
    });

    Route::prefix('/giro')->group(function() {
        Route::get('/index', 'GiroController@index')->name('giro.index');
        Route::get('/create', 'GiroController@create')->name('giro.create');
        Route::post('/create', 'GiroController@processCreate')->name('giro.create');
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

// Route::fallback(function() {
//     return redirect()
//         ->route("dashboard.show");
// });
