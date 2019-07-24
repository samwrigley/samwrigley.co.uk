@extends('layouts.default')

@section('content')
    <div class="flex mb-12">
        <div class="w-2/3">
            <a href="{{ $featuredArticle->showPath() }}"
                class="group block relative bg-gray-900 hover:bg-gray-800"
            >
                <article>
                    <div class="w-1/2 p-12 pb-64">
                        @if ($featuredArticle->categories->count())
                            <ul class="mb-6 text-sm text-gray-500 uppercase tracking-widest">
                                @foreach ($featuredArticle->categories as $category)
                                    <li class="leading-none">
                                        {{ $category->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <h2 class="mb-4 text-3xl text-white font-black">
                            {{ $featuredArticle->title }}
                        </h2>

                        @if ($featuredArticle->published_at)
                            <time datetime="{{ $featuredArticle->published_at }}"
                                aria-label="@lang('Posted On')"
                                class="block mb-6 text-base text-gray-500"
                            >
                                @date($featuredArticle->published_at)
                            </time>
                        @endif

                        @if ($featuredArticle->excerpt)
                            <p class="text-xl text-gray-200 font-light">
                                {!! $featuredArticle->excerpt !!}
                            </p>
                        @endif
                    </div>

                    @if ($featuredArticle->isNew())
                        <div class="absolute top-0 right-0 flex items-center justify-center bg-yellow-400 w-16 h-16 font-medium"
                            title="@lang('This article was published recently')"
                        >
                            New
                        </div>
                    @endif

                    <div class="absolute right-0 bottom-0 flex items-center justify-center bg-gray-200 text-xl w-16 h-16
                        group-hover:bg-yellow-400"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 32 32"
                            class="w-6"
                        >
                            <path d="M18 6l-1.43 1.39L24.15 15H3v2h21.15l-7.58 7.57L18 26l10-10L18 6z" />
                        </svg>
                    </div>
                </article>
            </a>
        </div>

        <div class="px-12 w-1/3">
            <h1 class="text-3xl font-light mb-3">
                @lang('The rabblings of a Front-End Developer. Covering HTML, CSS, JavaScript and PHP.')
            </h1>
        </div>
    </div>

    <div class="flex flex-wrap border-t border-l border-gray-900 mb-12">
        @foreach ($articles as $article)
            <a href="{{ $article->showPath() }}"
                aria-label="@lang('Read') {{ $article->title }}"
                title="@lang('Read') {{ $article->title }}"
                class="block group relative w-1/3 border-r border-b border-gray-900 p-12 pb-32 hover:bg-gray-100"
            >
                <article>
                    <header class="mb-6">
                        <div class="flex items-center mb-12">
                            @if ($article->categories->count())
                                <ul class="text-sm text-gray-600 uppercase tracking-widest">
                                    @foreach ($article->categories as $category)
                                        <li class="leading-none">
                                            {{ $category->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($article->isNew())
                                <div class="absolute top-0 right-0 flex items-center justify-center bg-yellow-400 w-16 h-16 font-medium"
                                    title="@lang('This article was published recently')"
                                >
                                    New
                                </div>
                            @endif

                            <div class="absolute right-0 bottom-0 flex items-center justify-center bg-gray-200 text-xl w-16 h-16
                                group-hover:bg-gray-900 group-hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 32 32"
                                    class="w-6 fill-current"
                                >
                                    <path d="M18 6l-1.43 1.39L24.15 15H3v2h21.15l-7.58 7.57L18 26l10-10L18 6z" />
                                </svg>
                            </div>
                        </div>

                        <h2 class="mb-2 text-4xl leading-tight">
                            {{ $article->title }}
                        </h2>

                        @if ($article->published_at)
                            <time datetime="{{ $article->published_at }}"
                                aria-label="@lang('Posted On')"
                                class="text-base text-gray-600"
                            >
                                @date($article->published_at)
                            </time>
                        @endif
                    </header>

                    @if ($article->excerpt)
                        <p class="text-xl">
                            {!! $article->excerpt !!}
                        </p>
                    @endif
                </article>
            </a>
        @endforeach
    </div>

    @include('partials.general.pagination', ['items' => $articles])
@endsection
