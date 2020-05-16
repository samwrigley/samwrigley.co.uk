<?php

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
