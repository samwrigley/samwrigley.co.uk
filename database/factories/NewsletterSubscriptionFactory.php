<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\NewsletterSubscription;
use Faker\Generator as Faker;

$factory->define(NewsletterSubscription::class, function (Faker $faker) {
    $created_at = $faker->dateTimeThisYear();
    $unsubscribed_at = $faker->boolean(20) ? $faker->dateTimeBetween($created_at, 'now') : null;

    return [
        'first_name' => $faker->boolean(20) ? $this->faker->firstName() : null,
        'last_name' => $faker->boolean(20) ? $this->faker->lastName() : null,
        'email' => $faker->unique()->safeEmail,
        'created_at' => $created_at,
        'unsubscribed_at' => $unsubscribed_at,
    ];
});

$factory->state(NewsletterSubscription::class, 'subscribed', [
    'unsubscribed_at' => now(),
]);

$factory->state(NewsletterSubscription::class, 'unsubscribed', [
    'unsubscribed_at' => null,
]);
