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
        $delivery_order_query = DeliveryOrder::query()
            ->select("received_at")
            ->whereColumn("delivery_order_id", "delivery_orders.id")
            ->limit(1)
            ->getQuery();

        $delivery_order_items = $item->delivery_order_items()
            ->select("id", "delivery_order_id", "price")
            ->selectSub($delivery_order_query, "delivery_order_received_at")
            ->orderByDesc("delivery_order_received_at")
            ->get();

        return view("item_price_history.index", compact("delivery_order_items", "item"));
    }
}
