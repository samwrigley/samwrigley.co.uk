<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * The route namespace.
     *
     * @var string
     */
    protected $namespace = 'articles.';

    public function index(): View
    {
        $articles = Article::published()
            ->latest('published_at')
            ->withCategories()
            ->withAuthor()
            ->paginate(10);

        $categories = ArticleCategory::has('articles')->get();

        return view($this->namespace . 'index')
            ->with([
                'articles' => $articles,
                'categories' => $categories,
            ]);
    }

    public function show(string $slug): View
    {
        $article = Article::whereSlug($slug)
            ->withCategories()
            ->withAuthor()
            ->firstOrFail();

        $categories = ArticleCategory::has('articles')->get();

        return view($this->namespace . 'show')
            ->with([
                'article' => $article,
                'categories' => $categories,
            ]);
    }
}
