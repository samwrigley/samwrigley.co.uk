<button
    type="{{ $type ?? 'submit' }}"
    class="flex items-center text-white bg-gray-900 py-3 px-4 rounded hover:bg-gray-800"
>
    <span class="mr-2">{{ $text }}</span>
    <x-heroicon-o-arrow-right class="w-3 fill-current md:w-4" />
</button>
