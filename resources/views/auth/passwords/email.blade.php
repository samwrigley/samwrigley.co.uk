@extends('layouts.island')

@section('title', __('Reset Password'))

@section('island')
    <div class="w-1/4">
        <h1 class="text-2xl font-bold mb-3">
            {{ __('Reset Password') }}
        </h1>

        <div class="p-8 bg-white rounded shadow-md">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                @if (session('status'))
                    <div class="mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @include('admin.partials.form.input', [
                    'name' => 'email',
                    'type' => 'email',
                    'value' => old('email'),
                    'label' => __('Email'),
                    'placeholder' =>  __('Your email'),
                    'autoComplete' => 'email',
                    'required' => true,
                    'autofocus' => true,
                ])

                @include('admin.partials.buttons.default', [
                    'text' => __('Send Password Reset Link'
                )])
            </form>
        </div>
    </div>
@endsection
