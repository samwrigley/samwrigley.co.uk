<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
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
        return view('admin.articles.create');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $article = Auth::user()->articles()->create($request->validated());

        if ($request->filled(['date', 'time'])) {
            $article->markAsScheduled(
                Carbon::parse("{$request->date} {$request->time}")
            );
        }

        return Redirect::back()->with($request->errorBag, __('admin.articles.successfully_created'));
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit')->with('article', $article);
    }
}
