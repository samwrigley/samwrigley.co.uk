<?php

use App\Article;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleTableTestSeeder extends Seeder
{
    public function run(): void
    {
        factory(Article::class)
            ->create([
                'user_id' => factory(User::class)->create(['name' => 'Jane Doe']),
                'title' => 'Test',
                'slug' => 'test',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'published_at' => Carbon::parse('01/01/2020'),
            ]);
    }
}
