@extends('layouts.default')

@section('title', __('about.page_title'))

@section('content')
    <div class="max-w-4xl mt-8">
        <h1 class="mb-6 text-2xl font-black">
            About
        </h1>

        <div class="text-xl text-gray-700 leading-relaxed">
            <p class="mb-6">
                I'm Sam Wrigley, a Front-End Engineer on the Contribution Experience team at
                <a href="https://www.imdb.com" target="_blank" rel="noopener">IMDb.com</a>.
                I specialise in all things front-end, including UX and UI, with a strong emphasis on modern, scalable JavaScript.
            </p>

            <p class="mb-6">
                I know my way around a back-end too, having previously
                <a href="https://www.linkedin.com/in/{{ config('social.linkedin') }}" target="_blank" rel="noopener">worked</a>
                as a Full-Stack Developer and Software Developer. I also have a strong understanding of user-experience and
                user-interface design—having studied Graphic Design at
                <a href="https://www.falmouth.ac.uk/study/undergraduate/graphic-design" target="_blank" rel="noopener">university</a>.
            </p>

            <p class="mb-6">
                I’m passionate about code-quality and accessibility and have an eye for detail. I pride myself on the
                quality of my work and take great satisfaction in doing things to the best of my ability. I’m hard
                working and enjoy overcoming challenges through problem-solving.
            </p>

            <p class="mb-6">
                Outside of web-development, I have a passion for photography and I’m also a keen outdoor runner.
            </p>
        </div>
    </div>
@endsection
