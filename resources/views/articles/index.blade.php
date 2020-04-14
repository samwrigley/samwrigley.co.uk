@extends('layouts.default')

@section('title', __('article.index_page_title'))

@section('content')
    <div class="grid mb-6 sm:mb-12">
        @foreach ($articles as $article)
            @include('partials.articles.preview', ['article' => $article])
        @endforeach
    </div>

    @include('partials.general.pagination', ['items' => $articles])
@endsection
