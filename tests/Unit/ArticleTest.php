<?php

namespace Tests\Unit;

use App\Article;
use App\ArticleCategory;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_author(): void
    {
        $article = factory(Article::class)->create();

        $this->assertInstanceOf(User::class, $article->author);
    }

    /** @test */
    public function it_belongs_to_many_categories(): void
    {
        $categoryCount = 2;
        $categories = factory(ArticleCategory::class, $categoryCount)->create();

        $article = factory(Article::class)->create();
        $article->categories()->attach($categories);

        $this->assertCount($categoryCount, $article->categories);
    }

    /** @test */
    public function it_can_be_published(): void
    {
        $publishedArticle = tap(factory(Article::class)->create())->publish();

        $this->assertTrue($publishedArticle->isPublished());
        $this->assertFalse($publishedArticle->isScheduled());
    }

    /** @test */
    public function it_can_be_scheduled(): void
    {
        $scheduledArticle = tap(factory(Article::class)->create())
            ->publish(now()->addDays(7));

        $this->assertTrue($scheduledArticle->isScheduled());
        $this->assertFalse($scheduledArticle->isPublished());
    }

    /** @test */
    public function it_can_be_draft(): void
    {
        $draftArticle = tap(factory(Article::class)->create())->draft();

        $this->assertTrue($draftArticle->isDraft());
    }
}
