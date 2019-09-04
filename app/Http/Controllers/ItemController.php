<?php

namespace App\Http\Controllers;

use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Item;

class ItemController extends Controller
{
    public function index()
    {
        $delivery_order_query = DeliveryOrder::query()
            ->select("received_at")
            ->whereColumn("id", "delivery_order_items.item_id")
            ->limit(1)
            ->getQuery();

        $delivery_order_item_query = DeliveryOrderItem::query()
            ->select("price")
            ->orderByDesc($delivery_order_query)
            ->whereColumn("item_id", "items.id")
            ->whereNotNull("price")
            ->limit(1)
            ->getQuery();

        $items = Item::query()
            ->select("id", "name", "vendor_id", "category_id")
            ->selectSub($delivery_order_item_query, "latest_price")
            ->with([
                "vendor:id,name",
                "category:id,name",
            ])
            ->get();

        return view("item.index", compact("items"));
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function edit(Item $item)
    {
    }

    public function update(Item $item)
    {
    }

    public function delete(Item $item)
    {
    }
}
