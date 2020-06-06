@extends('layouts.admin')

@section('body')
    <header class="flex items-center py-6 px-8 border-b border-gray-300">
        <h1 class="font-bold text-3xl">
            {{ __('Create article') }}
        </h1>
    </header>

    <div class="p-8">
        <div class="w-1/2">
            <form method="POST" action="{{ route('admin.articles.store') }}">
                @csrf

                @include('admin.partials.form.input', [
                    'name' => 'title',
                    'label' => __('Title'),
                    'placeholder' => __('Article title'),
                    'required' => true,
                    'maxLength' => 255,
                ])

                @include('admin.partials.form.input', [
                    'name' => 'slug',
                    'label' => __('Slug'),
                    'placeholder' => __('Article slug'),
                    'required' => true,
                    'maxLength' => 255,
                ])

                @include('admin.partials.form.textarea', [
                    'name' => 'excerpt',
                    'label' => __('Excerpt'),
                    'placeholder' => __('Article excerpt'),
                    'maxLength' => App\Article::MAX_EXCERPT_LENGTH,
                ])

                @include('admin.partials.form.textarea', [
                    'name' => 'body',
                    'label' => __('Body'),
                    'placeholder' => __('Article body'),
                    'rows' => 10,
                    'required' => true,
                ])

                <div class="flex">
                    @include('admin.partials.form.input', [
                        'class' => 'flex-1 mr-4',
                        'type' => 'date',
                        'name' => 'date',
                        'label' => __('Publish date'),
                        'min' => now()->toDateString(),
                    ])

                    @include('admin.partials.form.input', [
                        'class' => 'flex-1',
                        'type' => 'time',
                        'name' => 'time',
                        'label' => __('Publish time'),
                    ])
                </div>

                @include('admin.partials.buttons.default', ['text' => __('Create')])
            </form>

            <div class="mt-4">
                @include('components.general.errors', ['errorBag' => 'article'])
                @include('components.general.session', ['key' => 'article'])
            </div>
        </div>
    </div>
@endsection
