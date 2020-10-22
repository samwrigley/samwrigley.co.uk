<div class="flex-1 p-6 lg:p-16">
    <h3 class="mb-2 text-2xl lg:text-4xl">
        Want to read more articles like this?
    </h3>

    <label class="block mb-8 text-base text-gray-700 lg:text-2xl">
        Subscribe to my newsletter and you'll be the first to know.
    </label>

    <form action="{{ route('newsletter.subscribe') }}" method="POST" id="newsletter">
        @csrf
        @honeypot

        <div class="flex">
            <input
                type="email"
                name="email"
                placeholder="Subscribe for updates"
                required
                aria-label="Subscribe to my newsletter"
                autocomplete="email"
                class="flex-1 p-4 text-base bg-gray-200 lg:text-xl lg:px-6"
            >

            <button
                type="submit"
                class="text-white bg-gray-900 py-4 px-6 hover:bg-gray-800"
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
        </div>

        <x-form.feedback key="newsletter" class="mt-4" />
    </form>
</div>
