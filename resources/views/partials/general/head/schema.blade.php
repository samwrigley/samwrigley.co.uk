<script type="application/ld+json">
    [
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "url": "{{ config('app.url') }}",
            "name": "{{ config('app.name') }}",
            "author": {
                "@type": "Person",
                "name": "Sam Wrigley"
            },
            "description": "Hello, I'm Sam Wrigley. I'm a Web-Developer and Designer."
        },
        {
            "@context": "http://schema.org",
            "@type": "LocalBusiness",
            "description": "I'm a Web-Developer and Designer.",
            "name": "Sam Wrigley",
            "image": "{{ asset('images/sam-wrigley.webp') }}",
            "telephone": "{{ config('contact.telephone') }}",
            "openingHours": "Mo,Tu,We,Th,Fr 09:00-18:00",
            "sameAs": [
                "https://twitter.com/{{ config('social.twitter') }}",
                "https://instagram.com/{{ config('social.instagram') }}",
                "https://github.com/{{ config('social.instagram') }}"
            ]
        },
        {
            "@context": "http://schema.org",
            "@type": "Person",
            "email": "mailto:{{ config('contact.email') }}",
            "image": "{{ asset('images/sam-wrigley.webp') }}",
            "jobTitle": "Web-Developer",
            "name": "Sam Wrigley",
            "alumniOf": "Falmouth University",
            "gender": "male",
            "nationality": "British",
            "telephone": "{{ config('contact.telephone') }}",
            "url": "{{ config('app.url') }}",
            "sameAs": [
                "https://twitter.com/{{ config('social.twitter') }}",
                "https://instagram.com/{{ config('social.instagram') }}",
                "https://github.com/{{ config('social.instagram') }}"
            ]
        }
    ]
</script>
