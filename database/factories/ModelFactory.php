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

use App\Models\Category;
use App\Models\Guide;
use App\Models\GuideStep;
use App\Models\Issue;
use App\Models\Password;
use App\Models\PasswordFolder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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
        'name'  => $faker->name,
        'label' => $faker->name,
    ];
};

$factory[Permission::class] = function (Generator $faker) {
    return [
        'name'  => $faker->name,
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

$factory[Guide::class] = function (Generator $faker) {
    return [
        'title'       => $faker->title,
        'slug'        => $faker->slug(3),
        'description' => $faker->text(),
    ];
};

$factory[GuideStep::class] = function (Generator $faker) {
    return [
        'guide_id'    => factory(Guide::class)->create()->getKey(),
        'title'       => $faker->title,
        'description' => $faker->text(),
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

$factory[Category::class] = function (Generator $faker) {
    return [
        'name' => $faker->title,
    ];
};

$factory->defineAs(Category::class, 'manager', function ($faker) {
    return [
        'name'    => $faker->title,
        'options' => ['manager' => true],
    ];
});

$factory[Issue::class] = function (Generator $faker) {
    return [
        'user_id'     => factory(User::class)->create()->getKey(),
        'title'       => $faker->title,
        'occurred_at' => '03/03/2016 12:00 AM',
        'description' => $faker->text(),
    ];
};
