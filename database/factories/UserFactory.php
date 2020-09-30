<?php

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $name = $faker->unique()->name;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'bio' => $faker->paragraph,
        'avatar' => 'https://via.placeholder.com/48',
        'remember_token' => Str::random(10),
    ];
});
