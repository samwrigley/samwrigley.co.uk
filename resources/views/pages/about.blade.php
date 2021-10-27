@extends('layouts.default')

@section('title', __('about.page_title'))

@section('body')
    <h1 class="absolute top-0 right-0 text-gray-300 font-black leading-none text-8xl mt-16 -mr-6
        md:text-10xl
        lg:text-16xl lg:-mt-24 lg:-mr-8
        xl:text-20xl xl:-mt-32 xl:-mr-12
        xxl:-mt-40 xxl:mr-0 xxl:text-26xl"
    >
        About
    </h1>

    <section class="flex flex-col mb-12 mt-32 md:mb-16 xl:mb-32 xl:flex-row xl:mt-40">
        <div class="flex-shrink-0 relative mb-3 xl:w-32 xl:mb-0 xl:mr-12">
            <h2 id="who-am-i"
                class="text-xl font-bold xl:tracking-wide xl:text-2xl xl:absolute xl:top-0 xl:right-0 xl:transform xl:origin-top-right xl:-rotate-90"
            >
                <a href="#who-am-i">Who am I</a>
            </h2>
        </div>

        <div class="p-6 border border-black md:p-8 xl:mr-12 xl:p-16 xl:w-1/2 xxl:w-1/3">
            <div class="flex flex-col items-start text-gray-700 leading-relaxed md:text-xl">
                <p class="mb-6">
                    I'm Sam Wrigley, a Front-End Engineer helping to create contribution experiences at
                    <a href="https://www.imdb.com" target="_blank" rel="noopener">IMDb</a>.
                    I specialise in all things front-end with a strong emphasis on modern, scalable JavaScript.
                </p>
                <p class="mb-6">
                    I know my way around a back-end too, having previously <a href="#experience">worked</a> as a Full-Stack Developer and Software Developer.
                    I also have a strong understanding of user-experience and user-interface design—having studied Graphic Design at
                    <a href="https://www.falmouth.ac.uk/study/undergraduate/graphic-design" target="_blank" rel="noopener">university</a>.
                </p>
                <p class="mb-6">
                    Outside of web-development, I have a passion for photography and I’m also a keen outdoor runner.
                </p>
                <a href="{{ route('contact') }}"
                    class="flex items-center font-black text-blue-700 hover:text-blue-900"
                >
                    <span class="mr-2">Get in touch</span>
                    <x-heroicon-o-arrow-right class="w-4 fill-current md:w-6" />
                </a>
            </div>
        </div>

        <div class="flex-shrink-0 hidden w-56 self-end xl:block xxl:w-80">
            <div class="relative">
                <img src="https://res.cloudinary.com/samwrigley/image/upload/f_auto/e_grayscale/w_320/v1590338144/sam-wrigley-profile"
                    alt="{{ config('app.name') }}"
                    class="relative z-10"
                >
                <div class="absolute top-0 left-0 w-full h-full bg-blue-700 transform rotate-4"></div>
            </div>
        </div>
    </section>

    <section class="flex flex-col xl:flex-row">
        <div class="relative mb-3 xl:mb-0 xl:w-1/3 xl:mr-12">
            <h2 id="experience"
                class="text-xl font-bold xl:tracking-wide xl:text-2xl xl:absolute xl:top-0 xl:right-0 xl:transform xl:origin-top-right xl:-rotate-90"
            >
                <a href="#experience">Experience</a>
            </h2>
        </div>

        <div class="border border-black md:p-8 xl:w-3/4 xl:p-16">
            <div class="flex flex-col border-black border-b p-6 md:p-0 md:border-0 md:mb-16 md:flex-row">
                <div class="mb-4 md:mr-8 md:w-1/3">
                    <h3 class="font-black md:text-xl lg:text-2xl">Front End Engineer</h3>
                    <a href="https://www.imdb.com"
                        target="_blank"
                        rel="noopener"
                        class="font-bold inline-block text-blue-700 mb-1 hover:text-blue-900 md:mb-2 lg:text-xl"
                    >
                        IMDb
                    </a>
                    <div class="text-sm text-gray-700 lg:text-base">Jul 2019—Present</div>
                </div>
                <div class="text-gray-700 md:w-2/3 md:text-xl xl:w-1/3">
                    <p class="mb-3">
                        Helping create contribution experiences at <a href="https://www.imdb.com" target="_blank" rel="noopener">IMDb</a>
                        —the world's most popular and authoritative source for movie and TV content—using
                        <span class="text-black">React</span>, <span class="text-black">TypeScript</span> and <span class="text-black">Java</span>.
                    </p>
                </div>
            </div>

            <div class="flex flex-col border-black border-b p-6 md:p-0 md:border-0 md:mb-16 md:flex-row">
                <div class="mb-4 md:mr-8 md:w-1/3">
                    <h3 class="font-black md:text-xl lg:text-2xl">Front End Engineer</h3>
                    <a href="https://www.twineapp.com"
                        target="_blank"
                        rel="noopener"
                        class="font-bold inline-block text-blue-700 mb-1 hover:text-blue-900 md:mb-2 lg:text-xl"
                    >
                        Twine
                    </a>
                    <div class="text-sm text-gray-700 lg:text-base">Oct 2018—Jul 2019</div>
                </div>
                <div class="text-gray-700 md:w-2/3 md:text-xl xl:w-1/3">
                    <p class="mb-3">
                        Responsible for all things front-end at <a href="https://www.twineapp.com" target="_blank" rel="noopener">Twine</a>
                        —an intranet that connects people, content and ideas together.
                    </p>
                    <p>
                        Designed and built new features using <span class="text-black">React</span> and <span class="text-black">TypeScript</span>,
                        whilst also maintaining an existing <span class="text-black">Angular</span> codebase.
                    </p>
                </div>
            </div>

            <div class="flex flex-col border-black border-b p-6 md:p-0 md:border-0 md:mb-16 md:flex-row">
                <div class="mb-4 md:mr-8 md:w-1/3">
                    <h3 class="font-black md:text-xl lg:text-2xl">Software Developer</h3>
                    <a href="https://www.ekeepergroup.co.uk"
                        target="_blank"
                        rel="noopener"
                        class="font-bold inline-block text-blue-700 mb-1 hover:text-blue-900 md:mb-2 lg:text-xl"
                    >
                        eKeeper Group
                    </a>
                    <div class="text-sm text-gray-700 lg:text-base">May 2018—Oct 2018</div>
                </div>
                <div class="text-gray-700 md:w-2/3 md:text-xl xl:w-1/3">
                    <p class="mb-3">
                        Worked as a Software Developer at <a href="https://www.ekeepergroup.co.uk" target="_blank" rel="noopener">eKeeper Group</a>,
                        a market leader in mortgage, lending and banking CRM systems.
                    </p>
                    <p>
                        Maintained a bespoke version of the product for a large client in the financial
                        industry—built using <span class="text-black">PHP</span> and <span class="text-black">JavaScript</span>.
                    </p>
                </div>
            </div>

            <div class="flex flex-col p-6 md:p-0 md:flex-row">
                <div class="mb-4 md:mr-8 md:w-1/3">
                    <h3 class="font-black md:text-xl lg:text-2xl">Full Stack Developer</h3>
                    <a href="https://www.dewsign.co.uk"
                        target="_blank"
                        rel="noopener"
                        class="font-bold inline-block text-blue-700 mb-1 hover:text-blue-900 md:mb-2 lg:text-xl"
                    >
                        Dewsign
                    </a>
                    <div class="text-sm text-gray-700 lg:text-base">Oct 2016—May 2018</div>
                </div>
                <div class="text-gray-700 md:w-2/3 md:text-xl xl:w-1/3">
                    <p class="mb-3">
                        Tackled a diverse range of web-development projects at <a href="https://www.dewsign.co.uk" target="_blank" rel="noopener">Dewsign</a>
                        —a full-service digital design agency—often from design through to development.
                    </p>
                    <p>
                        Helped design and build content management systems, bespoke software applications and e-commerce websites using
                        <span class="text-black">Laravel</span>, <span class="text-black">WordPress</span> and <span class="text-black">Vue.js</span>.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
