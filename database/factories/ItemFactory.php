<?php

use Faker\Generator as Faker;

$factory->define(\App\Item::class, function (Faker $faker) {
    return [
        'name' => $faker->bs,
        'unit' => $faker->randomElement(['M2', 'KG', 'M3', 'box'])
    ];
});
