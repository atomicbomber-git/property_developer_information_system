<?php

use Faker\Generator as Faker;

$factory->define(\App\Storage::class, function (Faker $faker) {
    return [
        'name' => 'Gudang ' . $faker->randomNumber(),
        'address' => $faker->streetAddress
    ];
});
