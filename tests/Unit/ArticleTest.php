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

    /** @test */
    public function it_can_be_marked_as_published(): void
    {
        $this->freezeTime();

        $article = factory(Article::class)->states('draft')->make();

        $this->assertNull($article->published_at);
        $article->markAsPublished();
        $this->assertEquals($article->published_at, now());
    }

    /** @test */
    public function it_can_be_marked_as_scheduled(): void
    {
        $this->freezeTime();

        $article = factory(Article::class)->states('draft')->make();

        $this->assertNull($article->published_at);
        $article->markAsScheduled(now()->addWeek());
        $this->assertEquals($article->published_at, now()->addWeek());
    }

    /** @test */
    public function it_can_be_marked_as_draft(): void
    {
        $this->freezeTime();

        $article = factory(Article::class)->states('published')->make();

        $this->assertEquals($article->published_at, now());
        $article->markAsDraft();
        $this->assertNull($article->published_at);
    }

    /** @test */
    public function can_check_if_published(): void
    {
        $article = factory(Article::class)->states('published')->make();

        $this->assertNotNull($article->published_at);
        $this->assertTrue($article->published_at < now());
        $this->assertTrue($article->isPublished());
    }

    /** @test */
    public function can_check_if_scheduled(): void
    {
        $article = factory(Article::class)->states('scheduled')->make();

        $this->assertNotNull($article->published_at);
        $this->assertTrue($article->published_at > now());
        $this->assertTrue($article->isScheduled());
    }

    /** @test */
    public function can_check_if_draft(): void
    {
        $article = factory(Article::class)->states('draft')->make();

        $this->assertNull($article->published_at);
        $this->assertTrue($article->isDraft());
    }

    /** @test */
    public function can_get_published(): void
    {
        factory(Article::class)->states('draft')->create();
        factory(Article::class)->states('scheduled')->create();
        $publishedArticle = factory(Article::class)->states('published')->create();

        $publishedArticles = Article::published()->get();

        $this->assertCount(1, $publishedArticles);
        $this->assertEquals($publishedArticles->first()->id, $publishedArticle->id);
    }

    /** @test */
    public function can_get_scheduled(): void
    {
        factory(Article::class)->states('draft')->create();
        $scheduledArticle = factory(Article::class)->states('scheduled')->create();
        factory(Article::class)->states('published')->create();

        $scheduledArticles = Article::scheduled()->get();

        $this->assertCount(1, $scheduledArticles);
        $this->assertEquals($scheduledArticles->first()->id, $scheduledArticle->id);
    }

    /** @test */
    public function can_get_draft(): void
    {
        $draftArticle = factory(Article::class)->states('draft')->create();
        factory(Article::class)->states('scheduled')->create();
        factory(Article::class)->states('published')->create();

        $draftArticles = Article::draft()->get();

        $this->assertCount(1, $draftArticles);
        $this->assertEquals($draftArticles->first()->id, $draftArticle->id);
    }

    /** @test */
    public function can_get_published_in_a_given_month(): void
    {
        $januaryArticle = factory(Article::class)->create(['published_at' => Carbon::create(2020, 1)]);
        factory(Article::class)->create(['published_at' => Carbon::create(2020, 2)]);
        factory(Article::class)->create(['published_at' => Carbon::create(2020, 3)]);

        $januaryArticles = Article::publishedInMonth('1')->get();

        $this->assertCount(1, $januaryArticles);
        $this->assertEquals($januaryArticles->first()->id, $januaryArticle->id);
    }

    /** @test */
    public function can_get_published_in_a_given_year(): void
    {
        factory(Article::class)->create(['published_at' => Carbon::create(2018)]);
        factory(Article::class)->create(['published_at' => Carbon::create(2019)]);
        $twentyTwentyArticle = factory(Article::class)->create(['published_at' => Carbon::create(2020)]);

        $twentyTwentyArticles = Article::publishedInYear('2020')->get();

        $this->assertCount(1, $twentyTwentyArticles);
        $this->assertEquals($twentyTwentyArticles->first()->id, $twentyTwentyArticle->id);
    }

    /** @test */
    public function can_get_published_before_given_date(): void
    {
        $januaryArticle = factory(Article::class)->create(['published_at' => Carbon::create(2020, 1, 1)]);
        factory(Article::class)->create(['published_at' => Carbon::create(2020, 2, 1)]);
        factory(Article::class)->create(['published_at' => Carbon::create(2020, 3, 1)]);

        $beforeArticles = Article::publishedBefore(Carbon::create(2020, 1, 31))->get();

        $this->assertCount(1, $beforeArticles);
        $this->assertEquals($beforeArticles->first()->id, $januaryArticle->id);
    }

    /** @test */
    public function can_get_published_after_given_date(): void
    {
        factory(Article::class)->create(['published_at' => Carbon::create(2020, 1, 1)]);
        factory(Article::class)->create(['published_at' => Carbon::create(2020, 2, 1)]);
        $marchArticle = factory(Article::class)->create(['published_at' => Carbon::create(2020, 3, 1)]);

        $afterArticles = Article::publishedAfter(Carbon::create(2020, 2, 2))->get();

        $this->assertCount(1, $afterArticles);
        $this->assertEquals($afterArticles->first()->id, $marchArticle->id);
    }

    /** @test */
    public function can_get_published_between_given_dates(): void
    {
        factory(Article::class)->create(['published_at' => Carbon::create(2020, 1, 1)]);
        $februaryArticle = factory(Article::class)->create(['published_at' => Carbon::create(2020, 2, 1)]);
        factory(Article::class)->create(['published_at' => Carbon::create(2020, 3, 1)]);

        $betweenArticles = Article::publishedBetween(
            Carbon::create(2020, 1, 31),
            Carbon::create(2020, 2, 2)
        )->get();

        $this->assertCount(1, $betweenArticles);
        $this->assertEquals($betweenArticles->first()->id, $februaryArticle->id);
    }

    protected function freezeTime(?Carbon $time = null): void
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', $time ?: now());

        Carbon::setTestNow($now);
    }
}
