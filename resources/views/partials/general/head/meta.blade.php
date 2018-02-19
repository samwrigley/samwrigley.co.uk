<meta name="description" content="{{ config('meta.description') }}">

{{-- Open Graph --}}
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:title" content="{{ config('app.name') }} - {{ config('meta.tagline') }}" />
<meta property="og:description" content="{{ config('meta.description') }}">
<meta property="og:image" content="{{ asset('images/sam-wrigley.png') }}" />

{{-- Twitter Cards --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ '@' . config('social.twitter') }}">
