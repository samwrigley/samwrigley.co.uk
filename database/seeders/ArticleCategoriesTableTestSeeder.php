<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleCategoriesTableTestSeeder extends Seeder
{
    public function run(): void
    {
        $category = factory(ArticleCategory::class)->create([
            'name' => 'Test',
            'slug' => 'test',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $article = factory(Article::class)->make([
            'user_id' => factory(User::class)->create(),
            'title' => 'Dolor sit',
            'slug' => 'dolor-sit',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'published_at' => Carbon::parse('01/01/2020'),
        ]);

        $category->articles()->save($article);
    }
}
