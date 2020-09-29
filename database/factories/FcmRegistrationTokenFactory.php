<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FcmRegistrationToken;
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

$factory->define(FcmRegistrationToken::class, function (Faker $faker) {
    return [
        'registration_id' => $faker->uuid,
        'created_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
