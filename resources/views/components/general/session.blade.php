@if (session()->has($key))
    <div class="alert alert-success">
        {{ session($key) }}
    </div>
@endif
