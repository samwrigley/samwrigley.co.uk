@extends('layouts.default')

@section('content')
    <div class="flex border-black border">
        <div class="w-1/2 p-16 border-r border-black">
            <h1 class="text-5xl font-black mb-8">
                Get in touch
            </h1>

            <div class="text-2xl">
                <ul class="text-gray-600 mb-8">
                    <li>How can I help you?</li>
                    <li>What <a href="{{ route('services') }}" class="text-black">services</a> are you interested in?</li>
                    <li>Tell me about yourself or company</li>
                </ul>

                <p class="text-gray-600">
                    Fill out the form, or say Hello on
                    <a href="https://twitter.com/samwrigley" class="text-gray-900">Twitter</a>,
                    <a href="https://linkedin.com/in/samwrigley" class="text-gray-900">LinkedIn</a>
                    or send me an <a href="mailto:sam@samwrigley.co.uk" class="text-gray-900">email</a>.
                </p>
            </div>
        </div>

        <div class="w-1/2 p-16 text-xl">
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <div class="mb-8">
                    <label for="name" class="block mb-2">
                        Let's start with your name
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Your name"
                        required
                        class="block w-full px-6 py-4 bg-gray-200"
                        max="100"
                    >
                </div>

                <div class="mb-8">
                    <label for="email" class="block mb-2">
                        Your email, so I can get back to you
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Your email"
                        required
                        class="block w-full px-6 py-4 bg-gray-200"
                    >
                </div>

                <div class="mb-8">
                    <label for="message" class="block mb-2">
                        How can I help you?
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        value="{{ old('message') }}"
                        placeholder="Your message"
                        rows="6"
                        required
                        class="block w-full px-6 py-4 bg-gray-200"
                        max="2000"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    class="flex items-center text-white bg-gray-900 py-4 px-6 hover:bg-gray-800"
                    title="Get in touch"
                    aria-label="Get in touch"
                >
                    <span class="mr-2">Get in touch</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32"
                        class="w-6 fill-current"
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
