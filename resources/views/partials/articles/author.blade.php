@if ($article->author)
    <div class="flex items-start mb-16 last-child:mb-0">
        @if ($article->author->avatar)
            <a href="{{ route('about') }}"
                class="mr-4"
                title="@lang('Find out more about') {{ $article->author->name }}"
            >
                <img src="{{ $article->author->avatar }}"
                    alt="{{ $article->author->name }}"
                    class="rounded-full w-16"
                >
            </a>
        @endif

        <div class="flex-1 text-xl">
            <h4 class="mb-2 font-bold leading-tight">
                <a href="{{ route('about') }}"
                    title="@lang('Find out more about') {{ $article->author->name }}"
                >
                    {{ $article->author->name }}
                </a>
            </h4>

            <div class="markdown w-3/4 mb-4 text-gray-600">
                @markdown($article->author->bio)
            </div>
        </div>
    </div>
@endif
