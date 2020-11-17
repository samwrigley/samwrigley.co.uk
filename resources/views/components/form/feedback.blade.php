@if ($errors->{$key}->any() || session()->has($key))
    <div {{ $attributes->merge(['class' => 'text-base']) }}>
        @include('components.general.errors', ['key' => $key])
        @include('components.general.session', ['key' => $key])
    </div>
@endif

<div {{ $attributes->only('class')->merge(['class' => 'hidden text-base']) }}
    role="alert"
    id="feedback"
></div>
