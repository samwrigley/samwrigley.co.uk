@if ($article->isOld())
    <div class="flex mb-6 sm:mb-12">
        <div class="flex flex-start p-4 bg-yellow-400 text-sm sm:text-base sm:px-6">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 32 32"
                class="w-5 mr-2 flex-shrink-0"
            >
                <path d="M16 2a14 14 0 1 0 14 14A14 14 0 0 0 16 2zm-1.13 6h2.25v11h-2.25zM16 25a1.5 1.5 0 1 1 1.5-1.5A1.5 1.5 0 0 1 16 25z" />
            </svg>
            <span>
                @lang('article.out_of_date', ['date' => $article->published_at->diffForHumans()])
            </span>
        </div>
    </div>
@endif
