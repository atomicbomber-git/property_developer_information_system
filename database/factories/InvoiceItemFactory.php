<?php

use Faker\Generator as Faker;

$factory->define(\App\InvoiceItem::class, function (Faker $faker) {
    return [
        'price' => $faker->randomNumber(2) * 10000
    ];
});
