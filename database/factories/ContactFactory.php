<?php

use App\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker): array {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'message' => $faker->paragraphs(5, true),
    ];
});
