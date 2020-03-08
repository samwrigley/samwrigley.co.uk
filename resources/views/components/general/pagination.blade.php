@if ($paginator->hasPages())
    <div class="flex flex-col text-3xl sm:flex-row">
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <div class="hidden w-1/2 border border-gray-900 sm:block"></div>
        @else
            <a
                href="{{ $paginator->previousPageUrl() }}"
                rel="prev"
                class="group w-full p-6 border border-gray-900 hover:bg-gray-800 hover:text-white sm:w-1/2 sm:p-12"
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
                class="group w-full p-6 text-right border border-gray-900 hover:bg-gray-800 hover:text-white
                    @if (!$paginator->onFirstPage())
                        border-t-0
                    @endif
                    sm:w-1/2 sm:border-t sm:border-l-0 sm:p-12"
            >
                <div class="mb-3 leading-none">
                        @lang('Next')
                </div>
                <div class="text-base text-gray-600 leading-none group-hover:text-gray-500">
                    Page {{ $paginator->currentPage() + 1 }}
                </div>
            </a>
        @else
            <div class="hidden w-1/2 border border-l-0 border-gray-900 sm:block"></div>
        @endif
    </div>
@endif
