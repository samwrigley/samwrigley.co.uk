@extends('layouts.article')

@section('title', $article->title)

@section('article')
    <x-markdown :markdown="$article->formattedBody" />
@endsection

@push('schema')
    {!! $articleSchema->toScript() !!}
@endpush
