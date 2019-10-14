<?php

namespace App\Http\Controllers;

use App\DeliveryOrderItem;
use App\Storage;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StorageStockController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Storage $storage)
    {
        $storage->load([
            "stocks:id,item_id,quantity,value,storage_id,storage_type,created_at,origin_id,origin_type",
            "stocks.item:id,name,unit",
            "stocks.origin" => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    DeliveryOrderItem::class => [
                        "delivery_order:id,received_at,source_id,source_type",
                        "delivery_order.source",
                    ],
                ]);
            }
        ]);

        return view("storage-stock.index", compact("storage"));
    }
}
