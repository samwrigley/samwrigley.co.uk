<?php

namespace App\ViewModels;

use App\Article;
use Illuminate\Support\Facades\Config;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\ImageObject;
use Spatie\SchemaOrg\Organization;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;
use Spatie\ViewModels\ViewModel;

class ArticleViewModel extends ViewModel
{
    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function articleSchema(): BlogPosting
    {
        return Schema::blogPosting()
            ->articleBody($this->article->body)
            ->author($this->authorSchema())
            ->dateModified($this->article->updated_at)
            ->datePublished($this->article->published_at)
            ->description($this->article->excerpt)
            ->genre(optional($this->article->categories->first())->name)
            ->headline($this->article->title)
            ->image(asset('images/sam-wrigley.png'))
            ->publisher($this->publisherSchema())
            ->url($this->article->showPath())
            ->wordCount(str_word_count($this->article->body));
    }

    private function authorSchema(): Person
    {
        return Schema::person()
            ->name($this->article->author->name)
            ->email($this->article->author->email);
    }

    private function publisherSchema(): Organization
    {
        return Schema::organization()
            ->name($this->article->author->name)
            ->url(Config::get('app.url'))
            ->logo($this->publisherLogoSchema());
    }

    private function publisherLogoSchema(): ImageObject
    {
        return Schema::imageObject()
            ->url(asset('images/sam-wrigley.png'))
            ->width(1200)
            ->height(650);
    }
}
