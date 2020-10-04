<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSeries;
use App\Models\User;
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
        $article = Article::factory()->create();

        $this->assertInstanceOf(User::class, $article->author);
    }

    /** @test */
    public function it_can_belong_to_many_categories(): void
    {
        $article = Article::factory()->create();

        $this->assertCount(0, $article->categories);

        $articleWithCategories = Article::factory()->create();
        $categories = ArticleCategory::factory()->count(2)->create();
        $articleWithCategories->categories()->attach($categories);

        $this->assertCount(2, $articleWithCategories->categories);
        $this->assertInstanceOf(ArticleCategory::class, $articleWithCategories->categories->first());
    }

    /** @test */
    public function it_can_belong_to_a_series(): void
    {
        $article = Article::factory()->make();

        $this->assertNull($article->series);

        $articleInSeries = Article::factory()->make();
        $articleSeries = ArticleSeries::factory()->make();
        $articleInSeries->series()->associate($articleSeries);

        $this->assertInstanceOf(ArticleSeries::class, $articleInSeries->series);
    }

    /** @test */
    public function can_get_formatted_body(): void
    {
        $article = Article::factory()->create(['body' => '# Heading']);

        $this->assertEquals($article->formattedBody, "<h1>Heading</h1>\n");
    }

    /** @test */
    public function its_new_when_published_a_month_ago_or_less(): void
    {
        $this->freezeTime();

        $article = tap(Article::factory()->create())->markAsPublished();

        $this->assertTrue($article->isNew());
        $this->assertFalse($article->isOld());
    }

    /** @test */
    public function its_new_when_published_x_months_ago_or_less(): void
    {
        $this->freezeTime();

        $months = 2;
        $article = tap(Article::factory()->create())
            ->markAsScheduled(now()->subMonths($months));

        $this->assertTrue($article->isNew($months));
        $this->assertFalse($article->isOld($months));
    }

    /** @test */
    public function its_old_when_published_more_than_six_months_ago(): void
    {
        $this->freezeTime();

        $article = tap(Article::factory()->create())
            ->markAsScheduled(now()->subMonth(6)->subSecond());

        $this->assertTrue($article->isOld());
        $this->assertFalse($article->isNew());
    }

    /** @test */
    public function its_old_when_published_more_than_x_months_ago(): void
    {
        $this->freezeTime();

        $months = 7;
        $article = tap(Article::factory()->create())
            ->markAsScheduled(now()->subMonth($months)->subSecond());

        $this->assertTrue($article->isOld($months));
        $this->assertFalse($article->isNew($months));
    }

    /** @test */
    public function can_get_next_article(): void
    {
        $articleOne = Article::factory()->create(['published_at' => now()->subMonths(3)]);
        $articleTwo = Article::factory()->create(['published_at' => now()->subMonths(2)]);
        $articleThree = Article::factory()->create(['published_at' => now()->subMonth()]);

        $firstArticle = $articleOne;
        $secondArticle = $firstArticle->next();
        $thirdArticle = $secondArticle->next();

        $this->assertEquals($articleTwo->id, $secondArticle->id);
        $this->assertEquals($articleThree->id, $thirdArticle->id);
        $this->assertNull($thirdArticle->next());
    }

    /** @test */
    public function can_get_previous_article(): void
    {
        $articleOne = Article::factory()->create(['published_at' => now()->subMonths(3)]);
        $articleTwo = Article::factory()->create(['published_at' => now()->subMonths(2)]);
        $articleThree = Article::factory()->create(['published_at' => now()->subMonth()]);

        $thirdArticle = $articleThree;
        $secondArticle = $thirdArticle->previous();
        $firstArticle = $secondArticle->previous();

        $this->assertEquals($articleTwo->id, $secondArticle->id);
        $this->assertEquals($articleOne->id, $firstArticle->id);
        $this->assertNull($firstArticle->previous());
    }

    /** @test */
    public function can_get_next_article_in_series(): void
    {
        $articleOne = Article::factory()->create(['published_at' => now()->subMonths(3)]);
        $articleTwo = Article::factory()->create(['published_at' => now()->subMonths(2)]);
        $articleThree = Article::factory()->create(['published_at' => now()->subMonth()]);
        $articleSeries = ArticleSeries::factory()->create();
        $articleSeries->articles()->saveMany([$articleOne, $articleTwo, $articleThree]);

        $firstArticle = $articleSeries->articles->first();
        $secondArticle = $firstArticle->nextInSeries();
        $thirdArticle = $secondArticle->nextInSeries();

        $this->assertEquals($articleTwo->id, $secondArticle->id);
        $this->assertEquals($articleThree->id, $thirdArticle->id);
        $this->assertNull($thirdArticle->nextInSeries());
    }

    /** @test */
    public function can_get_previous_article_in_series(): void
    {
        $articleOne = Article::factory()->create(['published_at' => now()->subMonths(3)]);
        $articleTwo = Article::factory()->create(['published_at' => now()->subMonths(2)]);
        $articleThree = Article::factory()->create(['published_at' => now()->subMonth()]);
        $articleSeries = ArticleSeries::factory()->create();
        $articleSeries->articles()->saveMany([$articleOne, $articleTwo, $articleThree]);

        $thirdArticle = $articleSeries->articles->last();
        $secondArticle = $thirdArticle->previousInSeries();
        $firstArticle = $secondArticle->previousInSeries();

        $this->assertEquals($articleTwo->id, $secondArticle->id);
        $this->assertEquals($articleOne->id, $firstArticle->id);
        $this->assertNull($firstArticle->previousInSeries());
    }

    /** @test */
    public function can_be_converted_to_feed_item(): void
    {
        $article = Article::factory()->published()->create();

        $feedItem = $article->toFeedItem();

        $this->assertInstanceOf(FeedItem::class, $feedItem);
        $this->assertEquals($article->id, $feedItem->id);
        $this->assertEquals($article->title, $feedItem->title);
        $this->assertEquals($article->excerpt, $feedItem->summary);
        $this->assertEquals($article->published_at, $feedItem->updated);
        $this->assertEquals($article->showRoute(), $feedItem->link);
        $this->assertEquals($article->author->name, $feedItem->author);
    }

    /** @test */
    public function can_get_published_feed_items(): void
    {
        Article::factory()->draft()->create();
        Article::factory()->scheduled()->create();
        $publishedArticle = Article::factory()->published()->create();

        $feedItems = $publishedArticle->getFeedItems();

        $this->assertCount(1, $feedItems);
        $this->assertEquals($publishedArticle->fresh(), $feedItems->first());
    }

    /** @test */
    public function it_can_be_marked_as_published(): void
    {
        $this->freezeTime();

        $article = Article::factory()->draft()->make();

        $this->assertNull($article->published_at);
        $article->markAsPublished();
        $this->assertEquals($article->published_at, now());
    }

    /** @test */
    public function it_can_be_marked_as_scheduled(): void
    {
        $this->freezeTime();

        $article = Article::factory()->draft()->make();

        $this->assertNull($article->published_at);
        $article->markAsScheduled(now()->addWeek());
        $this->assertEquals($article->published_at, now()->addWeek());
    }

    /** @test */
    public function it_can_be_marked_as_draft(): void
    {
        $this->freezeTime();

        $article = Article::factory()->published()->make();

        $this->assertEquals($article->published_at, now());
        $article->markAsDraft();
        $this->assertNull($article->published_at);
    }

    /** @test */
    public function can_check_if_published(): void
    {
        $article = Article::factory()->published()->make();

        $this->assertNotNull($article->published_at);
        $this->assertTrue($article->published_at <= now());
        $this->assertTrue($article->isPublished());
        $this->assertFalse($article->isScheduled());
        $this->assertFalse($article->isDraft());
    }

    /** @test */
    public function can_check_if_scheduled(): void
    {
        $article = Article::factory()->scheduled()->make();

        $this->assertNotNull($article->published_at);
        $this->assertTrue($article->published_at > now());
        $this->assertTrue($article->isScheduled());
        $this->assertFalse($article->isPublished());
        $this->assertFalse($article->isDraft());
    }

    /** @test */
    public function can_check_if_draft(): void
    {
        $article = Article::factory()->draft()->make();

        $this->assertNull($article->published_at);
        $this->assertTrue($article->isDraft());
        $this->assertFalse($article->isScheduled());
        $this->assertFalse($article->isPublished());
    }

    /** @test */
    public function can_get_published(): void
    {
        Article::factory()->draft()->create();
        Article::factory()->scheduled()->create();
        $publishedArticle = Article::factory()->published()->create();

        $publishedArticles = Article::published()->get();

        $this->assertCount(1, $publishedArticles);
        $this->assertEquals($publishedArticles->first()->id, $publishedArticle->id);
    }

    /** @test */
    public function can_get_scheduled(): void
    {
        Article::factory()->draft()->create();
        $scheduledArticle = Article::factory()->scheduled()->create();
        Article::factory()->published()->create();

        $scheduledArticles = Article::scheduled()->get();

        $this->assertCount(1, $scheduledArticles);
        $this->assertEquals($scheduledArticles->first()->id, $scheduledArticle->id);
    }

    /** @test */
    public function can_get_draft(): void
    {
        $draftArticle = Article::factory()->draft()->create();
        Article::factory()->scheduled()->create();
        Article::factory()->published()->create();

        $draftArticles = Article::draft()->get();

        $this->assertCount(1, $draftArticles);
        $this->assertEquals($draftArticles->first()->id, $draftArticle->id);
    }

    /** @test */
    public function can_get_published_in_a_given_month(): void
    {
        $januaryArticle = Article::factory()->create(['published_at' => Carbon::create(2020, 1)]);
        Article::factory()->create(['published_at' => Carbon::create(2020, 2)]);
        Article::factory()->create(['published_at' => Carbon::create(2020, 3)]);

        $januaryArticles = Article::publishedInMonth('1')->get();

        $this->assertCount(1, $januaryArticles);
        $this->assertEquals($januaryArticles->first()->id, $januaryArticle->id);
    }

    /** @test */
    public function can_get_published_in_a_given_year(): void
    {
        Article::factory()->create(['published_at' => Carbon::create(2018)]);
        Article::factory()->create(['published_at' => Carbon::create(2019)]);
        $twentyTwentyArticle = Article::factory()->create(['published_at' => Carbon::create(2020)]);

        $twentyTwentyArticles = Article::publishedInYear('2020')->get();

        $this->assertCount(1, $twentyTwentyArticles);
        $this->assertEquals($twentyTwentyArticles->first()->id, $twentyTwentyArticle->id);
    }

    /** @test */
    public function can_get_published_before_given_date(): void
    {
        $januaryArticle = Article::factory()->create(['published_at' => Carbon::create(2020, 1, 1)]);
        Article::factory()->create(['published_at' => Carbon::create(2020, 2, 1)]);
        Article::factory()->create(['published_at' => Carbon::create(2020, 3, 1)]);

        $beforeArticles = Article::publishedBefore(Carbon::create(2020, 1, 31))->get();

        $this->assertCount(1, $beforeArticles);
        $this->assertEquals($beforeArticles->first()->id, $januaryArticle->id);
    }

    /** @test */
    public function can_get_published_after_given_date(): void
    {
        Article::factory()->create(['published_at' => Carbon::create(2020, 1, 1)]);
        Article::factory()->create(['published_at' => Carbon::create(2020, 2, 1)]);
        $marchArticle = Article::factory()->create(['published_at' => Carbon::create(2020, 3, 1)]);

        $afterArticles = Article::publishedAfter(Carbon::create(2020, 2, 2))->get();

        $this->assertCount(1, $afterArticles);
        $this->assertEquals($afterArticles->first()->id, $marchArticle->id);
    }

    /** @test */
    public function can_get_published_between_given_dates(): void
    {
        Article::factory()->create(['published_at' => Carbon::create(2020, 1, 1)]);
        $februaryArticle = Article::factory()->create(['published_at' => Carbon::create(2020, 2, 1)]);
        Article::factory()->create(['published_at' => Carbon::create(2020, 3, 1)]);

        $betweenArticles = Article::publishedBetween(
            Carbon::create(2020, 1, 31),
            Carbon::create(2020, 2, 2)
        )->get();

        $this->assertCount(1, $betweenArticles);
        $this->assertEquals($betweenArticles->first()->id, $februaryArticle->id);
    }

    /** @test */
    public function can_get_show_route(): void
    {
        $article = Article::factory()->published()->make();

        $route = route($article->routeNamespaces['web'] . 'show', [$article->slug]);

        $this->assertEquals($route, $article->showRoute());
    }

    /** @test */
    public function can_get_published_date_when_article_is_published(): void
    {
        $publishedAt = now();
        $article = Article::factory()->make(['published_at' => $publishedAt]);

        $this->assertEquals(
            $article->publishedDate,
            Carbon::parse($publishedAt)->format(Article::$PUBLISHED_DATE_FORMAT)
        );
    }

    /** @test */
    public function cannot_get_published_date_when_article_is_not_published(): void
    {
        $article = Article::factory()->draft()->make();

        $this->assertNull($article->publishedDate);
    }

    /** @test */
    public function can_get_published_time_when_article_is_published(): void
    {
        $publishedAt = now();
        $article = Article::factory()->make(['published_at' => $publishedAt]);

        $this->assertEquals(
            $article->publishedTime,
            Carbon::parse($publishedAt)->format(Article::$PUBLISHED_TIME_FORMAT)
        );
    }

    /** @test */
    public function cannot_get_published_time_when_article_is_not_published(): void
    {
        $article = Article::factory()->draft()->make();

        $this->assertNull($article->publishedTime);
    }

    protected function freezeTime(?Carbon $time = null): void
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', $time ?: now());

        Carbon::setTestNow($now);
    }
}
