<div class="flex-1 p-6 lg:p-16">
    <h3 class="mb-2 text-2xl lg:text-4xl">
        Want to read more articles like this?
    </h3>

    <label class="block mb-8 text-base text-gray-600 lg:text-2xl" id="emailLabel">
        Subscribe to my newsletter and you'll be the first to know.
    </label>

    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex">
        @csrf
        @honeypot

        <input
            type="email"
            name="email"
            placeholder="Subscribe for updates"
            required
            aria-describedby="emailLabel"
            autocomplete="email"
            class="flex-1 p-4 text-base bg-gray-200 focus:outline-none lg:text-xl lg:px-6"
        >

        <button
            type="submit"
            class="font-medium text-white tracking-wide bg-gray-900 py-4 px-6 hover:bg-gray-800"
            title="Subscribe"
            aria-label="Subscribe"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 32 32"
                class="w-4 fill-current lg:w-6"
            >
                <path d="M18 6l-1.43 1.39L24.15 15H3v2h21.15l-7.58 7.57L18 26l10-10L18 6z" />
            </svg>
        </button>
    </form>

    <div class="mt-4 text-md">
        @include('components.general.errors', ['errorBag' => 'newsletter'])
        @include('components.general.session', ['key' => 'newsletter'])
    </div>
</div>
