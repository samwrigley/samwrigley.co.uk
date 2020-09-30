<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleTableTestSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory()
            ->create([
                'user_id' => User::factory()->create(['name' => 'Jane Doe']),
                'title' => 'Test',
                'slug' => 'test',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'published_at' => Carbon::parse('01/01/2020'),
            ]);
    }
}
