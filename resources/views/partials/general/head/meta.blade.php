<meta name="description" content="{{ config('meta.description') }}">
<meta name="image" content="{{ asset('images/sam-wrigley.png') }}" />
<meta name="keywords" content="Front End Engineer, Front End Developer, Web Developer, Software Engineer">

{{-- Open Graph --}}
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:title" content="{{ config('app.name') }} - {{ config('meta.tagline') }}" />
<meta property="og:description" content="{{ config('meta.description') }}">
<meta property="og:image" content="{{ asset('images/sam-wrigley.png') }}" />

{{-- Twitter Cards --}}
<meta name="twitter:title" content="{{ config('app.name') }} - {{ config('meta.tagline') }}" />
<meta name="twitter:description" content="{{ config('meta.description') }}">
<meta name="twitter:image" content="{{ asset('images/sam-wrigley.png') }}" />
<meta name="twitter:creator" content="{{ '@' . config('social.twitter') }}">
<meta name="twitter:card" content="summary_large_image">
