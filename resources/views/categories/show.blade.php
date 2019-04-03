@extends('layouts.default')

@section('content')
    <header class="header-text">
        <h1 class="header-text__heading">
            @lang('All articles in ')
            <span>{{ $category->name }}</span>
        </h1>
    </header>

    <div class="article-overviews">
        @include('partials.articles.index')
    </div>
@endsection

@section('aside')
    @include('partials.general.aside')
@endsection
