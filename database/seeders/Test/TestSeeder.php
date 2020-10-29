<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ArticleCategoriesTableSeeder::class,
            ArticleSeriesTableSeeder::class,
            ArticleTableSeeder::class,
        ]);
    }
}
