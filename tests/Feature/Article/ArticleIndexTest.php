<?php

namespace Tests\Feature\Article;

use App\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_no_article_message_when_no_articles(): void
    {
        $this->getArticleIndexRoute()
            ->assertOk()
            ->assertSeeText(__('article.no_articles_heading'))
            ->assertSeeText(__('article.no_articles_subheading'));
    }

    /** @test */
    public function can_see_a_list_of_articles_in_reverse_chronological_order(): void
    {
        $articles = collect([
            factory(Article::class)->create(['published_at' => now()->subDays(2)]),
            factory(Article::class)->create(['published_at' => now()->subDay()]),
            factory(Article::class)->create(['published_at' => now()]),
        ]);

        $this->getArticleIndexRoute()
            ->assertOk()
            ->assertSeeInOrder(
                $articles->sortByDesc('published_at')->pluck('title')->toArray()
            );
    }

    /** @test */
    public function can_see_a_list_of_paginated_articles(): void
    {
        $articles = factory(Article::class, 18)->create(['published_at' => now()]);
        $articleTitles = $articles->pluck('title');

        $this->getArticleIndexRoute()
            ->assertSeeInOrder($articleTitles->forPage(1, 9)->toArray())
            ->assertDontSee($articleTitles->forPage(2, 9)->first());
    }

    /** @test */
    public function can_see_excerpt_in_list_of_articles(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()]);

        $this->getArticleIndexRoute()
            ->assertSee($article->excerpt);
    }

    /** @test */
    public function can_see_formatted_published_at_in_list_of_articles(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()]);

        $formattedPublishedAt = Carbon::parse($article->published_at)
            ->format('jS F Y');

        $this->getArticleIndexRoute()
            ->assertSee($formattedPublishedAt);
    }

    /** @test */
    public function can_see_published_at_timestamp_in_list_of_articles(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()]);

        $this->getArticleIndexRoute()
            ->assertSee($article->published_at);
    }

    /** @test */
    public function cannot_see_draft_articles_in_list(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => null]);

        $this->getArticleIndexRoute()
            ->assertDontSee($article->title);
    }

    /** @test */
    public function cannot_see_scheduled_articles_in_list(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()->addDays(7)]);

        $this->getArticleIndexRoute()
            ->assertDontSee($article->title);
    }

    private function getArticleIndexRoute(): TestResponse
    {
        return $this->get(
            route('blog.articles.index')
        );
    }
}
