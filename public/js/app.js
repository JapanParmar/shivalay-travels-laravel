// Shivalay Travels Core Frontend Interactivity Script
// Pure Vanilla JavaScript & Modern ES6 Web APIs

// ────────────────────────────────────────────────────────────────
// 1. GLOBAL STATE & STATICS
// ────────────────────────────────────────────────────────────────

const DESTINATIONS = (window.DB_PACKAGES && window.DB_PACKAGES.length > 0) ? window.DB_PACKAGES : [
  { id: 'kedarnath', name: 'Kedarnath Yatra', region: 'Uttarakhand', tagline: 'Spiritual temple yatra with divine scenic mountain views', duration: '4–6 nights', groupSize: '2–12', difficulty: 'Challenging', bestSeason: 'May – Jun, Sep – Nov', startingFrom: '₹15,000', tags: ['Spiritual', 'Adventure', 'Scenic'], highlights: ['VIP Darshan at Kedarnath Temple shrine', 'Beautiful trek from Gaurikund to Kedarnath basecamp', 'Comfortable stays near the holy temple base', 'Scenic helicopter ride booking options'], includes: ['Premium stays & hygienic food', 'Airport/station pickup & drop', 'Experienced local yatra coordinator', 'Helicopter booking assistance'], imagePath: '/images/kedarnath.png' },
  { id: 'chardham', name: 'Chardham Yatra', region: 'Uttarakhand', tagline: 'Holy pilgrimage to Yamunotri, Gangotri, Kedarnath, and Badrinath', duration: '9–12 nights', groupSize: '2–20', difficulty: 'Challenging', bestSeason: 'May – Jun, Sep – Oct', startingFrom: '₹45,000', tags: ['Spiritual', 'Heritage', 'Scenic'], highlights: ['Complete darshan of all four holy shrines', 'Special puja arrangement at Badrinath temple', 'Scenic drive through majestic Himalayan valleys', 'Holy Ganga aarti at Har Ki Pauri, Haridwar'], includes: ['Comfortable hotel bookings', 'All transfers via private luxury coach', 'Sanskrit-speaking local guide', 'All yatra registration permits'], imagePath: '/images/chardham.png' },
  { id: 'varanasi', name: 'Varanasi Kashi', region: 'Uttar Pradesh', tagline: 'Spiritual river ghats, ancient chants & silk-weaving heritage', duration: '3–5 nights', groupSize: '2–8', difficulty: 'Easy', bestSeason: 'Oct – Mar', startingFrom: '₹12,000', tags: ['Spiritual', 'Heritage', 'Wellness'], highlights: ['Private boat for Ganga Aarti ceremony at Dashashwamedh', 'Sunrise boat ride with live shehnai music', 'Guided walk through ancient alleyways & Kashi Vishwanath temple', 'Exclusive Banarasi silk weaving demonstration'], includes: ['Boutique riverfront stays', 'Private spiritual guide', 'VIP temple darshan assistance', 'Private boat charters'], imagePath: '/images/varanasi.png' },
  { id: 'kashmir', name: 'Kashmir Valley', region: 'North India', tagline: 'Misty pine valleys, wooden houseboats & peaceful shikaras', duration: '6–9 nights', groupSize: '2–12', difficulty: 'Easy', bestSeason: 'Mar – Oct', startingFrom: '₹22,000', tags: ['Luxury', 'Scenic', 'Wellness'], highlights: ['Stay in a hand-carved luxury houseboat', 'Dawn shikara ride on Dal Lake', 'Private saffron farm walk in Pampore', 'Gulmarg snow activities & gondola ride'], includes: ['Premium resort properties', 'Private local chauffeur', 'All gourmet local meals', 'Airport pickup assistance'], imagePath: '/images/kashmir.png' },
  { id: 'goa', name: 'Goa Beaches', region: 'West Coast', tagline: 'Secluded beaches, historic churches & vibrant coastal holiday', duration: '5–8 nights', groupSize: '2–8', difficulty: 'Easy', bestSeason: 'Nov – Apr', startingFrom: '₹18,000', tags: ['Luxury', 'Wellness', 'Adventure'], highlights: ['Private yacht sunset cruise', 'Curated heritage walk through Old Goa churches', 'Water sports and parasailing at Calangute', 'Beachside candlelight dinner'], includes: ['Luxury beachside hotel stays', 'Airport transfers & pickup', 'Personal travel coordinator', 'Sightseeing passes'], imagePath: '/images/goa.png' },
  { id: 'ladakh', name: 'Leh Ladakh', region: 'Himalayas', tagline: 'Snow-capped monasteries, deep valleys & high mountain passes', duration: '7–10 nights', groupSize: '2–8', difficulty: 'Challenging', bestSeason: 'Jun – Sep', startingFrom: '₹35,000', tags: ['Adventure', 'Scenic', 'Heritage'], highlights: ['Private sunrise at Pangong Tso Lake', 'Guided trek through Hemis National Park', 'VIP access to Thiksey Monastery prayer', 'Double-humped camel ride in Nubra Valley'], includes: ['Boutique camps & cottages', 'Private 4x4 vehicle & driver', 'Oxygen systems & medical backing', 'Expert local coordinator guide'], imagePath: '/images/ladakh.png' },
  { id: 'kerala', name: 'Kerala Backwaters', region: 'South India', tagline: 'Palm-fringed lagoons, spice hills & classical ayurveda', duration: '7–12 nights', groupSize: '2–6', difficulty: 'Easy', bestSeason: 'Sep – Mar', startingFrom: '₹24,000', tags: ['Wellness', 'Scenic', 'Luxury'], highlights: ['Private houseboat cruise through backwaters', 'Spice plantation trail in Munnar', 'Scenic Kathakali performance tour', 'Sunset view at Kovalam Beach'], includes: ['Boutique wellness resorts', 'All transfers via private sedan', 'Houseboat crew & meals', 'Sightseeing permits'], imagePath: '/images/kerala.png' },
  { id: 'rajasthan', name: 'Rajasthan Heritage', region: 'West India', tagline: 'Golden sandstone forts, royal palaces & desert heritage', duration: '8–12 nights', groupSize: '2–10', difficulty: 'Easy', bestSeason: 'Oct – Mar', startingFrom: '₹28,000', tags: ['Heritage', 'History', 'Luxury'], highlights: ['Private dinner at Jaisalmer desert camp', 'Exclusive tour of Mehrangarh Fort', 'Stay in Palace hotels of Udaipur', 'Sunrise hot air balloon ride over Jaipur'], includes: ['Heritage hotel properties', 'Vintage car tour', 'Folk dance performances', 'Private local guides'], imagePath: '/images/rajasthan.png' },
];

const GUIDES = (window.DB_GUIDES && window.DB_GUIDES.length > 0) ? window.DB_GUIDES : [
  { category: 'Packing Guide', title: 'The ultimate cold desert packing checklist for Ladakh — what to carry in June vs September', readTime: '7 min read', badge: 'Popular', image: '/images/ladakh.png', icon: '🏔️' },
  { category: 'Destination Intel', title: 'Kashmir in winters — Gulmarg ski resorts, wooden chalets, & winter wonderland guide', readTime: '9 min read', badge: 'Insider', image: '/images/kashmir.png', icon: '❄️' },
  { category: 'Health & Safety', title: 'High altitude acclimatisation 101 — how to prevent Acute Mountain Sickness (AMS) in Leh', readTime: '6 min read', badge: null, image: '/images/ladakh.png', icon: '⛑️' },
  { category: 'Culture', title: 'Monastery decorum in Ladakh & Spiti — rules, prayer wheel direction, & photography guidelines', readTime: '8 min read', badge: 'New', image: '/images/ladakh.png', icon: '🙏' },
  { category: 'Destination Intel', title: 'Inner Line Permits decoded — how to secure travel clearance to Pangong Tso, Nubra & Turtuk', readTime: '5 min read', badge: null, image: '/images/meghalaya.png', icon: '📋' },
  { category: 'Packing Guide', title: 'Monsoon packing list for Meghalaya — trekking boots, waterproof cases, & jungle essentials', readTime: '6 min read', badge: 'Popular', image: '/images/meghalaya.png', icon: '🌿' },
];

const TESTIMONIALS = [
  { quote: 'Our Kashmir honeymoon was beyond imagination. Every detail — the scenic houseboat, the private saffron farm walk — felt tailored to our exact pace.', name: 'Priya & Arjun Mehta', location: 'Mumbai', destination: 'Kashmir', trip: 'Honeymoon · 8 nights', rating: 5, avatar: 'PA' },
  { quote: 'The Kedarnath yatra was incredibly smooth. They managed all registrations and helicopter tickets without any hassle. A truly divine experience.', name: 'Ramesh & Savita Joshi', location: 'Indore', destination: 'Kedarnath', trip: 'Pilgrim · 5 nights', rating: 5, avatar: 'RS' },
  { quote: 'Taking our elderly parents to Chardham was a big concern, but Shivalay Travels made it absolutely stress-free. The premium Tempo Traveller was very comfortable.', name: 'The Verma Family', location: 'Bhopal', destination: 'Chardham Yatra', trip: 'Family Yatra · 11 nights', rating: 5, avatar: 'VF' },
  { quote: 'From our first call to our private houseboat cruise in Alleppey, we felt like honored guests. Already booking Jaisalmer for winter.', name: 'Dr. Ananya Nair', location: 'Kochi', destination: 'Kerala', trip: 'Solo · 9 nights', rating: 5, avatar: 'AN' },
  { quote: 'Shivalay Travels designed our corporate leadership retreat in a private Goa beach resort. The yacht sunset cruise and dinners were spectacular.', name: 'Rahul Sharma', location: 'Bangalore', destination: 'Goa', trip: 'Corporate · 5 nights', rating: 5, avatar: 'RS' },
  { quote: 'Shivalay Travels showed me what Leh Ladakh actually feels like when seasoned road specialists design it. The logistics and permits were top notch.', name: 'Vikram Sethi', location: 'New Delhi', destination: 'Ladakh', trip: 'Adventure · 9 nights', rating: 5, avatar: 'VS' },
];

const TICKETS_CLASS_OPTIONS = {
  flight: ['Economy', 'Premium', 'Business', 'First Class'],
  bus: ['AC Sleeper', 'Non-AC Sleeper', 'AC Seater', 'Luxury Volvo'],
  train: ['AC 1st Class', 'AC 2 Tier', 'AC 3 Tier', 'Sleeper Class', 'Vande Bharat CC'],
  cruise: ['Standard Cabin', 'Ocean View', 'Balcony Suite', 'Luxury Penthouse'],
};

const PLANNER_STEPS = [
  { id: 'destination', label: '01 — Where', question: 'Where in India does your soul want to go?', subtext: 'Choose from our curated regions or describe your dream destination.', options: ['Kedarnath', 'Chardham Yatra', 'Varanasi', 'Kashmir', 'Goa', 'Kerala', 'Rajasthan', 'Leh Ladakh', 'Surprise me'], inputType: 'text', inputPlaceholder: 'e.g. Kedarnath, Spiti Valley, Coorg, or a multi-city circuit…', icon: '🗺️' },
  { id: 'dates', label: '02 — When', question: 'When are you planning to travel?', subtext: 'Select a timeframe or enter specific dates.', options: ['Next month', 'In 2–3 months', 'In 6 months', 'Next year', 'Flexible / Open'], inputType: 'text', inputPlaceholder: 'e.g. Dec 20 – Jan 5, or around Diwali 2026…', icon: '📅' },
  { id: 'duration', label: '03 — Duration', question: 'How many nights are you envisioning?', subtext: 'We can design anything from a 3-night escape to a 21-night odyssey.', options: ['3–5 nights', '6–8 nights', '9–12 nights', '13–18 nights', '3+ weeks'], inputType: 'text', inputPlaceholder: 'e.g. 10 nights, or flexible based on budget…', icon: '🌙' },
  { id: 'travelers', label: '04 — Who', question: "Who's joining you on this journey?", subtext: 'Tell us about your group composition — we tailor every detail.', options: ['Solo traveller', 'Couple / Honeymoon', 'Small group (3–6)', 'Family with children', 'Family with seniors', 'Corporate team'], inputType: 'text', inputPlaceholder: 'e.g. 2 adults + 1 child (8 yrs), or 4 couples…', icon: '👥' },
  { id: 'budget', label: '05 — Budget', question: "What's your investment range per traveller?", subtext: 'All prices are per person. This helps us recommend the right properties.', options: ['Under ₹50,000', '₹50k – ₹1.5 Lakhs', '₹1.5L – ₹3 Lakhs', '₹3L – ₹5 Lakhs', '₹5 Lakhs+', 'Flexible'], inputType: 'text', inputPlaceholder: 'e.g. ₹8 Lakhs total for 2 people, or best value…', icon: '💰' },
  { id: 'style', label: '06 — Style', question: 'What kind of experience do you seek?', subtext: 'Mix and match — your journey can blend multiple styles.', options: ['Luxury Stays & Wellness', 'Himalayan Trek & Adventure', 'Heritage Trails & History', 'Wildlife & Nature', 'Honeymoon Retreat', 'Spiritual & Wellness', 'Family Magic', 'Culinary Journey'], inputType: 'text', inputPlaceholder: 'e.g. Active days, luxury nights, with some local food exploration…', icon: '✨' },
  { id: 'accommodation', label: '07 — Stay', question: 'Any accommodation preferences?', subtext: 'We partner with premium hotels, guest houses, camps, and heritage resorts.', options: ['Premium 3/4 Star Hotels', 'Comfortable Guest Houses', 'Boutique Resorts', 'Luxury Tented Camps', 'Houseboats', 'Mix of Stays'], inputType: 'text', inputPlaceholder: 'e.g. Near the temple shrine, pool required, family suite…', icon: '🏡' },
  { id: 'notes', label: '08 — Notes', question: 'Anything else we should know?', subtext: 'Dietary needs, medical considerations, must-do experiences, or special occasions.', options: [], inputType: 'textarea', inputPlaceholder: 'e.g. Celebrating our anniversary, vegetarian only, one guest uses a wheelchair, must see a sunrise…', icon: '📝' },
  { id: 'contact', label: '09 — Contact', question: 'Last step — how do we reach you?', subtext: 'We respond within 2 hours with a personalised itinerary draft.', options: [], icon: '📞' },
];

const FALLBACK_CITIES = (window.DB_CITIES && window.DB_CITIES.length > 0) ? window.DB_CITIES : [
  { name: 'Indore', code: 'IDR', state: 'Madhya Pradesh', country: 'India' },
  { name: 'Mumbai', code: 'BOM', state: 'Maharashtra', country: 'India' },
  { name: 'Delhi', code: 'DEL', state: 'Delhi', country: 'India' },
  { name: 'Bangalore', code: 'BLR', state: 'Karnataka', country: 'India' },
  { name: 'Goa', code: 'GOI', state: 'Goa', country: 'India' },
  { name: 'Varanasi', code: 'VNS', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Srinagar', code: 'SXR', state: 'Jammu & Kashmir', country: 'India' },
  { name: 'Leh', code: 'IXL', state: 'Ladakh', country: 'India' },
  { name: 'Kochi', code: 'COK', state: 'Kerala', country: 'India' }
];

// Smooth Scroll Function
window.smoothScroll = function(targetId) {
  const el = document.getElementById(targetId);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};

let lastScrollY = window.scrollY;
const mainNav = document.getElementById('main-nav');
const scrollProgressBar = document.getElementById('scroll-progress');

window.addEventListener('scroll', () => {
  const currentScrollY = window.scrollY;
  const docHeight = document.documentElement.scrollHeight - window.innerHeight;
  const progressPercent = docHeight > 0 ? (currentScrollY / docHeight) * 100 : 0;
  
  if (scrollProgressBar) {
    scrollProgressBar.style.width = `${progressPercent}%`;
  }

  if (mainNav) {
    if (currentScrollY > 60 && currentScrollY > lastScrollY) {
      mainNav.style.transform = 'translateY(-100%)';
    } else {
      mainNav.style.transform = 'translateY(0)';
    }
  }
  lastScrollY = currentScrollY;
}, { passive: true });

// Mobile Menu
const mobileMenu = document.getElementById('mobile-menu');
window.toggleMobileMenu = function() {
  if (mobileMenu) {
    const isVisible = mobileMenu.style.display === 'flex';
    mobileMenu.style.display = isVisible ? 'none' : 'flex';
  }
};

document.addEventListener('click', (e) => {
  if (mobileMenu && mobileMenu.style.display === 'flex') {
    const hamburger = document.getElementById('hamburger-btn');
    if (!mobileMenu.contains(e.target) && hamburger && !hamburger.contains(e.target)) {
      mobileMenu.style.display = 'none';
    }
  }
});

// Cycling words
const cyclingWords = ['fast', 'lowest-fare', 'reliable', 'hassle-free', 'secured'];
let cycleWordIdx = 0;
const cyclingWordEl = document.getElementById('cycling-word');
if (cyclingWordEl) {
  setInterval(() => {
    cyclingWordEl.style.opacity = 0;
    setTimeout(() => {
      cycleWordIdx = (cycleWordIdx + 1) % cyclingWords.length;
      cyclingWordEl.textContent = cyclingWords[cycleWordIdx];
      cyclingWordEl.style.opacity = 1;
    }, 300);
  }, 4000);
}

// Logo ticker
const tickerTrack = document.getElementById('ticker-track');
if (tickerTrack) {
  const logos = ['Kedarnath Tour', 'Chardham Yatra', 'Kashmir Escape', 'Goa Beach Resort', 'Kerala Houseboat', 'Leh Himalayan Camp'];
  let html = '';
  for (let cycle = 0; cycle < 3; cycle++) {
    logos.forEach(logo => {
      html += `<span class="ticker-item font-primary fs-11 fw-medium uppercase ls-1 text-muted" style="margin: 0 28px; white-space: nowrap; display: inline-block;">✦ &nbsp; ${logo}</span>`;
    });
  }
  tickerTrack.innerHTML = html;
}

// Stats Counter
const statsSection = document.getElementById('stats-grid');
if (statsSection) {
  const statsElements = statsSection.querySelectorAll('.text-stat[data-count]');
  let started = false;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !started) {
        started = true;
        statsElements.forEach(el => {
          const target = parseInt(el.getAttribute('data-count'), 10);
          const suffix = el.getAttribute('data-suffix') || '';
          let current = 0;
          const duration = 2000;
          const stepTime = Math.max(Math.floor(duration / target), 15);
          
          const timer = setInterval(() => {
            current += Math.ceil(target / (duration / stepTime));
            if (current >= target) {
              current = target;
              clearInterval(timer);
            }
            el.textContent = `${current}${suffix}`;
          }, stepTime);
        });
      }
    });
  }, { threshold: 0.1 });
  
  observer.observe(statsSection);
}

// Reveal
const revealElements = document.querySelectorAll('.reveal, .reveal-scale, .reveal-d1, .reveal-d2, .reveal-d3, .reveal-d4');
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.05, rootMargin: '0px 0px -40px 0px' });
revealElements.forEach(el => revealObserver.observe(el));

// Destinations
const destPillsContainer = document.getElementById('dest-pills');
const destScrollRow = document.getElementById('dest-scroll-row');
const destDotsContainer = document.getElementById('dest-dots');
const destDetailPanel = document.getElementById('dest-detail');

let destActiveFilter = 'All';
let destExpandedId = null;

const DIFFICULTY_LABEL = {
  Easy: '●',
  Moderate: '●●',
  Challenging: '●●●',
  Expedition: '●●●●'
};

function renderDestinations() {
  if (!destScrollRow) return;

  const filtered = destActiveFilter === 'All' 
    ? DESTINATIONS 
    : DESTINATIONS.filter(d => d.tags.some(t => t.toLowerCase().includes(destActiveFilter.toLowerCase())));

  const promoCardHtml = `
    <div style="width: 140px; height: 380px; border-radius: var(--radius-xl); flex-shrink: 0; background: var(--color-highlighter-lime); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; border: 1px solid var(--color-zinc-hairline);">
      <div style="font-size: 36px;">🇮🇳</div>
      <p class="font-primary text-xs fw-medium ls-2 uppercase text-center lh-16" style="color: var(--color-onyx-black);">Incredible<br />India</p>
    </div>
  `;

  const cardsHtml = filtered.map(d => {
    const diffDots = DIFFICULTY_LABEL[d.difficulty] || '●';
    const firstSeason = d.bestSeason.split(',')[0];
    return `
      <div
        class="portfolio-tile"
        style="width: 300px; height: 380px; cursor: pointer; flex-shrink:0"
        data-id="${d.id}"
      >
        <img class="tile-img" src="${d.imagePath}" alt="${d.name}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;" />
        <div style="position: absolute; inset: 0; background: var(--gradient-visual-overlay);"></div>

        <div style="position: absolute; top: 12px; left: 12px; right: 12px; display: flex; justify-content: space-between; align-items: center;">
          <span class="font-primary fs-9" style="color: var(--color-white-80); padding: 3px 7px; border: 1px solid var(--color-white-20); border-radius: var(--radius-full); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">
            ${firstSeason}
          </span>
          <span class="font-primary fs-9 fw-medium" style="color: var(--color-onyx-black); background: var(--color-highlighter-lime); padding: 3px 7px; border-radius: var(--radius-full);">
            ${diffDots}
          </span>
        </div>

        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 16px;">
          <p class="font-primary fs-9 fw-medium uppercase ls-1 text-muted" style="margin-bottom: 4px;">${d.region}</p>
          <h3 class="font-secondary fw-regular fs-18 lh-12" style="color: var(--color-pure-white); margin-bottom: 4px;">${d.name}</h3>
          <p class="font-primary fs-11 lh-14" style="color: var(--color-white-60); margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${d.tagline}</p>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="font-primary fs-11 text-muted">${d.duration}</span>
            <span class="font-primary fs-13 fw-medium" style="color: var(--color-highlighter-lime);">${d.startingFrom}</span>
          </div>
        </div>
      </div>
    `;
  }).join('');

  destScrollRow.innerHTML = promoCardHtml + cardsHtml;

  // Add click handlers
  destScrollRow.querySelectorAll('.portfolio-tile').forEach(card => {
    card.addEventListener('click', () => {
      const id = card.getAttribute('data-id');
      toggleDestDetail(id);
    });
  });

  // Render dots
  renderDestDots(filtered.length);
}

function renderDestDots(count) {
  if (!destDotsContainer) return;
  destDotsContainer.innerHTML = Array.from({ length: count + 1 }).map((_, i) => `
    <span class="scroll-dot" data-idx="${i}" style="transition:all 0.25s ease"></span>
  `).join('');

  // Highlight first dot
  const dots = destDotsContainer.querySelectorAll('.scroll-dot');
  if (dots.length > 0) dots[0].classList.add('active');

  // Dot click events to scroll
  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      const idx = parseInt(dot.getAttribute('data-idx'), 10);
      if (!destScrollRow) return;
      const maxScroll = destScrollRow.scrollWidth - destScrollRow.clientWidth;
      destScrollRow.scrollTo({ left: (idx / count) * maxScroll, behavior: 'smooth' });
      dots.forEach(d => d.classList.remove('active'));
      dot.classList.add('active');
    });
  });
}

window.scrollDestinations = function(dir) {
  if (destScrollRow) {
    destScrollRow.scrollBy({ left: dir === 'left' ? -320 : 320, behavior: 'smooth' });
  }
};

window.toggleDestDetail = function(id) {
  if (destExpandedId === id) {
    destExpandedId = null;
    if (destDetailPanel) destDetailPanel.style.display = 'none';
    return;
  }
  
  destExpandedId = id;
  const d = DESTINATIONS.find(item => item.id === id);
  if (!d) return;

  // Fill in detail panel details
  document.getElementById('dest-detail-region').textContent = d.region;
  document.getElementById('dest-detail-difficulty').textContent = d.difficulty;
  document.getElementById('dest-detail-title').textContent = d.name + ' Expedition';
  document.getElementById('dest-detail-tagline').textContent = d.tagline;
  document.getElementById('dest-detail-duration').textContent = d.duration;
  document.getElementById('dest-detail-groupsize').textContent = d.groupSize;
  document.getElementById('dest-detail-bestseason').textContent = d.bestSeason;
  document.getElementById('dest-detail-startingfrom').textContent = d.startingFrom;
  document.getElementById('dest-detail-img').src = d.imagePath;
  document.getElementById('dest-detail-img').alt = d.name;

  // Populate highlights
  document.getElementById('dest-detail-highlights').innerHTML = d.highlights.map(h => `
    <div style="display:flex; gap:8px; align-items:flex-start">
      <span style="color:var(--color-highlighter-lime); font-size:10px; margin-top:2px; flex-shrink:0">✦</span>
      <span class="font-primary fs-13 text-muted">${h}</span>
    </div>
  `).join('');

  // Populate includes
  document.getElementById('dest-detail-includes').innerHTML = d.includes.map(inc => `
    <div style="display:flex; gap:8px; align-items:center; padding:8px 10px; background:var(--color-carbon); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-md); transition:all 0.18s ease"
      onmouseenter="this.style.borderColor='var(--color-highlighter-lime)'"
      onmouseleave="this.style.borderColor='var(--color-zinc-hairline)'">
      <span style="color:var(--color-highlighter-lime); fontSize:10px; flex-shrink:0">✦</span>
      <span class="font-primary text-sm text-muted">${inc}</span>
    </div>
  `).join('');

  if (destDetailPanel) {
    destDetailPanel.style.display = 'block';
    destDetailPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
}

const FILTERS = ['All', 'Spiritual', 'Adventure', 'Luxury', 'Wellness', 'Heritage'];
if (destPillsContainer) {
  destPillsContainer.innerHTML = FILTERS.map(f => `
    <button class="pill ${f === 'All' ? 'active' : ''}" data-filter="${f}">${f}</button>
  `).join('');

  destPillsContainer.querySelectorAll('.pill').forEach(btn => {
    btn.addEventListener('click', () => {
      destPillsContainer.querySelectorAll('.pill').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      destActiveFilter = btn.getAttribute('data-filter');
      renderDestinations();
      if (destDetailPanel) destDetailPanel.style.display = 'none';
      destExpandedId = null;
    });
  });
}

let isDestDragging = false;
let destStartX, destScrollLeft;
if (destScrollRow) {
  destScrollRow.addEventListener('mousedown', (e) => {
    isDestDragging = true;
    destStartX = e.pageX - destScrollRow.offsetLeft;
    destScrollLeft = destScrollRow.scrollLeft;
  });
  destScrollRow.addEventListener('mouseleave', () => { isDestDragging = false; });
  destScrollRow.addEventListener('mouseup', () => { isDestDragging = false; });
  destScrollRow.addEventListener('mousemove', (e) => {
    if (!isDestDragging) return;
    e.preventDefault();
    const x = e.pageX - destScrollRow.offsetLeft;
    const walk = (x - destStartX) * 1.5;
    destScrollRow.scrollLeft = destScrollLeft - walk;
  });

  destScrollRow.addEventListener('scroll', () => {
    const dots = destDotsContainer ? destDotsContainer.querySelectorAll('.scroll-dot') : [];
    if (dots.length === 0) return;
    const maxScroll = destScrollRow.scrollWidth - destScrollRow.clientWidth;
    const ratio = destScrollRow.scrollLeft / (maxScroll || 1);
    const activeIdx = Math.min(Math.round(ratio * (dots.length - 1)), dots.length - 1);
    dots.forEach((d, idx) => {
      if (idx === activeIdx) {
        d.classList.add('active');
      } else {
        d.classList.remove('active');
      }
    });
  }, { passive: true });
}
renderDestinations();

// Ticket Booking
const ticketRoot = document.getElementById('ticket-booking-container');
let ticketActiveTab = 'flight';
let ticketIsRoundTrip = true;
let ticketCaptchaSvg = '';
let ticketCaptchaToken = '';
let ticketIsSubmitted = false;

let fromQuery = '';
let toQuery = '';
let fromSuggestions = [];
let toSuggestions = [];
let showFromDropdown = false;
let showToDropdown = false;

async function fetchTicketCaptcha() {
  try {
    const res = await fetch('/api/captcha');
    if (res.ok) {
      const data = await res.json();
      ticketCaptchaSvg = data.svg;
      ticketCaptchaToken = data.token;
      renderTicketBooking();
    }
  } catch (err) {
    console.error('CAPTCHA load error', err);
  }
}

function renderTicketBooking() {
  if (!ticketRoot) return;

  if (ticketIsSubmitted) {
    ticketRoot.innerHTML = `
      <div style="background:var(--color-carbon); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); padding:40px; text-align:center;">
        <div style="width:48px; height:48px; border-radius:50%; background:var(--color-highlighter-lime); display:flex; align-items:center; justify-content:center; color:var(--color-onyx-black); margin:0 auto 20px">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 class="font-secondary fs-20" style="color:var(--color-pure-white); margin-bottom:8px">Ticket Inquiry Received!</h3>
        <p class="font-primary text-sm text-muted" style="margin-bottom:24px">We are checking live seats. Opening WhatsApp details...</p>
        <button class="btn-primary" onclick="openTicketWhatsApp()">Open WhatsApp Manually</button>
      </div>
    `;
    return;
  }

  const activeClassOptions = TICKETS_CLASS_OPTIONS[ticketActiveTab];

  ticketRoot.innerHTML = `
    <div class="travelgo-card">
      <div class="travelgo-card-header" style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-zinc-hairline); padding:16px 24px">
        <h3 class="font-secondary fs-15 fw-medium" style="color:var(--color-pure-white)">Book Transit</h3>
        <div class="travelgo-tabs-grid" style="display:flex; gap:4px">
          <button class="travelgo-tab-btn ${ticketActiveTab === 'flight' ? 'active' : ''}" onclick="setTicketTab('flight')">✈️ Flights</button>
          <button class="travelgo-tab-btn ${ticketActiveTab === 'train' ? 'active' : ''}" onclick="setTicketTab('train')">🚆 Trains</button>
          <button class="travelgo-tab-btn ${ticketActiveTab === 'bus' ? 'active' : ''}" onclick="setTicketTab('bus')">🚌 Buses</button>
          <button class="travelgo-tab-btn ${ticketActiveTab === 'cruise' ? 'active' : ''}" onclick="setTicketTab('cruise')">🚢 Cruises</button>
        </div>
      </div>

      <form id="ticket-booking-form" style="padding:24px" onsubmit="handleTicketSubmit(event)">
        <div style="display:flex; align-items:center; gap:24px; margin-bottom:20px">
          <span class="font-primary text-xs text-muted">Trip Type</span>
          <div style="display:flex; gap:4px">
            <button type="button" class="pill ${ticketIsRoundTrip ? 'active' : ''}" onclick="setTicketRoundTrip(true)">Round Trip</button>
            <button type="button" class="pill ${!ticketIsRoundTrip ? 'active' : ''}" onclick="setTicketRoundTrip(false)">One Way</button>
          </div>
        </div>

        <div class="booking-grid" style="display:grid; grid-template-columns:repeat(2, 1fr); gap:16px; margin-bottom:20px">
          <div style="position:relative">
            <label class="text-field-label">From</label>
            <input type="text" id="ticket-from" class="input-terminal" placeholder="Departure station or city" value="${fromQuery}" oninput="handleFromInput(this.value)" onfocus="showFromDropdownList()" onblur="hideFromDropdownList()" required>
            ${showFromDropdown && fromSuggestions.length > 0 ? `
              <div class="autocomplete-dropdown" style="position:absolute; top:100%; left:0; right:0; background:#121212; border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-md); z-index:500; max-height:200px; overflow-y:auto">
                ${fromSuggestions.map(c => `
                  <div class="autocomplete-item" onclick="selectFromCity('${c.name} (${c.code})')" style="padding:10px; cursor:pointer; border-bottom:1px solid #1a1a1a" onmouseenter="this.style.background='var(--color-carbon)'" onmouseleave="this.style.background='transparent'">
                    <p class="font-primary text-sm" style="color:#fff">${c.name} (${c.code})</p>
                    <p class="font-primary text-xs text-muted">${c.state}, ${c.country}</p>
                  </div>
                `).join('')}
              </div>
            ` : ''}
          </div>

          <div style="position:relative">
            <label class="text-field-label">To</label>
            <input type="text" id="ticket-to" class="input-terminal" placeholder="Destination station or city" value="${toQuery}" oninput="handleToInput(this.value)" onfocus="showToDropdownList()" onblur="hideToDropdownList()" required>
            ${showToDropdown && toSuggestions.length > 0 ? `
              <div class="autocomplete-dropdown" style="position:absolute; top:100%; left:0; right:0; background:#121212; border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-md); z-index:500; max-height:200px; overflow-y:auto">
                ${toSuggestions.map(c => `
                  <div class="autocomplete-item" onclick="selectToCity('${c.name} (${c.code})')" style="padding:10px; cursor:pointer; border-bottom:1px solid #1a1a1a" onmouseenter="this.style.background='var(--color-carbon)'" onmouseleave="this.style.background='transparent'">
                    <p class="font-primary text-sm" style="color:#fff">${c.name} (${c.code})</p>
                    <p class="font-primary text-xs text-muted">${c.state}, ${c.country}</p>
                  </div>
                `).join('')}
              </div>
            ` : ''}
          </div>

          <div>
            <label class="text-field-label">Departure Date</label>
            <input type="date" id="ticket-date" class="input-terminal" required>
          </div>

          <div>
            <label class="text-field-label">Return Date</label>
            <input type="date" id="ticket-return-date" class="input-terminal" ${!ticketIsRoundTrip ? 'disabled' : 'required'}>
          </div>

          <div>
            <label class="text-field-label">Passengers</label>
            <select id="ticket-passengers" class="input-terminal">
              <option value="1">1 Passenger</option>
              <option value="2">2 Passengers</option>
              <option value="3">3 Passengers</option>
              <option value="4">4 Passengers</option>
              <option value="5">5+ Passengers</option>
            </select>
          </div>

          <div>
            <label class="text-field-label">Class</label>
            <select id="ticket-class" class="input-terminal">
              ${activeClassOptions.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
            </select>
          </div>

          <div class="span-2">
            <label class="text-field-label">WhatsApp Number</label>
            <input type="tel" id="ticket-phone" class="input-terminal" placeholder="e.g. +91 98765 43210" required>
          </div>
        </div>

        <div style="margin-bottom:24px">
          <label class="text-field-label">Security Verification (CAPTCHA)</label>
          <div style="display:flex; gap:12px; align-items:center">
            ${ticketCaptchaSvg ? `
              <div style="display:flex; border-radius:4px; overflow:hidden">${ticketCaptchaSvg}</div>
            ` : `
              <div style="width:140px; height:44px; background:#121212; display:flex; align-items:center; justify-content:center; font-size:11px; color:#666">Loading CAPTCHA...</div>
            `}
            <button type="button" class="btn-ghost" style="width:38px; height:38px; padding:0; display:flex; align-items:center; justify-content:center" onclick="fetchTicketCaptcha()">🔄</button>
            <input type="text" id="ticket-captcha-input" class="input-terminal" placeholder="Enter code" style="max-width:160px" required>
          </div>
          <p id="ticket-captcha-error" style="color:#ff4444; font-size:12px; margin-top:6px; display:none"></p>
        </div>

        <button type="submit" class="btn-primary" style="width:100%; justify-content:center">Submit Booking &amp; Open WhatsApp →</button>
      </form>
    </div>
  `;
}

window.setTicketTab = function(tab) {
  ticketActiveTab = tab;
  renderTicketBooking();
};
window.setTicketRoundTrip = function(val) {
  ticketIsRoundTrip = val;
  renderTicketBooking();
};
window.handleFromInput = function(val) {
  fromQuery = val;
  if (val.length >= 2) {
    const clean = val.toLowerCase();
    fromSuggestions = FALLBACK_CITIES.filter(c => c.name.toLowerCase().includes(clean) || c.code.toLowerCase().includes(clean));
  } else {
    fromSuggestions = [];
  }
  renderTicketBooking();
};
window.handleToInput = function(val) {
  toQuery = val;
  if (val.length >= 2) {
    const clean = val.toLowerCase();
    toSuggestions = FALLBACK_CITIES.filter(c => c.name.toLowerCase().includes(clean) || c.code.toLowerCase().includes(clean));
  } else {
    toSuggestions = [];
  }
  renderTicketBooking();
};
window.showFromDropdownList = function() { showFromDropdown = true; renderTicketBooking(); };
window.hideFromDropdownList = function() { setTimeout(() => { showFromDropdown = false; renderTicketBooking(); }, 300); };
window.showToDropdownList = function() { showToDropdown = true; renderTicketBooking(); };
window.hideToDropdownList = function() { setTimeout(() => { showToDropdown = false; renderTicketBooking(); }, 300); };
window.selectFromCity = function(nameCode) { fromQuery = nameCode; fromSuggestions = []; renderTicketBooking(); };
window.selectToCity = function(nameCode) { toQuery = nameCode; toSuggestions = []; renderTicketBooking(); };

window.handleTicketSubmit = async function(e) {
  e.preventDefault();
  const errorEl = document.getElementById('ticket-captcha-error');
  if (errorEl) errorEl.style.display = 'none';

  const phone = document.getElementById('ticket-phone').value;
  const date = document.getElementById('ticket-date').value;
  const returnDate = document.getElementById('ticket-return-date') ? document.getElementById('ticket-return-date').value : null;
  const passengers = document.getElementById('ticket-passengers').value;
  const classType = document.getElementById('ticket-class').value;
  const captchaInput = document.getElementById('ticket-captcha-input').value;

  try {
    const res = await fetch('/api/admin/bookings', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        customerName: 'Guest Traveller',
        customerPhone: phone,
        fromCity: fromQuery,
        toCity: toQuery,
        travelType: ticketActiveTab,
        date: date,
        returnDate: ticketIsRoundTrip ? returnDate : null,
        passengers: parseInt(passengers, 10),
        classType: classType,
        amount: 0,
        status: 'pending',
        notes: `Web Ticket Booking Inquiry`,
        isPublicInquiry: true,
        captchaToken: ticketCaptchaToken,
        captchaInput: captchaInput,
      })
    });

    if (!res.ok) {
      const data = await res.json();
      if (errorEl) {
        errorEl.textContent = data.error || 'CAPTCHA verification failed.';
        errorEl.style.display = 'block';
      }
      fetchTicketCaptcha();
      return;
    }

    ticketIsSubmitted = true;
    renderTicketBooking();
    setTimeout(() => { openTicketWhatsApp(); }, 800);
  } catch (err) {
    console.error('Server DB submit failed, direct handoff to WhatsApp', err);
    openTicketWhatsApp();
  }
};

window.openTicketWhatsApp = function() {
  const emojiMap = { flight: '✈️ Flight', bus: '🚌 Bus', train: '🚆 Train', cruise: '🚢 Cruise' };
  const text = `Hello Shivalay Travels! I would like to book a *${emojiMap[ticketActiveTab]} Ticket*:\n\n` +
    `📍 *From:* ${fromQuery || 'Not specified'}\n` +
    `📍 *To:* ${toQuery || 'Not specified'}\n` +
    `📅 *Departure:* ${document.getElementById('ticket-date') ? document.getElementById('ticket-date').value : ''}\n` +
    (ticketIsRoundTrip && document.getElementById('ticket-return-date') ? `📅 *Return:* ${document.getElementById('ticket-return-date').value}\n` : '') +
    `👥 *Passengers:* ${document.getElementById('ticket-passengers') ? document.getElementById('ticket-passengers').value : '1'}\n` +
    `✨ *Class:* ${document.getElementById('ticket-class') ? document.getElementById('ticket-class').value : ''}\n\n` +
    `Please share the best available rates. Thanks!`;
  
  window.open(`https://wa.me/919340994628?text=${encodeURIComponent(text)}`, '_blank');
};
fetchTicketCaptcha();

// FAQ Accordeon
const faqItems = document.querySelectorAll('.faq-item');
faqItems.forEach(item => {
  const btn = item.querySelector('.faq-btn');
  const content = item.querySelector('.faq-content');
  const arrow = item.querySelector('.faq-arrow');
  if (btn && content && arrow) {
    btn.addEventListener('click', () => {
      const isOpen = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';
      faqItems.forEach(x => {
        const c = x.querySelector('.faq-content');
        const a = x.querySelector('.faq-arrow');
        const b = x.querySelector('.faq-btn');
        if (c) c.style.maxHeight = '0px';
        if (a) a.style.transform = 'none';
        if (b) b.classList.remove('active');
      });
      if (!isOpen) {
        content.style.maxHeight = '200px';
        arrow.style.transform = 'rotate(180deg)';
        btn.classList.add('active');
      } else {
        content.style.maxHeight = '0px';
        arrow.style.transform = 'none';
        btn.classList.remove('active');
      }
    });
  }
});

// Itinerary Days
const itineraryDays = document.querySelectorAll('.itinerary-day');
itineraryDays.forEach(day => {
  const header = day.querySelector('.itinerary-day-header');
  const content = day.querySelector('.itinerary-day-content');
  const arrow = day.querySelector('.itinerary-day-arrow');
  const num = day.querySelector('.day-num');
  if (header && content && arrow) {
    header.addEventListener('click', () => {
      const isOpen = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';
      itineraryDays.forEach(x => {
        const c = x.querySelector('.itinerary-day-content');
        const a = x.querySelector('.itinerary-day-arrow');
        const n = x.querySelector('.day-num');
        if (c) c.style.maxHeight = '0px';
        if (a) a.style.transform = 'none';
        if (n) n.style.background = 'var(--color-carbon)';
      });
      if (!isOpen) {
        content.style.maxHeight = '120px';
        arrow.style.transform = 'rotate(180deg)';
        if (num) num.style.background = 'var(--color-highlighter-lime)';
      } else {
        content.style.maxHeight = '0px';
        arrow.style.transform = 'none';
        if (num) num.style.background = 'var(--color-carbon)';
      }
    });
  }
});

// Memories Testimonial Carousel
const testQuote = document.getElementById('testimonial-quote');
const testDest = document.getElementById('testimonial-dest');
const testAvatar = document.getElementById('testimonial-avatar');
const testName = document.getElementById('testimonial-name');
const testMeta = document.getElementById('testimonial-meta');
const testCard = document.getElementById('testimonial-card');
const testSidebar = document.getElementById('testimonial-sidebar');
const testDots = document.getElementById('testimonial-dots');

let testActiveIdx = 0;
let testTimer = null;

function renderTestimonial() {
  const t = TESTIMONIALS[testActiveIdx];
  if (!t) return;

  if (testCard) {
    testCard.style.opacity = 0;
    testCard.style.transform = 'translateY(4px)';
    setTimeout(() => {
      if (testQuote) testQuote.textContent = `“${t.quote}”`;
      if (testDest) testDest.textContent = t.destination;
      if (testAvatar) testAvatar.textContent = t.avatar;
      if (testName) testName.textContent = t.name;
      if (testMeta) testMeta.textContent = `${t.location} · ${t.trip}`;
      
      const ratingContainer = document.getElementById('testimonial-rating');
      if (ratingContainer) {
        ratingContainer.innerHTML = Array.from({ length: t.rating }).map(() => `
          <span style="color:var(--color-highlighter-lime); font-size:12px">★</span>
        `).join('');
      }
      testCard.style.opacity = 1;
      testCard.style.transform = 'translateY(0)';
    }, 180);
  }

  if (testSidebar) {
    const btns = testSidebar.querySelectorAll('button');
    btns.forEach((btn, i) => {
      const avatarEl = btn.querySelector('.test-sidebar-avatar');
      const nameEl = btn.querySelector('.test-sidebar-name');
      if (i === testActiveIdx) {
        btn.style.background = 'var(--color-carbon)';
        btn.style.borderColor = 'var(--color-zinc-hairline)';
        if (avatarEl) { avatarEl.style.background = 'var(--color-highlighter-lime)'; avatarEl.style.color = 'var(--color-onyx-black)'; }
        if (nameEl) nameEl.style.color = 'var(--color-pure-white)';
      } else {
        btn.style.background = 'transparent';
        btn.style.borderColor = 'transparent';
        if (avatarEl) { avatarEl.style.background = 'var(--color-zinc-hairline)'; avatarEl.style.color = 'var(--color-steel-gray)'; }
        if (nameEl) nameEl.style.color = 'var(--color-steel-gray)';
      }
    });
  }

  if (testDots) {
    const dots = testDots.querySelectorAll('button');
    dots.forEach((dot, i) => {
      if (i === testActiveIdx) {
        dot.style.width = '20px';
        dot.style.background = 'var(--color-highlighter-lime)';
      } else {
        dot.style.width = '6px';
        dot.style.background = 'var(--color-zinc-hairline)';
      }
    });
  }
}

function startTestimonialTimer() {
  if (testTimer) clearInterval(testTimer);
  testTimer = setInterval(() => {
    testActiveIdx = (testActiveIdx + 1) % TESTIMONIALS.length;
    renderTestimonial();
  }, 7000);
}
function stopTestimonialTimer() { if (testTimer) clearInterval(testTimer); }

if (testSidebar) {
  testSidebar.innerHTML = TESTIMONIALS.map((item, idx) => `
    <button onclick="setTestimonial(${idx})" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:var(--radius-xl); background:transparent; border:1px solid transparent; cursor:pointer; text-align:left; transition:all 0.18s ease; width:100%">
      <div class="test-sidebar-avatar font-primary fs-11 fw-medium" style="width:32px; height:32px; border-radius:var(--radius-md); flex-shrink:0; background:var(--color-zinc-hairline); display:flex; align-items:center; justify-content:center; color:var(--color-steel-gray); transition:all 0.18s ease">${item.avatar}</div>
      <div style="flex:1; min-width:0">
        <p class="test-sidebar-name font-primary fw-medium fs-11" style="color:var(--color-steel-gray); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px">${item.name}</p>
        <p class="font-primary text-xs" style="color:var(--color-ash-gray); white-space:nowrap; overflow:hidden; text-overflow:ellipsis">${item.destination}</p>
      </div>
    </button>
  `).join('');
}
if (testDots) {
  testDots.innerHTML = TESTIMONIALS.map((_, idx) => `
    <button onclick="setTestimonial(${idx})" style="height:6px; border-radius:3px; border:none; cursor:pointer; transition:all 0.25s ease"></button>
  `).join('');
}
window.setTestimonial = function(idx) {
  testActiveIdx = idx;
  renderTestimonial();
  startTestimonialTimer();
};
const prevBtn = document.getElementById('testimonial-prev-btn');
const nextBtn = document.getElementById('testimonial-next-btn');
if (prevBtn) {
  prevBtn.addEventListener('click', () => {
    testActiveIdx = (testActiveIdx - 1 + TESTIMONIALS.length) % TESTIMONIALS.length;
    renderTestimonial();
    startTestimonialTimer();
  });
}
if (nextBtn) {
  nextBtn.addEventListener('click', () => {
    testActiveIdx = (testActiveIdx + 1) % TESTIMONIALS.length;
    renderTestimonial();
    startTestimonialTimer();
  });
}
if (testCard) {
  testCard.addEventListener('mouseenter', stopTestimonialTimer);
  testCard.addEventListener('mouseleave', startTestimonialTimer);
}
renderTestimonial();
startTestimonialTimer();

// Guides
const guidesCategories = document.getElementById('guides-categories');
const guidesList = document.getElementById('guides-list');
let currentGuideCategory = 'All';

function renderGuides() {
  if (!guidesList) return;

  const filtered = currentGuideCategory === 'All'
    ? GUIDES
    : GUIDES.filter(g => g.category === currentGuideCategory);

  guidesList.innerHTML = filtered.map(g => `
    <div class="reveal visible" style="display:flex; flex-direction:column; gap:0; cursor:pointer; overflow:hidden; background:var(--color-onyx-black); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); transition:border-color 0.18s ease" onmouseenter="this.style.borderColor='var(--color-smoke)'" onmouseleave="this.style.borderColor='var(--color-zinc-hairline)'" onclick="smoothScroll('planner')">
      <div class="img-zoom-wrap" style="height:110px; position:relative; overflow:hidden; border-radius:0">
        <img src="${g.image}" alt="${g.category}" style="width:100%; height:100%; object-fit:cover">
        <div style="position:absolute; inset:0; background:var(--gradient-visual-overlay)"></div>
        <div style="position:absolute; bottom:8px; left:12px; display:flex; gap:6px; align-items:center">
          <span style="font-size:13px">${g.icon}</span>
          <span class="font-primary fs-9 fw-medium uppercase ls-1" style="color:var(--color-white-80)">${g.category}</span>
        </div>
        ${g.badge ? `<span class="font-primary fs-9 fw-medium" style="position:absolute; top:8px; right:10px; color:var(--color-onyx-black); background:var(--color-highlighter-lime); padding:2px 6px; border-radius:var(--radius-full)">${g.badge}</span>` : ''}
      </div>
      <div style="display:flex; flex-direction:column; gap:10px; padding:14px 16px; flex:1">
        <p class="font-primary fw-medium text-sm lh-15" style="color:var(--color-pure-white); flex:1">${g.title}</p>
        <div style="display:flex; justify-content:space-between; align-items:center">
          <span class="font-primary fs-11 text-muted">${g.readTime}</span>
          <div class="font-primary fs-11" style="display:flex; align-items:center; gap:3px; color:var(--color-highlighter-lime)">
            Read guide
            <svg width="11" height="11" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
      </div>
    </div>
  `).join('');
}

const CATEGORIES_LIST = ['All', 'Packing Guide', 'Destination Intel', 'Health & Safety', 'Culture'];
if (guidesCategories) {
  guidesCategories.innerHTML = CATEGORIES_LIST.map(c => `
    <button class="pill ${c === 'All' ? 'active' : ''}" data-cat="${c}">${c}</button>
  `).join('');
  guidesCategories.querySelectorAll('.pill').forEach(btn => {
    btn.addEventListener('click', () => {
      guidesCategories.querySelectorAll('.pill').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentGuideCategory = btn.getAttribute('data-cat');
      renderGuides();
    });
  });
}
renderGuides();

// Journey Planner
const plannerRoot = document.getElementById('journey-planner-root');
let plannerStep = 0;
let plannerAnswers = {};
let plannerCustomInputs = {};
let plannerCaptchaSvg = '';
let plannerCaptchaToken = '';
let plannerSubmitted = false;

async function fetchPlannerCaptcha() {
  try {
    const res = await fetch('/api/captcha');
    if (res.ok) {
      const data = await res.json();
      plannerCaptchaSvg = data.svg;
      plannerCaptchaToken = data.token;
      renderPlanner();
    }
  } catch (err) {
    console.error('Planner CAPTCHA load error', err);
  }
}

function renderPlanner() {
  if (!plannerRoot) return;

  const current = PLANNER_STEPS[plannerStep];
  const progress = Math.round((plannerStep / (PLANNER_STEPS.length - 1)) * 100);
  const isLastStep = plannerStep === PLANNER_STEPS.length - 1;
  const isNotesStep = current.id === 'notes';

  plannerRoot.innerHTML = `
    <div class="planner-sidebar">
      <p class="section-label" style="margin-bottom:8px">Journey Planner</p>
      <h2 class="heading-md" style="margin-bottom:8px">Build your perfect private escape.</h2>
      <p class="font-primary text-sm lh-16 text-muted" style="margin-bottom:24px">
        ${PLANNER_STEPS.length} steps to your dream itinerary. Every field is fully customisable.
      </p>
      <div style="display:flex; flex-direction:column; gap:2px">
        ${PLANNER_STEPS.map((s, i) => {
          const isActive = plannerStep === i;
          const isDone = i < plannerStep;
          return `
            <button type="button" onclick="setPlannerStep(${i})" style="display:flex; align-items:center; gap:10px; padding:8px 12px; background:${isActive ? 'var(--color-lime-07)' : 'transparent'}; border:1px solid ${isActive ? 'var(--color-lime-25)' : 'transparent'}; border-radius:var(--radius-md); cursor:${i <= plannerStep ? 'pointer' : 'default'}; text-align:left; width:100%; transition:all 0.18s ease">
              <div style="width:20px; height:20px; border-radius:var(--radius-md); flex-shrink:0; display:flex; align-items:center; justify-content:center; background:${isDone ? 'var(--color-highlighter-lime)' : isActive ? 'var(--color-lime-20)' : 'var(--color-zinc-hairline)'}; transition:background 0.18s ease">
                ${isDone ? `
                  <svg width="9" height="9" viewBox="0 0 10 10" fill="none"><path d="M2 5L4 7L8 3" stroke="var(--color-onyx-black)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                ` : `
                  <span class="font-primary fs-8 fw-medium" style="color:${isActive ? 'var(--color-highlighter-lime)' : 'var(--color-ash-gray)'}">${i + 1}</span>
                `}
              </div>
              <span class="font-primary fs-11 ${isActive ? 'fw-medium' : 'fw-regular'}" style="color:${isActive ? 'var(--color-pure-white)' : isDone ? 'var(--color-steel-gray)' : 'var(--color-ash-gray)'}; flex:1">
                ${s.label}
              </span>
              ${plannerAnswers[s.id] ? `
                <span class="font-primary fs-9" style="color:var(--color-highlighter-lime); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:64px">${plannerAnswers[s.id]}</span>
              ` : ''}
            </button>
          `;
        }).join('')}
      </div>
    </div>

    <div style="background:var(--color-carbon); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); padding:32px; min-height:480px; display:flex; flex-direction:column">
      ${plannerSubmitted ? `
        <div style="display:flex; flex-direction:column; align-items:flex-start; gap:20px; animation:scaleIn 0.5s var(--ease-spring) both">
          <div style="width:48px; height:48px; border-radius:var(--radius-md); background:var(--color-highlighter-lime); display:flex; align-items:center; justify-content:center; color:var(--color-onyx-black)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div>
            <h3 class="font-secondary fs-24 fw-regular lh-13" style="color:var(--color-pure-white); margin-bottom:8px">Your Journey Brief is On Its Way! 🎉</h3>
            <p class="font-primary fs-13 lh-16 text-muted" style="max-width:400px">Our travel specialist will contact you within 2 hours with a personalised draft itinerary based on your selections.</p>
          </div>
          <div style="display:flex; gap:10px; flex-wrap:wrap">
            <button class="btn-primary" onclick="openPlannerWhatsApp()">WhatsApp Planner Now</button>
            <a href="mailto:info@shivalaytravels.com" class="btn-ghost" style="text-decoration:none">Send Email</a>
          </div>
        </div>
      ` : `
        <div style="margin-bottom:28px">
          <div style="display:flex; justify-content:space-between; margin-bottom:8px">
            <span class="font-primary fs-11" style="color:var(--color-ash-gray)">Step ${plannerStep + 1} of ${PLANNER_STEPS.length}</span>
            <span class="font-primary fs-11 fw-medium" style="color:var(--color-highlighter-lime)">${progress}%</span>
          </div>
          <div style="height:3px; background:var(--color-zinc-hairline); border-radius:3px; overflow:hidden">
            <div style="height:100%; width:${progress}%; background:var(--color-highlighter-lime); border-radius:3px; transition:width 0.5s var(--ease-out)"></div>
          </div>
        </div>

        <div style="flex:1; display:flex; flex-direction:column">
          <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px">
            <span style="font-size:20px">${current.icon}</span>
            <h3 class="fs-planner-q" style="color:var(--color-pure-white); font-size:18px">${current.question}</h3>
          </div>
          ${current.subtext ? `<p class="font-primary text-sm lh-15 text-muted" style="margin-bottom:20px; margin-left:30px">${current.subtext}</p>` : ''}

          ${current.options.length > 0 ? `
            <div style="display:flex; flex-wrap:wrap; gap:7px; margin-bottom:24px">
              ${current.options.map(opt => {
                const isSelected = plannerAnswers[current.id] === opt;
                return `
                  <button type="button" class="font-primary text-sm" onclick="selectPlannerOption('${opt}')" style="padding:7px 14px; border-radius:var(--radius-md); border:1px solid ${isSelected ? 'var(--color-highlighter-lime)' : 'var(--color-zinc-hairline)'}; background:${isSelected ? 'var(--color-highlighter-lime)' : 'transparent'}; color:${isSelected ? 'var(--color-onyx-black)' : 'var(--color-steel-gray)'}; cursor:pointer; transition:all 0.18s ease">${opt}</button>
                `;
              }).join('')}
            </div>
          ` : ''}

          ${!isLastStep ? `
            <div style="${current.options.length > 0 ? 'border-top:1px solid var(--color-zinc-hairline); padding-top:18px' : ''}">
              ${current.options.length > 0 ? `<p class="font-primary text-xs fw-medium uppercase ls-05" style="color:var(--color-ash-gray); margin-bottom:10px">Or enter custom details:</p>` : ''}
              <div style="display:flex; gap:8px; align-items:flex-start">
                ${isNotesStep ? `
                  <textarea id="planner-notes-input" class="input-terminal" rows="4" style="resize:vertical; line-height:1.6; flex:1" placeholder="${current.inputPlaceholder || ''}">${plannerCustomInputs[current.id] || ''}</textarea>
                ` : `
                  <input type="text" id="planner-text-input" class="input-terminal" style="flex:1" placeholder="${current.inputPlaceholder || ''}" value="${plannerCustomInputs[current.id] || ''}">
                `}
                <button type="button" class="btn-primary fs-13" style="padding:10px 18px; flex-shrink:0" onclick="submitPlannerCustomValue()">Next →</button>
              </div>
              ${isNotesStep ? `
                <button type="button" class="font-primary text-sm underline" onclick="skipPlannerNotes()" style="margin-top:10px; color:var(--color-ash-gray); background:none; border:none; cursor:pointer; padding:0">Skip this step</button>
              ` : ''}
            </div>
          ` : `
            <form onsubmit="handlePlannerSubmit(event)" style="display:flex; flex-direction:column; gap:14px; max-width:440px">
              <div>
                <label class="text-field-label">Your full name</label>
                <input type="text" id="planner-name" class="input-terminal" placeholder="First &amp; last name" required>
              </div>
              <div>
                <label class="text-field-label">Email address</label>
                <input type="email" id="planner-email" class="input-terminal" placeholder="you@email.com" required>
              </div>
              <div>
                <label class="text-field-label">WhatsApp / Phone (optional)</label>
                <input type="tel" id="planner-phone" class="input-terminal" placeholder="+91 93409 94628">
              </div>

              <div style="background:var(--color-onyx-black); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); padding:14px 16px; display:flex; flex-direction:column; gap:8px">
                <p class="font-primary text-xs fw-medium uppercase ls-05" style="color:var(--color-steel-gray); margin-bottom:4px">Your journey summary</p>
                ${Object.entries(plannerAnswers).map(([k, v]) => {
                  const stepDef = PLANNER_STEPS.find(s => s.id === k);
                  return `
                    <div style="display:flex; justify-content:space-between; gap:16px; align-items:flex-start">
                      <span class="font-primary fs-11" style="color:var(--color-ash-gray); flex-shrink:0">${stepDef ? stepDef.label.replace(/^\d+ — /, '') : k}</span>
                      <span class="font-primary fs-11 fw-medium text-right" style="color:var(--color-pure-white)">${v}</span>
                    </div>
                  `;
                }).join('')}
              </div>

              <div style="display:flex; flex-direction:column; gap:8px; margin-top:4px">
                <label class="text-field-label">Security Verification (CAPTCHA)</label>
                <div style="display:grid; grid-template-columns:auto 1fr; alignItems:center; gap:12px; background:rgba(255,255,255,0.01); border:1px solid rgba(255,255,255,0.05); border-radius:8px; padding:12px">
                  <div style="display:flex; align-items:center; gap:8px">
                    ${plannerCaptchaSvg ? `
                      <div style="display:flex; align-items:center; border-radius:4px; overflow:hidden">${plannerCaptchaSvg}</div>
                    ` : `
                      <div style="width:140px; height:44px; background:#121212; display:flex; align-items:center; justify-content:center; font-size:11px; color:#666">Loading...</div>
                    `}
                    <button type="button" class="btn-ghost" style="width:38px; height:38px; padding:0" onclick="fetchPlannerCaptcha()">🔄</button>
                  </div>
                  <input type="text" id="planner-captcha-input" class="input-terminal" placeholder="Enter CAPTCHA code" style="font-family:monospace; letter-spacing:2px" required>
                </div>
                <p id="planner-captcha-error" style="color:#ff4444; font-size:12px; margin-top:4px; font-weight:500; display:none"></p>
              </div>

              <button type="submit" class="btn-primary fs-13" style="align-self:flex-start">Send My Journey Brief →</button>
            </form>
          `}
        </div>

        ${plannerStep > 0 ? `
          <button type="button" class="font-primary text-sm" onclick="prevPlannerStep()" style="margin-top:20px; background:none; border:none; cursor:pointer; color:var(--color-ash-gray); display:flex; align-items:center; gap:5px; transition:color 0.18s" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">← Back</button>
        ` : ''}
      `}
    </div>
  `;
}

window.setPlannerStep = function(stepIdx) { if (stepIdx <= plannerStep) { plannerStep = stepIdx; renderPlanner(); } };
window.prevPlannerStep = function() { if (plannerStep > 0) { plannerStep--; renderPlanner(); } };
window.selectPlannerOption = function(opt) {
  const current = PLANNER_STEPS[plannerStep];
  plannerAnswers[current.id] = opt;
  plannerCustomInputs[current.id] = '';
  advancePlanner();
};
window.submitPlannerCustomValue = function() {
  const current = PLANNER_STEPS[plannerStep];
  const el = document.getElementById(plannerStep === 7 ? 'planner-notes-input' : 'planner-text-input');
  if (el && el.value.trim()) {
    const val = el.value.trim();
    plannerAnswers[current.id] = val;
    plannerCustomInputs[current.id] = val;
    advancePlanner();
  }
};
window.skipPlannerNotes = function() { plannerAnswers['notes'] = ''; advancePlanner(); };

function advancePlanner() {
  if (plannerStep < PLANNER_STEPS.length - 1) {
    plannerStep++;
    if (plannerStep === PLANNER_STEPS.length - 1) {
      fetchPlannerCaptcha();
    } else {
      renderPlanner();
    }
  }
}

window.handlePlannerSubmit = async function(e) {
  e.preventDefault();
  const errorEl = document.getElementById('planner-captcha-error');
  if (errorEl) errorEl.style.display = 'none';

  const name = document.getElementById('planner-name').value;
  const email = document.getElementById('planner-email').value;
  const phone = document.getElementById('planner-phone').value;
  const captchaInput = document.getElementById('planner-captcha-input').value;

  const summaryLines = Object.entries(plannerAnswers)
    .filter(([, v]) => v)
    .map(([k, v]) => {
      const stepDef = PLANNER_STEPS.find(s => s.id === k);
      const label = stepDef ? stepDef.label.replace(/^\d+ — /, '') : k;
      return `${label}: ${v}`;
    });

  const passengersVal = plannerAnswers['travelers'] || '1';
  let passengersCount = 1;
  const match = passengersVal.match(/\d+/);
  if (match) { passengersCount = parseInt(match[0], 10); }

  try {
    const res = await fetch('/api/admin/inquiries', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        customerName: name,
        customerPhone: phone || 'Not provided',
        customerEmail: email,
        destinations: plannerAnswers['destination'] || 'Custom Pilgrimage',
        duration: plannerAnswers['duration'] || 'Not specified',
        travelers: passengersCount,
        budget: plannerAnswers['budget'] || 'Standard',
        accommodation: plannerAnswers['accommodation'] || 'Standard',
        notes: `Journey Planner Brief:\n${summaryLines.join('\n')}`,
        isPublicInquiry: true,
        captchaToken: plannerCaptchaToken,
        captchaInput: captchaInput,
      })
    });

    if (!res.ok) {
      const data = await res.json();
      if (errorEl) {
        errorEl.textContent = data.error || 'CAPTCHA validation failed.';
        errorEl.style.display = 'block';
      }
      fetchPlannerCaptcha();
      return;
    }

    plannerSubmitted = true;
    renderPlanner();
    setTimeout(() => { openPlannerWhatsApp(name, email, phone, summaryLines); }, 800);
  } catch (err) {
    console.error('Server DB submit failed, direct handoff to WhatsApp', err);
    openPlannerWhatsApp(name, email, phone, summaryLines);
  }
};

window.openPlannerWhatsApp = function(name, email, phone, summaryLines) {
  if (!name) {
    name = document.getElementById('planner-name') ? document.getElementById('planner-name').value : 'Guest';
    email = document.getElementById('planner-email') ? document.getElementById('planner-email').value : '';
    phone = document.getElementById('planner-phone') ? document.getElementById('planner-phone').value : '';
    summaryLines = Object.entries(plannerAnswers)
      .filter(([, v]) => v)
      .map(([k, v]) => {
        const stepDef = PLANNER_STEPS.find(s => s.id === k);
        const label = stepDef ? stepDef.label.replace(/^\d+ — /, '') : k;
        return `${label}: ${v}`;
      });
  }
  const text = `Hello Shivalay Travels! Here is my journey brief:\n\n${summaryLines.join('\n')}\n\n*Name:* ${name}\n*Email:* ${email}\n${phone ? `*Phone:* ${phone}` : ''}`;
  window.open(`https://wa.me/919340994628?text=${encodeURIComponent(text)}`, '_blank');
};
renderPlanner();
