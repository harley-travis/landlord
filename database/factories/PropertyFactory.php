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
        'pet' => $faker->numberBetween(0,1),
        'bed_amount' => $faker->numberBetween(1, 7),
        'bath_amount' => $faker->numberBetween(1, 5),
        'square_footage' => $faker->numberBetween(1000, 5000),
        'description' => $faker->sentence(12),
        'community_id' => null,
        
    ];
});
