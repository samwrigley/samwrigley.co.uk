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
    public function can_see_a_list_of_categories(): void
    {
        $category = factory(ArticleCategory::class)->create();
        $articles = factory(Article::class, 5)->create();

        $category->articles()->saveMany($articles);

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertSee($category->name);
    }

    /** @test */
    public function cannot_see_a_category_that_has_no_articles(): void
    {
        $category = factory(ArticleCategory::class)->create();

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertDontSee($category->name);
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
            ->assertDontSee($category->name);
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
            ->assertDontSee($category->name);
    }

    private function getCategoryIndexRoute(): TestResponse
    {
        return $this->get(
            route('blog.categories.index')
        );
    }
}
