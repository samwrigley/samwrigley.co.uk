<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="text-gray-900">
    <head>
        @include('partials.general.head')
    </head>
    <body class="min-h-screen">
        <div id="app" class="px-4 py-6 flex flex-col min-h-screen sm:p-8">
            <div class="flex mb-8 text-base leading-none">
                @include('partials.general.header')
            </div>

            <main class="mb-8">
                @yield('content')
            </main>

            <footer class="leading-none mt-auto">
                @include('partials.general.footer')
            </footer>
        </div>

        @include('partials.general.scripts')
    </body>
</html>
