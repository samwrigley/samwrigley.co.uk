@if (method_exists($items, 'links'))
    {{ $items->links('components.general.pagination') }}
@endif
