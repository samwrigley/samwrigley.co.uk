@if ($article->published_at)
    <span class="article__posted-on">
        Posted on
        <time datetime="{{ $article->published_at }}"
            aria-label="@lang('Posted On')"
        >
            @date($article->published_at)
        </time>
    </span>
@endif
