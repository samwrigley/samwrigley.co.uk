@extends('layouts.default')

@section('content')
    <article class="article">
        <header class="article__header">
            @include('partials.articles.header')
        </header>

        @yield('body')

        <footer class="article__footer">
            @include('partials.articles.share')
            @include('partials.articles.newsletter')
            @include('partials.articles.info')
        </footer>
    </article>
@endsection
