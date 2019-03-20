<?php

use App\User;
use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    $user = User::all()->random();
    $title = $faker->sentence;
    $created_at = $faker->dateTimeThisYear();
    $published_at = $faker->boolean(80) ? $faker->dateTimeBetween($created_at, 'now') : null;

    return [
        'user_id' => $user->id,
        'title' => $title,
        'slug' => str_slug($title),
        'body' => $faker->paragraphs(10, true),
        'excerpt' => $faker->paragraphs(2, true),
        'created_at' => $created_at,
        'published_at' => $published_at,
    ];
});
