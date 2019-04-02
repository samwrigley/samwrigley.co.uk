<?php

namespace Tests\Feature\Article;

use App\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ArticleIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_a_list_of_articles_in_reverse_chronological_order(): void
    {
        $articles = collect([
            factory(Article::class)->create(['published_at' => now()]),
            factory(Article::class)->create(['published_at' => now()->subDay()]),
            factory(Article::class)->create(['published_at' => now()->subDays(2)]),
        ]);

        $this->getArticleIndexRoute()
            ->assertOk()
            ->assertSeeTextInOrder(
                $articles->pluck('title')->toArray()
            );
    }

    /** @test */
    public function can_see_excerpt_in_list_of_articles(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()]);

        $this->getArticleIndexRoute()
            ->assertSeeText($article->excerpt);
    }

    /** @test */
    public function can_see_formatted_published_at_in_list_of_articles(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()]);

        $formattedPublishedAt = Carbon::parse($article->published_at)
            ->toFormattedDateString();

        $this->getArticleIndexRoute()
            ->assertSeeText($formattedPublishedAt);
    }

    /** @test */
    public function can_see_published_at_timestamp_in_list_of_articles(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()]);

        $this->getArticleIndexRoute()
            ->assertSee($article->published_at);
    }

    /** @test */
    public function cannot_see_draft_articles_in_list(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => null]);

        $this->getArticleIndexRoute()
            ->assertDontSeeText($article->title);
    }

    /** @test */
    public function cannot_see_scheduled_articles_in_list(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()->addDays(7)]);

        $this->getArticleIndexRoute()
            ->assertDontSeeText($article->title);
    }

    private function getArticleIndexRoute(): TestResponse
    {
        return $this->get(
            route('blog.articles.index')
        );
    }
}
