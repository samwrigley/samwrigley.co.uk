@if ($article->series && $article->series->articles->count())
    <div class="py-6 border-t border-b border-gray-200 sm:py-8">
        <p class="mb-6 text-xs uppercase tracking-widest sm:text-sm sm:mb-8">
            @lang('article.in_series', ['count' => $article->series->articles->count()])

            <a href="{{ $article->series->showRoute() }}" class="font-bold">
                {{ $article->series->title }}
            </a>
        </p>

        <ul class="text-base sm:text-lg">
            @foreach ($article->series->articles as $seriesArticle)
                <li class="mb-2 last:mb-0">
                    @if ($seriesArticle->id === $article->id)
                        <div class="flex items-start text-gray-600">
                            <span class="flex-shrink-0 mr-2">
                                @lang('Part') {{ $loop->index + 1 }}:
                            </span>
                            <span>
                                {{ $seriesArticle->title }}
                            </span>
                        </div>
                    @else
                        <a href="{{ $seriesArticle->showRoute() }}" class="flex items-start hover:text-gray-600">
                            <span class="flex-shrink-0 mr-2">
                                @lang('Part') {{ $loop->index + 1 }}:
                            </span>
                            <span class="font-bold">
                                {{ $seriesArticle->title }}
                            </span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
