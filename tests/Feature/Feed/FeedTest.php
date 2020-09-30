<?php

namespace Tests\Feature\Feed;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_feed(): void
    {
        factory(Article::class)->states('published')->create();

        $this->get(route('feeds.main'))->assertOk();
    }
}
