<?php

use App\Article;
use App\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(Article::class)->states('published')->create([
            'title' => 'Test',
            'slug' => 'test',
        ]);

        factory(Article::class, 50)
            ->create()
            ->each(function (Article $article): void {
                $article->categories()->attach(
                    ArticleCategory::all()->random()
                );
            }
        );
    }
}
