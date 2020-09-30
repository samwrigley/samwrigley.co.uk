<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\ArticleSeries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleSeriesShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_a_list_of_articles_in_chronological_order(): void
    {
        $articles = collect([
            Article::factory()->make(['published_at' => now()->subDays(2)]),
            Article::factory()->make(['published_at' => now()->subDay()]),
            Article::factory()->make(['published_at' => now()]),
        ]);

        $series = ArticleSeries::factory()->create();
        $series->articles()->saveMany($articles);

        $this->getSeriesShowRoute($series->slug)
            ->assertOk()
            ->assertSeeInOrder($articles->sortBy('published_at')->pluck('title')->toArray());
    }

    /** @test */
    public function can_see_a_list_of_paginated_articles(): void
    {
        $articles = Article::factory()->count(18)->published()->make();
        $articleTitles = $articles->pluck('title');

        $series = ArticleSeries::factory()->create();
        $series->articles()->saveMany($articles);

        $this->getSeriesShowRoute($series->slug)
            ->assertSeeInOrder($articleTitles->forPage(1, 9)->toArray())
            ->assertDontSee($articleTitles->forPage(2, 9)->first());
    }

    /** @test */
    public function cannot_view_an_article_not_within_series(): void
    {
        $article = Article::factory()->published()->create();

        $series = ArticleSeries::factory()->create();

        $this->getSeriesShowRoute($series->slug)
            ->assertDontSee($article->title);
    }

    /** @test */
    public function cannot_view_a_draft_article_within_series(): void
    {
        $article = Article::factory()->draft()->make();

        $series = ArticleSeries::factory()->create();
        $series->articles()->save($article);

        $this->getSeriesShowRoute($series->slug)
            ->assertDontSee($article->title);
    }

    /** @test */
    public function cannot_view_a_scheduled_article_within_series(): void
    {
        $article = Article::factory()->scheduled()->make();

        $series = ArticleSeries::factory()->create();
        $series->articles()->save($article);

        $this->getSeriesShowRoute($series->slug)
            ->assertDontSee($article->title);
    }

    /** @test */
    public function cannot_view_a_series_that_does_not_exist(): void
    {
        $this->getSeriesShowRoute('example-slug')
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_series_that_has_no_articles(): void
    {
        $series = ArticleSeries::factory()->create();

        $this->getSeriesShowRoute($series->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_series_that_only_has_scheduled_articles(): void
    {
        $series = ArticleSeries::factory()->create();
        $articles = Article::factory()->count(2)->scheduled()->make();

        $series->articles()->saveMany($articles);

        $this->getSeriesShowRoute($series->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_series_that_only_has_draft_articles(): void
    {
        $series = ArticleSeries::factory()->create();
        $articles = Article::factory()->count(2)->draft()->make();

        $series->articles()->saveMany($articles);

        $this->getSeriesShowRoute($series->slug)
            ->assertNotFound();
    }

    private function getSeriesShowRoute(string $slug): TestResponse
    {
        return $this->get(route('blog.series.show', $slug));
    }
}
