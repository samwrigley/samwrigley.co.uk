<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ArticleCategoriesTableSeeder::class,
            ArticleSeriesTableSeeder::class,
            ArticleTableSeeder::class,
            ContactsTableSeeder::class,
            NewsletterSubscriptionsTableSeeder::class,
        ]);
    }
}
