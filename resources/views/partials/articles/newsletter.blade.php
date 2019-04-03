<div class="article-newsletter">
    <h3 class="article-newsletter__title">
        Want to read more articles like this?
    </h3>

    <p class="article-newsletter__intro" id="emailLabel">
        Subscribe to my newsletter and you'll be the first to know.
    </p>

    <form action="{{ route('newsletter.subscribe') }}" method="POST">
        @csrf

        <input
            type="email"
            name="email"
            placeholder="Your email"
            required
            aria-describedby="emailLabel"
        >

        <button type="submit" class="article-newsletter__submit">
            Subscribe
        </button>

    </form>

    @include('components.general.errors')
</div>
