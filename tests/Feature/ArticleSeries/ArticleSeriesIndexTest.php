<?php

namespace Tests\Feature\Article;

use App\Article;
use App\ArticleSeries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class ArticleSeriesIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_a_list_of_series(): void
    {
        $series = factory(ArticleSeries::class)->create();
        $articles = factory(Article::class, 5)->create();

        $series->articles()->saveMany($articles);

        $this->getSeriesIndexRoute()
            ->assertOk()
            ->assertSee($series->title);
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
