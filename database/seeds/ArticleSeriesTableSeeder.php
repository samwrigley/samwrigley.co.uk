<?php

use App\Article;
use App\ArticleSeries;
use Illuminate\Database\Seeder;

class ArticleSeriesTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(ArticleSeries::class, 10)
            ->create()
            ->each(function (ArticleSeries $series): void {
                $series->articles()->saveMany(
                    factory(Article::class, 2)->state('published')->make()
                );
            });
    }
}
