@extends('layouts.default')

@section('title', __('contact.page_title'))

@section('content')
    <div class="flex flex-col border-black border lg:flex-row">
        <div class="p-6 border-b border-black lg:w-1/2 lg:border-r lg:border-b-0 lg:p-16">
            <h1 class="text-2xl font-black mb-4 md:text-4xl lg:mb-8 lg:text-5xl">
                Get in touch
            </h1>

            <div class="text-base md:text-xl lg:text-2xl">
                <p class="text-gray-600 mb-4 lg:mb-8">
                    How can I help you? Tell me about yourself or your company.
                </p>

                <p class="text-gray-600">
                    Fill out the form, or send me an <a href="mailto:{{ config('contact.email') }}" class="text-gray-900">email</a>.
                </p>
            </div>
        </div>

        <div class="p-6 text-base lg:w-1/2 lg:text-xl lg:p-16">
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                @honeypot

                <div class="mb-6 md:mb-8">
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
                        class="block w-full p-4 bg-gray-200 md:px-6"
                        max="100"
                    >
                </div>

                <div class="mb-6 md:mb-8">
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
                        class="block w-full p-4 bg-gray-200 md:px-6"
                    >
                </div>

                <div class="mb-6 md:mb-8">
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
                        class="block w-full p-4 bg-gray-200 mb-1 md:px-6"
                        aria-describedby="messageInformation"
                        max="{{ \App\Contact::MAX_MESSAGE_LENGTH }}"
                    ></textarea>
                    <div id="messageInformation" class="text-md text-gray-600">
                        Maximum {{ \App\Contact::MAX_MESSAGE_LENGTH }} characters
                    </div>
                </div>

                <button
                    type="submit"
                    class="flex items-center text-white bg-gray-900 py-3 px-4 hover:bg-gray-800 md:px-6 md:py-4"
                >
                    <span class="mr-2">Get in touch</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32"
                        class="w-4 fill-current md:w-6"
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
