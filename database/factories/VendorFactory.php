<?php

use Faker\Generator as Faker;

$factory->define(\App\Vendor::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->streetAddress . ', ' . $faker->city,
        'contact_person' => $faker->name,
        'contact_person_phone' => $faker->phoneNumber
    ];
});
