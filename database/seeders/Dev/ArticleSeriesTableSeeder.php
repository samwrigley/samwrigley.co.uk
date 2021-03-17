<?php

namespace Database\Seeders\Dev;

use App\Models\Article;
use App\Models\ArticleSeries;
use Illuminate\Database\Seeder;

class ArticleSeriesTableSeeder extends Seeder
{
    public function run(): void
    {
        ArticleSeries::factory()->count(10)
            ->has(Article::factory()->count(2)->published())
            ->create();
    }
}
