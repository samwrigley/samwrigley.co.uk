<?php

namespace Tests\Unit\Schemas;

use App\Article;
use App\Schemas\BlogPostingSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\Organization;
use Spatie\SchemaOrg\Person;
use Tests\TestCase;

class BlogPostingSchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_blog_posting_schema(): void
    {
        $article = factory(Article::class)->states('published')->make();
        $blogPostingSchema = (new BlogPostingSchema($article))->generate();

        $this->assertInstanceOf(BlogPosting::class, $blogPostingSchema);
        $this->assertEquals($blogPostingSchema['articleBody'], $article->body);
        $this->assertEquals($blogPostingSchema['dateModified'], $article->updated_at);
        $this->assertEquals($blogPostingSchema['datePublished'], $article->published_at);
        $this->assertEquals($blogPostingSchema['description'], $article->excerpt);
        $this->assertEquals($blogPostingSchema['headline'], $article->title);
        $this->assertEquals($blogPostingSchema['image'], asset('images/sam-wrigley.png'));
        $this->assertEquals($blogPostingSchema['url'], $article->showPath());
        $this->assertEquals($blogPostingSchema['wordCount'], str_word_count($article->body));

        $this->assertInstanceOf(Person::class, $blogPostingSchema['author']);
        $this->assertEquals($blogPostingSchema['author']['email'], $article->author->email);
        $this->assertEquals($blogPostingSchema['author']['name'], $article->author->name);

        $this->assertInstanceOf(Organization::class, $blogPostingSchema['publisher']);
        $this->assertEquals($blogPostingSchema['publisher']['name'], $article->author->name);
        $this->assertEquals($blogPostingSchema['publisher']['url'], Config::get('app.url'));
    }

    /** @test */
    public function it_generates_blog_posting_schema_with_correct_genre_when_article_has_multiple_categories(): void
    {
        $article = factory(Article::class)->states(['published', 'withCategories'])->create();
        $blogPostingSchema = (new BlogPostingSchema($article))->generate();

        $this->assertEquals(
            $blogPostingSchema['genre'],
            $article->categories->first()->name
        );
    }

    /** @test */
    public function it_generates_blog_posting_schema_with_correct_genre_when_article_has_no_categories(): void
    {
        $article = factory(Article::class)->states(['published'])->create();
        $blogPostingSchema = (new BlogPostingSchema($article))->generate();

        $this->assertNull($blogPostingSchema['genre']);
    }
}
