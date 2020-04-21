@if ($article->next() || $article->previous())
    <div class="flex flex-col text-2xl lg:text-4xl sm:flex-row {{ $classes ?? '' }}">
        @if ($article->previous())
            <a
                href="{{ $article->previous()->showRoute() }}"
                rel="prev"
                class="group w-full p-6 border border-gray-900 hover:bg-gray-800 hover:text-white sm:w-1/2 sm:p-12"
            >
                <div class="mb-3 leading-none">
                    @lang('Previous')
                </div>
                <div class="text-base text-gray-700 group-hover:text-gray-500">
                    {{ $article->previous()->title }}
                </div>
            </a>
        @else
            <div class="hidden w-1/2 border border-gray-900 sm:block"></div>
        @endif

        @if ($article->next())
            <a
                href="{{ $article->next()->showRoute() }}"
                rel="next"
                class="group w-full p-6 text-right border border-gray-900 hover:bg-gray-800 hover:text-white
                    @if ($article->previous())
                        border-t-0
                    @endif
                    sm:w-1/2 sm:border-t sm:border-l-0 sm:p-12"
            >
                <div class="mb-3 leading-none">
                    @lang('Next')
                </div>
                <div class="text-base text-gray-700 group-hover:text-gray-500">
                    {{ $article->next()->title }}
                </div>
            </a>
        @else
            <div class="hidden w-1/2 border border-l-0 border-gray-900 sm:block"></div>
        @endif
    </div>
@endif
