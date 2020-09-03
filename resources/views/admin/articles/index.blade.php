@extends('layouts.admin')

@section('body')
    <x-admin.section-header heading="{{ __('All articles') }}" />

    <div class="p-8">
        @if ($articles->count())
            <div class="flex flex-col overflow-hidden w-full rounded shadow text-left mb-4">
                <div class="bg-gray-100 border-b border-gray-300 text-lg font-bold">
                    <div class="flex">
                        <div class="flex-1 p-4">{{ __('Title') }}</div>
                        <div class="w-64 p-4">{{ __('Status') }}</div>
                    </div>
                </div>
                <div>
                    @foreach ($articles as $article)
                        <div class="border-b border-gray-300">
                            <a href="{{ $article->editRoute() }}" class="flex hover:bg-gray-100">
                                <div class="flex-1 p-4">
                                    {{ $article->title }}
                                </div>
                                <div class="w-64 p-4">
                                    @if ($article->isPublished())
                                        <div class="inline-block rounded-full py-1 px-2 text-sm leading-tight bg-green-200 text-green-800">
                                            Published
                                        </div>
                                    @elseif ($article->isScheduled())
                                        <div class="inline-block rounded-full py-1 px-2 text-sm leading-tight bg-orange-200 text-orange-800">
                                            Scheduled
                                        </div>
                                    @elseif ($article->isDraft())
                                        <div class="inline-block rounded-full py-1 px-2 text-sm leading-tight bg-yellow-200 text-yellow-800">
                                            Draft
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{ $articles->links('admin.partials.pagination') }}
        @else
            <div class="flex flex-col items-center">
                <div class="text-2xl font-bold mb-4">
                    {{ __('No articles') }}
                </div>
                <a href="{{ route('admin.articles.create') }}"
                    class="text-white bg-gray-800 py-2 px-3 rounded hover:bg-gray-900"
                >
                    {{ __('Create article') }}
                </a>
            </div>
        @endif
    </div>
@endsection
