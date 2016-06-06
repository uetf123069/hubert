<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Provider::class, function (Faker\Generator $faker) {
    $first_name = $faker->firstName;
    $last_name = $faker->lastName;
    return [
        'name' => $first_name.' '.$last_name,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'latitude' => (mt_rand(10000, 900000) / 10000)*((mt_rand(0,1)*-2)+1),
        'longitude' => (mt_rand(10000, 1800000) / 10000)*((mt_rand(0,1)*-2)+1),
        'is_available' => mt_rand(0, 1),
    ];
});
