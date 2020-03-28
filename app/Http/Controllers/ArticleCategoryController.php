<?php

namespace App\Http\Controllers;

use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ArticleCategoryController extends Controller
{
    protected string $namespace = 'categories.';

    public function index(): View
    {
        $categories = ArticleCategory::hasPublished('articles')
            ->latest()
            ->withArticles()
            ->paginate();

        return view($this->namespace . 'index', [
            'categories' => $categories,
        ]);
    }

    public function show(string $slug): View
    {
        $category = ArticleCategory::hasPublished('articles')
            ->whereSlug($slug)
            ->withArticles()
            ->firstOrFail();

        $articles = $category->articles()
            ->published()
            ->withCategories()
            ->paginate();

        return view($this->namespace . 'show', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }
}
