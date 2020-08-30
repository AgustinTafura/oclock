<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
      // 'name' => $faker->company,
      // 'cuit' => $faker->numberBetween(20000000009,20999999999),
      // 'address_id' => App\Address::all()->random()->id,
      // 'contact_phone' => $faker->tollFreePhoneNumber,
      // 'email' => $faker->freeEmail,
      // 'type' => $faker->randomElement(['consultorio particular', 'clinica', 'centro medico', 'centro profesional', 'estudio', 'centro_estetica']),
      // 'website' => $faker->domainName,
      // 'avatar' => 'default-company.png',

    ];
});
