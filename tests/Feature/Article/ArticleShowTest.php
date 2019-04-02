<?php

namespace Tests\Feature\Article;

use App\Article;
use App\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ArticleShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_a_published_article(): void
    {
        $category = factory(ArticleCategory::class)->create();

        $article = factory(Article::class)->create(['published_at' => now()]);
        $article->categories()->attach($category);

        $formattedPublishedAt = Carbon::parse($article->published_at)
            ->toFormattedDateString();

        $this->getArticleShowRoute($article->slug)
            ->assertOk()
            ->assertSeeText($article->categories()->first()->title)
            ->assertSeeText($article->title)
            ->assertSeeText($article->author->name)
            ->assertSeeText($article->body)
            ->assertSeeText($formattedPublishedAt)
            ->assertSee($article->published_at);
    }

    /** @test */
    public function cannot_view_a_draft_article(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => null]);

        $this->getArticleShowRoute($article->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_scheduled_article(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()->addDays(7)]);

        $this->getArticleShowRoute($article->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_an_article_that_does_not_exist(): void
    {
        $this->getArticleShowRoute('example-slug')
            ->assertNotFound();
    }

    private function getArticleShowRoute(string $articleSlug): TestResponse
    {
        return $this->get(
            route('blog.articles.show', $articleSlug)
        );
    }
}
