@extends('layouts.article')

@section('body')
    <div class="markdown text-2xl leading-relaxed">
        @markdown($article->body)
    </div>
@endsection
