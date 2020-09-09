@extends('layouts.default')

@section('title', __('article.index_page_title'))

@section('body')
    @if ($articles->count())
        <div class="grid mb-6 sm:mb-12">
            @foreach ($articles as $article)
                @include('partials.articles.preview', ['article' => $article])
            @endforeach
        </div>
    @else
        <div class="flex-1 flex items-center justify-center">
            <div class="text-center">
                <h1 class="mb-2 text-3xl font-black leading-tight md:mb-4 md:text-5xl lg:text-6xl">
                    @lang('article.no_articles_heading')
                </h1>
                <span class="leading-tight tracking-wide md:text-xl sm:tracking-normal">
                    @lang('article.no_articles_subheading')
                </span>
            </div>
        </div>
    @endif

    @include('partials.general.pagination', ['items' => $articles])
@endsection
