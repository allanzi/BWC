<?php

use Faker\Generator as Faker;

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

$factory->define(App\Vehicle::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'brand' => $faker->name,
        'year' => $faker->year,
        'description' => $faker->text,
        'has_sold' => $faker->boolean,
    ];
});
