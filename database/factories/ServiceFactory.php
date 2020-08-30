<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'recommendation' => $faker->text($maxNbChars = 90),
        'requirement' => $faker->text($maxNbChars = 90),
        'specialty_id' => App\Specialty::all()->random()->id,
    ];
});
