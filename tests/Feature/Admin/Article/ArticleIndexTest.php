<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_admin_article_index_page_when_authenticated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.articles.index'))
            ->assertViewIs('admin.articles.index')
            ->assertOk();
    }

    /** @test */
    public function cannot_view_admin_article_index_page_when_not_authenticated(): void
    {
        $this->followingRedirects()
            ->get(route('admin.articles.index'))
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function can_see_a_list_of_articles_in_chronological_created_order(): void
    {
        $user = User::factory()->create();

        $articles = collect([
            Article::factory()->create(['created_at' => now()]),
            Article::factory()->create(['created_at' => now()->subDay()]),
            Article::factory()->create(['created_at' => now()->subDays(2)]),
        ]);

        $this->actingAs($user)
            ->get(route('admin.articles.index'))
            ->assertOk()
            ->assertSeeInOrder(
                $articles->sortByDesc('created_at')->pluck('title')->toArray()
            );
    }

    /** @test */
    public function can_see_a_list_of_paginated_articles(): void
    {
        $user = User::factory()->create();
        $articles = Article::factory()->count(50)->create(['created_at' => now()]);
        $articleTitles = $articles->pluck('title');

        $this->actingAs($user)
            ->get(route('admin.articles.index'))
            ->assertSeeInOrder($articleTitles->forPage(1, 25)->toArray())
            ->assertDontSee($articleTitles->forPage(2, 25)->first());
    }
}
