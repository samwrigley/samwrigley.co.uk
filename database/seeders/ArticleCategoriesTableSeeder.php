<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        ArticleCategory::factory()->count(10)->create();
    }
}
