<header class="flex items-center py-6 px-8 border-b border-gray-300">
    <h1 class="font-bold text-3xl">
        {{ $heading }}
    </h1>

    @unless ($slot->isEmpty())
        <div class="ml-auto">
            {{ $slot }}
        </div>
    @endunless
</header>
