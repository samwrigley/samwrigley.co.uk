<?php

namespace Tests\Feature\Feed;

use App\Article;
use App\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_feed(): void
    {
        $article = factory(Article::class)->states('published')->create();
        $category = factory(ArticleCategory::class)->create();
        $article->categories()->attach($category);

        $this->get(route('feeds.main'))->assertOk();
    }
}
