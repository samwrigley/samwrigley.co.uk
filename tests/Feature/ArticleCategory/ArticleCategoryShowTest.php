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
    public function can_see_a_list_of_articles_in_reverse_chronological_order(): void
    {
        $articles = collect([
            factory(Article::class)->create(['published_at' => now()->subDays(2)]),
            factory(Article::class)->create(['published_at' => now()->subDay()]),
            factory(Article::class)->create(['published_at' => now()]),
        ]);

        $category = factory(ArticleCategory::class)->create();
        $category->articles()->saveMany($articles);

        $this->getCategoryShowRoute($category->slug)
            ->assertOk()
            ->assertSeeInOrder($articles->sortByDesc('published_at')->pluck('title')->toArray());
    }

    /** @test */
    public function can_see_a_list_of_paginated_articles(): void
    {
        $articles = factory(Article::class, 18)->create(['published_at' => now()]);
        $articleTitles = $articles->pluck('title');

        $category = factory(ArticleCategory::class)->create();
        $category->articles()->saveMany($articles);

        $this->getCategoryShowRoute($category->slug)
            ->assertSeeInOrder($articleTitles->forPage(1, 9)->toArray())
            ->assertDontSee($articleTitles->forPage(2, 9)->first());
    }

    /** @test */
    public function cannot_view_an_article_not_within_category(): void
    {
        $article = factory(Article::class)->create(['published_at' => now()]);

        $category = factory(ArticleCategory::class)->create();

        $this->getCategoryShowRoute($category->slug)
            ->assertDontSee($article->title);
    }

    /** @test */
    public function cannot_view_a_draft_article_within_category(): void
    {
        $article = factory(Article::class)->create(['published_at' => null]);

        $category = factory(ArticleCategory::class)->create();
        $category->articles()->save($article);

        $this->getCategoryShowRoute($category->slug)
            ->assertDontSee($article->title);
    }

    /** @test */
    public function cannot_view_a_scheduled_article_within_category(): void
    {
        $article = factory(Article::class)->create(['published_at' => now()->addDays(7)]);

        $category = factory(ArticleCategory::class)->create();
        $category->articles()->save($article);

        $this->getCategoryShowRoute($category->slug)
            ->assertDontSee($article->title);
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


    /** @test */
    public function cannot_view_a_category_that_only_has_scheduled_articles(): void
    {
        $category = factory(ArticleCategory::class)->create();
        $articles = factory(Article::class, 2)->create([
            'published_at' => now()->addDays(7),
        ]);

        $category->articles()->saveMany($articles);

        $this->getCategoryShowRoute($category->slug)
            ->assertNotFound();
    }

    /** @test */
    public function cannot_view_a_category_that_only_has_draft_articles(): void
    {
        $category = factory(ArticleCategory::class)->create();
        $articles = factory(Article::class, 2)->create([
            'published_at' => null,
        ]);

        $category->articles()->saveMany($articles);

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
