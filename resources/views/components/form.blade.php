<form method="POST" action="{{ $route }}" {{ $attributes }}>
    @csrf
    @isset ($method)
        @method($method)
    @endisset

    {{ $slot }}
</form>
