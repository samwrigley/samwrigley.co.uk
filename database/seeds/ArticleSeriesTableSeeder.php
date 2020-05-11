<?php

use App\Article;
use App\ArticleSeries;
use Illuminate\Database\Seeder;

class ArticleSeriesTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(ArticleSeries::class, 10)
            ->state('withArticles')
            ->create();
    }
}
