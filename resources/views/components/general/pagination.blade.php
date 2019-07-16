@if ($paginator->hasPages())
    <div class="mb-12 flex text-3xl">
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <div class="w-1/2 border border-gray-900"></div>
        @else
            <a
                href="{{ $paginator->previousPageUrl() }}"
                rel="prev"
                class="group w-1/2 p-12 border border-gray-900 hover:bg-gray-800 hover:text-white"
            >
                <div class="mb-3 leading-none">
                    @lang('Previous')
                </div>
                <div class="text-base text-gray-600 leading-none group-hover:text-gray-500">
                    Page {{ $paginator->currentPage() - 1 }}
                </div>
            </a>
        @endif

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                rel="next"
                class="group w-1/2 p-12 text-right border border-l-0 border-gray-900 hover:bg-gray-800 hover:text-white"
            >
                <div class="mb-3 leading-none">
                        @lang('Next')
                </div>
                <div class="text-base text-gray-600 leading-none group-hover:text-gray-500">
                    Page {{ $paginator->currentPage() + 1 }}
                </div>
            </a>
        @else
            <div class="w-1/2 border border-l-0 border-gray-900"></div>
        @endif
    </div>
@endif
