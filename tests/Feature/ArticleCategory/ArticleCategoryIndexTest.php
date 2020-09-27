<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleCategoryIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function see_not_found_page_when_no_categories(): void
    {
        $this->getCategoryIndexRoute()->assertNotFound();
    }

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
        $categoryWithoutArticle = factory(ArticleCategory::class)->create();
        $categoryWithArticle = factory(ArticleCategory::class)->state('withArticle')->create();

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSeeText($categoryWithoutArticle->name)
            ->assertSeeText($categoryWithArticle->name);
    }

    /** @test */
    public function cannot_see_a_category_that_only_has_scheduled_article(): void
    {
        $categoryWithScheduledArticle = factory(ArticleCategory::class)->create();
        $categoryWithPublishedArticle = factory(ArticleCategory::class)->state('withArticle')->create();
        $scheduledArticle = factory(Article::class)->state('scheduled')->create();

        $categoryWithScheduledArticle->articles()->save($scheduledArticle);

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSeeText($categoryWithScheduledArticle->name)
            ->assertSeeText($categoryWithPublishedArticle->name);
    }

    /** @test */
    public function cannot_see_a_category_that_only_has_draft_article(): void
    {
        $categoryWithDraftArticle = factory(ArticleCategory::class)->create();
        $categoryWithPublishedArticle = factory(ArticleCategory::class)->state('withArticle')->create();
        $draftArticle = factory(Article::class)->states('draft')->create();

        $categoryWithDraftArticle->articles()->save($draftArticle);

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSeeText($categoryWithDraftArticle->name)
            ->assertSeeText($categoryWithPublishedArticle->name);
    }

    private function getCategoryIndexRoute(): TestResponse
    {
        return $this->get(
            route('blog.categories.index')
        );
    }
}
