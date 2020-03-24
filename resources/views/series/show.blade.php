@extends('layouts.default')

@section('title', $series->title)

@section('content')
    <div class="grid mb-6 sm:mb-12">
        @foreach ($articles as $article)
            <a href="{{ $article->showPath() }}"
                aria-label="@lang('Read') {{ $article->title }}"
                title="@lang('Read') {{ $article->title }}"
                class="block group relative p-6 pb-16 hover:bg-gray-100 sm:p-12 sm:pb-32"
            >
                <article>
                    <header class="mb-6">
                        <div class="flex items-center mb-6 sm:mb-12">
                            @if ($article->categories->count())
                                <ul class="text-xs text-gray-600 uppercase tracking-widest sm:text-sm">
                                    @foreach ($article->categories as $category)
                                        <li class="leading-none">
                                            {{ $category->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($article->isNew())
                                <div class="absolute top-0 right-0 flex items-center justify-center bg-yellow-400 w-12 h-12 font-medium text-sm sm:w-16 sm:h-16 sm:text-base"
                                    title="@lang('This article was published recently')"
                                >
                                    New
                                </div>
                            @endif

                            <div class="absolute right-0 bottom-0 flex items-center justify-center bg-gray-200 text-xl w-12 h-12
                                group-hover:bg-gray-900 group-hover:text-white sm:w-16 sm:h-16"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 32 32"
                                    class="w-4 fill-current sm:w-6"
                                >
                                    <path d="M18 6l-1.43 1.39L24.15 15H3v2h21.15l-7.58 7.57L18 26l10-10L18 6z" />
                                </svg>
                            </div>
                        </div>

                        <h2 class="mb-2 text-2xl leading-tight font-bold sm:text-4xl">
                            {{ $article->title }}
                        </h2>

                        @if ($article->published_at)
                            <time datetime="{{ $article->published_at }}"
                                aria-label="@lang('Posted On')"
                                class="text-sm text-gray-600 sm:text-base"
                            >
                                @date($article->published_at)
                            </time>
                        @endif
                    </header>

                    @if ($article->excerpt)
                        <p class="text-base sm:text-xl">
                            {!! $article->excerpt !!}
                        </p>
                    @endif
                </article>
            </a>
        @endforeach
    </div>

    @include('partials.general.pagination', ['items' => $articles])
@endsection
