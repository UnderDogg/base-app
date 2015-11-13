<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\User;
use App\Models\Issue;

$factory[User::class] = function (Faker\Generator $faker) {
    return [
        'email'          => $faker->email,
        'password'       => str_random(10),
        'remember_token' => str_random(10),
        'status'         => User::VERIFIED,
    ];
};

$factory[Issue::class] = function (Faker\Generator $faker) {
    return [
        'user_id'       => factory(User::class)->create()->id,
        'title'         => $faker->title,
        'description'   => $faker->sentence(),
    ];
};

