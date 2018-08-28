<?php

use Faker\Generator as Faker;

$factory->define(\App\DeliveryOrderItem::class, function (Faker $faker) {
    return [
        'quantity' => $faker->randomNumber(2),
        'price' => $faker->randomNumber(2) * 10000
    ];
});
