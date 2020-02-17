<ul class="flex text-base">
    <li class="font-bold mr-8">
        &copy; Sam Wrigley
    </li>

    <li class="mr-4">
        <a href="https://github.com/{{ config('social.github') }}"
            target="_blank"
            rel="noopener"
        >
            @lang('Github')
        </a>
    </li>

    <li class="mr-4">
        <a href="https://www.linkedin.com/in/{{ config('social.linkedin') }}"
            target="_blank"
            rel="noopener"
        >
            @lang('LinkedIn')
        </a>
    </li>

    <li class="mr-4">
        <a href="https://twitter.com/{{ config('social.twitter') }}"
            target="_blank"
            rel="noopener"
        >
            @lang('Twitter')
        </a>
    </li>

    <li class="mr-4">
        <a href="https://www.instagram.com/{{ config('social.instagram') }}"
            target="_blank"
            rel="noopener"
        >
            @lang('Instagram')
        </a>
    </li>

    <li>
        <a href="mailto:{{ config('contact.email') }}"
            aria-label="Send me an email"
        >
            @lang('Email')
        </a>
    </li>
</ul>
