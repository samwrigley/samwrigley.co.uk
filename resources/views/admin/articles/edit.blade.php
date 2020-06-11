@extends('layouts.admin')

@section('body')
    <header class="flex items-center py-6 px-8 border-b border-gray-300">
        <h1 class="font-bold text-3xl">
            {{ __('Edit article') }}
        </h1>

        <div class="ml-auto">
            <form action="{{ route('admin.articles.destroy', ['article' => $article]) }}" method="POST">
                @csrf
                @method('DELETE')
                @include('admin.partials.buttons.default', ['text' => __('Delete article')])
            </form>
        </div>
    </header>

    <div class="p-8">
        <div class="w-1/2">
            <form method="POST" action="{{ route('admin.articles.update', ['article' => $article]) }}">
                @csrf
                @method('PUT')

                @include('admin.partials.form.input', [
                    'name' => 'title',
                    'label' => __('Title'),
                    'placeholder' =>  __('Article title'),
                    'value' => $article->title,
                    'required' => true,
                    'maxLength' => 255,
                ])

                @include('admin.partials.form.input', [
                    'name' => 'slug',
                    'label' => __('Slug'),
                    'placeholder' =>  __('Article slug'),
                    'value' => $article->slug,
                    'required' => true,
                    'maxLength' => 255,
                ])

                @include('admin.partials.form.textarea', [
                    'name' => 'excerpt',
                    'label' => __('Excerpt'),
                    'placeholder' =>  __('Article excerpt'),
                    'value' => $article->excerpt,
                    'maxLength' => App\Article::MAX_EXCERPT_LENGTH,
                ])

                @include('admin.partials.form.textarea', [
                    'name' => 'body',
                    'label' => __('Body'),
                    'placeholder' =>  __('Article body'),
                    'value' => $article->body,
                    'rows' => 10,
                    'required' => true,
                ])

                <div class="flex">
                    @include('admin.partials.form.input', [
                        'class' => 'flex-1 mr-4',
                        'type' => 'date',
                        'name' => 'date',
                        'value' => $article->publishedDate,
                        'label' => __('Publish date'),
                        'min' => now()->toDateString(),
                    ])

                    @include('admin.partials.form.input', [
                        'class' => 'flex-1',
                        'type' => 'time',
                        'name' => 'time',
                        'value' => $article->publishedTime,
                        'label' => __('Publish time'),
                    ])
                </div>

                @include('admin.partials.buttons.default', ['text' => __('Save')])
            </form>

            <div class="mt-4">
                @include('components.general.errors', ['errorBag' => 'article'])
                @include('components.general.session', ['key' => 'article'])
            </div>
        </div>
    </div>
@endsection
