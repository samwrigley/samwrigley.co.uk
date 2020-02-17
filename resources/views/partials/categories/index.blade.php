@foreach ($categories as $category)
    @if (count($category->articles))
        <li class="category">
            <h2 class="category__title">
                <a href="{{ $category->showPath() }}">
                    {{ $category->name }}
                </a>

                <span class="category__count"
                    aria-label="@lang("Number of articles in $category->name")"
                >
                    {{ $category->articles_count }}
                </span>
            </h2>
        </li>
    @endif
@endforeach
