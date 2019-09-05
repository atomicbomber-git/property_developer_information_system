<?php

namespace App\Http\Controllers;

use App\DeliveryOrder;
use App\Item;

class ItemPriceHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Item $item)
    {
        // $item->load([
        //     "delivery_order_items" => function ($query) {
        //         $query->orderBy
        //     }
        // ]);

        $delivery_order_items = $item->delivery_order_items()
            ->orderBy(
                DeliveryOrder::query()
                    ->select("received_at")
                    ->whereColumn("delivery_order_id", "delivery_orders.id")
                    ->limit(1)
            );



        return compact("item");
    }
}
