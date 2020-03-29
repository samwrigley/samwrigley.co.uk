<?php

namespace Tests\Unit\ViewModels;

use App\Article;
use App\ViewModels\ArticleViewModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\Organization;
use Spatie\SchemaOrg\Person;
use Tests\TestCase;

class ArticleViewModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_contains_article_when_cast_to_array(): void
    {
        $article = factory(Article::class)->states('published')->make();
        $viewModel = (new ArticleViewModel($article))->toArray();

        $this->assertEquals($viewModel['article'], $article);
    }

    /** @test */
    public function it_contains_article_schema_when_cast_to_array(): void
    {
        $article = factory(Article::class)->states('published')->make();
        $viewModel = (new ArticleViewModel($article))->toArray();
        $articleSchema = $viewModel['articleSchema'];
        $authorSchema = $articleSchema['author'];
        $publisherSchema = $articleSchema['publisher'];

        $this->assertInstanceOf(BlogPosting::class, $articleSchema);
        $this->assertEquals($articleSchema['articleBody'], $article->body);
        $this->assertEquals($articleSchema['dateModified'], $article->updated_at);
        $this->assertEquals($articleSchema['datePublished'], $article->published_at);
        $this->assertEquals($articleSchema['description'], $article->excerpt);
        $this->assertEquals($articleSchema['headline'], $article->title);
        $this->assertEquals($articleSchema['image'], asset('images/sam-wrigley.png'));
        $this->assertEquals($articleSchema['url'], $article->showPath());
        $this->assertEquals($articleSchema['wordCount'], str_word_count($article->body));

        $this->assertInstanceOf(Person::class, $authorSchema);
        $this->assertEquals($authorSchema['email'], $article->author->email);
        $this->assertEquals($authorSchema['name'], $article->author->name);

        $this->assertInstanceOf(Organization::class, $publisherSchema);
        $this->assertEquals($publisherSchema['name'], $article->author->name);
        $this->assertEquals($publisherSchema['url'], Config::get('app.url'));
    }

    /** @test */
    public function it_contains_article_schema_with_correct_genre_when_article_has_multiple_categories(): void
    {
        $article = factory(Article::class)->states(['published', 'withCategories'])->create();
        $viewModel = (new ArticleViewModel($article))->toArray();

        $this->assertEquals(
            $viewModel['articleSchema']['genre'],
            $article->categories->first()->name
        );
    }

    /** @test */
    public function it_contains_article_schema_with_correct_genre_when_article_has_not_categories(): void
    {
        $article = factory(Article::class)->states(['published'])->create();
        $viewModel = (new ArticleViewModel($article))->toArray();

        $this->assertNull($viewModel['articleSchema']['genre']);
    }
}
