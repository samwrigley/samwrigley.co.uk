<a class="block mr-8 font-black" href="{{ url('/') }}">
    {{ config('app.name') }}
</a>

<nav>
    <ul class="flex">
        <li class="mr-4">
            <a href="{{ route('about') }}">
                @lang('Work')
            </a>
        </li>

        <li class="mr-4">
            <a href="{{ route('services') }}">
                @lang('Services')
            </a>
        </li>

        <li class="mr-4">
            <a href="{{ route('about') }}">
                @lang('About')
            </a>
        </li>

        <li class="mr-4">
            <a href="{{ route('blog.articles.index') }}">
                @lang('Blog')
            </a>
        </li>

        <li>
            <a href="{{ route('contact') }}">
                @lang('Contact')
            </a>
        </li>
    </ul>
</nav>
