<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Categories;
use App\Models\LineUsers;
use Faker\Generator as Faker;


$factory->define(Conversations::class, function (Faker $faker) {
    return [
        'note' => '{}',
        'type' => 'url',
        'user_id' => factory(LineUsers::class)->line_id,
        'status' => (mt_rand(0,1))?'open':'closed'
    ];
});
