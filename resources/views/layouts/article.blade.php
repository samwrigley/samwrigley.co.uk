@extends('layouts.default')

@section('content')
    <article class="pt-12 sm:pt-20">
        <header class="relative mx-auto max-w-4xl mb-12 sm:mb-20">
            @include('partials.articles.outOfDate')

            <div class="flex flex-col mb-4 text-xs uppercase tracking-widest sm:flex-row sm:text-sm">
                @if ($article->published())
                    <time datetime="{{ $article->published_at }}"
                        aria-label="@lang('Posted On')"
                        class="mb-2 sm:mr-6 sm:mb-0"
                        title="Published at {{ $article->published_at }}"
                    >
                        @date($article->published_at)
                    </time>
                @endif

                @include('partials.articles.categories')
            </div>

            <h1 class="mb-4 text-3xl font-black leading-tight md:text-4xl lg:text-6xl">
                <a href="{{ $article->showRoute() }}">
                    {{ $article->title }}
                </a>
            </h1>

            @include('partials.articles.author')
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
