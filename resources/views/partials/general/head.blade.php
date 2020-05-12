<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title') | {{ config('app.name') }}</title>

{{-- Google Tag Manager --}}
@include('partials.general.head.gtm')

{{-- Icons --}}
@include('partials.general.head.icons')

{{-- Fonts --}}
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

{{-- Styles --}}
<link href="{{ mix('css/app.css') }}" rel="stylesheet">

{{-- Meta Tags --}}
@include('partials.general.head.meta')

{{-- Schema --}}
@include('partials.general.head.schema')

{{-- Feed --}}
@include('feed::links')
