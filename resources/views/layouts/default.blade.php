<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        @include('partials.general.head')
    </head>

    <body>

        @include('partials.general.gtm')

        <div class="site">

            <main class="site__main" role="main">
                @yield('content')
            </main>

            <footer class="site__footer">
                @include('partials.general.footer')
            </footer>

        </div>
        
    </body>

</html>
