<?php

use App\ArticleCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ArticleCategory::class, function (Faker $faker) {
    $name = $faker->unique()->words(2, true);

    return [
        'slug' => Str::slug($name),
        'name' => ucfirst($name),
        'description' => $faker->paragraph,
    ];
});
