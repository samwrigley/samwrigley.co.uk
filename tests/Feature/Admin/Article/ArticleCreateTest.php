<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSeries;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ArticleCreateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_view_admin_article_create_page_when_authenticated(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.articles.create'))
            ->assertViewIs('admin.articles.create')
            ->assertOk();
    }

    /** @test */
    public function cannot_view_admin_article_create_page_when_not_authenticated(): void
    {
        $this->followingRedirects()
            ->get(route('admin.articles.create'))
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function can_create_article(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertOk()
            ->assertViewIs('admin.articles.create')
            ->assertSeeText(__('admin.articles.successfully_created'))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function article_is_persisted_in_database(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)->postArticleRoute($articleData);

        $this->assertDatabaseHas('articles', $articleData);
    }

    /** @test */
    public function article_title_is_required(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertSessionHasErrorsIn('article', 'title')
            ->assertSessionDoesntHaveErrors(['slug', 'body'], null, 'article')
            ->assertSessionHasInput($articleData);
    }

    /** @test */
    public function article_title_must_be_unique(): void
    {
        $title = $this->faker->sentence;
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $title,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        factory(Article::class)->create(['title' => $title]);

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertSessionHasErrorsIn('article', 'title')
            ->assertSessionDoesntHaveErrors(['slug', 'body'], null, 'article')
            ->assertSessionHasInput($articleData);
    }

    /** @test */
    public function article_slug_is_required(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body'], null, 'article')
            ->assertSessionHasInput($articleData);
    }

    /** @test */
    public function article_slug_must_be_unique(): void
    {
        $slug = Str::slug($this->faker->sentence);
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => $slug,
            'body' => $this->faker->paragraphs(10, true),
        ];

        factory(Article::class)->create(['slug' => $slug]);

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body'], null, 'article')
            ->assertSessionHasInput($articleData);
    }

    /** @test */
    public function article_slug_must_be_alpha_dash(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body'], null, 'article')
            ->assertSessionHasInput($articleData);
    }

    /** @test */
    public function article_excerpt_must_be_shorter_than_maximum_length(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'excerpt' => $this->faker->paragraphs(20, true),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->assertTrue(Str::length($articleData['excerpt']) > Article::MAX_EXCERPT_LENGTH);

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertSessionHasErrorsIn('article', 'excerpt')
            ->assertSessionHasInput($articleData);
    }

    /** @test */
    public function article_body_is_required(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertSessionHasErrorsIn('article', 'body')
            ->assertSessionDoesntHaveErrors(['title', 'slug'], null, 'article')
            ->assertSessionHasInput($articleData);
    }

    /** @test */
    public function date_is_required_when_time_is_present(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $article = collect($articleData)
            ->merge(['time' => now()->format(Article::$PUBLISHED_TIME_FORMAT)])
            ->toArray();

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($article)
            ->assertSessionHasErrorsIn('article', 'date')
            ->assertSessionHasInput($article);
    }

    /** @test */
    public function publish_date_must_be_the_correct_format(): void
    {
        $date = '2020-01-31';
        $article = factory(Article::class)->create([
            'published_at' => Carbon::parse($date),
        ]);

        $this->assertEquals($date, $article->published_date);
    }

    /** @test */
    public function time_is_required_when_date_is_present(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $article = collect($articleData)
            ->merge(['date' => now()->addWeek()->format(Article::$PUBLISHED_DATE_FORMAT)])
            ->toArray();

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($article)
            ->assertSessionHasErrorsIn('article', 'time')
            ->assertSessionHasInput($article);
    }

    /** @test */
    public function publish_time_must_be_the_correct_format(): void
    {
        $time = '21:15:30';
        $article = factory(Article::class)->create([
            'published_at' => Carbon::parse($time),
        ]);

        $this->assertEquals($time, $article->published_time);
    }

    /** @test */
    public function is_marked_as_scheduled_when_created_with_published_date_and_time(): void
    {
        $date = now()->addWeek()->format(Article::$PUBLISHED_DATE_FORMAT);
        $time = now()->format(Article::$PUBLISHED_TIME_FORMAT);
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $article = collect($articleData)
            ->merge(['date' => $date, 'time' => $time])
            ->toArray();

        $expectedArticle = collect($articleData)
            ->merge(['published_at' => Carbon::parse("{$date} {$time}")])
            ->toArray();

        $this->actingAs($user)
            ->postArticleRoute($article)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('articles', $expectedArticle);
    }

    /** @test */
    public function can_add_to_single_category(): void
    {
        $user = factory(User::class)->create();
        $category = factory(ArticleCategory::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
            'categories' => [$category->id],
        ];

        $this->assertDatabaseCount('articles', 0);

        $this->actingAs($user)->postArticleRoute($articleData);

        $this->assertDatabaseCount('articles', 1);
        $this->assertCount(1, Article::first()->categories);
    }

    /** @test */
    public function can_add_to_multiple_categories(): void
    {
        $user = factory(User::class)->create();
        $categoryCount = 2;
        $categories = factory(ArticleCategory::class, $categoryCount)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
            'categories' => $categories->pluck('id')->toArray(),
        ];

        $this->assertDatabaseCount('articles', 0);

        $this->actingAs($user)->postArticleRoute($articleData);

        $this->assertDatabaseCount('articles', 1);
        $this->assertCount($categoryCount, Article::first()->categories);
    }

    /** @test */
    public function can_add_to_a_series(): void
    {
        $user = factory(User::class)->create();
        $series = factory(ArticleSeries::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
            'series' => (string) $series->id,
        ];

        $this->assertDatabaseCount('articles', 0);

        $this->actingAs($user)->postArticleRoute($articleData);

        $this->assertDatabaseCount('articles', 1);
        $this->assertInstanceOf(ArticleSeries::class, Article::first()->series);
    }

    /** @test */
    public function can_only_add_to_series_that_exists(): void
    {
        $user = factory(User::class)->create();
        $articleData = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
            'series' => 1,
        ];

        $this->assertDatabaseCount('articles', 0);

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($articleData)
            ->assertSessionHasErrorsIn('article', 'series')
            ->assertSessionHasInput($articleData);

        $this->assertDatabaseCount('articles', 0);
    }

    protected function postArticleRoute(array $data = []): TestResponse
    {
        return $this->post(route('admin.articles.store'), $data);
    }
}
