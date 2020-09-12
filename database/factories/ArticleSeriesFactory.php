<?php

use App\Article;
use App\ArticleSeries;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ArticleSeries::class, function (Faker $faker): array {
    $title = $faker->unique()->words(5, true);

    return [
        'title' => ucfirst($title),
        'slug' => Str::slug($title),
        'description' => $faker->paragraph,
    ];
});

$factory->afterCreatingState(ArticleSeries::class, 'withArticles', function (ArticleSeries $series) {
    $series->articles()->saveMany(
        factory(Article::class, 2)->state('published')->make()
    );
});
