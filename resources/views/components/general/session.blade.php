@if (session()->has($key))
    <div class="mt-2 text-md">
        {{ session($key) }}
    </div>
@endif
