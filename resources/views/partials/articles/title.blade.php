<h1 class="article__title">
    <a href="{{ $article->showPath() }}"
        aria-label="@lang("Read: $article->title")"
        title="@lang("Read: $article->title")"
    >
        {{ $article->title }}
    </a>
</h1>
