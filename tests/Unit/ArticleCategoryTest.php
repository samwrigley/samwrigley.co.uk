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
        $articles = factory(Article::class)->create();

        $articleCategory = tap(factory(ArticleCategory::class)->create())
            ->addArticle($articles);

        $this->assertCount(1, $articleCategory->articles);
    }

    /** @test */
    public function it_belongs_to_many_articles(): void
    {
        $articleCount = 2;

        $articles = factory(Article::class, $articleCount)->create();

        $articleCategory = tap(factory(ArticleCategory::class)->create())
            ->addArticles($articles);

        $this->assertCount($articleCount, $articleCategory->articles);
    }

    /** @test */
    public function it_has_article_count(): void
    {
        $articleCount = 3;
        $articles = factory(Article::class, $articleCount)->create();

        $articleCategory = tap(factory(ArticleCategory::class)->create())
            ->addArticles($articles);

        $articles[0]->markAsPublished();
        $articles[1]->markAsScheduled(now()->addDays(7));
        $articles[2]->markAsDraft();

        $this->assertEquals($articleCount, $articleCategory->articleCount());
    }

    /** @test */
    public function it_has_published_article_count(): void
    {
        $publishedArticle = tap(factory(Article::class)->create())->markAsPublished();

        $articleCategory = tap(factory(ArticleCategory::class)->create())
            ->addArticle($publishedArticle);

        $this->assertEquals(1, $articleCategory->publishedArticleCount());
    }

    /** @test */
    public function it_has_scheduled_article_count(): void
    {
        $scheduledArticle = tap(factory(Article::class)->create())
            ->markAsScheduled(now()->addDays(7));

        $articleCategory = tap(factory(ArticleCategory::class)->create())
            ->addArticle($scheduledArticle);

        $this->assertEquals(1, $articleCategory->scheduledArticleCount());
    }

    /** @test */
    public function it_has_draft_article_count(): void
    {
        $draftArticle = tap(factory(Article::class)->create())->markAsDraft();

        $articleCategory = tap(factory(ArticleCategory::class)->create())
            ->addArticle($draftArticle);

        $this->assertEquals(1, $articleCategory->draftArticleCount());
    }

    /** @test */
    public function can_get_show_route(): void
    {
        $category = factory(ArticleCategory::class)->make();

        $route = route($category->routeNamespaces['web'] . 'show', [$category->slug]);

        $this->assertEquals($route, $category->showRoute());
    }
}
