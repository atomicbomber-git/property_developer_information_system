<?php

use Faker\Generator as Faker;

$factory->define(App\VendorContactPerson::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber
    ];
});
