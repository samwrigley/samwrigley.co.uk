@if ($article->series && $article->series->articles->count())
    <div class="text-xl py-8 border-t border-b border-gray-200">
        <p class="mb-4 text-sm uppercase tracking-widest text-gray-600">
            @lang('article.in_series', ['count' => $article->series->articles->count()])
        </p>
        <ul>
            @foreach ($article->series->articles as $seriesArticle)
                <li class="mb-1 last-child:mb-0">
                    @if ($seriesArticle->id === $article->id)
                        <span class="text-gray-600">
                            <span class="mr-1 font-semibold">
                                @lang('Part') {{ $loop->index + 1}}:
                            </span>
                            {{ $seriesArticle->title }}
                        </span>
                    @else
                        <a href="{{ $seriesArticle->showPath() }}" class="hover:text-gray-600">
                            <span class="mr-1 font-semibold">
                                @lang('Part') {{ $loop->index + 1}}:
                            </span>
                            {{ $seriesArticle->title }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
