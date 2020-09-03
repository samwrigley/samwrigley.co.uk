@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="flex min-h-screen">
        <div class="w-1/6 bg-gray-800 text-white text-lg">
            <div class="h-20 flex items-center bg-gray-900 py-4 px-6 font-bold hover:text-gray-300">
                <a href="{{ route('admin.dashboard') }}">
                    {{ config('app.name') }}
                </a>
            </div>
            <div class="py-4">
                <nav>
                    <ul>
                        <li class="px-8 py-4">
                            <span class="font-bold">
                                {{ __('Articles') }}
                            </span>
                        </li>
                        <li>
                            <a href="{{ route('admin.articles.index') }}" class="block px-8 py-2 hover:bg-gray-900">
                                {{ __('All articles') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.articles.create') }}" class="block px-8 py-2 hover:bg-gray-900">
                                {{ __('Create article') }}
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="w-5/6 bg-gray-200">
            <div class="h-20 flex items-center bg-white py-4 px-6 border-b border-gray-300">
                <div class="ml-auto">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <x-admin.buttons.default text="{{ __('Logout') }}" />
                    </form>
                </div>
            </div>
            <div class="p-16">
                <section class="bg-white rounded shadow">
                    @yield('body')
                </section>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="absolute bottom-0 right-0 mb-8 mr-8 bg-white shadow rounded py-3 px-4" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endsection
