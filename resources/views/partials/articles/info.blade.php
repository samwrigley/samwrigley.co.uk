@if ($article->author)
    <section class="article-info">
        <div class="article-info__author">
            @if ($article->author->profile_image)
                <img src="{{ $article->author->profile_image }}"
                    alt="{{ $article->author->name }}"
                    class="article-info__author-image"
                >
            @endif

            <div class="article-info__author-text">
                <h4 class="article-info__author-name">
                    {{ $article->author->name }}
                </h4>

                @include('partials.author.email')
            </div>
        </div>

        <p class="article-info__bio">
            {{ $article->author->bio }}
        </p>

        <a href="#"
            class="article-info__cta"
            rel="author"
            title="@lang('Find out more about the author')"
            aria-label="@lang('Find out more about the author')"
        >
            @lang('Find out more')
            @svg('arrow-right')
        </a>
    </section>
@endif
