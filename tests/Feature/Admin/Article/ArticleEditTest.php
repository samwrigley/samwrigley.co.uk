<?php

namespace Tests\Feature\Admin\Article;

use App\Article;
use App\ArticleCategory;
use App\ArticleSeries;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleEditTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_view_admin_article_edit_page_when_authenticated(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('published')->create();

        $this->actingAs($user)
            ->get(route('admin.articles.edit', ['article' => $article]))
            ->assertViewIs('admin.articles.edit')
            ->assertOk()
            ->assertSee($article->title)
            ->assertSee($article->slug)
            ->assertSee($article->excerpt)
            ->assertSee($article->body)
            ->assertSee($article->publishedDate)
            ->assertSee($article->publishedTime);
    }

    /** @test */
    public function cannot_view_admin_article_edit_page_when_not_authenticated(): void
    {
        $article = factory(Article::class)->create();

        $this->followingRedirects()
            ->get(route('admin.articles.edit', ['article' => $article]))
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function author_can_edit_article(): void
    {
        $user = factory(User::class)->create();
        $article = $user->articles()->create(factory(Article::class)->make()->toArray());

        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('admin.articles.edit', ['article' => $article]))
            ->putArticleRoute($article, $article->toArray())
            ->assertOk()
            ->assertViewIs('admin.articles.edit')
            ->assertSeeText(__('admin.articles.successfully_updated'))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function non_author_cannot_edit_article(): void
    {
        $userOne = factory(User::class)->create();
        $userTwo = factory(User::class)->create();
        $article = $userTwo->articles()->create(factory(Article::class)->make()->toArray());

        $this->actingAs($userOne)
            ->followingRedirects()
            ->from(route('admin.articles.edit', ['article' => $article]))
            ->putArticleRoute($article, $article->toArray())
            ->assertViewIs('admin.articles.edit')
            ->assertSeeText(__('admin.articles.forbidden_update'))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function edited_article_is_persisted_in_database(): void
    {
        $user = factory(User::class)->create();
        $articleOne = factory(Article::class)->create();
        $articleTwo = factory(Article::class)->create();

        $this->assertDatabaseHas('articles', $articleOne->toArray());

        $this->actingAs($user)->putArticleRoute($articleOne, $articleTwo->toArray());

        $this->assertDatabaseHas('articles', $articleTwo->toArray());
    }

    /** @test */
    public function article_title_is_required(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('published')->create();
        $editedArticle = collect($article)->forget('title')->toArray();

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'title')
            ->assertSessionDoesntHaveErrors(['slug', 'body', 'excerpt'], null, 'article')
            ->assertSessionHasInput($editedArticle);
    }

    /** @test */
    public function article_title_must_be_unique(): void
    {
        $title = $this->faker->sentence;
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('published')->create();
        $editedArticle = collect($article)->replace(['title' => $title])->toArray();

        factory(Article::class)
            ->state('published')
            ->create(['title' => $title]);

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'title')
            ->assertSessionDoesntHaveErrors(['slug', 'body', 'excerpt'], null, 'article')
            ->assertSessionHasInput($editedArticle);
    }

    /** @test */
    public function article_slug_is_required(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('published')->create();
        $editedArticle = collect($article)->forget('slug')->toArray();

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body', 'excerpt'], null, 'article')
            ->assertSessionHasInput($editedArticle);
    }

    /** @test */
    public function article_slug_must_be_unique(): void
    {
        $slug = Str::slug($this->faker->sentence);
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('published')->create();
        $editedArticle = collect($article)->replace(['slug' => $slug])->toArray();

        factory(Article::class)
            ->state('published')
            ->create(['slug' => $slug]);

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body', 'excerpt'], null, 'article')
            ->assertSessionHasInput($editedArticle);
    }

    /** @test */
    public function article_slug_must_be_alpha_dash(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('published')->create();
        $editedArticle = collect($article)
            ->replace(['slug' => $this->faker->sentence])
            ->toArray();

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body', 'excerpt'], null, 'article')
            ->assertSessionHasInput($editedArticle);
    }

    /** @test */
    public function article_excerpt_must_be_shorter_than_maximum_length(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('published')->create();
        $editedArticle = collect($article)
            ->replace(['excerpt' => $this->faker->paragraphs(20, true)])
            ->toArray();

        $this->assertTrue(Str::length($editedArticle['excerpt']) > Article::MAX_EXCERPT_LENGTH);

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'excerpt')
            ->assertSessionDoesntHaveErrors(['title', 'slug', 'body'], null, 'article')
            ->assertSessionHasInput($editedArticle);
    }

    /** @test */
    public function article_body_is_required(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('published')->create();
        $editedArticle = collect($article)->forget('slug')->toArray();

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body', 'excerpt'], null, 'article')
            ->assertSessionHasInput($editedArticle);
    }

    /** @test */
    public function date_is_required_when_time_is_present(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->states('draft')->create();

        $editedArticle = collect($article)
            ->merge(['time' => now()->format(Article::$PUBLISHED_TIME_FORMAT)])
            ->toArray();

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'date')
            ->assertSessionDoesntHaveErrors(['title', 'body', 'excerpt', 'time'], null, 'article')
            ->assertSessionHasInput(['title', 'body', 'excerpt', 'time']);
    }

    /** @test */
    public function time_is_required_when_date_is_present(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->states('draft')->create();

        $editedArticle = collect($article)
            ->merge(['date' => now()->addWeek()->format(Article::$PUBLISHED_DATE_FORMAT)])
            ->toArray();

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'time')
            ->assertSessionDoesntHaveErrors(['title', 'body', 'excerpt', 'date'], null, 'article')
            ->assertSessionHasInput(['title', 'body', 'excerpt', 'date']);
    }

    /** @test */
    public function time_must_be_the_correct_format(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->states('draft')->create();

        $editedArticle = collect($article)
            ->merge([
                'date' => now()->addWeek()->format(Article::$PUBLISHED_DATE_FORMAT),
                'time' => now()->format('H:i'),
            ])
            ->toArray();

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'time')
            ->assertSessionDoesntHaveErrors(['title', 'body', 'excerpt', 'date'], null, 'article')
            ->assertSessionHasInput(['title', 'body', 'excerpt', 'date']);
    }

    /** @test */
    public function is_marked_as_scheduled_when_edited_with_date_and_time(): void
    {
        $date = now()->addWeek()->format(Article::$PUBLISHED_DATE_FORMAT);
        $time = now()->format(Article::$PUBLISHED_TIME_FORMAT);
        $user = factory(User::class)->create();
        $article = factory(Article::class)->states('draft')->create();

        $editedArticle = collect($article)
            ->merge(['date' => $date, 'time' => $time])
            ->toArray();

        $expectedArticle = collect($article)
            ->replace(['published_at' => Carbon::parse("{$date} {$time}")])
            ->toArray();

        $this->actingAs($user)
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('articles', $expectedArticle);
    }

    /** @test */
    public function can_edit_single_category(): void
    {
        $user = factory(User::class)->create();
        $categoryOne = factory(ArticleCategory::class)->create();
        $categoryTwo = factory(ArticleCategory::class)->create();
        $article = factory(Article::class)->create();
        $article->categories()->attach($categoryOne);
        $editedArticle = collect($article)->merge(['categories' => [$categoryTwo->id]])->toArray();
        $expectedArticle = Article::first();

        $this->assertCount(1, $expectedArticle->categories);
        $this->assertEquals($categoryOne->id, $expectedArticle->categories()->first()->id);

        $this->actingAs($user)->putArticleRoute($article, $editedArticle);

        $this->assertCount(1, $expectedArticle->categories);
        $this->assertEquals($categoryTwo->id, $expectedArticle->categories()->first()->id);
    }

     /** @test */
     public function can_remove_from_a_category(): void
     {
        $user = factory(User::class)->create();
        $category = factory(ArticleCategory::class)->create();
        $article = factory(Article::class)->create();
        $article->categories()->attach($category);
        $editedArticle = collect($article)->merge(['categories' => []])->toArray();
        $expectedArticle = Article::first();

        $this->assertCount(1, $expectedArticle->categories);
        $this->assertEquals($category->id, $expectedArticle->categories()->first()->id);

        $this->actingAs($user)->putArticleRoute($article, $editedArticle);
        $expectedArticle->refresh();

        $this->assertCount(0, $expectedArticle->categories);
     }

    /** @test */
    public function can_edit_multiple_categories(): void
    {
        $user = factory(User::class)->create();
        $categoriesOne = factory(ArticleCategory::class, 2)->create();
        $article = factory(Article::class)->create();
        $article->categories()->attach($categoriesOne);

        $categoriesTwo = factory(ArticleCategory::class, 2)->create();
        $editedArticle = collect($article)
            ->merge(['categories' => $categoriesTwo->pluck('id')->toArray()])
            ->toArray();

        $expectedArticle = Article::first();

        $this->assertCount(2, $expectedArticle->categories);
        $this->assertEquals(
            $categoriesOne->pluck('id'),
            $expectedArticle->categories()->pluck('id')
        );

        $this->actingAs($user)->putArticleRoute($article, $editedArticle);

        $this->assertCount(2, $expectedArticle->categories);
        $this->assertEquals(
            $categoriesTwo->pluck('id'),
            $expectedArticle->categories()->pluck('id')
        );
    }

    /** @test */
    public function can_remove_from_multiple_categories(): void
    {
        $user = factory(User::class)->create();
        $categories = factory(ArticleCategory::class, 2)->create();
        $article = factory(Article::class)->create();
        $article->categories()->attach($categories);

        $editedArticle = collect($article)->merge(['categories' => []])->toArray();

        $expectedArticle = Article::first();

        $this->assertCount(2, $expectedArticle->categories);
        $this->assertEquals(
            $categories->pluck('id'),
            $expectedArticle->categories()->pluck('id')
        );

        $this->actingAs($user)->putArticleRoute($article, $editedArticle);
        $expectedArticle->refresh();

        $this->assertCount(0, $expectedArticle->categories);
    }

    /** @test */
    public function can_edit_series(): void
    {
        $user = factory(User::class)->create();
        $seriesOne = factory(ArticleSeries::class)->create();
        $seriesTwo = factory(ArticleSeries::class)->create();

        $article = factory(Article::class)->create();
        $article->series()->associate($seriesOne);
        $article->save();

        $editedArticle = collect($article)
            ->merge(['series' => (string) $seriesTwo->id])
            ->toArray();

        $this->assertEquals($seriesOne->id, $article->series->id);

        $this->actingAs($user)->putArticleRoute($article, $editedArticle);
        $article->refresh();

        $this->assertEquals($seriesTwo->id, $article->series->id);
    }

    /** @test */
    public function can_only_add_to_series_that_exists(): void
    {
        $user = factory(User::class)->create();
        $series = factory(ArticleSeries::class)->create();
        $article = factory(Article::class)->state('published')->create();
        $article->series()->associate($series);
        $article->save();

        $editedArticle = collect($article)
            ->merge(['series' => '2'])
            ->toArray();

        $this->assertEquals($series->id, $article->series->id);

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->putArticleRoute($article, $editedArticle)
            ->assertSessionHasErrorsIn('article', 'series')
            ->assertSessionHasInput($editedArticle);
    }

    /** @test */
    public function can_remove_from_a_series(): void
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->state('withSeries')->create();
        $editedArticle = $article->toArray();

        $this->assertNotNull($article->series);

        $this->actingAs($user)->putArticleRoute($article, $editedArticle);
        $article->refresh();

        $this->assertNull($article->series);
    }

    protected function putArticleRoute(Article $article, array $data = []): TestResponse
    {
        $uri = route('admin.articles.update', ['article' => $article]);

        return $this->put($uri, $data);
    }
}
