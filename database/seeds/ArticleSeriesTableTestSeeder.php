<?php

use App\ArticleSeries;
use Illuminate\Database\Seeder;

class ArticleSeriesTableTestSeeder extends Seeder
{
    public function run(): void
    {
        factory(ArticleSeries::class)
            ->state('withArticles')
            ->create([
                'title' => 'Test',
                'slug' => 'test',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
    }
}
