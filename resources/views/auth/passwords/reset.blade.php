@extends('layouts.island')

@section('title', __('Reset Password'))

@section('island')
    <div class="w-1/4">
        <h1 class="text-2xl font-bold mb-3">
            {{ __('Reset Password') }}
        </h1>

        <div class="p-8 bg-white rounded shadow-md">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                @include('admin.partials.form.input', [
                    'name' => 'email',
                    'type' => 'email',
                    'value' => $email ?? old('email'),
                    'label' => __('Email'),
                    'placeholder' =>  __('Your email'),
                    'autoComplete' => 'email',
                    'required' => true,
                    'autofocus' => true,
                ])

                @include('admin.partials.form.input', [
                    'name' => 'password',
                    'type' => 'password',
                    'label' => __('New Password'),
                    'placeholder' =>  __('New Password'),
                    'autoComplete' => 'new-password',
                    'required' => true,
                ])

                @include('admin.partials.form.input', [
                    'name' => 'password_confirmation',
                    'type' => 'password',
                    'label' => __('Confirm Password'),
                    'placeholder' =>  __('Confirm Password'),
                    'autoComplete' => 'new-password',
                    'required' => true,
                ])

                @include('admin.partials.buttons.default', [
                    'text' => __('Reset Password'
                )])
            </form>
        </div>
    </div>
</div>
@endsection
