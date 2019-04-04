@if ($article->featured_image)
    <img src="{{ $article->featured_image->url }}"
        alt="{{ $article->title }}"
        class="article-overview__image"
    >
@endif
