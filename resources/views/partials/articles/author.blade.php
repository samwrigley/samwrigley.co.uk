@if ($article->author)
    <div class="flex items-center mb-12 last-child:mb-0 sm:mb-16">
        @if ($article->author->avatar)
            <a href="{{ route('about') }}"
                class="mr-3 sm:mr-4"
                title="@lang('Find out more about') {{ $article->author->name }}"
            >
                <img src="{{ $article->author->avatar }}"
                    alt="{{ $article->author->name }}"
                    class="rounded-full w-10 h-10 bg-gray-200 sm:w-12 sm:h-12"
                >
            </a>
        @endif

        <h4 class="font-bold leading-tight text-sm tracking-wide sm:text-xl sm:tracking-normal">
            <a href="{{ route('about') }}"
                title="@lang('Find out more about') {{ $article->author->name }}"
            >
                {{ $article->author->name }}
            </a>
        </h4>
    </div>
@endif
