@extends('layouts.article')

@section('title', $article->title)

@section('article')
    <div class="markdown-body text-xl leading-relaxed sm:text-2xl">
        @markdown($article->body)
    </div>
@endsection

@push('schema')
    {!! $articleSchema->toScript() !!}
@endpush
