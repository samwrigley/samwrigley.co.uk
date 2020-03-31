<?php

namespace App\Schemas;

use App\Article;
use App\Schemas\Contracts\SchemaContract;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\ImageObject;
use Spatie\SchemaOrg\Organization;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;

class BlogPostingSchema implements SchemaContract
{
    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function generate(): BlogPosting
    {
        return Schema::blogPosting()
            ->articleBody($this->article->body)
            ->author($this->generateAuthorSchema())
            ->dateModified($this->article->updated_at)
            ->datePublished($this->article->published_at)
            ->description($this->article->excerpt)
            ->genre(optional($this->article->categories->first())->name)
            ->headline($this->article->title)
            ->image(asset('images/sam-wrigley.png'))
            ->publisher($this->generatePublisherSchema())
            ->url($this->article->showPath())
            ->wordCount(str_word_count($this->article->body));
    }

    private function generateAuthorSchema(): Person
    {
        return Schema::person()
            ->name($this->article->author->name)
            ->email($this->article->author->email);
    }

    private function generatePublisherSchema(): Organization
    {
        return Schema::organization()
            ->name($this->article->author->name)
            ->url(Config::get('app.url'))
            ->logo($this->generatePublisherLogoSchema());
    }

    private function generatePublisherLogoSchema(): ImageObject
    {
        return Schema::imageObject()
            ->url(asset('images/sam-wrigley.png'))
            ->width(1200)
            ->height(650);
    }
}
