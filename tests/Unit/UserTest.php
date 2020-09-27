<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_single_article(): void
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        $user->addArticle($article);

        $this->assertCount(1, $user->articles);
    }

    /** @test */
    public function it_has_many_articles(): void
    {
        $articleCount = 2;

        $articles = factory(Article::class, $articleCount)->create();
        $user = factory(User::class)->create();

        $user->addArticles($articles);

        $this->assertCount($articleCount, $user->articles);
    }

    /** @test */
    public function it_can_publish_an_article(): void
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        $user->publish($article);

        $this->assertDatabaseHas('articles', $article->toArray());
    }

    /** @test */
    public function it_has_article_count(): void
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        $user->publish($article);
        $article->markAsPublished();

        $this->assertEquals(1, $user->articleCount());
    }

    /** @test */
    public function it_has_published_article_count(): void
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        $user->publish($article);
        $article->markAsPublished();

        $this->assertEquals(1, $user->publishedArticleCount());
    }

    /** @test */
    public function it_has_scheduled_article_count(): void
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        $user->publish($article);
        $article->markAsScheduled(now()->addDays(7));

        $this->assertEquals(1, $user->scheduledArticleCount());
    }

    /** @test */
    public function it_has_draft_article_count(): void
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        $user->publish($article);
        $article->markAsDraft();

        $this->assertEquals(1, $user->draftArticleCount());
    }
}
