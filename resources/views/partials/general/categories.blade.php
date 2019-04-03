@if (count($categories))
    <h3>
        <a href="{{ route('blog.categories.index') }}">
            @lang('Categories')
        </a>
    </h3>

    <ul>
        @foreach ($categories as $category)
            <li>
                <a href="{{ $category->showPath() }}"
                    title="@lang("Read all articles in $category->name")"
                    aria-label="@lang("Read all articles in $category->name")"
                >
                    {{ $category->name }}
                </a>

                <span aria-label="@lang("Number of articles in $category->name")">
                    {{ $category->publishedArticleCount() }}
                </span>
            </li>
        @endforeach
    </ul>
@endif
