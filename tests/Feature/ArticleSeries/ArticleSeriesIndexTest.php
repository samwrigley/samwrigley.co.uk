<?php

namespace Tests\Feature\Article;

use App\Article;
use App\ArticleSeries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleSeriesIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_a_list_of_series_in_chronological_order(): void
    {
        $series = collect([
            factory(ArticleSeries::class)->state('withArticles')->create(['created_at' => now()->subDays(2)]),
            factory(ArticleSeries::class)->state('withArticles')->create(['created_at' => now()->subDay()]),
            factory(ArticleSeries::class)->state('withArticles')->create(['created_at' => now()]),
        ]);

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertSeeInOrder($series->sortByDesc('created_at')->pluck('title')->toArray());
    }

    /** @test */
    public function can_see_a_list_of_paginated_series(): void
    {
        $series = factory(ArticleSeries::class, 18)->state('withArticles')->create();
        $seriesTitles = $series->pluck('title');

        $this->getSeriesIndexRoute()
            ->assertSeeInOrder($seriesTitles->forPage(1, 9)->toArray())
            ->assertDontSee($seriesTitles->forPage(2, 9)->first());
    }

    /** @test */
    public function cannot_see_a_series_that_has_no_articles(): void
    {
        $series = factory(ArticleSeries::class)->create();

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertDontSee($series->title);
    }

    /** @test */
    public function cannot_see_a_series_that_only_has_scheduled_articles(): void
    {
        $series = factory(ArticleSeries::class)->create();
        $articles = factory(Article::class, 2)->create([
            'published_at' => now()->addDays(7),
        ]);

        $series->articles()->saveMany($articles);

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertDontSee($series->title);
    }

    /** @test */
    public function cannot_see_a_series_that_only_has_draft_articles(): void
    {
        $series = factory(ArticleSeries::class)->create();
        $articles = factory(Article::class, 2)->create([
            'published_at' => null,
        ]);

        $series->articles()->saveMany($articles);

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertDontSee($series->title);
    }

    private function getSeriesIndexRoute(): TestResponse
    {
        return $this->get(route('blog.series.index'));
    }
}
