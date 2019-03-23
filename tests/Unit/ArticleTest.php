<?php

namespace Tests\Unit;

use App\Article;
use App\ArticleCategory;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_author(): void
    {
        $article = factory(Article::class)->create();

        $this->assertInstanceOf(User::class, $article->author);
    }

    /** @test */
    public function it_can_be_published(): void
    {
        $article = factory(Article::class)->create();

        $article->publish();

        $this->assertTrue($article->isPublished());
        $this->assertFalse($article->isScheduled());
    }

    /** @test */
    public function it_can_be_scheduled(): void
    {
        $article = factory(Article::class)->create();

        $article->publish(now()->addDays(7));

        $this->assertTrue($article->isScheduled());
        $this->assertFalse($article->isPublished());
    }

    /** @test */
    public function it_can_be_draft(): void
    {
        $article = factory(Article::class)->create();

        $article->draft();

        $this->assertTrue($article->isDraft());
    }
}
