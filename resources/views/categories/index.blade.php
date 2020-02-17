@extends('layouts.default')

@section('title', 'Blog Categories')

@section('content')
    <header class="header-text">
        <h1 class="header-text__heading">
            @lang('All Categories')
        </h1>
    </header>

    <ul class="categories">
        @include('partials.categories.index')
    </ul>
@endsection
