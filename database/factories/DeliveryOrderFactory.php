<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Item;
use App\Stock;
use App\StockMutation;
use App\Storage;
use App\User;
use App\Vendor;
use Faker\Generator as Faker;

const ITEM_PER_DELIVERY_ORDER = 5;

$factory->define(DeliveryOrder::class, function (Faker $faker) {
    return [
        "receiver_id" => User::select("id")->inRandomOrder()->value("id"),
    ];
});

$factory->afterMaking(DeliveryOrder::class, function (DeliveryOrder $delivery_order) {
    $delivery_order
        ->source()->associate(Vendor::select("id")->inRandomOrder()->first())
        ->target()->associate(Storage::select("id")->inRandomOrder()->first());
});

$factory->afterCreating(DeliveryOrder::class, function (DeliveryOrder $delivery_order) {
    $items = Item::select("id")
        ->inRandomOrder()
        ->limit(ITEM_PER_DELIVERY_ORDER)
        ->get();

    foreach ($items as $item) {
        $delivery_order_item = factory(DeliveryOrderItem::class)
            ->make(["item_id" => $item->id]);

        $delivery_order
            ->delivery_order_items()
            ->save($delivery_order_item);

        $stock = (new Stock([
            "quantity" => $delivery_order_item->quantity,
            "item_id" => $delivery_order_item->item_id,
        ]))
        ->storage()->associate($delivery_order->source)
        ->origin()->associate($delivery_order_item);

        $stock->moveTo(
            $delivery_order->target,
            $delivery_order_item->quantity,
            $delivery_order,
        );
    }
});
