<?php

use App\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategoriesTableTestSeeder extends Seeder
{
    public function run(): void
    {
        factory(ArticleCategory::class)
            ->state('withArticle')
            ->create([
                'name' => 'Test',
                'slug' => 'test',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
    }
}
