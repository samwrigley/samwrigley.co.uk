@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li>
                <button
                    type="button"
                    class="btn"
                    disabled
                >@lang('Previous')</button>
            </li>
        @else
            <li>
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    rel="prev"
                    class="btn"
                >@lang('Previous')</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())
                        <li
                            class="active"
                            aria-current="page"
                        >{{ $page }}</li>
                    @else
                        <li>
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif

                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    class="btn"
                >@lang('Next')</a>
            </li>
        @else
            <li>
                <button
                    type="button"
                    class="btn"
                    disabled
                >@lang('Next')</button>
            </li>
        @endif
    </ul>
@endif
