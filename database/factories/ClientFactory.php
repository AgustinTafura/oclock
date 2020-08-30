<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
      'user_id' => App\User::all()->random()->id,
      'membership_number' => $faker->numberBetween(00000001,99999999),
      'plan_id' => App\Plan::all()->random()->id,        //
    ];
});
