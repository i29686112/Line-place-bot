<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Categories;
use App\Models\LineUsers;
use App\Models\SavedPlaces;
use Faker\Generator as Faker;

$factory->define(SavedPlaces::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'url' => $faker->url,
        'add_user_id' => factory(LineUsers::class),
        'category_id' => factory(Categories::class)
    ];
});
