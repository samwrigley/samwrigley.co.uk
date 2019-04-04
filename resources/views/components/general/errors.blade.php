
@if ($errors->{$errorBag}->any())
    <div class="alert alert--warning" role="alert">

        <ul>
            @foreach ($errors->{$errorBag}->all() as $error)
                <li class="alert__item">{{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif
