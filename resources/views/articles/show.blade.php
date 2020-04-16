@extends('layouts.article')

@section('title', $article->title)

@section('body')
    <div class="markdown-body text-xl leading-relaxed sm:text-2xl">
        {!! GitDown::parseAndCache($article->body) !!}
    </div>
@endsection

@push('schema')
    {!! $articleSchema->toScript() !!}
@endpush
