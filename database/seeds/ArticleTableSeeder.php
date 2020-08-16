<?php

use App\Article;
use App\ArticleCategory;
use App\User;
use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(Article::class)->states('published')->create([
            'user_id' => factory(User::class)->create(['name' => 'Jane Doe']),
            'title' => 'Test',
            'slug' => 'test',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
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
