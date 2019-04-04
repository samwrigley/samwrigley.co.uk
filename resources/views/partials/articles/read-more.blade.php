<a href="{{ $article->showPath() }}"
    class="article-overview__cta"
    aria-label="@lang("Read: $article->title")"
    title="@lang("Read: $article->title")"
>
    @lang('Read more')
    @svg('arrow-right')
</a>
