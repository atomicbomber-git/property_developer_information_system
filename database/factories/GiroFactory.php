<?php

use Faker\Generator as Faker;

$factory->define(\App\Giro::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomNumber(2) * 100000,
        'number' => $faker->randomNumber(7)
    ];
});
