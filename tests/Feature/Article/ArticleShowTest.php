<?php

namespace Tests\Feature\Article;

use App\Article;
use App\ArticleCategory;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ArticleShowTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_view_a_published_article(): void
    {
        $category = factory(ArticleCategory::class)->create();

        $article = factory(Article::class)->states('published')->create();
        $article->categories()->save($category);

        $formattedPublishedAt = Carbon::parse($article->published_at)
            ->format('jS F Y');

        $body = Markdown::convertToHtml($article->body);

        $this->getArticleShowRoute($article->slug)
            ->assertOk()
            ->assertSee($article->categories()->first()->title)
            ->assertSee($article->title)
            ->assertSee($article->author->name)
            ->assertSee($body)
            ->assertSee($formattedPublishedAt)
            ->assertSee($article->published_at);
    }

    /** @test */
    public function cannot_view_a_draft_article(): void
    {
        $article = factory(Article::class)->states('draft')->create();

        $this->getArticleShowRoute($article->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_scheduled_article(): void
    {
        $article = factory(Article::class)->states('scheduled')->create();

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

        $article = factory(Article::class)
            ->create(['published_at' => $date]);

        $this->getArticleShowRoute($article->slug)
            ->assertSee(__('newsletter.out_of_date', ['date' => $date->diffForHumans()]));
    }

    /** @test */
    public function cant_see_out_of_date_notice_when_published_less_than_6_months_ago(): void
    {
        $date = now()->subMonths(5);

        $article = factory(Article::class)
            ->create(['published_at' => $date]);

        $this->getArticleShowRoute($article->slug)
            ->assertDontSee(__('newsletter.out_of_date', ['date' => $date->diffForHumans()]));
    }

    /** @test */
    public function can_subscribe_to_newsletter_with_valid_email(): void
    {
        $article = factory(Article::class)->states('published')->create();

        $this->followingRedirects()
            ->from(route('blog.articles.show', $article->slug))
            ->post(route('newsletter.subscribe'), ['email' => $this->faker->email])
            ->assertViewIs('articles.show')
            ->assertOk()
            ->assertSeeText(__('newsletter.success'));
    }

    protected function getArticleShowRoute(string $slug): TestResponse
    {
        return $this->get(route('blog.articles.show', $slug));
    }
}
