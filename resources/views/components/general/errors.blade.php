@if ($errors->{$errorBag}->any())
    <ul role="alert">
        @foreach ($errors->{$errorBag}->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
