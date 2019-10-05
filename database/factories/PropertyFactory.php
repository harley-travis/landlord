<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [

        'address_1' => $faker->streetAddress,
        'address_2' => $faker->secondaryAddress,
        'address_3' => $faker->buildingNumber,
        'city' => $faker->citySuffix,
        'state' => $faker->state,
        'zip' => $faker->postcode,
        'country' => $faker->country,
        'occupied' => $faker->numberBetween(0,1),
        'lease_length' => $faker->numberBetween(1,24),
        'rent_amount' => $faker->numberBetween(900, 5000),
        'pet' => $faker->numberBetween(0,1),
        'deposit_amount' => $faker->numberBetween(100, 500),
        'pet_deposit_amount' => $faker->numberBetween(100, 500),
        'amount_refundable' => $faker->numberBetween(100, 500),
        'bed_amount' => $faker->numberBetween(1, 7),
        'bath_amount' => $faker->numberBetween(1, 5),
        'square_footage' => $faker->numberBetween(1000, 5000),
        'description' => $faker->sentence(12),
    ];
});
