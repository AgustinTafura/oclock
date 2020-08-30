<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
      'street' => $faker->streetName,
      'number' => $faker->buildingNumber,
      'postal_code' => $faker->postcode,
      'floor' => $faker->numberBetween(0,15),
      'apartment' => $faker->randomLetter,
      'neighborhood' => $faker->streetName,
      'state' => $faker->state,
      'city' => $faker->city,
      'country' => $faker->country,
      'lat' => $faker->latitude($min = -90, $max = 90),
      'lng' => $faker->longitude($min = -180, $max = 180),
    ];
});
