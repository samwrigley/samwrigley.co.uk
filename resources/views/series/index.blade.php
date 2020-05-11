@extends('layouts.default')

@section('title', __('article_series.index_page_title'))

@section('content')
    <h1 class="text-2xl font-black mb-4 md:text-4xl lg:mb-8 lg:text-5xl">
        All Series
    </h1>

    <div class="grid mb-6 sm:mb-12">
        @foreach ($allSeries as $series)
            @include('partials.series.preview', ['series' => $series])
        @endforeach
    </div>

    @include('partials.general.pagination', ['items' => $allSeries])
@endsection
