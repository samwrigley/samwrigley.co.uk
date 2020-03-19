@extends('layouts.article')

@section('title', $article->title)

@section('body')
    <div class="markdown text-xl leading-relaxed sm:text-2xl">
        @markdown($article->body)
    </div>
@endsection
