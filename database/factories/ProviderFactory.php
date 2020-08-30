<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Provider;
use Faker\Generator as Faker;

$factory->define(Provider::class, function (Faker $faker) {
    return [
      // 'cuit' => $faker->numberBetween(20000000009,20999999999),
      // 'license_number' => $faker->numberBetween(00000001,99999999),
      // 'contact_phone' => $faker->tollFreePhoneNumber,        //
    ];
});
