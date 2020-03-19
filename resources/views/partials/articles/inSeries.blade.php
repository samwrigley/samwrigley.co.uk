@if ($article->series && $article->series->articles->count())
    <div class="py-6 border-t border-b border-gray-200 sm:py-8">
        <p class="mb-4 text-xs uppercase tracking-widest sm:text-sm">
            @lang('article.in_series', ['count' => $article->series->articles->count()])
        </p>
        <ul class="text-base sm:text-xl">
            @foreach ($article->series->articles as $seriesArticle)
                <li class="mb-2 last-child:mb-0">
                    @if ($seriesArticle->id === $article->id)
                        <div class="flex items-start text-gray-600">
                            <span class="flex-shrink-0 mr-2">
                                @lang('Part') {{ $loop->index + 1}}:
                            </span>
                            <span>
                                {{ $seriesArticle->title }}
                            </span>
                        </div>
                    @else
                        <a href="{{ $seriesArticle->showPath() }}" class="flex items-start hover:text-gray-600">
                            <span class="flex-shrink-0 mr-2">
                                @lang('Part') {{ $loop->index + 1}}:
                            </span>
                            <span class="font-semibold">
                                {{ $seriesArticle->title }}
                            </span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
