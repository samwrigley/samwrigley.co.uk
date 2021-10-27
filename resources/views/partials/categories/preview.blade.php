<a href="{{ $category->showRoute() }}"
    aria-label="Read {{ $category->name }}"
    title="Read {{ $category->name }}"
    class="block group relative p-6 pb-16 hover:bg-gray-100 sm:p-12 sm:pb-32"
>
    <article>
        <header class="mb-6 last:mb-0">
            <div class="mb-6 text-xs text-gray-700 uppercase tracking-widest leading-none sm:mb-12 sm:text-sm">
                {{ $category->publishedArticleCount() }} {{ Str::plural('article', $category->publishedArticleCount()) }}
            </div>

            <h2 class="text-2xl leading-tight font-bold sm:text-4xl">
                {{ $category->name }}
            </h2>
        </header>

        @if ($category->description)
            <p class="text-base sm:text-xl">
                {!! $category->description !!}
            </p>
        @endif
    </article>

    <div class="absolute right-0 bottom-0 flex items-center justify-center bg-gray-200 text-xl w-12 h-12
        group-hover:bg-gray-900 group-hover:text-white sm:w-16 sm:h-16"
    >
        <x-heroicon-o-arrow-right class="w-4 fill-current sm:w-6" />
    </div>
</a>
