<?php

namespace App\ViewModels;

use App\Models\Article;
use App\Schemas\BlogPostingSchema;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\ViewModels\ViewModel;

class ArticleViewModel extends ViewModel
{
    private BlogPostingSchema $blogPostingSchema;

    public function __construct(
        public Article $article
    ) {
        $this->blogPostingSchema = new BlogPostingSchema($article);
    }

    public function articleSchema(): BlogPosting
    {
        return $this->blogPostingSchema->generate();
    }
}
