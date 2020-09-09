@extends('layouts.app')

@section('content')
    <div class="relative px-4 py-6 flex flex-col min-h-screen overflow-x-hidden sm:p-8">
        <div class="flex items-end mb-8 text-base leading-none">
            @include('partials.general.header')
        </div>

        <main class="flex-1 flex flex-col mb-8">
            @yield('body')
        </main>

        <footer class="leading-none">
            @include('partials.general.footer')
        </footer>
    </div>
@endsection
