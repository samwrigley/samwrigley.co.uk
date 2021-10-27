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
                <x-heroicon-o-arrow-right class="w-4 fill-current lg:w-6" />
            </button>
        </div>

        <div class="mt-4 text-md">
            @include('components.general.errors', ['errorBag' => 'newsletter'])
            @include('components.general.session', ['key' => 'newsletter'])
        </div>
    </form>
</div>
