<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSeries;
use App\Schemas\BlogPostingSchema;
use App\Schemas\SiteSchema;
use App\Services\CommonMark\CommonMark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Spatie\Newsletter\Newsletter;
use Tests\TestCase;

class ArticleShowTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        Config::set('honeypot.enabled', false);
    }

    /** @test */
    public function can_view_a_published_article(): void
    {
        $category = ArticleCategory::factory()->create();

        $article = Article::factory()->published()->create();
        $article->categories()->save($category);

        $formattedPublishedAt = Carbon::parse($article->published_at)
            ->format('jS F Y');

        $body = CommonMark::convertToHtml($article->body);

        $this->getArticleShowRoute($article->slug)
            ->assertOk()
            ->assertSee($article->categories()->first()->title)
            ->assertSee($article->title)
            ->assertSee($article->author->name)
            ->assertSee($body, false)
            ->assertSee($formattedPublishedAt)
            ->assertSee($article->published_at);
    }

    /** @test */
    public function cannot_view_a_draft_article(): void
    {
        $article = Article::factory()->draft()->create();

        $this->getArticleShowRoute($article->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_scheduled_article(): void
    {
        $article = Article::factory()->scheduled()->create();

        $this->getArticleShowRoute($article->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_an_article_that_does_not_exist(): void
    {
        $this->getArticleShowRoute('example-slug')
            ->assertNotFound();
    }

    /** @test */
    public function can_see_out_of_date_notice_when_published_more_than_6_months_ago(): void
    {
        $date = now()->subMonths(7);

        $article = Article::factory()
            ->create(['published_at' => $date]);

        $this->getArticleShowRoute($article->slug)
            ->assertSee(__('article.out_of_date', ['date' => $date->diffForHumans()]));
    }

    /** @test */
    public function cant_see_out_of_date_notice_when_published_less_than_6_months_ago(): void
    {
        $date = now()->subMonths(5);

        $article = Article::factory()
            ->create(['published_at' => $date]);

        $this->getArticleShowRoute($article->slug)
            ->assertDontSee(__('article.out_of_date', ['date' => $date->diffForHumans()]));
    }

    /** @test */
    public function can_see_in_series_notice_when_part_of_a_series(): void
    {
        $articleCount = 2;
        $articles = Article::factory()->count($articleCount)->published()->create();
        $articleSeries = ArticleSeries::factory()->create();
        $articleSeries->articles()->saveMany($articles);

        $this->getArticleShowRoute($articles->first()->slug)
            ->assertSee(__('article.in_series', ['count' => $articleCount]))
            ->assertSee($articles->last()->title);

        $this->getArticleShowRoute($articles->last()->slug)
            ->assertSee(__('article.in_series', ['count' => $articleCount]))
            ->assertSee($articles->first()->title);
    }

    /** @test */
    public function cannot_see_in_series_notice_when_not_part_of_a_series(): void
    {
        $article = Article::factory()->published()->create();

        $this->assertNull($article->series);

        $this->getArticleShowRoute($article->slug)
            ->assertDontSee(__('article.in_series', ['count' => 1]));
    }

    /** @test */
    public function can_subscribe_to_newsletter_with_valid_email(): void
    {
        $email = $this->faker->email;
        $article = Article::factory()->published()->create();

        $this->mock(Newsletter::class, function ($mock) use ($email) {
            $mock->shouldReceive()->isSubscribed($email)->once()->andReturn(false);
            $mock->shouldReceive()->subscribe($email)->once()->andReturn(true);
        });

        $this->followingRedirects()
            ->from(route('blog.articles.show', $article->slug))
            ->post(route('newsletter.subscribe'), ['email' => $email])
            ->assertViewIs('articles.show')
            ->assertOk()
            ->assertSeeText(__('newsletter.subscribe_success'));
    }

    /** @test */
    public function newsletter_form_has_honeypot_fields(): void
    {
        Config::set('honeypot.enabled', true);

        $article = Article::factory()->published()->create();

        $this->getArticleShowRoute($article->slug)
            ->assertSee(Config::get('honeypot.name_field_name'))
            ->assertSee(Config::get('honeypot.valid_from_field_name'));
    }

    /** @test */
    public function has_blog_posting_schema_script(): void
    {
        $article = Article::factory()->published()->create();
        $blogPostingSchema = (new BlogPostingSchema($article))->generate();

        $this->getArticleShowRoute($article->slug)
            ->assertSee($blogPostingSchema->toScript(), false);
    }

    /** @test */
    public function can_see_next_article_link(): void
    {
        $articleOne = Article::factory()->create(['published_at' => now()->subMonths(2)]);
        $articleTwo = Article::factory()->create(['published_at' => now()->subMonth()]);

        $this->getArticleShowRoute($articleOne->slug)
            ->assertSeeText('Next')
            ->assertSeeText($articleTwo->title)
            ->assertSee($articleTwo->showRoute());
    }

    /** @test */
    public function can_see_previous_article_link(): void
    {
        $articleOne = Article::factory()->create(['published_at' => now()]);
        $articleTwo = Article::factory()->create(['published_at' => now()->subMonth()]);

        $this->getArticleShowRoute($articleOne->slug)
            ->assertSeeText('Prev')
            ->assertSeeText($articleTwo->title)
            ->assertSee($articleTwo->showRoute());
    }

    /** @test */
    public function has_site_schema_script(): void
    {
        $article = Article::factory()->published()->create();
        $siteSchema = (new SiteSchema())->generate();

        $this->getArticleShowRoute($article->slug)
            ->assertSee($siteSchema->toScript(), false);
    }

    protected function getArticleShowRoute(string $slug): TestResponse
    {
        return $this->get(route('blog.articles.show', $slug));
    }
}
