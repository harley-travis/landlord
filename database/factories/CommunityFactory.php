<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Community;
use Faker\Generator as Faker;

$factory->define(Community::class, function (Faker $faker) {
    return [
        'hoa_community' => $faker->name,
    ];
});
