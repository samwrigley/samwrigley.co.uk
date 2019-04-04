<a class="site__logo" href="{{ url('/') }}">
    {{ config('app.name') }}
</a>

<nav class="site__nav">
    <ul>
        <li>
            <a href="{{ route('blog.articles.index') }}">
                @lang('About')
            </a>
        </li>

        <li>
            <a href="{{ route('blog.articles.index') }}">
                @lang('Services')
            </a>
        </li>

        <li>
            <a href="{{ route('blog.articles.index') }}">
                @lang('Blog')
            </a>
        </li>

        <li>
            <a href="{{ route('blog.articles.index') }}">
                @lang('Contact')
            </a>
        </li>
    </ul>
</nav>
