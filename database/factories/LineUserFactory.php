<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Categories;
use App\Models\LineUsers;
use App\Models\SavedPlaces;
use Faker\Generator as Faker;

$factory->define(LineUsers::class, function (Faker $faker) {
    return [

        'line_id'=>$faker->randomNumber(8),
        'name' => $faker->name
    ];
});
