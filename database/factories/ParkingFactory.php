<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Parking;
use Faker\Generator as Faker;

$factory->define(Parking::class, function (Faker $faker) {
    return [
        'location' => $faker->randomLetter.$faker->randomDigit,
        'type' => $faker->numberBetween(0, 1),
        'parking_deposit_amount' => $faker->numberBetween(50, 200),
        'monthly_fee' => $faker->numberBetween(25, 100),
        'avaliable' => $faker->numberBetween(0, 1),
        'property_id' => null,
        'company_id' => null,
    ];
});