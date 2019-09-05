<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Storage;
use App\User;
use App\Vendor;
use Faker\Generator as Faker;

const ITEM_PER_DELIVERY_ORDER = 5;

$receivers = User::select("id")->get();
$vendors = Vendor::select("id")->get();
$storages = Storage::select("id")->get();

$factory->define(DeliveryOrder::class, function (Faker $faker) use($receivers, $vendors) {
    return [
        "receiver_id" => $receivers->random()->id,
    ];
});

$factory->afterMaking(DeliveryOrder::class, function (DeliveryOrder $delivery_order) use ($vendors, $storages) {
    $delivery_order
        ->source()->associate($vendors->random())
        ->target()->associate($storages->random());
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

        $delivery_order
            ->delivery_order_items()
            ->save($delivery_order_item);
    }
});
