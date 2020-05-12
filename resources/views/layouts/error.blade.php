@extends('layouts.default')

@section('content')
    <div class="flex-1 flex items-center justify-center">
        <div class="text-center">
            <h1 class="mb-1 text-3xl font-black leading-tight md:mb-2 md:text-5xl lg:text-6xl">
                @yield('code')
            </h1>
            <span class="leading-tight tracking-wide md:text-xl sm:tracking-normal">
                @yield('message')
            </span>
        </div>
    </div>
@endsection
