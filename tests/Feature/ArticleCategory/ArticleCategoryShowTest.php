<?php

namespace Tests\Feature\Article;

use App\Article;
use App\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class ArticleCategoryShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_a_list_of_articles_within_category(): void
    {
        $articles = factory(Article::class, 5)
            ->create(['published_at' => now()]);

        $category = factory(ArticleCategory::class)->create();
        $category->articles()->attach($articles);

        $this->getCategoryShowRoute($category->slug)
            ->assertOk()
            ->assertSeeTextInOrder(
                $articles->pluck('title')->toArray()
            );
    }

    /** @test */
    public function cannot_view_an_article_not_within_category(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()]);

        $category = factory(ArticleCategory::class)->create();

        $this->getCategoryShowRoute($category->slug)
            ->assertDontSeeText($article->title);
    }

    /** @test */
    public function cannot_view_a_draft_article_within_category(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => null]);

        $category = factory(ArticleCategory::class)->create();
        $category->articles()->attach($article);

        $this->getCategoryShowRoute($category->slug)
            ->assertDontSeeText($article->title);
    }

    /** @test */
    public function cannot_view_a_scheduled_article_within_category(): void
    {
        $article = factory(Article::class)
            ->create(['published_at' => now()->addDays(7)]);

        $category = factory(ArticleCategory::class)->create();
        $category->articles()->attach($article);

        $this->getCategoryShowRoute($category->slug)
            ->assertDontSeeText($article->title);
    }

    /** @test */
    public function cannot_view_a_category_that_does_not_exist(): void
    {
        $this->getCategoryShowRoute('example-slug')
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_category_that_has_no_articles(): void
    {
        $category = factory(ArticleCategory::class)->create();

        $this->getCategoryShowRoute($category->slug)
            ->assertNotFound();
    }

    private function getCategoryShowRoute(string $categorySlug): TestResponse
    {
        return $this->get(
            route('blog.categories.show', $categorySlug)
        );
    }
}
