@extends('layouts.admin')

@section('title', __('Create article'))

@section('body')
    <x-admin.section-header heading="{{ __('Create article') }}" />

    <div class="p-8">
        <div class="w-1/2">
            <x-form route="{{ route('admin.articles.store') }}">
                <x-input
                    name="title"
                    label="{{ __('Title') }}"
                    placeholder="{{ __('Article title') }}"
                    required="true"
                    maxlength="{{ App\Article::MAX_TITLE_LENGTH }}"
                    errorBag="article"
                />

                <x-input
                    name="slug"
                    label="{{ __('Slug') }}"
                    placeholder="{{ __('Article slug') }}"
                    required="true"
                    maxlength="{{ App\Article::MAX_SLUG_LENGTH }}"
                    errorBag="article"
                />

                <x-textarea
                    name="excerpt"
                    label="{{ __('Excerpt') }}"
                    placeholder="{{ __('Article excerpt') }}"
                    maxlength="{{ App\Article::MAX_EXCERPT_LENGTH }}"
                    errorBag="article"
                />

                <x-textarea
                    name="body"
                    label="{{ __('Body') }}"
                    placeholder="{{ __('Article body') }}"
                    rows="10"
                    required="true"
                    errorBag="article"
                />

                <div class="flex">
                    <x-input
                        type="date"
                        name="date"
                        label="{{ __('Publish date') }}"
                        class="flex-1 mr-4"
                        errorBag="article"
                    />

                    <x-input
                        type="time"
                        name="time"
                        label="{{ __('Publish time') }}"
                        class="flex-1"
                        step="1"
                        errorBag="article"
                    />
                </div>

                <x-select
                    name="categories[]"
                    label="{{ __('Categories') }}"
                    :items="$categories"
                    multiple
                    errorBag="article"
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
                    errorBag="article"
                >
                    <option></option>
                    @foreach ($series as $series)
                        <option value="{{ $series->id }}">
                            {{ $series->title }}
                        </option>
                    @endforeach
                </x-select>

                <x-admin.buttons.default text="{{ __('Create') }}" />
            </x-form>

            <div class="mt-4">
                @include('components.general.errors', ['errorBag' => 'article'])
                @include('components.general.session', ['key' => 'article'])
            </div>
        </div>
    </div>
@endsection
