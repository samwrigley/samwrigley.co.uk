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

class ArticleCreateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected array $validArticle;

    public function setUp(): void
    {
        parent::setUp();

        $this->validArticle = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];
    }

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

        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('admin.articles.create'))
            ->postArticleRoute($this->validArticle)
            ->assertOk()
            ->assertViewIs('admin.articles.create')
            ->assertSeeText(__('admin.articles.successfully_created'))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function article_is_persisted_in_database(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->postArticleRoute($this->validArticle);

        $this->assertDatabaseHas('articles', $this->validArticle);
    }

    /** @test */
    public function article_title_is_required(): void
    {
        $user = factory(User::class)->create();

        $data = [
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($data)
            ->assertSessionHasErrorsIn('article', 'title')
            ->assertSessionDoesntHaveErrors(['slug', 'body'], null, 'article')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function article_title_must_be_unique(): void
    {
        $title = $this->faker->sentence;
        $user = factory(User::class)->create();

        factory(Article::class)->create(['title' => $title]);

        $data = [
            'title' => $title,
            'slug' => Str::slug($this->faker->sentence),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($data)
            ->assertSessionHasErrorsIn('article', 'title')
            ->assertSessionDoesntHaveErrors(['slug', 'body'], null, 'article')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function article_slug_is_required(): void
    {
        $user = factory(User::class)->create();

        $data = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($data)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body'], null, 'article')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function article_slug_must_be_unique(): void
    {
        $slug = Str::slug($this->faker->sentence);
        $user = factory(User::class)->create();

        factory(Article::class)->create(['slug' => $slug]);

        $data = [
            'title' => $this->faker->sentence,
            'slug' => $slug,
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($data)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body'], null, 'article')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function article_slug_must_be_alpha_dash(): void
    {
        $user = factory(User::class)->create();

        $data = [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($data)
            ->assertSessionHasErrorsIn('article', 'slug')
            ->assertSessionDoesntHaveErrors(['title', 'body'], null, 'article')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function article_excerpt_must_be_shorter_than_maximum_length(): void
    {
        $user = factory(User::class)->create();

        $data = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'excerpt' => $this->faker->paragraphs(20, true),
            'body' => $this->faker->paragraphs(10, true),
        ];

        $this->assertTrue(Str::length($data['excerpt']) > Article::MAX_EXCERPT_LENGTH);

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($data)
            ->assertSessionHasErrorsIn('article', 'excerpt')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function article_body_is_required(): void
    {
        $user = factory(User::class)->create();

        $data = [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
        ];

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($data)
            ->assertSessionHasErrorsIn('article', 'body')
            ->assertSessionDoesntHaveErrors(['title', 'slug'], null, 'article')
            ->assertSessionHasInput($data);
    }

    /** @test */
    public function date_is_required_when_time_is_present(): void
    {
        $user = factory(User::class)->create();

        $article = collect($this->validArticle)
            ->merge(['time' => now()->format(Article::$PUBLISHED_TIME_FORMAT)])
            ->toArray();

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($article)
            ->assertSessionHasErrorsIn('article', 'date')
            ->assertSessionHasInput($article);
    }

    /** @test */
    public function time_is_required_when_date_is_present(): void
    {
        $user = factory(User::class)->create();

        $article = collect($this->validArticle)
            ->merge(['date' => now()->addWeek()->format(Article::$PUBLISHED_DATE_FORMAT)])
            ->toArray();

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($article)
            ->assertSessionHasErrorsIn('article', 'time')
            ->assertSessionHasInput($article);
    }

    /** @test */
    public function article_is_marked_as_scheduled_when_created_with_publish_date_and_time(): void
    {
        $date = now()->addWeek()->format(Article::$PUBLISHED_DATE_FORMAT);
        $time = now()->format(Article::$PUBLISHED_TIME_FORMAT);
        $user = factory(User::class)->create();

        $article = collect($this->validArticle)
            ->merge(['date' => $date, 'time' => $time])
            ->toArray();

        $expectedArticle = collect($this->validArticle)
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
        $article = array_merge($this->validArticle, ['categories' => [$category->id]]);

        $this->assertDatabaseCount('articles', 0);

        $this->actingAs($user)->postArticleRoute($article);

        $this->assertDatabaseCount('articles', 1);
        $this->assertCount(1, Article::first()->categories);
    }

    /** @test */
    public function can_add_to_multiple_categories(): void
    {
        $user = factory(User::class)->create();
        $categoryCount = 2;
        $categories = factory(ArticleCategory::class, $categoryCount)->create();
        $article = array_merge($this->validArticle, ['categories' => $categories->pluck('id')->toArray()]);

        $this->assertDatabaseCount('articles', 0);

        $this->actingAs($user)->postArticleRoute($article);

        $this->assertDatabaseCount('articles', 1);
        $this->assertCount($categoryCount, Article::first()->categories);
    }

    /** @test */
    public function can_add_to_a_series(): void
    {
        $user = factory(User::class)->create();
        $series = factory(ArticleSeries::class)->create();
        $article = array_merge($this->validArticle, ['series' => (string) $series->id]);

        $this->assertDatabaseCount('articles', 0);

        $this->actingAs($user)->postArticleRoute($article);

        $this->assertDatabaseCount('articles', 1);
        $this->assertInstanceOf(ArticleSeries::class, Article::first()->series);
    }

    /** @test */
    public function can_only_add_to_series_that_exists(): void
    {
        $user = factory(User::class)->create();
        $article = array_merge($this->validArticle, ['series' => 1]);

        $this->assertDatabaseCount('articles', 0);

        $this->actingAs($user)
            ->from(route('admin.articles.create'))
            ->postArticleRoute($article)
            ->assertSessionHasErrorsIn('article', 'series')
            ->assertSessionHasInput($article);

        $this->assertDatabaseCount('articles', 0);
    }

    protected function postArticleRoute(array $data = []): TestResponse
    {
        return $this->post(route('admin.articles.store'), $data);
    }
}
