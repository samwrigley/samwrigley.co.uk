<meta name="description" content="Hello, I'm Sam Wrigley. I'm a Web-Developer and Designer.">

{{-- Open Graph --}}
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ config('app.name') }} | Web-Developer" />
<meta property="og:title" content="{{ config('app.name') }}" />
<meta property="og:image" content="{{ asset('images/sam-wrigley.webp') }}" />

{{-- Twitter Cards --}}
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="{{ '@' . config('social.twitter') }}">
