@extends('layouts.default')

@section('content')
    <article class="pt-12 sm:pt-20">
        <header class="relative mx-auto max-w-4xl pb-4 mb-12 border-b border-black sm:mb-16">
            @include('partials.articles.outOfDate')
            @include('partials.articles.categories')

            <h1 class="mb-4 text-3xl font-black leading-tight md:text-4xl lg:text-6xl">
                <a href="{{ $article->showPath() }}">
                    {{ $article->title }}
                </a>
            </h1>

            @include('partials.articles.author')

            @if ($article->published_at)
                <time datetime="{{ $article->published_at }}"
                    aria-label="@lang('Posted On')"
                    class="block text-base text-gray-600 leading-none sm:text-xl"
                    title="{{ $article->published_at }}"
                >
                    @date($article->published_at)
                </time>
            @endif

            @include('partials.articles.inSeries')
        </header>

        <div class="mx-auto max-w-4xl mb-12 sm:mb-32">
            @yield('body')
        </div>

        <footer class="flex flex-col border border-black lg:flex-row">
            @include('partials.articles.info')
            @include('partials.articles.newsletter')
        </footer>
    </article>
@endsection
