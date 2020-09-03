@extends('layouts.admin')

@section('body')
    <x-admin.section-header heading="{{ __('Edit article') }}">
        <form action="{{ route('admin.articles.destroy', ['article' => $article]) }}" method="POST">
            @csrf
            @method('DELETE')
            @include('admin.partials.buttons.default', ['text' => __('Delete article')])
        </form>
    </x-admin.section-header>

    <div class="p-8">
        <div class="w-1/2">
            <form method="POST" action="{{ route('admin.articles.update', ['article' => $article]) }}">
                @csrf
                @method('PUT')

                <x-input
                    name="title"
                    label="{{ __('Title') }}"
                    placeholder="{{ __('Article title') }}"
                    :value="$article->title"
                    required="true"
                    maxlength="255"
                />

                <x-input
                    name="slug"
                    label="{{ __('Slug') }}"
                    placeholder="{{ __('Article slug') }}"
                    :value="$article->slug"
                    required="true"
                    maxlength="255"
                />

                <x-textarea
                    name="excerpt"
                    label="{{ __('Excerpt') }}"
                    placeholder="{{ __('Article excerpt') }}"
                    :value="$article->excerpt"
                    maxlength="{{ App\Article::MAX_EXCERPT_LENGTH }}"
                />

                <x-textarea
                    name="body"
                    label="{{ __('Body') }}"
                    placeholder="{{ __('Article body') }}"
                    :value="$article->body"
                    rows="10"
                    required="true"
                />

                <div class="flex">
                    <x-input
                        type="date"
                        name="date"
                        label="{{ __('Publish date') }}"
                        :value="$article->publishedDate"
                        class="flex-1 mr-4"
                    />

                    <x-input
                        type="time"
                        name="time"
                        label="{{ __('Publish time') }}"
                        :value="$article->publishedTime"
                        class="flex-1"
                        step="1"
                    />
                </div>

                <x-select
                    name="categories[]"
                    label="{{ __('Categories') }}"
                    :items="$categories"
                    :selected="$article->categories->pluck('id')->toArray()"
                    multiple
                >
                    <option></option>
                    @foreach ($component->items as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ $component->isSelected($category->id) ? 'selected="selected"' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-select>

                <x-select
                    name="series"
                    label="{{ __('Series') }}"
                    :items="$series"
                    :selected="optional($article->series)->id"
                >
                    <option></option>
                    @foreach ($component->items as $series)
                        <option
                            value="{{ $series->id }}"
                            {{ $component->isSelected($series->id) ? 'selected="selected"' : '' }}
                        >
                            {{ $series->title }}
                        </option>
                    @endforeach
                </x-select>

                @include('admin.partials.buttons.default', ['text' => __('Save')])
            </form>

            <div class="mt-4">
                @include('components.general.errors', ['errorBag' => 'article'])
                @include('components.general.session', ['key' => 'article'])
            </div>
        </div>
    </div>
@endsection
