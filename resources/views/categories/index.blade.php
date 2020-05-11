@extends('layouts.default')

@section('title', __('article_category.index_page_title'))

@section('content')
    <h1 class="text-2xl font-black mb-4 md:text-4xl lg:mb-8 lg:text-5xl">
        All Categories
    </h1>

    <div class="grid mb-6 sm:mb-12">
        @foreach ($categories as $category)
            @include('partials.categories.preview', ['category' => $category])
        @endforeach
    </div>

    @include('partials.general.pagination', ['items' => $categories])
@endsection
