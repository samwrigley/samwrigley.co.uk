@if (count($categories))
    <h3>
        <a href="{{ route('blog.categories.index') }}">
            @lang('Categories')
        </a>
    </h3>

    <ul>
        @foreach ($categories as $category)
            <li>
                <a href="{{ $category->showRoute() }}">
                    {{ $category->name }}
                </a>

                <span aria-label="@lang("Number of articles in $category->name")">
                    {{ $category->publishedArticleCount() }}
                </span>
            </li>
        @endforeach
    </ul>
@endif
