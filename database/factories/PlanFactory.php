<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Plan;
use Faker\Generator as Faker;

$factory->define(Plan::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->text($maxNbChars = 80),
        'medical_insurance_id' => App\MedicalInsurance::all()->random()->id,
    ];
});
