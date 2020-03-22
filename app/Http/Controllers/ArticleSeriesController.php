<?php

namespace App\Http\Controllers;

use App\ArticleSeries;
use Illuminate\View\View;

class ArticleSeriesController extends Controller
{
    protected string $namespace = 'series.';

    public function index(): View
    {
        $series = ArticleSeries::hasPublished('articles')->get();

        return view($this->namespace . 'index', [
            'allSeries' => $series,
        ]);
    }

    public function show(string $slug): View
    {
        $series = ArticleSeries::hasPublished('articles')
            ->whereSlug($slug)
            ->withArticles()
            ->firstOrFail();

        $articles = $series->articles()
            ->published()
            ->paginate();

        return view($this->namespace . 'show', [
            'series' => $series,
            'articles' => $articles,
        ]);
    }
}
