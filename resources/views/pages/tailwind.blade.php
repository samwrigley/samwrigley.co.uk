@extends('layouts.default')

@section('title', 'Tailwind')

@section('content')
    <article class="max-w-4xl mx-auto mt-24 mb-20 text-xl text-gray-700 leading-relaxed xl:mt-56 xl:mb-32 md:text-2xl">
        <h1 class="absolute top-0 right-0 text-gray-300 font-black leading-none text-8xl mt-16 -mr-6
            lg:text-10xl lg:-mt-8 lg:-mr-8
            xl:text-16xl xl:-mt-12 xl:-mr-12
            xxl:-mt-16 xxl:mr-0 xxl:text-20xl"
        >
            Tailwind
        </h1>

        <div>
            <h2 id="intro" class="font-black text-2xl text-gray-900 mb-6 md:mb-8 md:text-3xl">
                <a href="#intro">Intro</a>
            </h2>
            <p class="mb-6">
                I'm Sam Wrigley, a Front-End Engineer helping to create contribution experiences at
                <a href="https://www.imdb.com" target="_blank" rel="noopener">IMDb</a>.
                I specialise in all things front-end with a strong emphasis on modern, scalable JavaScript.
            </p>
            <p class="mb-6">
                I know my way around a back-end too, having previously <a href="{{ route('about') . '#experience' }}">worked</a> as a
                Full-Stack Developer and Software Developer. I also have a strong understanding of user-experience and user-interface design—having
                studied Graphic Design at <a href="https://www.falmouth.ac.uk/study/undergraduate/graphic-design" target="_blank" rel="noopener">university</a>.
            </p>
            <p class="mb-6">
                Outside of web development, I have a passion for photography and I’m also a keen outdoor runner.
            </p>
        </div>

        <div class="w-12 mx-auto border border-black my-16"></div>

        <div class="mb-20 md:mb-24">
            <h2 id="great-fit" class="font-black text-2xl text-gray-900 mb-6 md:mb-8 md:text-3xl">
                <a href="#great-fit">Why we’d be a great fit for each other</a>
            </h2>
            <p class="mb-6">
                This is, without-a-doubt, the most excited I’ve been applying for a role. Working on OSS has always been a dream of mine and to do
                it on a project I’ve used and admired for years would be incredible.
            </p>
            <p class="mb-6">
                Without wanting to sound contrived, I’ve followed your work for a long time and have great admiration for what you’ve achieved.
                I’ve consumed a number of your courses and always been struck by their quality. You can tell you care deeply about the things you
                create and the thought that’s gone into them is always evident. I say these things not in an attempt to flatter, but because they’re
                things I value and strive for myself. I take great satisfaction in doing things to the best of my ability and take pride in my work.
            </p>
            <p class="mb-6">
                I enjoy learning new skills and challenging myself; for me, that’s the best part about being a developer. Over the years, this has
                led me to work across the ‘front-end’, ‘back-end’ and design and enjoyed them all equally. I believe having a diverse range of skills
                 and experience is one of the best ways to improve your ability to problem-solve.
            </p>
            <p class="mb-6">
                Whilst I certainly wouldn’t call myself a great designer, I’d like to think I was OK. Before transitioning into web-development,
                I studied Graphic Design at <a href="https://www.falmouth.ac.uk/study/undergraduate/graphic-design" target="_blank" rel="noopener">university</a>
                where I gained a solid understanding of core design principles, such as layout, typography and hierarchy.
                Whilst I didn’t realise it at the time, these skills have proved invaluable in my career as a web-developer.
            </p>
            <p>
                I have a passion for front-end development and care deeply about creating the best possible user experience for customers,
                whoever they might be.
            </p>
        </div>

        <div class="mb-20 md:mb-24">
            <h2 id="worked-together" class="font-black text-2xl text-gray-900 mb-6 md:mb-8 md:text-3xl">
                <a href="#worked-together">What I see the future being like if we worked together</a>
            </h2>
            <p class="mb-6">
                For me, the idea of official React and Vue libraries is incredibly exciting and I think the logical next step for Tailwind UI.
                Most UI components require at least some JavaScript to provide the best user experience. There’s a huge value proposition for
                fully functional Tailwind UI components that work out of the box.
            </p>
            <p>
                Providing customers with an ‘official’ way to use fully functional Tailwind UI components helps to improve their productivity
                as well as the developer experience. It would also allow accessibility best practises to be baked into the components, which
                can often be the first victim of budget and time constraints or developer inexperience.
            </p>
        </div>

        <div class="mb-20 md:mb-24">
            <h2 id="excited-about" class="font-black text-2xl text-gray-900 mb-6 md:mb-8 md:text-3xl">
                <a href="#excited-about">What I’m excited about in the industry</a>
            </h2>
            <p class="mb-6">
                Whilst not specific to tech, I’m interested to see what effect the current situation has on our industry. If more and more tech
                companies transition to remote-only, it’s going to have a huge impact on the jobs market. Suddenly, developers can work for many
                more companies and companies have access to a much larger talent pool.
            </p>
            <p>
                Will we see more freelance developers? Will those developers need to be full-stack? Will they reach for tools like Tailwind to
                improve their productivity?
            </p>
        </div>

        <div class="mb-20 md:mb-24">
            <h2 id="betting-on" class="font-black text-2xl text-gray-900 mb-6 md:mb-8 md:text-3xl">
                <a href="#betting-on">What I’m betting on for the future</a>
            </h2>
            <p class="mb-6">
                Betting on anything in tech, especially in the front-end world, can be difficult given the pace of change in our industry.
                I try to avoid jumping on any bandwagons until it’s clear what the benefits are.
            </p>
            <p class="mb-6">
                When it comes to front-end development, I think you can’t go too wrong betting on the continued importance of the basics:
                <span class="text-gray-900 font-bold">usability</span>, <span class="text-gray-900 font-bold">accessibility</span>,
                <span class="text-gray-900 font-bold">maintainability</span> and <span class="text-gray-900 font-bold">performance</span> etc.
            </p>
            <p>
                Part of the reason I love Tailwind so much is that it’s only a slight abstraction on top of plain old CSS. If you’re familiar
                with CSS, then Tailwind is simple to understand and reason about whilst allowing you to be more productive as a developer.
                At the same time, for those who have little to no experience writing CSS, its power lies in its ability to abstract away the
                complexities and inconsistencies of CSS, allowing them to focus on what’s really important—building their project.
            </p>
        </div>

        <div>
            <h2 id="build-together" class="font-black text-2xl text-gray-900 mb-6 md:mb-8 md:text-3xl">
                <a href="#build-together">Projects I’d love for us to build together</a>
            </h2>
            <ul>
                <li class="mb-6">
                    <span class="text-gray-900 font-bold">Tailwind UI Store:</span>
                    Open up Tailwind UI and allow third-parties to sell their own components. Whilst this would need to be carefully managed to maintain
                    a high level of quality, I think it could play a big role in the proliferation of Tailwind UI and help reduce component burn-out.
                </li>
                <li class="mb-6">
                    <span class="text-gray-900 font-bold">Tailwind Playground:</span>
                    Simple, interactive UI for quickly experimenting and prototyping with Tailwind. The ability to select different versions of Tailwind
                    and see any differences could be helpful when upgrading to a newer version.
                </li>
                <li class="mb-6">
                    <span class="text-gray-900 font-bold">Tailwind Showcase:</span>
                    Showcase great examples of UIs built using Tailwind. Not only would this serve as inspiration for others, but it might help alleviate
                    any concerns or reservations potential users might have about using Tailwind on their personal or professional projects.
                </li>
                <li>
                    <span class="text-gray-900 font-bold">Tailwind Config Builder:</span>
                    Easily and quickly generate/validate Tailwind configuration files. It could also help when extending the default configuration to ensure
                    any additional values conform to their respective scales.
                </li>
            </ul>
        </div>

        <div class="w-12 mx-auto border border-black my-16"></div>

        <div>
            <h2 id="closing" class="font-black text-2xl text-gray-900 mb-6 md:mb-8 md:text-3xl">
                <a href="#closing">Closing</a>
            </h2>
            <p class="mb-6">
                I have experience working in a small team, having been one of only two developers at
                <a href="https://www.twineapp.com" target="_blank" rel="noopener">Twine</a>,
                where I was responsible for all things front-end. Working remotely is also something I’m accustomed to, having done so at
                <a href="https://www.dewsign.co.uk" target="_blank" rel="noopener">Dewsign</a>,
                <a href="https://www.twineapp.com" target="_blank" rel="noopener">Twine</a> and most recently,
                <a href="https://www.imdb.com" target="_blank" rel="noopener">IMDb</a>.
            </p>
            <p class="mb-6">
                If you’d like to see my experience, please take a look at the <a href="{{ route('about') . '#experience' }}">about</a> page.
                Whilst I can’t share the majority of my work, I do have some open-source projects on
                <a href="https://github.com/{{ config('social.github') }}" target="_blank" rel="noopener">GitHub</a> (in various states), including
                the <a href="https://github.com/{{ config('social.github') }}/samwrigley.co.uk" target="_blank" rel="noopener">source</a> for this site.
            </p>
            <p class="mb-6">
                Thank you for taking the time to consider my application. If this goes no further, then I just want to say thank you for everything
                you do for the community and keep up the fantastic work.
            </p>
            <p>
                It would be an absolute dream come true to work with you on Tailwind and contribute to the larger OSS community.
            </p>
        </div>
    </article>
@endsection
