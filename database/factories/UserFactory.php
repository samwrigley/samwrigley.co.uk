<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $name = $faker->unique()->name;

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'bio' => $faker->paragraph,
        'avatar' => $faker->imageUrl(200, 200),
        'remember_token' => str_random(10),
    ];
});
