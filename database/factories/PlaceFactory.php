<?php

/** @var Factory $factory */

use App\Models\Categories;
use App\Models\LineUsers;
use App\Models\Places;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Places::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'url' => $faker->url,
        'add_user_id' => factory(LineUsers::class),
        'category_id' => factory(Categories::class)
    ];
});
