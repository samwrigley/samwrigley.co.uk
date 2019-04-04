<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('partials.general.head')
    </head>
    <body id="top">
        <div id="app" class="site">
            <header class="site__header">
                @include('partials.general.header')
            </header>

            @hasSection('aside')
                <main class="site__main site__main--aside" role="main">
                    <section class="site__content">
                        @yield('content')
                    </section>

                    <aside class="site__aside">
                        @yield('aside')
                    </aside>
                </main>
            @else
                <main class="site__main" role="main">
                    @yield('content')
                </main>
            @endif

            <footer class="site__footer">
                @include('partials.general.footer')
            </footer>
        </div>

        @include('partials.general.scripts')
    </body>
</html>
