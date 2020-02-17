<?php

namespace Tests\Unit;

use App\Article;
use App\ArticleSeries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleSeriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_many_articles(): void
    {
        $articles = factory(Article::class, 3)->create(['published_at' => now()->subMonth()]);

        $articleSeries = factory(ArticleSeries::class)->create();
        $articleSeries->articles()->saveMany($articles);

        $this->assertCount(3, $articleSeries->articles);
    }

    /** @test */
    public function its_articles_are_ordered_by_ascending_published_at(): void
    {
        $article = factory(Article::class)->create(['published_at' => now()->subMonth()]);
        $articleTwo = factory(Article::class)->create(['published_at' => now()->subMonths(2)]);
        $articleThree = factory(Article::class)->create(['published_at' => now()->subMonths(3)]);

        $articleSeries = factory(ArticleSeries::class)->create();
        $articleSeries->articles()->saveMany([$article, $articleTwo, $articleThree]);

        $this->assertCount(3, $articleSeries->articles);
        $this->assertEquals($article->id, $articleSeries->articles[2]->id);
        $this->assertEquals($articleTwo->id, $articleSeries->articles[1]->id);
        $this->assertEquals($articleThree->id, $articleSeries->articles[0]->id);
    }

    /** @test */
    public function its_articles_are_all_published(): void
    {
        $publishedArticle = tap(factory(Article::class)->create())->publish();
        $scheduledArticle = tap(factory(Article::class)->create())->publish(now()->addMonth());
        $draftArticle = tap(factory(Article::class)->create())->draft();

        $articleSeries = factory(ArticleSeries::class)->create();
        $articleSeries->articles()->saveMany([
            $publishedArticle,
            $scheduledArticle,
            $draftArticle,
        ]);

        $this->assertCount(1, $articleSeries->articles);
        $this->assertTrue($articleSeries->articles->contains($publishedArticle));
    }
}
