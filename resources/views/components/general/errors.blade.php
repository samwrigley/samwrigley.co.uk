@if ($errors->{$errorBag}->any())
    <div class="mt-2 text-md" role="alert">
        <ul>
            @foreach ($errors->{$errorBag}->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
