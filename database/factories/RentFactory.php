<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rent;
use Faker\Generator as Faker;

$factory->define(Rent::class, function (Faker $faker) {
    return [

        'rent_amount' => $faker->numberBetween(900, 5000),
        'deposit_amount' => $faker->numberBetween(100, 500),
        'pet_deposit_amount' => $faker->numberBetween(100, 500),
        'amount_refundable' => $faker->numberBetween(100, 500),
        'lease_length' => $faker->numberBetween(1,24),
        'late_date' => '10', 
        'late_fee' => $faker->numberBetween(25,100),
        'account_number' => $faker->numberBetween(5413,9163),
        'hoa_amount' => $faker->numberBetween(50,200),
        'property_id' => null,

    ];
});
