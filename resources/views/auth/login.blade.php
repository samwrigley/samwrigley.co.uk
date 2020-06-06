@extends('layouts.island')

@section('title', __('Login'))

@section('island')
    <div  class="w-1/4">
        <h1 class="text-2xl font-bold mb-3">
            {{ __('Login') }}
        </h1>

        <div class="p-8 bg-white rounded shadow-md">
            <form method="POST" action="{{ route('login') }}">
                @csrf

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

                @include('admin.partials.form.input', [
                    'name' => 'password',
                    'type' => 'password',
                    'label' => __('Password'),
                    'placeholder' =>  __('Your Password'),
                    'autoComplete' => 'current-password',
                    'required' => true,
                ])

                <div class="mb-6">
                    <label>
                        <input
                            class="mr-1"
                            type="checkbox"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span>{{ __('Remember me') }}</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="flex items-center text-white bg-gray-900 py-3 px-4 rounded hover:bg-gray-800"
                >
                    <span class="mr-2">{{ __('Login') }}</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32"
                        class="w-3 fill-current md:w-4"
                    >
                        <path d="M18 6l-1.43 1.39L24.15 15H3v2h21.15l-7.58 7.57L18 26l10-10L18 6z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
@endsection
