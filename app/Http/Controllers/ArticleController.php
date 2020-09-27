<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\ViewModels\ArticleViewModel;
use Illuminate\View\View;

class ArticleController extends Controller
{
    protected string $namespace = 'articles.';

    public function index(): View
    {
        $articles = Article::published()
            ->latest('published_at')
            ->withCategories()
            ->withAuthor()
            ->paginate();

        return view($this->namespace . 'index', [
            'articles' => $articles,
        ]);
    }

    public function show(string $slug): View
    {
        $article = Article::whereSlug($slug)
            ->published()
            ->withCategories()
            ->withAuthor()
            ->withSeries()
            ->firstOrFail();

        $viewModel = new ArticleViewModel($article);

        return view($this->namespace . 'show', $viewModel);
    }
}
