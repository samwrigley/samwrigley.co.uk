<?php

use App\ArticleCategory;
use Faker\Generator as Faker;

$factory->define(ArticleCategory::class, function (Faker $faker) {
    $name = $faker->unique()->word;

    return [
        'slug' => str_slug($name),
        'name' => ucfirst($name),
        'description' => $faker->paragraph,
    ];
});
