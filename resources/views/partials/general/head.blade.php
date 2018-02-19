<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name') }} | Web-Developer</title>

{{-- Google Tag Manager --}}
@include('partials.general.head.gtm')

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com/css?family=Inconsolata:400,700|Karla:400,700" rel="stylesheet" crossorigin>

{{-- Styles --}}
<link href="{{ mix('css/app.css') }}" rel="stylesheet">

{{-- Meta Tags --}}
@include('partials.general.head.meta')

{{-- Schema --}}
@include('partials.general.head.schema')
