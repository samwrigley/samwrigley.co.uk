<?php

namespace Tests\Feature\ArticleSeries;

use App\Models\Article;
use App\Models\ArticleSeries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleSeriesIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_not_found_page_when_no_series(): void
    {
        $this->getSeriesIndexRoute()->assertNotFound();
    }

    /** @test */
    public function can_see_a_list_of_series_in_chronological_order(): void
    {
        $series = collect([
            ArticleSeries::factory()
                ->has(Article::factory()->count(2)->published())
                ->create(['created_at' => now()->subDays(2)]),
            ArticleSeries::factory()
                ->has(Article::factory()->count(2)->published())
                ->create(['created_at' => now()->subDay()]),
            ArticleSeries::factory()
                ->has(Article::factory()->count(2)->published())
                ->create(['created_at' => now()]),
        ]);

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertSeeInOrder($series->sortByDesc('created_at')->pluck('title')->toArray());
    }

    /** @test */
    public function can_see_a_list_of_paginated_series(): void
    {
        $series = ArticleSeries::factory()
            ->count(18)
            ->has(Article::factory()->count(2)->published())
            ->create();
        $seriesTitles = $series->pluck('title');

        $this->getSeriesIndexRoute()
            ->assertSeeInOrder($seriesTitles->forPage(1, 9)->toArray())
            ->assertDontSee($seriesTitles->forPage(2, 9)->first());
    }

    /** @test */
    public function cannot_see_a_series_that_has_no_articles(): void
    {
        $seriesWithoutArticles = ArticleSeries::factory()->create();
        $seriesWithArticles = ArticleSeries::factory()
            ->has(Article::factory()->count(2)->published())
            ->create();

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertDontSeeText($seriesWithoutArticles->title)
            ->assertSeeText($seriesWithArticles->title);
    }

    /** @test */
    public function cannot_see_a_series_that_only_has_scheduled_articles(): void
    {
        $seriesWithScheduledArticles = ArticleSeries::factory()->create();
        $seriesWithPublishedArticles = ArticleSeries::factory()
            ->has(Article::factory()->count(2)->published())
            ->create();
        $scheduledArticles = Article::factory()->count(2)->scheduled()->create();

        $seriesWithScheduledArticles->articles()->saveMany($scheduledArticles);

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertDontSeeText($seriesWithScheduledArticles->title)
            ->assertSeeText($seriesWithPublishedArticles->title);
    }

    /** @test */
    public function cannot_see_a_series_that_only_has_draft_articles(): void
    {
        $seriesWithDraftArticles = ArticleSeries::factory()->create();
        $seriesWithPublishedArticles = ArticleSeries::factory()
            ->has(Article::factory()->count(2)->published())
            ->create();
        $draftArticles = Article::factory()->count(2)->draft()->create();

        $seriesWithDraftArticles->articles()->saveMany($draftArticles);

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertDontSeeText($seriesWithDraftArticles->title)
            ->assertSeeText($seriesWithPublishedArticles->title);
    }

    private function getSeriesIndexRoute(): TestResponse
    {
        return $this->get(route('blog.series.index'));
    }
}
