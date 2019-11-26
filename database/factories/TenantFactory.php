<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tenant;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    return [

        // need to figure out the pivot table
        // no company id on this user create

        'phone' => $faker->phoneNumber,
        'work_phone' => $faker->phoneNumber,
        'secondary_name' => $faker->name,
        'secondary_phone' => $faker->phoneNumber,
        'secondary_work_phone' => $faker->phoneNumber,
        'secondary_email' => $faker->email,
        'number_occupants' => $faker->numberBetween(0, 5),
        'active' => $faker->numberBetween(0, 1),
        'assigned' => $faker->numberBetween(0, 1),
    ];
});
