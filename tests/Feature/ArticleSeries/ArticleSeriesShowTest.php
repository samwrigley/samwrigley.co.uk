<?php

namespace Tests\Feature\Article;

use App\Article;
use App\ArticleSeries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class ArticleSeriesShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_a_list_of_articles_in_chronological_order(): void
    {
        $articles = collect([
            factory(Article::class)->make(['published_at' => now()->subDays(2)]),
            factory(Article::class)->make(['published_at' => now()->subDay()]),
            factory(Article::class)->make(['published_at' => now()]),
        ]);

        $series = factory(ArticleSeries::class)->create();
        $series->articles()->saveMany($articles);

        $this->getSeriesShowRoute($series->slug)
            ->assertOk()
            ->assertSeeInOrder($articles->sortBy('published_at')->pluck('title')->toArray());
    }

    /** @test */
    public function can_see_a_list_of_paginated_articles(): void
    {
        $articles = factory(Article::class, 18)->state('published')->make();
        $articleTitles = $articles->pluck('title');

        $series = factory(ArticleSeries::class)->create();
        $series->articles()->saveMany($articles);

        $this->getSeriesShowRoute($series->slug)
            ->assertSeeInOrder($articleTitles->forPage(1, 9)->toArray())
            ->assertDontSee($articleTitles->forPage(2, 9)->first());
    }

    /** @test */
    public function cannot_view_an_article_not_within_series(): void
    {
        $article = factory(Article::class)->state('published')->create();

        $series = factory(ArticleSeries::class)->create();

        $this->getSeriesShowRoute($series->slug)
            ->assertDontSee($article->title);
    }

    /** @test */
    public function cannot_view_a_draft_article_within_series(): void
    {
        $article = factory(Article::class)->state('draft')->make();

        $series = factory(ArticleSeries::class)->create();
        $series->articles()->save($article);

        $this->getSeriesShowRoute($series->slug)
            ->assertDontSee($article->title);
    }

    /** @test */
    public function cannot_view_a_scheduled_article_within_series(): void
    {
        $article = factory(Article::class)->state('scheduled')->make();

        $series = factory(ArticleSeries::class)->create();
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
        $series = factory(ArticleSeries::class)->create();

        $this->getSeriesShowRoute($series->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_series_that_only_has_scheduled_articles(): void
    {
        $series = factory(ArticleSeries::class)->create();
        $articles = factory(Article::class, 2)->state('scheduled')->make();

        $series->articles()->saveMany($articles);

        $this->getSeriesShowRoute($series->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_series_that_only_has_draft_articles(): void
    {
        $series = factory(ArticleSeries::class)->create();
        $articles = factory(Article::class, 2)->state('draft')->make();

        $series->articles()->saveMany($articles);

        $this->getSeriesShowRoute($series->slug)
            ->assertNotFound();
    }

    private function getSeriesShowRoute(string $slug): TestResponse
    {
        return $this->get(route('blog.series.show', $slug));
    }
}
