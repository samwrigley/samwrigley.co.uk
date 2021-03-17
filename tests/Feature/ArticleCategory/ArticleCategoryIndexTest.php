<?php

namespace Tests\Feature\ArticleCategory;

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
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDay()]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(2)]),
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
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDay()]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(2)]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(3)]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(4)]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(5)]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(6)]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(7)]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(8)]),
            ArticleCategory::factory()
                ->has(Article::factory()->published())
                ->create(['created_at' => now()->subDays(9)]),
        ]);
        $categoryNames = $categories->sortByDesc('created_at')->pluck('name');

        $this->getCategoryIndexRoute()
            ->assertSeeTextInOrder($categoryNames->forPage(1, 9)->toArray())
            ->assertDontSeeText($categoryNames->forPage(2, 9)->first());
    }

    /** @test */
    public function cannot_see_a_category_that_has_no_articles(): void
    {
        $categoryWithoutArticle = ArticleCategory::factory()->create();
        $categoryWithArticle = ArticleCategory::factory()->has(Article::factory()->published())->create();

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSeeText($categoryWithoutArticle->name)
            ->assertSeeText($categoryWithArticle->name);
    }

    /** @test */
    public function cannot_see_a_category_that_only_has_scheduled_article(): void
    {
        $categoryWithScheduledArticle = ArticleCategory::factory()->create();
        $categoryWithPublishedArticle = ArticleCategory::factory()->has(Article::factory()->published())->create();
        $scheduledArticle = Article::factory()->scheduled()->create();

        $categoryWithScheduledArticle->articles()->save($scheduledArticle);

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSeeText($categoryWithScheduledArticle->name)
            ->assertSeeText($categoryWithPublishedArticle->name);
    }

    /** @test */
    public function cannot_see_a_category_that_only_has_draft_article(): void
    {
        $categoryWithDraftArticle = ArticleCategory::factory()->create();
        $categoryWithPublishedArticle = ArticleCategory::factory()->has(Article::factory()->published())->create();
        $draftArticle = Article::factory()->draft()->create();

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
