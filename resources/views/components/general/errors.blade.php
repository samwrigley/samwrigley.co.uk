@if ($errors->{$key}->any())
    <ul class="list-disc list-inside text-red-700" role="alert">
        @foreach ($errors->{$key}->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
