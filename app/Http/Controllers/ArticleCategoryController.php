<?php

namespace App\Http\Controllers;

use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ArticleCategoryController extends Controller
{
    /**
     * The route namespace.
     *
     * @var string
     */
    protected $namespace = 'categories.';

    public function index(): View
    {
        $categories = ArticleCategory::hasPublished('articles')->get();

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

        $categories = ArticleCategory::hasPublished('articles')->get();

        $articles = $category->articles()
            ->published()
            ->paginate(10);

        return view($this->namespace . 'show', [
            'category' => $category,
            'categories' => $categories,
            'articles' => $articles,
        ]);
    }
}
