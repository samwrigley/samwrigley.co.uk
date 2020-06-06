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

                <div class="mb-6">
                    <div class="flex mb-1">
                        <label for="password" class="block text-lg font-bold">
                            {{ __('Password') }}
                        </label>
                        @if (Route::has('password.request'))
                            <a class="ml-auto text-gray-700" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <input
                        id="password"
                        type="password"
                        class="block w-full p-4 bg-gray-200 rounded @error('password') bg-red-100 @enderror"
                        name="password"
                        autocomplete="current-password"
                        placeholder="{{  __('Your password') }}"
                        required
                    >
                    @error('password')
                        <div class="mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>

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
