<ul class="flex flex-col text-sm sm:flex-row">
    <li class="font-bold mb-6 sm:mr-8 sm:mb-0">
        &copy; Sam Wrigley
    </li>

    <li class="mb-3 text-gray-600 sm:mr-4 sm:mb-0">
        <a href="https://github.com/{{ config('social.github') }}"
            target="_blank"
            rel="noopener"
        >
            @lang('Github')
        </a>
    </li>

    <li class="mb-3 text-gray-600 sm:mr-4 sm:mb-0">
        <a href="https://www.linkedin.com/in/{{ config('social.linkedin') }}"
            target="_blank"
            rel="noopener"
        >
            @lang('LinkedIn')
        </a>
    </li>

    <li class="mb-3 text-gray-600 sm:mr-4 sm:mb-0">
        <a href="https://twitter.com/{{ config('social.twitter') }}"
            target="_blank"
            rel="noopener"
        >
            @lang('Twitter')
        </a>
    </li>

    <li class="mb-3 text-gray-600 sm:mr-4 sm:mb-0">
        <a href="https://www.instagram.com/{{ config('social.instagram') }}"
            target="_blank"
            rel="noopener"
        >
            @lang('Instagram')
        </a>
    </li>

    <li class="text-gray-600">
        <a href="mailto:{{ config('contact.email') }}"
            aria-label="Send me an email"
        >
            @lang('Email')
        </a>
    </li>
</ul>
