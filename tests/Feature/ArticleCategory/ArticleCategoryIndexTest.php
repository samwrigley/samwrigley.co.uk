<?php

namespace Tests\Feature\Article;

use App\Article;
use App\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class ArticleCategoryIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_a_list_of_categories_in_chronological_order(): void
    {
        $categories = collect([
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDay()]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(2)]),
        ]);

        $categoryNames = $categories->sortByDesc('created_at')->pluck('name')->toArray();

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertSeeTextInOrder($categoryNames);
    }

    /** @test */
    public function can_see_a_list_of_paginated_categories(): void
    {
        $categories = collect([
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDay()]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(2)]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(3)]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(4)]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(5)]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(6)]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(7)]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(8)]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(9)]),
        ]);
        $categoryNames = $categories->sortByDesc('created_at')->pluck('name');

        $this->getCategoryIndexRoute()
            ->assertSeeTextInOrder($categoryNames->forPage(1, 9)->toArray())
            ->assertDontSeeText($categoryNames->forPage(2, 9)->first());
    }

    /** @test */
    public function cannot_see_a_category_that_has_no_articles(): void
    {
        $category = factory(ArticleCategory::class)->create();

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSeeText($category->name);
    }

    /** @test */
    public function cannot_see_a_category_that_only_has_scheduled_articles(): void
    {
        $category = factory(ArticleCategory::class)->create();
        $articles = factory(Article::class, 2)->create([
            'published_at' => now()->addDays(7),
        ]);

        $category->articles()->saveMany($articles);

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSeeText($category->name);
    }

    /** @test */
    public function cannot_see_a_category_that_only_has_draft_articles(): void
    {
        $category = factory(ArticleCategory::class)->create();
        $articles = factory(Article::class, 2)->create([
            'published_at' => null,
        ]);

        $category->articles()->saveMany($articles);

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSeeText($category->name);
    }

    private function getCategoryIndexRoute(): TestResponse
    {
        return $this->get(
            route('blog.categories.index')
        );
    }
}
