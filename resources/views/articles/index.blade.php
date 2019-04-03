@extends('layouts.default')

@section('content')
    <header class="header-text">
        <h1 class="header-text__heading">
            @lang('All articles')
        </h1>
    </header>

    <div class="article-overviews">
        @foreach ($articles as $article)
            <article class="article-overview">
                <header class="article-overview__header">
                    @include('partials.articles.header')
                </header>

                @include('partials.articles.featured-image')
                @include('partials.articles.excerpt')
                @include('partials.articles.read-more')
            </article>
        @endforeach

        @include('partials.general.pagination', ['items' => $articles])
    </div>
@endsection
