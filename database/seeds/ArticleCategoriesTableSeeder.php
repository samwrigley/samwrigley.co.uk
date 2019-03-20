<?php

use App\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(ArticleCategory::class, 10)->create();
    }
}
