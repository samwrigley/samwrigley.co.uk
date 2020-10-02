<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ArticleTableSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory()
            ->published()
            ->create([
                'user_id' => User::factory()->create(['name' => 'Jane Doe']),
                'title' => 'Test',
                'slug' => 'test',
                'body' => Storage::get('testArticle.md'),
            ]);

        Article::factory()->count(50)
            ->create()
            ->each(function (Article $article): void {
                $article->categories()->attach(
                    ArticleCategory::all()->random()
                );
            }
        );
    }
}
