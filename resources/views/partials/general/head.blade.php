<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name') }} - {{ config('meta.tagline') }}</title>

{{-- Google Tag Manager --}}
@include('partials.general.head.gtm')

{{-- Icons --}}
@include('partials.general.head.icons')

{{-- Styles --}}
<link href="{{ mix('css/app.css') }}" rel="stylesheet">

{{-- Meta Tags --}}
@include('partials.general.head.meta')

{{-- Schema --}}
@include('partials.general.head.schema')
