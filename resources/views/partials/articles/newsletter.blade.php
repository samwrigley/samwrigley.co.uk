<div class="flex-1 p-16">
    <h3 class="mb-2 text-4xl">
        Want to read more articles like this?
    </h3>

    <label class="block mb-8 text-2xl text-gray-600" id="emailLabel">
        Subscribe to my newsletter and you'll be the first to know.
    </label>

    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex">
        @csrf

        <input
            type="email"
            name="email"
            placeholder="Subscribe for updates"
            required
            aria-describedby="emailLabel"
            class="flex-1 px-6 py-4 text-xl bg-gray-200 focus:outline-none"
        >

        <button
            type="submit"
            class="font-medium text-white text-xl tracking-wide bg-gray-900 py-4 px-6 hover:bg-gray-800"
            title="Subscribe"
            aria-label="Subscribe"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 32 32"
                class="w-6 fill-current"
            >
                <path d="M18 6l-1.43 1.39L24.15 15H3v2h21.15l-7.58 7.57L18 26l10-10L18 6z" />
            </svg>
        </button>
    </form>

    @include('components.general.errors', ['errorBag' => 'newsletter'])
    @include('components.general.session', ['key' => 'newsletter'])
</div>
