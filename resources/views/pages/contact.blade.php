@extends('layouts.default')

@section('title', 'Contact')

@section('content')
    <div class="flex flex-col border-black border sm:flex-row">
        <div class="p-6 border-b border-black sm:w-1/2 sm:border-r sm:border-b-0 sm:p-16">
            <h1 class="text-2xl font-black mb-4 sm:mb-8 sm:text-5xl">
                Get in touch
            </h1>

            <div class="text-base sm:text-2xl">
                <p class="text-gray-600 mb-4 sm:mb-8">
                    How can I help you? Tell me about yourself or your company.
                </p>

                <p class="text-gray-600">
                    Fill out the form, or send me an <a href="mailto:{{ config('contact.email') }}" class="text-gray-900">email</a>.
                </p>
            </div>
        </div>

        <div class="p-6 text-base sm:w-1/2 sm:text-xl sm:p-16">
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <div class="mb-6 sm:mb-8">
                    <label for="name" class="block mb-2">
                        Let's start with your name
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Full name"
                        autocomplete="name"
                        required
                        class="block w-full p-4 bg-gray-200 sm:px-6"
                        max="100"
                    >
                </div>

                <div class="mb-6 sm:mb-8">
                    <label for="email" class="block mb-2">
                        Your email, so I can get back to you
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        autocomplete="email"
                        required
                        class="block w-full p-4 bg-gray-200 sm:px-6"
                    >
                </div>

                <div class="mb-6 sm:mb-8">
                    <label for="message" class="block mb-2">
                        How can I help you?
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        value="{{ old('message') }}"
                        placeholder="Message"
                        rows="6"
                        required
                        class="block w-full p-4 bg-gray-200 mb-1 sm:px-6"
                        aria-describedby="messageInformation"
                        max="2000"
                    ></textarea>
                    <div id="messageInformation" class="text-sm text-gray-600">
                        Maximum 2000 characters
                    </div>
                </div>

                <button
                    type="submit"
                    class="flex items-center text-white bg-gray-900 py-3 px-4 hover:bg-gray-800 sm:px-6 sm:py-4"
                >
                    <span class="mr-2">Get in touch</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32"
                        class="w-4 fill-current sm:w-6"
                    >
                        <path d="M18 6l-1.43 1.39L24.15 15H3v2h21.15l-7.58 7.57L18 26l10-10L18 6z" />
                    </svg>
                </button>
            </form>

            <div class="mt-4">
                @include('components.general.errors', ['errorBag' => 'contact'])
                @include('components.general.session', ['key' => 'contact'])
            </div>
        </div>
    </div>
@endsection
