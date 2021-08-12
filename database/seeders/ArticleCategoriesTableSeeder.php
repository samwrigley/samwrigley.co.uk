<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $category = ArticleCategory::factory()->create([
            'name' => 'Test',
            'slug' => 'test',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $article = Article::factory()->make([
            'user_id' => User::factory()->create(),
            'title' => 'Dolor sit',
            'slug' => 'dolor-sit',
            'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created_at' => Carbon::parse('03/01/2020'),
            'published_at' => Carbon::parse('03/01/2020'),
        ]);

        $category->articles()->save($article);
    }
}
