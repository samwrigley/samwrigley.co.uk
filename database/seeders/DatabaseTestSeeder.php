<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseTestSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableTestSeeder::class,
            ArticleCategoriesTableTestSeeder::class,
            ArticleSeriesTableTestSeeder::class,
            ArticleTableTestSeeder::class,
        ]);
    }
}
