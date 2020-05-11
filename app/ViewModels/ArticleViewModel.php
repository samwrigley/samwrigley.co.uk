<?php

namespace App\ViewModels;

use App\Article;
use App\Schemas\BlogPostingSchema;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\ViewModels\ViewModel;

class ArticleViewModel extends ViewModel
{
    public Article $article;

    private BlogPostingSchema $blogPostingSchema;

    public function __construct(Article $article)
    {
        $this->article = $article;
        $this->blogPostingSchema = new BlogPostingSchema($article);
    }

    public function articleSchema(): BlogPosting
    {
        return $this->blogPostingSchema->generate();
    }
}
