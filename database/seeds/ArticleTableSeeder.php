<?php

use App\Article;
use App\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(Article::class, 50)
            ->create()
            ->each(function ($article) {
                $category = ArticleCategory::all()->random();

                $article->categories()->attach($category->id);
            }
        );
    }
}
