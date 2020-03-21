<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\ArticleSeries::class, function (Faker $faker) {
    $title = $faker->unique()->words(5, true);

    return [
        'slug' => Str::slug($title),
        'title' => ucfirst($title),
        'description' => $faker->paragraph,
    ];
});
