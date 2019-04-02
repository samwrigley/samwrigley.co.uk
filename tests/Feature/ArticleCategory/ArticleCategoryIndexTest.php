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

        $category->articles()->attach($articles);

        $this->getCategoryIndexRoute()
            ->assertOk()
            ->assertSeeText($category->name);
    }

    /** @test */
    public function cannot_see_a_category_that_has_no_articles(): void
    {
        $category = factory(ArticleCategory::class)->create();

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
