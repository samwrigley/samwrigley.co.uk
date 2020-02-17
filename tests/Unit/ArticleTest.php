<?php

namespace Tests\Unit;

use App\Article;
use App\ArticleCategory;
use App\ArticleSeries;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Spatie\Feed\FeedItem;
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
    public function it_can_belong_to_many_categories(): void
    {
        $article = factory(Article::class)->create();

        $this->assertCount(0, $article->categories);

        $articleWithCategories = factory(Article::class)->create();
        $categories = factory(ArticleCategory::class, 2)->create();
        $articleWithCategories->categories()->attach($categories);

        $this->assertCount(2, $articleWithCategories->categories);
        $this->assertInstanceOf(ArticleCategory::class, $articleWithCategories->categories->first());
    }

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
    public function its_new_when_published_a_month_ago_or_less(): void
    {
        $this->freezeTime();

        $article = tap(factory(Article::class)->create())->publish();

        $this->assertTrue($article->isNew());
        $this->assertFalse($article->isOld());
    }

    /** @test */
    public function its_new_when_published_x_months_ago_or_less(): void
    {
        $this->freezeTime();

        $months = 2;
        $article = tap(factory(Article::class)->create())
            ->publish(now()->subMonths($months));

        $this->assertTrue($article->isNew($months));
        $this->assertFalse($article->isOld($months));
    }

    /** @test */
    public function its_old_when_published_more_than_six_months_ago(): void
    {
        $this->freezeTime();

        $article = tap(factory(Article::class)->create())
            ->publish(now()->subMonth(6)->subSecond());

        $this->assertTrue($article->isOld());
        $this->assertFalse($article->isNew());
    }

    /** @test */
    public function its_old_when_published_more_than_x_months_ago(): void
    {
        $this->freezeTime();

        $months = 7;
        $article = tap(factory(Article::class)->create())
            ->publish(now()->subMonth($months)->subSecond());

        $this->assertTrue($article->isOld($months));
        $this->assertFalse($article->isNew($months));
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

    /** @test */
    public function can_be_converted_to_feed_item(): void
    {
        $article = factory(Article::class)->states('published')->create();
        $category = factory(ArticleCategory::class)->create();
        $article->categories()->attach($category);

        $feedItem = $article->toFeedItem();

        $this->assertInstanceOf(FeedItem::class, $feedItem);
        $this->assertEquals($article->id, $feedItem->id);
        $this->assertEquals($article->title, $feedItem->title);
        $this->assertEquals($article->excerpt, $feedItem->summary);
        $this->assertEquals($article->published_at, $feedItem->updated);
        $this->assertEquals($article->showPath(), $feedItem->link);
        $this->assertEquals($article->author->name, $feedItem->author);
        $this->assertEquals($article->categories()->first()->name, $feedItem->category);
    }

    /** @test */
    public function can_get_published_feed_items(): void
    {
        factory(Article::class)->states('draft')->create();
        factory(Article::class)->states('scheduled')->create();
        $publishedArticle = factory(Article::class)->states('published')->create();

        $feedItems = $publishedArticle->getFeedItems();

        $this->assertCount(1, $feedItems);
        $this->assertEquals($publishedArticle->fresh(), $feedItems->first());
    }

    protected function freezeTime(?Carbon $time = null): void
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', $time ?: now());

        Carbon::setTestNow($now);
    }
}
