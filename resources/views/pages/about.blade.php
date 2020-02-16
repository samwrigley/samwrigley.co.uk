@extends('layouts.default')

@section('title', 'About')

@section('content')
    <div class="max-w-4xl mt-8">
        <h1 class="mb-6 text-2xl font-black">
            About
        </h1>

        <div class="text-xl leading-relaxed">
            <p class="mb-6">
                I'm Sam Wrigley, a Front-End Engineer on the Contribution Experience team at <a href="https://www.imdb.com">IMDb.com</a>.
                I specialise in all things front-end, including UX and UI, with a strong emphasis on modern, scalable JavaScript.
            </p>

            <p class="mb-6">
                I know my way around a back-end too, having previously worked as a Full-Stack Developer and Software
                Developer. I also have a strong understanding of user-experience and user-interface design—having
                studied Graphic Design at university.
            </p>

            <p class="mb-6">
                I’m passionate about code-quality and accessibility and have an eye for detail. I pride myself on the
                quality of my work and take great satisfaction in doing things to the best of my ability. I’m hard
                working and enjoy overcoming challenges through problem-solving.
            </p>

            <p class="mb-6">
                Outside of web-development, I have a passion for photography and I’m also a keen outdoor runner.
            </p>

            <p>
                Get in <a href="{{ route('contact') }}">touch</a>.
            </p>
        </div>
    </div>
@endsection
