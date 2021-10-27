@if ($article->isOld())
    <div class="flex mb-6 sm:mb-12">
        <div class="flex flex-start p-4 bg-yellow-400 text-sm sm:text-base sm:px-6">
            <x-heroicon-o-information-circle class="w-6 mr-2 flex-shrink-0" />
            <span>
                @lang('article.out_of_date', ['date' => $article->published_at->diffForHumans()])
            </span>
        </div>
    </div>
@endif
