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
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDays(2)]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()->subDay()]),
            factory(ArticleCategory::class)->state('withArticle')->create(['created_at' => now()]),
        ]);

        $categoryNames = $categories->sortByDesc('created_at')->pluck('name')->toArray();

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertSeeInOrder($categoryNames);
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
