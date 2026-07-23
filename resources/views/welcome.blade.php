<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shivalay Travels — Instant Ticket Bookings &amp; Sacred Temple Yatras</title>
    <meta name="description" content="Shivalay Travels is Indore's trusted agency for instant ticket bookings. Get lowest prices on Flights, Trains, Buses &amp; Cruises.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    <script>
      window.DB_PACKAGES = @json($packages);
      window.DB_GUIDES = @json($guides);
      window.DB_CITIES = @json($cities);
    </script>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif
    <style>
      .nav-link-mobile {
        font-family: var(--font-tomorrow);
        font-size: 24px;
        font-weight: 400;
        color: var(--color-pure-white);
        background: none;
        border: none;
        cursor: pointer;
        padding: 12px 24px;
        border-radius: var(--radius-xl);
        transition: all 0.18s ease;
        text-decoration: none;
        display: inline-block;
      }
      .nav-link-mobile:hover {
        background: var(--color-carbon);
      }
      @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.5; }
      }
    </style>
</head>
<body>

<!-- ═══════════════ NAVIGATION ═══════════════ -->
<nav id="main-nav" style="position:fixed;top:0;left:0;right:0;z-index:1000;background:var(--color-onyx-black-80);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-bottom:1px solid var(--color-zinc-hairline);transition:background 0.3s ease, transform 0.3s ease">
  <div class="container" style="display:flex;align-items:center;justify-content:space-between;height:56px">
    <!-- Logo -->
    <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" style="display: flex; align-items: center; gap: 8px; background: none; border: none; cursor: pointer; padding: 0;">
      <div style="width: 28px; height: 28px; border-radius: 6px; background: var(--color-highlighter-lime); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--color-onyx-black)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 2L15 22L11 13L2 9L22 2Z" />
        </svg>
      </div>
      <span class="text-logo-brand" style="display: flex; align-items: center;">
        Shivalay Travels
      </span>
    </button>
    <!-- Desktop Nav -->
    <div class="desktop-nav" style="display:flex;align-items:center;gap:2px">
      <button class="nav-link" onclick="smoothScroll('tickets')">Ticket Booking</button>
      <button class="nav-link" onclick="smoothScroll('destinations')">Destinations</button>
      <button class="nav-link" onclick="smoothScroll('itinerary-preview')">Temple Yatras</button>
      <button class="nav-link" onclick="smoothScroll('how-it-works')">How it works</button>
      <button class="nav-link" onclick="smoothScroll('stories')">Stories</button>
    </div>
    <!-- CTA + Hamburger -->
    <div style="display:flex;align-items:center;gap:10px">
      <a
        href="https://wa.me/919340994628?text=Hello%20Shivalay%20Travels!%20I%20need%20help%20with%20a%20booking."
        target="_blank" rel="noopener noreferrer"
        class="desktop-nav ff-mono fs-12"
        style="color: var(--color-steel-gray); display: flex; align-items: center; gap: 5px; padding: 5px 10px; border: 1px solid var(--color-zinc-hairline); border-radius: var(--radius-md); transition: all 0.18s ease; text-decoration: none;"
        onmouseenter="this.style.color='var(--color-pure-white)'; this.style.borderColor='var(--color-smoke)';"
        onmouseleave="this.style.color='var(--color-steel-gray)'; this.style.borderColor='var(--color-zinc-hairline)';"
      >
        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
        WhatsApp
      </a>
      <button class="btn-primary desktop-nav" onclick="smoothScroll('planner')" style="padding: 7px 14px;">
        Plan Journey →
      </button>
      <button class="mobile-menu-btn" id="hamburger-btn" style="display:none;width:36px;height:36px;border-radius:var(--radius-md);border:1px solid var(--color-zinc-hairline);align-items:center;justify-content:center;background:transparent;color:var(--color-pure-white);cursor:pointer" onclick="toggleMobileMenu()">
        <div style="width: 18px; display: flex; flex-direction: column; gap: 4px;" id="hamburger-icon-wrapper">
          <div style="width: 100%; height: 1.5px; background: var(--color-pure-white); border-radius: 2px; transition: transform 0.25s ease;" id="ham-bar-1"></div>
          <div style="height: 1.5px; background: var(--color-pure-white); border-radius: 2px; transition: opacity 0.25s ease;" id="ham-bar-2"></div>
          <div style="height: 1.5px; background: var(--color-pure-white); border-radius: 2px; transition: transform 0.25s ease; width: 70%;" id="ham-bar-3"></div>
        </div>
      </button>
    </div>
  </div>
  <!-- Scroll progress -->
  <div style="height:1px;background:transparent;position:absolute;bottom:0;left:0;right:0">
    <div id="scroll-progress" style="height:100%;width:0%;background:var(--color-highlighter-lime);transition:width 0.1s linear"></div>
  </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu" style="display:none;position:fixed;inset:0;z-index:999;background:var(--color-onyx-black-98);backdrop-filter:blur(20px);padding:80px 24px 24px;flex-direction:column;align-items:center;justify-content:center;gap:8px;opacity:0;transform:translateY(-6px);transition:opacity 0.3s ease, transform 0.3s ease">
  <button class="nav-link-mobile" onclick="smoothScroll('tickets');toggleMobileMenu()">Ticket Booking</button>
  <button class="nav-link-mobile" onclick="smoothScroll('destinations');toggleMobileMenu()">Destinations</button>
  <button class="nav-link-mobile" onclick="smoothScroll('itinerary-preview');toggleMobileMenu()">Temple Yatras</button>
  <button class="nav-link-mobile" onclick="smoothScroll('how-it-works');toggleMobileMenu()">How it works</button>
  <button class="nav-link-mobile" onclick="smoothScroll('stories');toggleMobileMenu()">Stories</button>
  <button class="btn-primary" onclick="smoothScroll('planner');toggleMobileMenu()" style="margin-top: 20px;">Plan Journey</button>
</div>

<main style="padding-top:56px">

<!-- ═══════════════ HERO ═══════════════ -->
<section id="hero" style="background:var(--surface-canvas);padding-top:30px;padding-bottom:48px;border-bottom:1px solid var(--color-zinc-hairline);position:relative">
  <div class="container" style="position:relative;z-index:2">
    <div class="hero-grid">
      <!-- LEFT -->
      <div>
        <div class="hero-announcement" style="display:flex;margin-bottom:28px">
          <div class="announcement-banner">
            <span style="width:6px;height:6px;border-radius:50%;background:var(--color-highlighter-lime);animation:pulse 2s ease-in-out infinite;display:inline-block;flex-shrink:0"></span>
            <span>🇮🇳 India's Trusted Pilgrimage &amp; Tourism Partner · Indore, MP</span>
          </div>
        </div>
        <h1 class="reveal font-secondary fs-hero fw-medium lh-115" style="color:var(--color-pure-white);margin-bottom:16px">
          Instant Ticket Bookings<br>
          Made <span id="cycling-word" class="italic" style="color:var(--color-highlighter-lime);display:inline-block;transition:opacity 0.25s ease">lowest-fare</span><br>
          &amp; Sacred Temple Yatras
        </h1>
        <p class="reveal reveal-d1 font-primary fs-14 lh-16 text-muted" style="max-width:480px;margin-bottom:28px">
          Shivalay Travels is Indore's trusted agency for instant ticket bookings. Get the lowest prices on Flights, Trains, Buses &amp; Cruises with 24/7 on-ground assistance.
        </p>
        <!-- Destination chips -->
        <div class="reveal reveal-d2" style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:32px">
          <button class="pill" onclick="smoothScroll('planner')">Kedarnath</button>
          <button class="pill" onclick="smoothScroll('planner')">Chardham</button>
          <button class="pill" onclick="smoothScroll('planner')">Kashmir</button>
          <button class="pill" onclick="smoothScroll('planner')">Goa</button>
          <button class="pill" onclick="smoothScroll('planner')">Kerala</button>
          <button class="pill" onclick="smoothScroll('planner')">Ladakh</button>
          <button class="pill" onclick="smoothScroll('planner')">Rajasthan</button>
          <button class="pill" onclick="smoothScroll('planner')">Varanasi</button>
        </div>
        <!-- CTA buttons -->
        <div class="reveal reveal-d3" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:36px">
          <button class="btn-primary" onclick="smoothScroll('tickets')" style="padding:10px 20px">Book Tickets →</button>
          <button class="btn-ghost" onclick="smoothScroll('planner')" style="padding:10px 20px">Plan Custom Journey</button>
          <a
            href="https://wa.me/919340994628"
            target="_blank"
            rel="noopener noreferrer"
            class="font-primary fs-14"
            style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:var(--radius-md);background:transparent;border:1px solid var(--color-zinc-hairline);color:var(--color-steel-gray);transition:all 0.18s ease;text-decoration:none"
            onmouseenter="this.style.color='var(--color-pure-white)';this.style.borderColor='var(--color-smoke)'"
            onmouseleave="this.style.color='var(--color-steel-gray)';this.style.borderColor='var(--color-zinc-hairline)'"
          >
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="color:var(--color-whatsapp)">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            WhatsApp
          </a>
        </div>
        <!-- Trust badges -->
        <div class="reveal reveal-d4" style="display:flex;gap:0;border-top:1px solid var(--color-zinc-hairline);padding-top:24px;flex-wrap:wrap">
          <div style="padding:12px 24px;border-right:1px solid var(--color-zinc-hairline);text-align:center">
            <p class="font-primary fs-18 fw-medium lh-1" style="color:var(--color-pure-white)">12,500+</p>
            <p class="font-primary fs-11 text-muted" style="margin-top:4px">Happy Travellers</p>
          </div>
          <div style="padding:12px 24px;border-right:1px solid var(--color-zinc-hairline);text-align:center">
            <p class="font-primary fs-18 fw-medium lh-1" style="color:var(--color-pure-white)">50+</p>
            <p class="font-primary fs-11 text-muted" style="margin-top:4px">Destinations</p>
          </div>
          <div style="padding:12px 24px;border-right:1px solid var(--color-zinc-hairline);text-align:center">
            <p class="font-primary fs-18 fw-medium lh-1" style="color:var(--color-pure-white)">24/7</p>
            <p class="font-primary fs-11 text-muted" style="margin-top:4px">Support</p>
          </div>
          <div style="padding:12px 24px;text-align:center">
            <p class="font-primary fs-18 fw-medium lh-1" style="color:var(--color-pure-white)">₹ Best</p>
            <p class="font-primary fs-11 text-muted" style="margin-top:4px">Rates</p>
          </div>
        </div>
      </div>
      <!-- RIGHT -->
      <div class="hero-right-visual reveal-scale" style="display:flex;flex-direction:column;gap:12px">
        <!-- Hero image card -->
        <div class="portfolio-tile" style="height:320px;position:relative">
          <img src="/images/kedarnath.png" alt="Kedarnath Yatra" class="tile-img" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
          <div style="position:absolute;inset:0;background:var(--gradient-visual-overlay)"></div>
          <!-- Badge -->
          <div style="position:absolute;top:14px;left:14px">
            <span class="font-primary text-xs fw-medium uppercase ls-05" style="display:inline-flex;align-items:center;gap:5px;background:var(--color-highlighter-lime);color:var(--color-onyx-black);padding:4px 8px;border-radius:var(--radius-full)">
              <span style="width:5px;height:5px;border-radius:50%;background:var(--color-onyx-black);animation:pulse 1.5s infinite"></span>
              Temple Yatra Special
            </span>
          </div>
          <div style="position:absolute;bottom:16px;left:16px;right:16px">
            <p class="font-primary text-xs text-muted uppercase ls-1" style="margin-bottom:4px">Spiritual Journey · Divine Experience</p>
            <h3 class="font-secondary fs-20 fw-regular" style="color:var(--color-pure-white);margin-bottom:10px">Complete Pilgrimage Solutions</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px">
              <span class="font-primary fs-11" style="color:var(--color-white-80);display:flex;align-items:center;gap:5px"><span style="color:var(--color-highlighter-lime)" class="fs-10">✦</span> Comfortable Stay</span>
              <span class="font-primary fs-11" style="color:var(--color-white-80);display:flex;align-items:center;gap:5px"><span style="color:var(--color-highlighter-lime)" class="fs-10">✦</span> Hygienic Food</span>
              <span class="font-primary fs-11" style="color:var(--color-white-80);display:flex;align-items:center;gap:5px"><span style="color:var(--color-highlighter-lime)" class="fs-10">✦</span> VIP Darshan</span>
              <span class="font-primary fs-11" style="color:var(--color-white-80);display:flex;align-items:center;gap:5px"><span style="color:var(--color-highlighter-lime)" class="fs-10">✦</span> Travel Assistance</span>
            </div>
          </div>
        </div>
        <!-- Quick contact card -->
        <div style="background:var(--color-onyx-black);border:1px solid var(--color-zinc-hairline);border-radius:var(--radius-xl);padding:20px">
          <p class="font-primary fs-13 fw-medium" style="color:var(--color-pure-white);margin-bottom:4px">Need instant booking assistance?</p>
          <p class="font-primary text-sm lh-15 text-muted" style="margin-bottom:14px">Enter your phone number to get connected directly on WhatsApp.</p>
          <form style="display:flex;gap:8px" onsubmit="event.preventDefault(); const ph = this.elements.phone.value; window.open('https://wa.me/919340994628?text=' + encodeURIComponent('Hello Shivalay Travels, I need instant booking support. Contact: ' + ph), '_blank');">
            <input class="input-terminal" name="phone" type="tel" placeholder="+91 93409 94628" required style="flex:1">
            <button type="submit" class="btn-primary" style="flex-shrink:0;white-space:nowrap">Get Tickets</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════ SECTION: TICKET BOOKING ═══════════════ -->
@include('sections.ticket-booking')

<!-- ═══════════════ LOGO STRIP ═══════════════ -->
<section style="border-top:1px solid var(--color-zinc-hairline);border-bottom:1px solid var(--color-zinc-hairline);background:var(--color-carbon);padding:16px 0;overflow:hidden">
  <div class="ticker-wrap">
    <div class="ticker-track" id="ticker-track"></div>
  </div>
</section>

<!-- ═══════════════ SECTION: DESTINATIONS ═══════════════ -->
@include('sections.destinations')

<!-- ═══════════════ SECTION: PHILOSOPHY (How it works / About) ═══════════════ -->
@include('sections.philosophy')

<!-- ═══════════════ SECTION: DARK PROBLEM PANEL ═══════════════ -->
@include('sections.dark-panel')

<!-- ═══════════════ SECTION: ITINERARY PREVIEW ═══════════════ -->
@include('sections.itinerary-preview')

<!-- ═══════════════ SECTION: STATS ═══════════════ -->
<section style="background:var(--surface-canvas);padding:0;border-bottom:1px solid var(--color-zinc-hairline)" id="stats-section-anchor">
  <div class="container">
    <div class="stats-grid" style="overflow:hidden" id="stats-grid">
      <div class="reveal" style="padding:32px 24px;display:flex;flex-direction:column;gap:6px;border-right:1px solid var(--color-zinc-hairline);cursor:default" onmouseenter="this.style.background='var(--color-carbon)'" onmouseleave="this.style.background='transparent'">
        <div class="text-stat" data-count="12500" data-suffix="+">0+</div>
        <p class="font-primary text-sm fw-regular lh-15 text-muted">Happy travellers served</p>
      </div>
      <div class="reveal" style="padding:32px 24px;display:flex;flex-direction:column;gap:6px;border-right:1px solid var(--color-zinc-hairline);cursor:default" onmouseenter="this.style.background='var(--color-carbon)'" onmouseleave="this.style.background='transparent'">
        <div class="text-stat" data-count="99" data-suffix="%">0%</div>
        <p class="font-primary text-sm fw-regular lh-15 text-muted">Customer satisfaction rate</p>
      </div>
      <div class="reveal" style="padding:32px 24px;display:flex;flex-direction:column;gap:6px;border-right:1px solid var(--color-zinc-hairline);cursor:default" onmouseenter="this.style.background='var(--color-carbon)'" onmouseleave="this.style.background='transparent'">
        <div class="text-stat" data-count="50" data-suffix="+">0+</div>
        <p class="font-primary text-sm fw-regular lh-15 text-muted">Pilgrimage &amp; tourist routes</p>
      </div>
      <div class="reveal" style="padding:32px 24px;display:flex;flex-direction:column;gap:6px;cursor:default" onmouseenter="this.style.background='var(--color-carbon)'" onmouseleave="this.style.background='transparent'">
        <div class="text-stat">24/7</div>
        <p class="font-primary text-sm fw-regular lh-15 text-muted">On-ground support available</p>
      </div>
    </div>
  </div>
  <style>
    @media(max-width:768px){.stats-grid>div{border-bottom:1px solid var(--color-zinc-hairline)!important}.stats-grid>div:nth-child(2n){border-right:none!important}.stats-grid>div:nth-last-child(-n+2){border-bottom:none!important}}
    @media(max-width:480px){.stats-grid{grid-template-columns:1fr 1fr!important}}
  </style>
</section>

<!-- ═══════════════ SECTION: JOURNEY PLANNER ═══════════════ -->
@include('sections.journey-planner')

<!-- ═══════════════ SECTION: MEMORIES (Stories) ═══════════════ -->
@include('sections.memories')

<!-- ═══════════════ SECTION: TRAVEL GUIDES (Travel Intelligence) ═══════════════ -->
@include('sections.travel-guides')

<!-- ═══════════════ SECTION: EARTH OUTRO ═══════════════ -->
@include('sections.earth-outro')

<!-- ═══════════════ FOOTER ═══════════════ -->
@include('sections.footer')

</main>

<!-- ═══════════════ MOBILE BOTTOM NAV ═══════════════ -->
<nav class="mobile-bottom-nav">
  <button class="mobile-bottom-nav-btn" onclick="smoothScroll('tickets')">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 2L15 22L11 13L2 9L22 2Z" />
    </svg>
    <span class="text-nav-label">Tickets</span>
  </button>
  <button class="mobile-bottom-nav-btn" onclick="smoothScroll('destinations')">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"/>
      <path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/>
    </svg>
    <span class="text-nav-label">Explore</span>
  </button>
  <button class="mobile-bottom-nav-btn mobile-bottom-nav-main" onclick="smoothScroll('planner')">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
      <line x1="16" y1="2" x2="16" y2="6"/>
      <line x1="8" y1="2" x2="8" y2="6"/>
      <line x1="3" y1="10" x2="21" y2="10"/>
    </svg>
    <span class="text-nav-label">Plan</span>
  </button>
  <button class="mobile-bottom-nav-btn" onclick="smoothScroll('stories')">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
    </svg>
    <span class="text-nav-label">Stories</span>
  </button>
  <button class="mobile-bottom-nav-btn" onclick="smoothScroll('how-it-works')">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"/>
      <path d="M12 8v4M12 16h.01"/>
    </svg>
    <span class="text-nav-label">About</span>
  </button>
</nav>

<!-- ═══════════════ WHATSAPP FAB ═══════════════ -->
<a href="https://wa.me/919340994628?text=Hello%20Shivalay%20Travels!%20I%20need%20help%20with%20a%20booking." target="_blank" rel="noopener noreferrer" class="whatsapp-fab" aria-label="Chat on WhatsApp">
  <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
  </svg>
</a>

</body>
</html>
