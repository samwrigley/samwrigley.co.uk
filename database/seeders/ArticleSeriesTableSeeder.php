<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleSeries;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleSeriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $series = ArticleSeries::factory()->create([
            'title' => 'Test',
            'slug' => 'test',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $article = Article::factory()->make([
            'user_id' => User::factory()->create(),
            'title' => 'Lorem ipsum',
            'slug' => 'lorem-ipsum',
            'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created_at' => Carbon::parse('02/01/2020'),
            'published_at' => Carbon::parse('02/01/2020'),
        ]);

        $series->articles()->save($article);
    }
}
