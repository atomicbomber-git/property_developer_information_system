<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->username,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
        'privilege' => 'EMPLOYEE'
    ];
});

$factory->state(App\User::class, 'admin', function (Faker $faker) {
    return [
        'privilege' => 'ADMINISTRATOR'
    ];
});

$factory->state(App\User::class, 'employee', function (Faker $faker) {
    return [
        'privilege' => 'EMPLOYEE'
    ];
});
