@extends('layouts.admin')

@section('body')
    <x-admin.section-header heading="{{ __('Create article') }}" />

    <div class="p-8">
        <div class="w-1/2">
            <form method="POST" action="{{ route('admin.articles.store') }}">
                @csrf

                <x-input
                    name="title"
                    label="{{ __('Title') }}"
                    placeholder="{{ __('Article title') }}"
                    required="true"
                    maxlength="255"
                />

                <x-input
                    name="slug"
                    label="{{ __('Slug') }}"
                    placeholder="{{ __('Article slug') }}"
                    required="true"
                    maxlength="255"
                />

                <x-textarea
                    name="excerpt"
                    label="{{ __('Excerpt') }}"
                    placeholder="{{ __('Article excerpt') }}"
                    maxlength="{{ App\Article::MAX_EXCERPT_LENGTH }}"
                />

                <x-textarea
                    name="body"
                    label="{{ __('Body') }}"
                    placeholder="{{ __('Article body') }}"
                    rows="10"
                    required="true"
                />

                <div class="flex">
                    <x-input
                        type="date"
                        name="date"
                        label="{{ __('Publish date') }}"
                        class="flex-1 mr-4"
                    />

                    <x-input
                        type="time"
                        name="time"
                        label="{{ __('Publish time') }}"
                        class="flex-1"
                        step="1"
                    />
                </div>

                <x-select
                    name="categories[]"
                    label="{{ __('Categories') }}"
                    :items="$categories"
                    multiple
                >
                    <option></option>
                    @foreach ($component->items as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-select>

                <x-select
                    name="series"
                    label="{{ __('Series') }}"
                    :items="$series"
                >
                    <option></option>
                    @foreach ($series as $series)
                        <option value="{{ $series->id }}">
                            {{ $series->title }}
                        </option>
                    @endforeach
                </x-select>

                @include('admin.partials.buttons.default', ['text' => __('Create')])
            </form>

            <div class="mt-4">
                @include('components.general.errors', ['errorBag' => 'article'])
                @include('components.general.session', ['key' => 'article'])
            </div>
        </div>
    </div>
@endsection
