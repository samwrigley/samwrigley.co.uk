<?php

namespace Tests\Unit;

use App\Article;
use App\ArticleCategory;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_author(): void
    {
        $article = factory(Article::class)->create();

        $this->assertInstanceOf(User::class, $article->author);
    }

    /** @test */
    public function it_belongs_to_many_categories(): void
    {
        $categoryCount = 2;
        $categories = factory(ArticleCategory::class, $categoryCount)->create();

        $article = factory(Article::class)->create();
        $article->categories()->attach($categories);

        $this->assertCount($categoryCount, $article->categories);

    /** @test */
    public function it_can_belong_to_a_series(): void
    {
        $article = factory(Article::class)->make();

        $this->assertNull($article->series);

        $articleInSeries = factory(Article::class)->make();
        $articleSeries = factory(ArticleSeries::class)->make();
        $articleInSeries->series()->associate($articleSeries);

        $this->assertInstanceOf(ArticleSeries::class, $articleInSeries->series);
    }

    /** @test */
    public function it_can_be_published(): void
    {
        $publishedArticle = tap(factory(Article::class)->create())->publish();

        $this->assertTrue($publishedArticle->isPublished());
        $this->assertFalse($publishedArticle->isScheduled());
    }

    /** @test */
    public function it_can_be_scheduled(): void
    {
        $scheduledArticle = tap(factory(Article::class)->create())
            ->publish(now()->addDays(7));

        $this->assertTrue($scheduledArticle->isScheduled());
        $this->assertFalse($scheduledArticle->isPublished());
    }

    /** @test */
    public function it_can_be_draft(): void
    {
        $draftArticle = tap(factory(Article::class)->create())->draft();

        $this->assertTrue($draftArticle->isDraft());
    }

    /** @test */
    public function can_get_next_article_in_series(): void
    {
        $articleOne = factory(Article::class)->create(['published_at' => now()->subMonths(3)]);
        $articleTwo = factory(Article::class)->create(['published_at' => now()->subMonths(2)]);
        $articleThree = factory(Article::class)->create(['published_at' => now()->subMonth()]);
        $articleSeries = factory(ArticleSeries::class)->create();
        $articleSeries->articles()->saveMany([$articleOne, $articleTwo, $articleThree]);

        $firstArticle = $articleSeries->articles->first();
        $secondArticle = $firstArticle->next();
        $thirdArticle = $secondArticle->next();

        $this->assertEquals($articleTwo->id, $secondArticle->id);
        $this->assertEquals($articleThree->id, $thirdArticle->id);
        $this->assertNull($thirdArticle->next());
    }

    /** @test */
    public function can_get_previous_article_in_series(): void
    {
        $articleOne = factory(Article::class)->create(['published_at' => now()->subMonths(3)]);
        $articleTwo = factory(Article::class)->create(['published_at' => now()->subMonths(2)]);
        $articleThree = factory(Article::class)->create(['published_at' => now()->subMonth()]);
        $articleSeries = factory(ArticleSeries::class)->create();
        $articleSeries->articles()->saveMany([$articleOne, $articleTwo, $articleThree]);

        $thirdArticle = $articleSeries->articles->last();
        $secondArticle = $thirdArticle->previous();
        $firstArticle = $secondArticle->previous();

        $this->assertEquals($articleTwo->id, $secondArticle->id);
        $this->assertEquals($articleOne->id, $firstArticle->id);
        $this->assertNull($firstArticle->previous());
    }
}
