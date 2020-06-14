<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleCategory;
use App\ArticleSeries;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index', [
            'articles' => Article::latest()->paginate('25'),
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.create')->with([
            'categories' => ArticleCategory::orderBy('name')->get(),
            'series' => ArticleSeries::orderBy('title')->get(),
        ]);
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $article = Auth::user()
            ->articles()
            ->create($request->all());

        if ($request->filled('categories')) {
            $article->categories()->attach($request->categories);
        }

        if ($request->filled('series')) {
            $article->series()->associate($request->series);
            $article->save();
        }

        return Redirect::back()->with(
            'article',
            __('admin.articles.successfully_created')
        );
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit')->with([
            'article' => $article,
            'categories' => ArticleCategory::orderBy('name')->get(),
            'series' => ArticleSeries::orderBy('title')->get(),
        ]);
    }

    public function update(Article $article, ArticleRequest $request): RedirectResponse
    {
        $article->update($request->all());

        $article->categories()->detach();

        $article->series()->dissociate();
        $article->save();

        if ($request->filled('categories')) {
            $article->categories()->attach($request->categories);
        }

        if ($request->filled('series')) {
            $article->series()->associate($request->series);
            $article->save();
        }

        return Redirect::back()->with(
            'article',
            __('admin.articles.successfully_updated')
        );
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return Redirect::route('admin.articles.index')
            ->with('article', __('admin.articles.successfully_delete'));
    }
}
