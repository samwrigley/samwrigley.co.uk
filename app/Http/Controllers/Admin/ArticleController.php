<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSeries;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index', [
            'articles' => Article::latest()->paginate(25),
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
        $article = auth()->user()->articles()->create($request->validated());

        if ($request->filled('categories')) {
            $article->categories()->attach($request->categories);
        }

        if ($request->filled('series')) {
            $article->series()->associate($request->series);
            $article->save();
        }

        return back()->with('article', __('admin.articles.successfully_created'));
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
        $response = Gate::inspect('update', $article);

        if ($response->denied()) {
            return back()->with('article', __('admin.articles.forbidden_update'));
        }

        $article->update($request->validated());

        if (! empty($request->categories)) {
            $article->categories()->sync($request->categories);
        } else {
            $article->categories()->detach();
        }

        if ($request->filled('series')) {
            $article->series()->associate($request->series);
        } else {
            $article->series()->dissociate();
        }

        $article->save();

        return back()->with('article', __('admin.articles.successfully_updated'));
    }

    public function destroy(Article $article): RedirectResponse
    {
        $response = Gate::inspect('delete', $article);

        if ($response->denied()) {
            return back()->with('article', __('admin.articles.forbidden_delete'));
        }

        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('article', __('admin.articles.successfully_deleted'));
    }
}
