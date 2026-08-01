@props(['settings' => []])

@php
    // Fallbacks
    $title = $settings['seo_title'] ?? 'Shivalay Travels — Instant Ticket Bookings & Sacred Temple Yatras';
    $description = $settings['seo_description'] ?? 'Shivalay Travels is Indore\'s trusted agency for instant ticket bookings. Get lowest prices on Flights, Trains, Buses & Cruises.';
    $keywords = $settings['seo_keywords'] ?? 'travel agency indore, bus booking, taxi booking, hotel stays, villa stays, custom tour packages, shivalay travels';
    $robots = $settings['seo_robots'] ?? 'index, follow';
    $analytics = $settings['google_analytics'] ?? '';
    
    $businessName = $settings['businessName'] ?? 'Shivalay Travels';
    $phone = $settings['phone'] ?? '+91 93409 94628';
    $email = $settings['email'] ?? 'shivalaytravels@gmail.com';
    $address = $settings['address'] ?? 'Indore, Madhya Pradesh, India';
    
    $canonicalUrl = request()->url();
    $logoUrl = asset('images/logo.png'); // fallback to a default logo path if exists
@endphp

<!-- Basic Meta Tags -->
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
<meta property="og:site_name" content="{{ $businessName }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $canonicalUrl }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ asset('images/og-image.jpg') }}">

<!-- Favicon and App Icons -->
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

<!-- Google Analytics / Custom Scripts -->
@if(!empty($analytics))
    @if(str_contains($analytics, '<script'))
        {!! $analytics !!}
    @else
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $analytics }}');
        </script>
    @endif
@endif

<!-- JSON-LD Structured Data Schema -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Organization",
      "@@id": "{{ url('/') }}/#organization",
      "name": "{{ $businessName }}",
      "url": "{{ url('/') }}",
      "logo": {
        "@@type": "ImageObject",
        "url": "{{ asset('images/logo.png') }}",
        "caption": "{{ $businessName }}"
      },
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "{{ $phone }}",
        "contactType": "customer service",
        "email": "{{ $email }}",
        "areaServed": "IN",
        "availableLanguage": ["English", "Hindi"]
      }
    },
    {
      "@@type": "WebSite",
      "@@id": "{{ url('/') }}/#website",
      "url": "{{ url('/') }}",
      "name": "{{ $businessName }}",
      "description": "{{ $description }}",
      "publisher": {
        "@@id": "{{ url('/') }}/#organization"
      }
    },
    {
      "@@type": "WebPage",
      "@@id": "{{ $canonicalUrl }}/#webpage",
      "url": "{{ $canonicalUrl }}",
      "name": "{{ $title }}",
      "description": "{{ $description }}",
      "isPartOf": {
        "@@id": "{{ url('/') }}/#website"
      },
      "about": {
        "@@id": "{{ url('/') }}/#organization"
      }
    },
    {
      "@@type": "LocalBusiness",
      "@@id": "{{ url('/') }}/#localbusiness",
      "name": "{{ $businessName }}",
      "image": "{{ asset('images/og-image.jpg') }}",
      "telephone": "{{ $phone }}",
      "email": "{{ $email }}",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ $address }}",
        "addressLocality": "Indore",
        "addressRegion": "Madhya Pradesh",
        "addressCountry": "IN"
      },
      "priceRange": "$$",
      "openingHoursSpecification": {
        "@@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
          "Sunday"
        ],
        "opens": "00:00",
        "closes": "23:59"
      }
    },
    {
      "@@type": "BreadcrumbList",
      "@@id": "{{ url('/') }}/#breadcrumb",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "{{ url('/') }}"
        }
      ]
    },
    {
      "@@type": "FAQPage",
      "@@id": "{{ url('/') }}/#faq",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "What travel services does Shivalay Travels offer?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Shivalay Travels offers premium taxi bookings, bus bookings, luxury villa stays, curated hotel stays, and customizable tour packages across India."
          }
        },
        {
          "@@type": "Question",
          "name": "Where is Shivalay Travels located?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "Our primary operations office is located in Indore, Madhya Pradesh, India. However, we coordinate and arrange tour packages and travel logistics nationwide."
          }
        },
        {
          "@@type": "Question",
          "name": "How can I get an instant quote for my holiday?",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "You can get an instant quote by filling out the 'Get a Quote' form on our home page or via the quick popup. Alternatively, you can call us or chat on WhatsApp at {{ $phone }}."
          }
        }
      ]
    }
  ]
}
</script>
