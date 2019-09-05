<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Item;
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
            ->target
            ->stocks()
            ->create([
                "item_id" => $delivery_order_item->item_id,
                "quantity" => $delivery_order_item->quantity,
                "value" => $delivery_order_item->price,
            ]);

        (new StockMutation([
            "item_id" => $delivery_order_item->item_id,
            "quantity" => $delivery_order_item->quantity,
            "value" => $delivery_order_item->price,
        ]))
        ->source()->associate($delivery_order->source)
        ->target()->associate($delivery_order->target)
        ->save();

        $delivery_order
            ->delivery_order_items()
            ->save($delivery_order_item);
    }
});
