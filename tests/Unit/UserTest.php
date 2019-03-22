<?php

namespace Tests\Unit;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;
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
}
