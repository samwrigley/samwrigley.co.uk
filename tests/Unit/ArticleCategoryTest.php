<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_single_article(): void
    {
        $article = Article::factory()->create();
        $articleCategory = ArticleCategory::factory()->create();

        $articleCategory->articles()->attach($article);

        $this->assertCount(1, $articleCategory->articles);
    }

    /** @test */
    public function it_belongs_to_many_articles(): void
    {
        $articleCount = 2;
        $articles = Article::factory()->count($articleCount)->create();
        $articleCategory = ArticleCategory::factory()->create();

        $articleCategory->articles()->attach($articles);

        $this->assertCount($articleCount, $articleCategory->articles);
    }

    /** @test */
    public function it_has_article_count(): void
    {
        $articleCount = 3;
        $articles = Article::factory()->count($articleCount)->create();
        $articleCategory = ArticleCategory::factory()->create();

        $articleCategory->articles()->attach($articles);

        $articles[0]->markAsPublished();
        $articles[1]->markAsScheduled(now()->addDays(7));
        $articles[2]->markAsDraft();

        $this->assertEquals($articleCount, $articleCategory->articleCount());
    }

    /** @test */
    public function it_has_published_article_count(): void
    {
        $publishedArticle = tap(Article::factory()->create())->markAsPublished();
        $articleCategory = ArticleCategory::factory()->create();

        $articleCategory->articles()->attach($publishedArticle);

        $this->assertEquals(1, $articleCategory->publishedArticleCount());
    }

    /** @test */
    public function it_has_scheduled_article_count(): void
    {
        $scheduledArticle = tap(Article::factory()->create())
            ->markAsScheduled(now()->addDays(7));
        $articleCategory = ArticleCategory::factory()->create();

        $articleCategory->articles()->attach($scheduledArticle);

        $this->assertEquals(1, $articleCategory->scheduledArticleCount());
    }

    /** @test */
    public function it_has_draft_article_count(): void
    {
        $draftArticle = tap(Article::factory()->create())->markAsDraft();
        $articleCategory = ArticleCategory::factory()->create();

        $articleCategory->articles()->attach($draftArticle);

        $this->assertEquals(1, $articleCategory->draftArticleCount());
    }

    /** @test */
    public function can_get_show_route(): void
    {
        $category = ArticleCategory::factory()->make();

        $route = route($category->routeNamespaces['web'] . 'show', [$category->slug]);

        $this->assertEquals($route, $category->showRoute());
    }
}
