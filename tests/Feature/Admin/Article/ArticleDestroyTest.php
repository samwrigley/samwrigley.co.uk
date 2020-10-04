<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleDestroyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function author_can_delete_article(): void
    {
        $user = User::factory()->create();
        $article = $user->articles()->create(Article::factory()->make()->toArray());

        $this->assertDatabaseCount('articles', 1);

        $this->actingAs($user)
            ->followingRedirects()
            ->delete($article->destroyRoute())
            ->assertOk()
            ->assertViewIs('admin.articles.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('articles', 0);
    }

    /** @test */
    public function non_author_cannot_delete_article(): void
    {
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();
        $article = $userTwo->articles()->create(Article::factory()->make()->toArray());

        $this->assertDatabaseCount('articles', 1);

        $this->actingAs($userOne)
            ->followingRedirects()
            ->from(route('admin.articles.edit', ['article' => $article]))
            ->delete($article->destroyRoute())
            ->assertOk()
            ->assertViewIs('admin.articles.edit')
            ->assertSeeText(__('admin.articles.forbidden_delete'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('articles', 1);
        $this->assertDatabaseHas('articles', $article->toArray());
    }
}
