<a class="block mr-8 font-black" href="{{ url('/') }}">
    {{ config('app.name') }}
</a>

<nav>
    <ul class="flex">
        <li class="mr-4">
            <a href="{{ route('about') }}">Work</a>
        </li>

        <li class="mr-4">
            <a href="{{ route('services') }}">Services</a>
        </li>

        <li class="mr-4">
            <a href="{{ route('blog.articles.index') }}">Blog</a>
        </li>

        <li class="mr-4">
            <a href="{{ route('about') }}">About</a>
        </li>

        <li>
            <a href="{{ route('contact') }}">Contact</a>
        </li>
    </ul>
</nav>
