<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        // 'name' => $faker->name,
        // 'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // 'remember_token' => Str::random(10),
        // 'surname' => $faker->lastName,
        // 'address_id' => App\Address::all()->random()->id,
        // 'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        // 'dni' => $faker->numberBetween(00000001,99999999),
        // 'mobile_phone' => $faker->phoneNumber,
        // 'sex' => $faker->randomElement(['male', 'female', 'other']),
        // 'is_client' => '1',
        // 'is_provider' => $faker->numberBetween(0,1),
        // 'is_admin' => $faker->numberBetween(0,1),
        // 'avatar' => 'default-user.png',
        // 'active' => '1',
    ];
});
