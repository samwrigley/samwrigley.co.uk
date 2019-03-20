<?php

namespace App\Http\Controllers;

use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ArticleCategoryController extends Controller
{
    /**
     * The route namespace.
     *
     * @var string
     */
    protected $namespace = 'categories.';

    public function index(): Response
    {
        $categories = ArticleCategory::withPosts()->get();

        return view($this->namespace . 'index')
            ->with('categories', $categories);
    }

    public function show(string $slug): Response
    {
        $category = ArticleCategory::whereSlug($slug)
            ->withPosts()
            ->firstOrFail();

        $categories = ArticleCategory::has('posts')->get();

        $posts = $category->posts()
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return view($this->namespace . 'show')
            ->with([
                'category' => $category,
                'categories' => $categories,
                'posts' => $posts,
            ]);
    }
}
