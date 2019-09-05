<?php

use App\DeliveryOrderItem;
use App\Item;
use Faker\Generator as Faker;

$factory->define(\App\DeliveryOrderItem::class, function (Faker $faker) {
    return [
        'item_id' => Item::select("id")->inRandomOrder()->value("id"),
        'quantity' => $faker->randomNumber(2),
        'price' => $faker->randomNumber(2) * 10000
    ];
});
