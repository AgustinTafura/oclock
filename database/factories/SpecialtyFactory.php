<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Specialty;
use Faker\Generator as Faker;

$factory->define(Specialty::class, function (Faker $faker) {
    return [
      'name'=> $faker->name,
      'category_id'=> App\Category::all()->random()->id,
    ];
});
