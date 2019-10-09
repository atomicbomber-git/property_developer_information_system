<?php

namespace App\Http\Controllers;

use App\Item;
use App\Storage;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class StorageStockAdjustmentController extends Controller
{
    public function create(Request $request, Storage $storage)
    {
        $items = Item::query()
            ->select(
                "name",
                "unit",
            )
            ->orderBy("name")
            ->get();

        $storage->load([
            "stocks" => function (MorphMany $query) {

            }
        ]);


        return $storage;

        return view("storage_stock_adjustment.create", compact("storage"));
    }
}
