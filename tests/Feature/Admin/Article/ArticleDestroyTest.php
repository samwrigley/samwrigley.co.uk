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
        $user = factory(User::class)->create();
        $article = $user->articles()->create(factory(Article::class)->make()->toArray());

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
        $userOne = factory(User::class)->create();
        $userTwo = factory(User::class)->create();
        $article = $userTwo->articles()->create(factory(Article::class)->make()->toArray());

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
