@if (session()->has($key))
    {{ session($key) }}
@endif
