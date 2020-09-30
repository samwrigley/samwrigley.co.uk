<?php

namespace Database\Seeders;

use App\Models\ArticleSeries;
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
