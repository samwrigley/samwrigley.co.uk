<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSeries;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Article::class, function (Faker $faker) {
    $title = $faker->sentence;
    $created_at = $faker->dateTimeThisYear();
    $published_at = $faker->boolean(80) ? $faker->dateTimeBetween($created_at, 'now') : null;

    return [
        'user_id' => factory(User::class),
        'title' => $title,
        'slug' => Str::slug($title),
        'body' => $faker->paragraphs(10, true),
        'excerpt' => $faker->paragraph,
        'created_at' => $created_at,
        'published_at' => $published_at,
    ];
});

$factory->state(Article::class, 'draft', [
    'published_at' => null,
]);

$factory->state(Article::class, 'scheduled', [
    'published_at' => now()->addWeek(),
]);

$factory->state(Article::class, 'published', [
    'published_at' => now(),
]);

$factory->afterCreatingState(Article::class, 'withCategories', function (Article $article): void {
    $article->categories()->saveMany(factory(ArticleCategory::class, 3)->make());
});

$factory->afterCreatingState(Article::class, 'withSeries', function (Article $article): void {
    $article->series()->associate(factory(ArticleSeries::class)->make());
    $article->save();
});
