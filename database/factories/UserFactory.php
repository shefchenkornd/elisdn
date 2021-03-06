<?php

use Faker\Generator as Faker;
use App\Entity\User as User;

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
    $active = $faker->boolean();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'verify_code' => $active ? null : $faker->uuid,
        'status' => $active ? User::STATUS_ACTIVE : User::STATUS_WAIT,
        'role' => $active ? $faker->randomElement([User::ROLE_ADMIN,User::ROLE_USER]) : User::ROLE_USER
    ];
});