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

use App\Models\Issue;
use App\Models\Password;
use App\Models\PasswordFolder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Faker\Generator;

$factory[User::class] = function (Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'password'       => str_random(10),
        'remember_token' => str_random(10),
    ];
};

$factory[Role::class] = function (Generator $faker) {
    return [
        'name' => $faker->name,
        'label' => $faker->name,
    ];
};

$factory[Permission::class] = function (Generator $faker) {
    return [
        'name' => $faker->name,
        'label' => $faker->name,
    ];
};

$factory[Issue::class] = function (Generator $faker) {
    return [
        'user_id'       => factory(User::class)->create()->getKey(),
        'title'         => $faker->title,
        'description'   => $faker->sentence(),
    ];
};

$factory[PasswordFolder::class] = function (Generator $faker) {
    return [
        'user_id'   => factory(User::class)->create()->getKey(),
        'uuid'      => uuid(),
        'pin'       => $faker->password(),
    ];
};

$factory[Password::class] = function (Generator $faker) {
    return [
        'folder_id' => factory(PasswordFolder::class)->create()->getKey(),
        'title'     => $faker->title,
        'website'   => $faker->url,
        'username'  => $faker->userName,
        'password'  => $faker->password(),
        'notes'     => $faker->text(),
    ];
};
