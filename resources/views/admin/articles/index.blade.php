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
                                        <x-pill
                                            colour="{{ App\View\Components\Pill::GREEN }}"
                                            text="{{ __('Published') }}"
                                        />
                                    @elseif ($article->isScheduled())
                                        <x-pill
                                            colour="{{ App\View\Components\Pill::ORANGE }}"
                                            text="{{ __('Scheduled') }}"
                                        />
                                    @elseif ($article->isDraft())
                                        <x-pill
                                            colour="{{ App\View\Components\Pill::YELLOW }}"
                                            text="{{ __('Draft') }}"
                                        />
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
