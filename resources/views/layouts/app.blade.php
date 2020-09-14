<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('partials.general.head')
    </head>
    <body class="relative text-gray-900">
        @yield('content')
        @include('partials.general.scripts')
    </body>
</html>
