@extends('layouts.default')

@section('title', $series->title)

@section('body')
    <div class="grid mb-6 sm:mb-12">
        @foreach ($articles as $article)
            @include('partials.articles.preview', ['article' => $article])
        @endforeach
    </div>

    @include('partials.general.pagination', ['items' => $articles])
@endsection
