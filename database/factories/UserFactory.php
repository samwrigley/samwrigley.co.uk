<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $name = $faker->unique()->name;

    return [
        'name' => $name,
        'slug' => str::slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'bio' => $faker->paragraph,
        'avatar' => $faker->imageUrl(200, 200),
        'remember_token' => Str::random(10),
    ];
});
