<?php

use App\Article;
use App\User;
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
