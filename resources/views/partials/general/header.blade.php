<a class="block mr-6 font-black sm:mr-8" href="{{ url('/') }}">
    {{ config('app.name') }}
</a>

<nav>
    <ul class="flex text-sm text-gray-700">
        <li class="mr-3">
            <a href="{{ route('blog.articles.index') }}">Blog</a>
        </li>

        <li class="mr-3">
            <a href="{{ route('about') }}">About</a>
        </li>

        <li>
            <a href="{{ route('contact') }}">Contact</a>
        </li>
    </ul>
</nav>
