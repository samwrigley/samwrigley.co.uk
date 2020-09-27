<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleSeries;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleSeriesTableTestSeeder extends Seeder
{
    public function run(): void
    {
        $series = factory(ArticleSeries::class)->create([
            'title' => 'Test',
            'slug' => 'test',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $article = factory(Article::class)->make([
            'user_id' => factory(User::class)->create(),
            'title' => 'Lorem ipsum',
            'slug' => 'lorem-ipsum',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'published_at' => Carbon::parse('01/01/2020'),
        ]);

        $series->articles()->save($article);
    }
}
