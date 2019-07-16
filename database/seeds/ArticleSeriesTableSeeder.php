<?php

use App\ArticleSeries;
use Illuminate\Database\Seeder;

class ArticleSeriesTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(ArticleSeries::class, 5)->create();
    }
}
