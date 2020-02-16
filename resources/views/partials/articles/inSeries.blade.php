@if ($article->series && $article->series->articles->count())
    <div class="text-xl">
        <p class="mb-4">
            @lang('article.in_series', ['count' => $article->series->articles->count()])
        </p>
        <ul>
            @foreach ($article->series->articles as $seriesArticle)
                <li class="mb-1 last-child:mb-0">
                    <span class="mr-1 text-gray-600">
                        @lang('Part') {{ $loop->index + 1}}:
                    </span>
                    @if ($seriesArticle->showPath() === $article->showPath())
                        {{ $seriesArticle->title }}
                    @else
                        <a href="{{ $seriesArticle->showPath() }}"
                            title="@lang("Read $seriesArticle->title")"
                            aria-label="@lang("Read $seriesArticle->title")"
                        >
                            {{ $seriesArticle->title }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
