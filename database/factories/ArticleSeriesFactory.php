<?php

use App\ArticleSeries;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ArticleSeries::class, function (Faker $faker): array {
    $title = $faker->unique()->words(5, true);

    return [
        'slug' => Str::slug($title),
        'title' => ucfirst($title),
        'description' => $faker->paragraph,
    ];
});
