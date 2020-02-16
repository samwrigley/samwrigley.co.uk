@extends('layouts.default')

@section('content')
    <article class="pt-20">
        <header class="relative mx-auto max-w-4xl mb-16">
            @if ($article->isOld())
                <div class="flex mb-12">
                    <div class="flex px-6 py-4 bg-yellow-400 text-base">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 32 32"
                            class="w-6 mr-2"
                        >
                            <path d="M16 2a14 14 0 1 0 14 14A14 14 0 0 0 16 2zm-1.13 6h2.25v11h-2.25zM16 25a1.5 1.5 0 1 1 1.5-1.5A1.5 1.5 0 0 1 16 25z" />
                        </svg>
                        <span>
                            @lang('newsletter.out_of_date', ['date' => $article->published_at->diffForHumans()])
                        </span>
                    </div>
                </div>
            @endif

            @if ($article->categories && $article->categories->count())
                <ul class="mb-4 text-sm uppercase tracking-widest">
                    @foreach ($article->categories as $category)
                        <li class="leading-none">
                            <a href="{{ $category->showPath() }}"
                                title="@lang("Read all articles in $category->name")"
                                aria-label="@lang("Read all articles in $category->name")"
                                class="block text-gray-600 hover:text-gray-900"
                            >
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <h1 class="mb-4 text-6xl font-black leading-tight">
                <a href="{{ $article->showPath() }}"
                    aria-label="@lang("Read: $article->title")"
                    title="@lang("Read: $article->title")"
                >
                    {{ $article->title }}
                </a>
            </h1>

            @if ($article->published_at)
                <time datetime="{{ $article->published_at }}"
                    aria-label="@lang('Posted On')"
                    class="block mb-10 text-xl text-gray-600 leading-none"
                    title="{{ $article->published_at }}"
                >
                    @date($article->published_at)
                </time>
            @endif

            @if ($article->author)
                <div class="flex items-start mb-16 last-child:mb-0">
                    @if ($article->author->avatar)
                        <a href="{{ route('about') }}"
                            class="mr-4"
                            title="@lang('Find out more about') {{ $article->author->name }}"
                        >
                            <img src="{{ $article->author->avatar }}"
                                alt="{{ $article->author->name }}"
                                class="rounded-full w-16"
                            >
                        </a>
                    @endif

                    <div class="flex-1 text-xl">
                        <h4 class="mb-2 font-bold leading-tight">
                            <a href="{{ route('about') }}"
                                title="@lang('Find out more about') {{ $article->author->name }}"
                            >
                                {{ $article->author->name }}
                            </a>
                        </h4>

                        <div class="markdown w-3/4 mb-4 text-gray-600">
                            @markdown($article->author->bio)
                        </div>
                    </div>
                </div>
            @endif

            @if ($article->series && $article->series->articles->count())
                <div class="text-xl">
                    <p class="mb-4">
                        @lang('article.in_series', ['count' => $article->series->articles->count()])
                    </p>
                    <ul>
                        @foreach ($article->series->articles as $seriesArticle)
                            <li class="mb-1 last-child:mb-0">
                                <span class="mr-1 text-gray-600">
                                    @lang('Part') {{ $loop->index + 1}}:
                                </span>
                                @if ($seriesArticle->showPath() === $article->showPath())
                                    {{ $seriesArticle->title }}
                                @else
                                    <a href="{{ $seriesArticle->showPath() }}"
                                        title="@lang("Read $seriesArticle->title")"
                                        aria-label="@lang("Read $seriesArticle->title")"
                                    >
                                        {{ $seriesArticle->title }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </header>

        <div class="mx-auto max-w-4xl mb-32">
            @yield('body')
        </div>

        <footer class="flex border border-black">
            @include('partials.articles.info')
            @include('partials.articles.newsletter')
        </footer>
    </article>
@endsection
