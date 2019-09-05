<?php

namespace App\Http\Controllers;

use App\Storage;

class StorageStockController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Storage $storage)
    {
        $storage->load([
            "stocks:id,item_id,quantity,value,storage_id,storage_type,created_at",
            "stocks.item:id,name,unit"
        ]);

        return view("storage-stock.index", compact("storage"));
    }
}
