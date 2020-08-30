<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MedicalInsurance;
use Faker\Generator as Faker;

$factory->define(MedicalInsurance::class, function (Faker $faker) {
    return [
        'name'=>$faker->company,
        'business_name'=>$faker->company,
        'cuit'=>$faker->numberBetween(20000000009,20999999999),
        'email'=>$faker->freeEmail,
        'contact_phone'=>$faker->tollFreePhoneNumber,
        'type'=>$faker->randomElement(['prepaga', 'obra social', 'otro']),

    ];
});
