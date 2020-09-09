<form method="POST" action="{{ $route }}">
    @csrf
    @isset ($method)
        @method($method)
    @endisset

    {{ $slot }}
</form>
