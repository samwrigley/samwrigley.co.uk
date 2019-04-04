@if (count($article->categories))
    <ul class="article__categories">
        @foreach ($article->categories as $category)
            <li class="article__category">
                <a href="{{ $category->showPath() }}"
                    title="@lang("Read all articles in $category->name")"
                    aria-label="@lang("Read all articles in $category->name")"
                >
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
