@foreach ($articles as $article)
    <article class="article-overview">
        <header class="article-overview__header">
            @include('partials.articles.header')
        </header>

        @include('partials.articles.featured-image')
        @include('partials.articles.excerpt')
        @include('partials.articles.read-more')
    </article>
@endforeach

@include('partials.general.pagination', ['items' => $articles])
