// Shivalay Travels Core Frontend Interactivity Script
// Pure Vanilla JavaScript & Modern ES6 Web APIs

// ────────────────────────────────────────────────────────────────
// 1. GLOBAL STATE & STATICS
// ────────────────────────────────────────────────────────────────

const DESTINATIONS = window.DB_PACKAGES || [];
const GUIDES = window.DB_GUIDES || [];
const TESTIMONIALS = window.DB_TESTIMONIALS || [];

const TICKETS_CLASS_OPTIONS = {
  bus: ['AC Sleeper', 'Non-AC Sleeper', 'AC Seater', 'Luxury Volvo'],
  taxi: ['Sedan (Dzire/Etios)', 'SUV (Ertiga/Tavera)', 'Premium SUV (Innova Crysta)', 'Tempo Traveller'],
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

// Comprehensive Indian cities database for ticket autocomplete
const FALLBACK_CITIES = (window.DB_CITIES && window.DB_CITIES.length > 0) ? window.DB_CITIES : [
  // Major Metros
  { name: 'Mumbai', code: 'BOM', state: 'Maharashtra', country: 'India' },
  { name: 'Delhi', code: 'DEL', state: 'Delhi', country: 'India' },
  { name: 'New Delhi', code: 'NDLS', state: 'Delhi', country: 'India' },
  { name: 'Bangalore', code: 'BLR', state: 'Karnataka', country: 'India' },
  { name: 'Bengaluru', code: 'BLR', state: 'Karnataka', country: 'India' },
  { name: 'Chennai', code: 'MAA', state: 'Tamil Nadu', country: 'India' },
  { name: 'Kolkata', code: 'CCU', state: 'West Bengal', country: 'India' },
  { name: 'Hyderabad', code: 'HYD', state: 'Telangana', country: 'India' },
  { name: 'Pune', code: 'PNQ', state: 'Maharashtra', country: 'India' },
  { name: 'Ahmedabad', code: 'AMD', state: 'Gujarat', country: 'India' },
  // MP & Central India
  { name: 'Indore', code: 'IDR', state: 'Madhya Pradesh', country: 'India' },
  { name: 'Bhopal', code: 'BHO', state: 'Madhya Pradesh', country: 'India' },
  { name: 'Gwalior', code: 'GWL', state: 'Madhya Pradesh', country: 'India' },
  { name: 'Jabalpur', code: 'JLR', state: 'Madhya Pradesh', country: 'India' },
  { name: 'Ujjain', code: 'UJN', state: 'Madhya Pradesh', country: 'India' },
  { name: 'Raipur', code: 'RPR', state: 'Chhattisgarh', country: 'India' },
  { name: 'Nagpur', code: 'NAG', state: 'Maharashtra', country: 'India' },
  // North India
  { name: 'Jaipur', code: 'JAI', state: 'Rajasthan', country: 'India' },
  { name: 'Jodhpur', code: 'JDH', state: 'Rajasthan', country: 'India' },
  { name: 'Udaipur', code: 'UDR', state: 'Rajasthan', country: 'India' },
  { name: 'Ajmer', code: 'AII', state: 'Rajasthan', country: 'India' },
  { name: 'Bikaner', code: 'BKB', state: 'Rajasthan', country: 'India' },
  { name: 'Lucknow', code: 'LKO', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Varanasi', code: 'VNS', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Agra', code: 'AGR', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Prayagraj', code: 'IXD', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Kanpur', code: 'KNU', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Mathura', code: 'MTJ', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Vrindavan', code: 'MTJ', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Ayodhya', code: 'AYJ', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Gorakhpur', code: 'GOP', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Amritsar', code: 'ATQ', state: 'Punjab', country: 'India' },
  { name: 'Chandigarh', code: 'IXC', state: 'Punjab', country: 'India' },
  { name: 'Ludhiana', code: 'LUH', state: 'Punjab', country: 'India' },
  // Pilgrimage & Spiritual
  { name: 'Haridwar', code: 'HRW', state: 'Uttarakhand', country: 'India' },
  { name: 'Rishikesh', code: 'DED', state: 'Uttarakhand', country: 'India' },
  { name: 'Kedarnath', code: 'KTH', state: 'Uttarakhand', country: 'India' },
  { name: 'Badrinath', code: 'BDN', state: 'Uttarakhand', country: 'India' },
  { name: 'Dehradun', code: 'DED', state: 'Uttarakhand', country: 'India' },
  { name: 'Jammu', code: 'IXJ', state: 'Jammu & Kashmir', country: 'India' },
  { name: 'Srinagar', code: 'SXR', state: 'Jammu & Kashmir', country: 'India' },
  { name: 'Leh', code: 'IXL', state: 'Ladakh', country: 'India' },
  { name: 'Tirupati', code: 'TIR', state: 'Andhra Pradesh', country: 'India' },
  { name: 'Shirdi', code: 'SAG', state: 'Maharashtra', country: 'India' },
  { name: 'Nashik', code: 'ISK', state: 'Maharashtra', country: 'India' },
  // South India
  { name: 'Kochi', code: 'COK', state: 'Kerala', country: 'India' },
  { name: 'Thiruvananthapuram', code: 'TRV', state: 'Kerala', country: 'India' },
  { name: 'Kozhikode', code: 'CCJ', state: 'Kerala', country: 'India' },
  { name: 'Madurai', code: 'IXM', state: 'Tamil Nadu', country: 'India' },
  { name: 'Coimbatore', code: 'CJB', state: 'Tamil Nadu', country: 'India' },
  { name: 'Mysuru', code: 'MYQ', state: 'Karnataka', country: 'India' },
  { name: 'Mangalore', code: 'IXE', state: 'Karnataka', country: 'India' },
  { name: 'Vijayawada', code: 'VGA', state: 'Andhra Pradesh', country: 'India' },
  { name: 'Visakhapatnam', code: 'VTZ', state: 'Andhra Pradesh', country: 'India' },
  // East India
  { name: 'Bhubaneswar', code: 'BBI', state: 'Odisha', country: 'India' },
  { name: 'Puri', code: 'PUR', state: 'Odisha', country: 'India' },
  { name: 'Patna', code: 'PAT', state: 'Bihar', country: 'India' },
  { name: 'Gaya', code: 'GAY', state: 'Bihar', country: 'India' },
  { name: 'Ranchi', code: 'IXR', state: 'Jharkhand', country: 'India' },
  { name: 'Guwahati', code: 'GAU', state: 'Assam', country: 'India' },
  // West India
  { name: 'Goa', code: 'GOI', state: 'Goa', country: 'India' },
  { name: 'Panaji', code: 'GOI', state: 'Goa', country: 'India' },
  { name: 'Surat', code: 'STV', state: 'Gujarat', country: 'India' },
  { name: 'Vadodara', code: 'BDQ', state: 'Gujarat', country: 'India' },
  { name: 'Rajkot', code: 'RAJ', state: 'Gujarat', country: 'India' },
  { name: 'Dwarka', code: 'DWK', state: 'Gujarat', country: 'India' },
  // Hill Stations & Tourist
  { name: 'Shimla', code: 'SLV', state: 'Himachal Pradesh', country: 'India' },
  { name: 'Manali', code: 'KUU', state: 'Himachal Pradesh', country: 'India' },
  { name: 'Dharamshala', code: 'DHM', state: 'Himachal Pradesh', country: 'India' },
  { name: 'Mussoorie', code: 'DED', state: 'Uttarakhand', country: 'India' },
  { name: 'Darjeeling', code: 'DAR', state: 'West Bengal', country: 'India' },
  { name: 'Ooty', code: 'CJB', state: 'Tamil Nadu', country: 'India' },
  { name: 'Munnar', code: 'COK', state: 'Kerala', country: 'India' },
  // Tier 2 cities
  { name: 'Aurangabad', code: 'IXU', state: 'Maharashtra', country: 'India' },
  { name: 'Solapur', code: 'SSE', state: 'Maharashtra', country: 'India' },
  { name: 'Kolhapur', code: 'KLH', state: 'Maharashtra', country: 'India' },
  { name: 'Srinagar', code: 'SXR', state: 'Jammu & Kashmir', country: 'India' },
  { name: 'Jamshedpur', code: 'IXW', state: 'Jharkhand', country: 'India' },
  { name: 'Allahabad', code: 'IXD', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Meerut', code: 'MRT', state: 'Uttar Pradesh', country: 'India' },
  { name: 'Kota', code: 'KTU', state: 'Rajasthan', country: 'India' },
  { name: 'Sikar', code: 'SKI', state: 'Rajasthan', country: 'India' },
];

// ────────────────────────────────────────────────────────────────
// 2. SCROLL UTILITIES & EVENTS
// ────────────────────────────────────────────────────────────────

// Smooth Scroll Function
window.smoothScroll = function (targetId) {
  const el = document.getElementById(targetId);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};

// Scroll Progress & Hide/Show Nav Bar
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
      // Scrolling down - hide navigation bar smoothly
      mainNav.style.transform = 'translateY(-100%)';
    } else {
      // Scrolling up - show navigation bar
      mainNav.style.transform = 'translateY(0)';
    }
  }
  lastScrollY = currentScrollY;
}, { passive: true });

// Mobile Menu Toggle
const mobileMenu = document.getElementById('mobile-menu');
window.toggleMobileMenu = function () {
  if (mobileMenu) {
    const isVisible = mobileMenu.style.display === 'flex';
    mobileMenu.style.display = isVisible ? 'none' : 'flex';
  }
};

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
  if (mobileMenu && mobileMenu.style.display === 'flex') {
    const hamburger = document.getElementById('hamburger-btn');
    if (!mobileMenu.contains(e.target) && hamburger && !hamburger.contains(e.target)) {
      mobileMenu.style.display = 'none';
    }
  }
});

// ────────────────────────────────────────────────────────────────
// 3. HERO WORD CYCLING ANIMATION
// ────────────────────────────────────────────────────────────────

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

// ────────────────────────────────────────────────────────────────
// 4. LOGO STRIP MARQUEE TICKER
// ────────────────────────────────────────────────────────────────

const tickerTrack = document.getElementById('ticker-track');
if (tickerTrack) {
  const logos = ['Kedarnath Tour', 'Chardham Yatra', 'Kashmir Escape', 'Goa Beach Resort', 'Kerala Houseboat', 'Leh Himalayan Camp'];
  let html = '';
  // Repeat logos three times to guarantee infinite seamless overflow
  for (let cycle = 0; cycle < 3; cycle++) {
    logos.forEach(logo => {
      html += `<span class="ticker-item font-primary fs-11 fw-medium uppercase ls-1 text-muted" style="margin: 0 28px; white-space: nowrap; display: inline-block;">✦ &nbsp; ${logo}</span>`;
    });
  }
  tickerTrack.innerHTML = html;
}

// ────────────────────────────────────────────────────────────────
// 5. STATS COUNTER ANIMATION
// ────────────────────────────────────────────────────────────────

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
          const duration = 2000; // 2 seconds
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

// ────────────────────────────────────────────────────────────────
// 6. SCROLL REVEAL ANIMATIONS
// ────────────────────────────────────────────────────────────────

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

// ────────────────────────────────────────────────────────────────
// 7. DESTINATIONS CONTROLLER
// ────────────────────────────────────────────────────────────────

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
    
    // Build gallery array in JS
    const gallery = [d.imagePath].concat(d.gallery || []).filter(Boolean);
    const hasGallery = gallery.length > 1;

    const galleryImgsHtml = gallery.map((img, idx) => {
      if (idx === 0) {
        return `<img src="${img}" class="prop-gallery-img prop-img-${idx}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: opacity 0.4s ease; opacity: 0;" onload="this.style.opacity=1; this.closest('.property-card-gallery-wrapper').classList.remove('skeleton-loading');" />`;
      } else {
        return `<img data-src="${img}" class="prop-gallery-img prop-img-${idx}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: opacity 0.4s ease; opacity: 0; pointer-events: none;" />`;
      }
    }).join('');

    const dotsHtml = hasGallery ? `
      <div class="prop-gallery-dots" style="position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); display: flex; gap: 4px; z-index: 10;">
        ${gallery.map((_, idx) => `
          <span class="prop-gallery-dot" style="width: 6px; height: 6px; border-radius: 50%; background: ${idx === 0 ? 'var(--color-highlighter-lime)' : 'rgba(255,255,255,0.4)'}; transition: all 0.2s;"></span>
        `).join('')}
      </div>
    ` : '';

    const navBtnsHtml = hasGallery ? `
      <button type="button" class="prop-gallery-nav-btn prev" onclick="event.stopPropagation(); window.changeCardImage(this, -1)" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); border: none; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; opacity: 0; transition: opacity 0.25s, background 0.2s, transform 0.2s;">
        ‹
      </button>
      <button type="button" class="prop-gallery-nav-btn next" onclick="event.stopPropagation(); window.changeCardImage(this, 1)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); border: none; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; opacity: 0; transition: opacity 0.25s, background 0.2s, transform 0.2s;">
        ›
      </button>
    ` : '';

    const safeGalleryJson = JSON.stringify(gallery).replace(/'/g, "\\'");

    return `
      <div
        class="portfolio-tile"
        style="width: 300px; height: 380px; flex-shrink: 0; position: relative; overflow: hidden; background: var(--color-carbon);"
        data-id="${d.id}"
      >
        <!-- The top image gallery portion (clickable to zoom/lightbox) -->
        <div class="property-card-gallery-wrapper skeleton-loading" style="position: absolute; inset: 0 0 120px 0; overflow: hidden; cursor: zoom-in;" onmouseenter="window.lazyLoadCardImages(this)" onclick="window.openLightbox(${safeGalleryJson}, window.getCardActiveIdx(this), event)">
          <div class="property-card-gallery" style="position: relative; width: 100%; height: 100%;">
            ${galleryImgsHtml}
          </div>
          
          <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 10, 10, 0.95) 0%, rgba(10, 10, 10, 0.1) 80%, transparent 100%); pointer-events: none;"></div>
          
          ${navBtnsHtml}
          ${dotsHtml}

          <!-- Magnifier icon on top-left of image area -->
          <div class="gallery-zoom-icon" style="position: absolute; top: 12px; left: 12px; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: #fff; z-index: 10; transition: transform 0.2s, background 0.2s, color 0.2s;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </div>

          <div style="position: absolute; top: 12px; right: 12px; display: flex; justify-content: flex-end; align-items: center; z-index: 10; pointer-events: none;">
            <span class="font-primary fs-9" style="color: var(--color-white-80); padding: 3px 7px; border: 1px solid var(--color-white-20); border-radius: var(--radius-full); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">
              ${firstSeason}
            </span>
          </div>
        </div>

        <!-- The bottom text portion (clickable to toggle details below) -->
        <div style="position: absolute; left: 0; right: 0; bottom: 0; height: 120px; padding: 16px; z-index: 10; display: flex; flex-direction: column; justify-content: flex-end; pointer-events: none;">
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
    card.addEventListener('click', (e) => {
      // If click was inside the gallery wrapper (prev/next buttons, zoom, etc.)
      if (e.target.closest('.prop-gallery-nav-btn') || e.target.closest('.gallery-zoom-icon') || e.target.closest('.property-card-gallery-wrapper')) {
        return;
      }
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

window.scrollDestinations = function (dir) {
  if (destScrollRow) {
    destScrollRow.scrollBy({ left: dir === 'left' ? -320 : 320, behavior: 'smooth' });
  }
};

window.toggleDestDetail = function (id) {
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

  const imgWrap = document.getElementById('dest-detail-img-wrap');
  if (imgWrap) imgWrap.classList.add('skeleton-loading');
  const imgEl = document.getElementById('dest-detail-img');
  if (imgEl) {
    imgEl.style.opacity = '0';
    imgEl.src = d.imagePath;
    imgEl.alt = d.name;
  }

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

// Initialize destinations filter pills
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

// Drag scrolling logic for destinations
let isDragging = false;
let startX, scrollLeft;

if (destScrollRow) {
  destScrollRow.addEventListener('mousedown', (e) => {
    isDragging = true;
    startX = e.pageX - destScrollRow.offsetLeft;
    scrollLeft = destScrollRow.scrollLeft;
  });

  destScrollRow.addEventListener('mouseleave', () => {
    isDragging = false;
  });

  destScrollRow.addEventListener('mouseup', () => {
    isDragging = false;
  });

  destScrollRow.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - destScrollRow.offsetLeft;
    const walk = (x - startX) * 1.5;
    destScrollRow.scrollLeft = scrollLeft - walk;
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

// ────────────────────────────────────────────────────────────────
// 8. TICKET BOOKING SYSTEM
// ────────────────────────────────────────────────────────────────

const ticketRoot = document.getElementById('ticket-booking-container');
window.ticketActiveTab = 'bus';
window.ticketIsRoundTrip = true;
window.ticketCaptchaSvg = '';
window.ticketCaptchaToken = '';
window.ticketIsSubmitted = false;

// Ticket state tracking variables to prevent input state loss
window.ticketPhone = '';
window.ticketDate = '';
window.ticketReturnDate = '';
window.ticketPassengers = '1';
window.ticketClassType = 'Economy';
window.ticketCaptchaInput = '';
window.ticketIsLoading = false;
window.ticketIsCaptchaLoading = false;

// Local search suggestions list handler
window.fromQuery = '';
window.toQuery = '';
window.fromSuggestions = [];
window.toSuggestions = [];
window.activeDropdown = null; // 'from' | 'to' | null

// One-time global mousedown handler: close dropdowns when clicking outside
document.addEventListener('mousedown', function(e) {
  const wrapper = document.querySelector('.route-inputs-wrapper');
  if (wrapper && !wrapper.contains(e.target)) {
    if (window.activeDropdown) {
      window.activeDropdown = null;
      window.fromSuggestions = [];
      window.toSuggestions = [];
      // Direct DOM removal — no full re-render needed
      ['ticket-from', 'ticket-to'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) {
          const fg = el.closest('.travelgo-field-group');
          if (fg) { const d = fg.querySelector('.autocomplete-dropdown'); if (d) d.remove(); }
        }
      });
    }
  }
});

function getCityCode(cityName, fallback) {
  if (!cityName) return fallback;
  const match = cityName.match(/\(([^)]+)\)/);
  if (match) return match[1].toUpperCase();
  return cityName.slice(0, 3).toUpperCase();
}

window.handleSwapDestinations = function () {
  const temp = window.fromQuery;
  window.fromQuery = window.toQuery;
  window.toQuery = temp;
  window.renderTicketBooking();
};

window.fetchTicketCaptcha = async function () {
  window.ticketIsCaptchaLoading = true;
  window.ticketCaptchaSvg = '';
  window.renderTicketBooking();
  try {
    const res = await fetch('/api/captcha');
    if (res.ok) {
      const data = await res.json();
      window.ticketCaptchaSvg = data.svg;
      window.ticketCaptchaToken = data.token;
      window.ticketCaptchaInput = '';
      const errorEl = document.getElementById('ticket-captcha-error');
      if (errorEl) errorEl.style.display = 'none';
      window.renderTicketBooking();
    }
  } catch (err) {
    console.error('CAPTCHA load error', err);
  } finally {
    window.ticketIsCaptchaLoading = false;
    window.renderTicketBooking();
  }
};

window.renderTicketBooking = function () {
  if (!ticketRoot) return;

  if (window.ticketIsSubmitted) {
    ticketRoot.innerHTML = `
      <div style="background:var(--color-carbon); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); padding:40px; text-align:center;">
        <div style="width:48px; height:48px; border-radius:50%; background:var(--color-highlighter-lime); display:flex; align-items:center; justify-content:center; color:var(--color-onyx-black); margin:0 auto 20px">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 class="font-secondary fs-20" style="color:var(--color-pure-white); margin-bottom:8px">Ticket Inquiry Received!</h3>
        <p class="font-primary text-sm text-muted" style="margin-bottom:24px">We are checking live seats. Opening WhatsApp details...</p>
        <button class="btn-primary" onclick="window.openTicketWhatsApp()">Open WhatsApp Manually</button>
      </div>
    `;
    return;
  }

  const activeClassOptions = TICKETS_CLASS_OPTIONS[window.ticketActiveTab];

  ticketRoot.innerHTML = `
    <div class="travelgo-card">
      <!-- Card Header -->
      <div class="travelgo-card-header">
        <h3 class="travelgo-card-title">Book Transit</h3>
        <div class="travelgo-tabs-grid" style="grid-template-columns: repeat(2, 1fr);">
          <button type="button" class="travelgo-tab-btn ${window.ticketActiveTab === 'bus' ? 'active' : ''}" onclick="window.setTicketTab('bus')">🚌 Buses</button>
          <button type="button" class="travelgo-tab-btn ${window.ticketActiveTab === 'taxi' ? 'active' : ''}" onclick="window.setTicketTab('taxi')">🚕 Taxis</button>
        </div>
      </div>

      <!-- Form container -->
      <form id="ticket-booking-form" style="padding: 24px" onsubmit="window.handleTicketSubmit(event)">
        <!-- Trip Type toggle -->
        <div class="travelgo-toggles">
          <span class="toggles-label">Trip Type</span>
          <div class="toggles-row">
            <button type="button" class="toggle-pill ${window.ticketIsRoundTrip ? 'active' : ''}" onclick="window.setTicketRoundTrip(true)">Round Trip</button>
            <button type="button" class="toggle-pill ${!window.ticketIsRoundTrip ? 'active' : ''}" onclick="window.setTicketRoundTrip(false)">One Way</button>
          </div>
        </div>

        <!-- Grid Inputs -->
        <div class="travelgo-form-grid">
          <!-- Row 1: From & To -->
          <div class="span-4 route-inputs-wrapper">
            <!-- From field -->
            <div class="travelgo-field-group">
              <label class="input-box-label">From</label>
              <div class="travelgo-input-box">
                <span class="input-box-icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                  </svg>
                </span>
                <input
                  type="text"
                  id="ticket-from"
                  class="input-box-field"
                  placeholder="Departure Station / City"
                  value="${window.fromQuery}"
                  oninput="window.handleFromInput(this.value)"
                  onclick="window.activeDropdown='from'; window.renderTicketDropdown('from')"
                  autocomplete="off"
                  required
                />
                <span class="input-box-code">${getCityCode(window.fromQuery, 'IND')}</span>
              </div>
              ${window.activeDropdown === 'from' && window.fromSuggestions.length > 0 ? `
                <div class="autocomplete-dropdown">
                  ${window.fromSuggestions.map(c => `
                    <div class="autocomplete-item" onclick="window.selectFromCity('${c.name} (${c.code})')">
                      <div class="autocomplete-item-name">${c.name} (${c.code})</div>
                      <div class="autocomplete-item-sub">${c.state}, ${c.country}</div>
                    </div>
                  `).join('')}
                </div>
              ` : ''}
            </div>

            <!-- Interactive Swap Button -->
            <button
              type="button"
              onclick="window.handleSwapDestinations()"
              class="travelgo-swap-btn"
              title="Swap Destinations"
            >
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 17H4M4 17l4 4M4 17l4-4M4 7h16M20 7l-4-4M20 7l-4 4" />
              </svg>
            </button>

            <!-- To field -->
            <div class="travelgo-field-group">
              <label class="input-box-label">To</label>
              <div class="travelgo-input-box">
                <span class="input-box-icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                  </svg>
                </span>
                <input
                  type="text"
                  id="ticket-to"
                  class="input-box-field"
                  placeholder="Arrival Station / City"
                  value="${window.toQuery}"
                  oninput="window.handleToInput(this.value)"
                  onclick="window.activeDropdown='to'; window.renderTicketDropdown('to')"
                  autocomplete="off"
                  required
                />
                <span class="input-box-code">${getCityCode(window.toQuery, 'BOM')}</span>
              </div>
              ${window.activeDropdown === 'to' && window.toSuggestions.length > 0 ? `
                <div class="autocomplete-dropdown">
                  ${window.toSuggestions.map(c => `
                    <div class="autocomplete-item" onclick="window.selectToCity('${c.name} (${c.code})')">
                      <div class="autocomplete-item-name">${c.name} (${c.code})</div>
                      <div class="autocomplete-item-sub">${c.state}, ${c.country}</div>
                    </div>
                  `).join('')}
                </div>
              ` : ''}
            </div>
          </div>

          <!-- Row 2: Date, Return, Travelers & Class -->
          <!-- Departure Date -->
          <div class="travelgo-field-group span-1-tablet">
            <label class="input-box-label">Departure Date</label>
            <div class="travelgo-input-box">
              <span class="input-box-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" /><line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" /></svg>
              </span>
              <input
                type="date"
                id="ticket-date"
                class="input-box-field"
                value="${window.ticketDate}"
                onchange="window.ticketDate=this.value"
                required
              />
            </div>
          </div>

          <!-- Return Date -->
          <div class="travelgo-field-group span-1-tablet ${!window.ticketIsRoundTrip ? 'disabled' : ''}">
            <label class="input-box-label">Return Date</label>
            <div class="travelgo-input-box">
              <span class="input-box-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" /><line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" /></svg>
              </span>
              <input
                type="date"
                id="ticket-return-date"
                class="input-box-field"
                value="${window.ticketReturnDate}"
                onchange="window.ticketReturnDate=this.value"
                ${!window.ticketIsRoundTrip ? 'disabled' : 'required'}
              />
            </div>
          </div>

          <!-- Combined Travelers & Class -->
          <div class="travelgo-field-group span-2">
            <label class="input-box-label">Travelers &amp; Class</label>
            <div class="travelgo-input-box">
              <span class="input-box-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /></svg>
              </span>
              <div style="display: flex; gap: var(--spacing-8); width: 100%; align-items: center">
                <select
                  id="ticket-passengers"
                  class="input-box-select"
                  onchange="window.ticketPassengers=this.value"
                >
                  ${[1, 2, 3, 4, 5, 6, 8, 10].map(n => `
                    <option value="${n}" ${window.ticketPassengers === String(n) ? 'selected' : ''}>${n} Traveler${n > 1 ? 's' : ''}</option>
                  `).join('')}
                </select>
                <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.08)"></div>
                <select
                  id="ticket-class"
                  class="input-box-select"
                  onchange="window.ticketClassType=this.value"
                >
                  ${activeClassOptions.map(opt => `
                    <option value="${opt}" ${window.ticketClassType === opt ? 'selected' : ''}>${opt}</option>
                  `).join('')}
                </select>
              </div>
              <span class="booking-select-arrow">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M6 9l6 6 6-6" /></svg>
              </span>
            </div>
          </div>

          <!-- Row 3: Contact Phone & Info Panel -->
          <div class="travelgo-field-group span-2">
            <label class="input-box-label">WhatsApp Contact Number</label>
            <div class="travelgo-input-box">
              <span class="input-box-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
              </span>
              <input
                type="tel"
                id="ticket-phone"
                class="input-box-field"
                placeholder="e.g. +91 93409 94628"
                value="${window.ticketPhone}"
                oninput="window.ticketPhone=this.value"
                required
              />
            </div>
          </div>

          <div class="travelgo-info-radar span-2" style="align-self: end">
            <span class="radar-ping"></span>
            <p class="font-primary text-xs text-muted" style="margin: 0; line-height: 1.4">
              <strong>Live Radar Search:</strong> Direct API lookup to Indian state transport links and flight booking platforms.
            </p>
          </div>

          <!-- Row 4: Captcha Verification & Submit -->
          <div class="span-2" style="margin-top: var(--spacing-8)">
            <label class="input-box-label" style="display: block; margin-bottom: 8px">
              Security Verification (CAPTCHA)
            </label>
            <div style="
              display: grid;
              grid-template-columns: auto 1fr;
              align-items: center;
              gap: 16px;
              background: rgba(255, 255, 255, 0.01);
              border: 1px solid rgba(255, 255, 255, 0.05);
              border-radius: var(--radius-md);
              padding: 12px;
              width: 100%;
            ">
              <div style="display: flex; align-items: center; gap: 8px">
                ${window.ticketCaptchaSvg && !window.ticketIsCaptchaLoading ? `
                  <div style="display: flex; align-items: center; border-radius: 4px; overflow: hidden">${window.ticketCaptchaSvg}</div>
                ` : `
                  <div style="width: 140px; height: 44px; background: #121212; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #666">
                    <div style="
                      width: 14px;
                      height: 14px;
                      border: 2px solid rgba(255,255,255,0.1);
                      border-top: 2px solid #fff;
                      border-radius: 50%;
                      animation: adminSpin 1s linear infinite;
                      margin-right: 8px;
                      display: inline-block;
                    "></div>
                    Loading...
                  </div>
                `}
                <button
                  type="button"
                  onclick="window.fetchTicketCaptcha()"
                  ${window.ticketIsCaptchaLoading ? 'disabled' : ''}
                  style="
                    background: rgba(255,255,255,0.05);
                    border: 1px solid rgba(255,255,255,0.08);
                    color: #fff;
                    border-radius: 6px;
                    width: 38px;
                    height: 38px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: ${window.ticketIsCaptchaLoading ? 'not-allowed' : 'pointer'};
                    transition: all 0.2s;
                    opacity: ${window.ticketIsCaptchaLoading ? 0.6 : 1};
                  "
                  title="Refresh CAPTCHA"
                >
                  <svg 
                    width="15" 
                    height="15" 
                    viewBox="0 0 24 24" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    style="
                      color: var(--color-steel-gray);
                      animation: ${window.ticketIsCaptchaLoading ? 'adminSpin 1s linear infinite' : 'none'};
                    "
                  >
                    <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67" />
                  </svg>
                </button>
              </div>
              <input
                type="text"
                id="ticket-captcha-input"
                class="input-terminal"
                placeholder="Enter CAPTCHA code"
                style="font-family: monospace; letter-spacing: 2px"
                value="${window.ticketCaptchaInput}"
                oninput="window.ticketCaptchaInput=this.value"
                required
              />
            </div>
            <p id="ticket-captcha-error" style="color: #ff4444; font-size: 12px; margin-top: 4px; font-weight: 500; display: none"></p>
          </div>
          
          <div class="span-2" style="display: flex; flex-direction: column; gap: 10px; margin-top: var(--spacing-8); justify-content: flex-end;">
            <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 10px; padding: 10px 14px; gap: 8px;">
              <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 16px;">📲</span>
                <div>
                  <div style="font-size: 11px; font-weight: 600; color: rgb(255, 255, 255); font-family: &quot;DM Sans&quot;, sans-serif;">
                    Direct Agent Booking
                  </div>
                  <div style="font-size: 10px; color: rgb(102, 102, 102); font-family: &quot;DM Sans&quot;, sans-serif;">
                    No prepayment required. Rates verified by agents.
                  </div>
                </div>
              </div>
              <div style="font-size: 9px; color: var(--color-highlighter-lime); text-align: right; max-width: 140px; line-height: 1.3;">⚡ Instant inquiry logged directly</div>
            </div>
            <div class="span-2">
              <button type="submit" class="travelgo-search-btn" style="width: 100%" ${window.ticketIsLoading ? 'disabled' : ''}>
                ${window.ticketIsLoading ? `
                  <span class="spinner" style="border: 2px solid rgba(255,255,255,0.2); border-top: 2px solid #fff; border-radius: 50%; width: 14px; height: 14px; display: inline-block; animation: adminSpin 0.8s linear infinite; margin-right: 8px;"></span> Loading...
                ` : 'SEARCH TRANSIT →'}
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  `;
}

window.setTicketTab = function (tab) {
  window.ticketActiveTab = tab;
  window.ticketClassType = TICKETS_CLASS_OPTIONS[tab][0];
  // Clear suggestions on tab switch
  window.fromSuggestions = [];
  window.toSuggestions = [];
  window.activeDropdown = null;
  window.renderTicketBooking();
};

window.setTicketRoundTrip = function (val) {
  window.ticketIsRoundTrip = val;
  window.renderTicketBooking();
};

// ── Lightweight dropdown renderer (no full form re-render) ──
window.renderTicketDropdown = function(which, isLoading) {
  const inputId = which === 'from' ? 'ticket-from' : 'ticket-to';
  const suggestions = which === 'from' ? window.fromSuggestions : window.toSuggestions;
  const selectFn = which === 'from' ? 'selectFromCity' : 'selectToCity';

  const inputEl = document.getElementById(inputId);
  if (!inputEl) return;

  // Update airport code badge
  const codeEl = inputEl.parentElement.querySelector('.input-box-code');
  if (codeEl) codeEl.textContent = getCityCode(inputEl.value, which === 'from' ? 'IND' : 'BOM');

  const fieldGroup = inputEl.closest('.travelgo-field-group');
  if (!fieldGroup) return;

  // Remove existing dropdown
  const existing = fieldGroup.querySelector('.autocomplete-dropdown');
  if (existing) existing.remove();

  if (window.activeDropdown !== which) return;

  // Show loading state
  if (isLoading) {
    const loadingDiv = document.createElement('div');
    loadingDiv.className = 'autocomplete-dropdown';
    loadingDiv.innerHTML = '<div style="padding:14px 16px;display:flex;align-items:center;gap:10px;color:#666;font-size:13px;">'
      + '<div style="width:12px;height:12px;border:2px solid rgba(255,255,255,0.1);border-top:2px solid #ccc;border-radius:50%;animation:adminSpin 0.8s linear infinite;flex-shrink:0"></div>'
      + 'Searching cities...</div>';
    fieldGroup.appendChild(loadingDiv);
    return;
  }

  // Inject suggestions dropdown
  if (suggestions.length > 0) {
    const dropdown = document.createElement('div');
    dropdown.className = 'autocomplete-dropdown';
    dropdown.innerHTML = suggestions.slice(0, 8).map(function(c) {
      const safeName = (c.name + ' (' + c.code + ')').replace(/'/g, "\\'");
      return '<div class="autocomplete-item" onclick="window.' + selectFn + '(\'' + safeName + '\')">' +
        '<div style="display:flex;align-items:center;gap:10px">' +
        '<span style="font-family:monospace;font-size:10px;font-weight:700;background:rgba(255,255,255,0.06);color:#ccc;padding:2px 6px;border-radius:4px;flex-shrink:0">' + c.code + '</span>' +
        '<div>' +
        '<div class="autocomplete-item-name">' + c.name + '</div>' +
        '<div class="autocomplete-item-sub">' + (c.state || c.admin1 || '') + (c.country ? ', ' + c.country : '') + '</div>' +
        '</div></div></div>';
    }).join('');
    fieldGroup.appendChild(dropdown);
  }
};

// Open-Meteo Geocoding fetch (free, no API key, India-first)
var _geocodeTimer = {};
window.fetchGeocoding = function(val, which) {
  clearTimeout(_geocodeTimer[which]);
  _geocodeTimer[which] = setTimeout(function() {
    var url = 'https://geocoding-api.open-meteo.com/v1/search?name=' + encodeURIComponent(val) + '&count=10&language=en&format=json';
    fetch(url)
      .then(function(r) { return r.json(); })
      .catch(function() { return null; })
      .then(function(data) {
        if (window.activeDropdown !== which) return;
        var results = [];
        if (data && data.results && data.results.length > 0) {
          // Filter India cities only
          var india = data.results.filter(function(r) { return r.country_code === 'IN'; });
          results = india.slice(0, 8).map(function(r) {
            return {
              name: r.name,
              code: r.name.slice(0, 3).toUpperCase(),
              state: r.admin1 || '',
              country: r.country || 'India'
            };
          });
        }
        // Merge with local matches (local first)
        var clean = val.toLowerCase();
        var local = FALLBACK_CITIES.filter(function(c) {
          return c.name.toLowerCase().includes(clean) || c.code.toLowerCase().includes(clean);
        });
        // Dedupe by name
        var seen = {};
        local.forEach(function(c) { seen[c.name.toLowerCase()] = true; });
        var merged = local.concat(results.filter(function(r) { return !seen[r.name.toLowerCase()]; }));
        if (which === 'from') {
          window.fromSuggestions = merged;
        } else {
          window.toSuggestions = merged;
        }
        window.renderTicketDropdown(which, false);
      });
  }, 280); // 280ms debounce
};

// Autocomplete logic — local first instant, then geocoding enrichment
window.handleFromInput = function (val) {
  window.fromQuery = val;
  window.activeDropdown = 'from';
  if (val.length >= 2) {
    // Show local results immediately
    var clean = val.toLowerCase();
    window.fromSuggestions = FALLBACK_CITIES.filter(function(c) {
      return c.name.toLowerCase().includes(clean) || c.code.toLowerCase().includes(clean);
    });
    window.renderTicketDropdown('from', false);
    // Then enrich with Open-Meteo API
    window.fetchGeocoding(val, 'from');
  } else {
    window.fromSuggestions = [];
    window.renderTicketDropdown('from', false);
  }
};

window.handleToInput = function (val) {
  window.toQuery = val;
  window.activeDropdown = 'to';
  if (val.length >= 2) {
    var clean = val.toLowerCase();
    window.toSuggestions = FALLBACK_CITIES.filter(function(c) {
      return c.name.toLowerCase().includes(clean) || c.code.toLowerCase().includes(clean);
    });
    window.renderTicketDropdown('to', false);
    // Enrich with Open-Meteo API
    window.fetchGeocoding(val, 'to');
  } else {
    window.toSuggestions = [];
    window.renderTicketDropdown('to', false);
  }
};

// These are kept for backward compat but no longer called
window.showFromDropdownList = function () {
  window.activeDropdown = 'from';
  window.renderTicketDropdown('from');
};
window.hideFromDropdownList = function () {
  setTimeout(function() { if (window.activeDropdown === 'from') { window.activeDropdown = null; window.renderTicketDropdown('from'); } }, 200);
};
window.showToDropdownList = function () {
  window.activeDropdown = 'to';
  window.renderTicketDropdown('to');
};
window.hideToDropdownList = function () {
  setTimeout(function() { if (window.activeDropdown === 'to') { window.activeDropdown = null; window.renderTicketDropdown('to'); } }, 200);
};

// City selection — direct DOM update, no full re-render
window.selectFromCity = function (nameCode) {
  window.fromQuery = nameCode;
  window.fromSuggestions = [];
  window.activeDropdown = null;
  // Update input value and badge directly
  const input = document.getElementById('ticket-from');
  if (input) {
    input.value = nameCode;
    const codeEl = input.parentElement.querySelector('.input-box-code');
    if (codeEl) codeEl.textContent = getCityCode(nameCode, 'IND');
  }
  window.renderTicketDropdown('from');
};

window.selectToCity = function (nameCode) {
  window.toQuery = nameCode;
  window.toSuggestions = [];
  window.activeDropdown = null;
  const input = document.getElementById('ticket-to');
  if (input) {
    input.value = nameCode;
    const codeEl = input.parentElement.querySelector('.input-box-code');
    if (codeEl) codeEl.textContent = getCityCode(nameCode, 'BOM');
  }
  window.renderTicketDropdown('to');
};

// Form submit handler
window.handleTicketSubmit = async function (e) {
  e.preventDefault();
  const errorEl = document.getElementById('ticket-captcha-error');
  if (errorEl) errorEl.style.display = 'none';

  const phone = document.getElementById('ticket-phone').value;
  const date = document.getElementById('ticket-date').value;
  const returnDate = document.getElementById('ticket-return-date') ? document.getElementById('ticket-return-date').value : null;
  const passengers = document.getElementById('ticket-passengers').value;
  const classType = document.getElementById('ticket-class').value;
  const captchaInput = document.getElementById('ticket-captcha-input').value;

  window.ticketIsLoading = true;
  window.renderTicketBooking();

  try {
    const res = await fetch('/api/admin/bookings', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        customerName: 'Guest Traveller',
        customerPhone: phone,
        fromCity: window.fromQuery,
        toCity: window.toQuery,
        travelType: window.ticketActiveTab,
        date: date,
        returnDate: window.ticketIsRoundTrip ? returnDate : null,
        passengers: parseInt(passengers, 10),
        classType: classType,
        amount: 0,
        status: 'pending',
        notes: `Web Ticket Booking Inquiry`,
        isPublicInquiry: true,
        captchaToken: window.ticketCaptchaToken,
        captchaInput: captchaInput,
      })
    });

    if (!res.ok) {
      const data = await res.json();
      if (errorEl) {
        errorEl.textContent = data.error || 'CAPTCHA verification failed.';
        errorEl.style.display = 'block';
      }
      window.fetchTicketCaptcha();
      window.ticketIsLoading = false;
      window.renderTicketBooking();
      return;
    }

    window.ticketIsSubmitted = true;
    window.ticketIsLoading = false;
    window.renderTicketBooking();

    // Open WhatsApp
    setTimeout(() => { window.openTicketWhatsApp(); }, 800);

  } catch (err) {
    console.error('Server DB submit failed, direct handoff to WhatsApp', err);
    window.ticketIsLoading = false;
    window.renderTicketBooking();
    // Even if DB fails, keep the client happy by doing the WhatsApp handoff!
    window.openTicketWhatsApp();
  }
};

window.openTicketWhatsApp = function () {
  const emojiMap = { bus: '🚌 Bus', taxi: '🚕 Taxi' };
  const text = `Hello Shivalay Travels! I would like to book a *${emojiMap[window.ticketActiveTab]} Ticket*:\n\n` +
    `📍 *From:* ${window.fromQuery || 'Not specified'}\n` +
    `📍 *To:* ${window.toQuery || 'Not specified'}\n` +
    `📅 *Departure:* ${document.getElementById('ticket-date') ? document.getElementById('ticket-date').value : ''}\n` +
    (window.ticketIsRoundTrip && document.getElementById('ticket-return-date') ? `📅 *Return:* ${document.getElementById('ticket-return-date').value}\n` : '') +
    `👥 *Passengers:* ${document.getElementById('ticket-passengers') ? document.getElementById('ticket-passengers').value : '1'}\n` +
    `✨ *Class:* ${document.getElementById('ticket-class') ? document.getElementById('ticket-class').value : ''}\n\n` +
    `Please share the best available rates. Thanks!`;

  window.open(`https://wa.me/919340994628?text=${encodeURIComponent(text)}`, '_blank');
};

window.fetchTicketCaptcha();

// ────────────────────────────────────────────────────────────────
// 9. PHILOSOPHY & FAQ ACCORDEON
// ────────────────────────────────────────────────────────────────

const faqItems = document.querySelectorAll('.faq-item');
faqItems.forEach(item => {
  const btn = item.querySelector('.faq-btn');
  const content = item.querySelector('.faq-content');
  const arrow = item.querySelector('.faq-arrow');

  if (btn && content && arrow) {
    btn.addEventListener('click', () => {
      const isOpen = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';

      // Close all others
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

// ────────────────────────────────────────────────────────────────
// 10. ITINERARY PREVIEW ACCORDEON
// ────────────────────────────────────────────────────────────────

const itineraryDays = document.querySelectorAll('.itinerary-day');
itineraryDays.forEach(day => {
  const header = day.querySelector('.itinerary-day-header');
  const content = day.querySelector('.itinerary-day-content');
  const arrow = day.querySelector('.itinerary-day-arrow');
  const num = day.querySelector('.day-num');

  if (header && content && arrow) {
    header.addEventListener('click', () => {
      const isOpen = content.style.maxHeight !== '0px' && content.style.maxHeight !== '';

      // Close all others
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

// ────────────────────────────────────────────────────────────────
// 11. MEMORIES CAROUSEL (GUEST REVIEWS)
// ────────────────────────────────────────────────────────────────

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
      if (testAvatar) {
        if (t.clientImage) {
          // Only rebuild avatar if the image URL actually changed
          const existingImg = testAvatar.querySelector('img');
          if (!existingImg || existingImg.getAttribute('src') !== t.clientImage) {
            testAvatar.innerHTML = `<img src="${t.clientImage}" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;" />`;
          }
        } else {
          if (testAvatar.textContent.trim() !== t.avatar) testAvatar.textContent = t.avatar;
        }
      }
      if (testName) testName.textContent = t.name;
      if (testMeta) testMeta.textContent = `${t.location} · ${t.trip}`;

      const testImg = document.getElementById('testimonial-img');
      if (testImg) {
        // Only set .src if it changed — browser re-fetches on every .src assignment otherwise
        const newSrc = t.image || '/images/kashmir.png';
        if (testImg.getAttribute('data-current-src') !== newSrc) {
          testImg.src = newSrc;
          testImg.setAttribute('data-current-src', newSrc);
        }
      }

      // Update rating stars
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

  // Update Sidebar active state
  if (testSidebar) {
    const btns = testSidebar.querySelectorAll('button');
    btns.forEach((btn, i) => {
      const avatarEl = btn.querySelector('.test-sidebar-avatar');
      const nameEl = btn.querySelector('.test-sidebar-name');

      if (i === testActiveIdx) {
        btn.style.background = 'var(--color-carbon)';
        btn.style.borderColor = 'var(--color-zinc-hairline)';
        if (avatarEl) {
          avatarEl.style.background = 'var(--color-highlighter-lime)';
          avatarEl.style.color = 'var(--color-onyx-black)';
        }
        if (nameEl) nameEl.style.color = 'var(--color-pure-white)';
      } else {
        btn.style.background = 'transparent';
        btn.style.borderColor = 'transparent';
        if (avatarEl) {
          avatarEl.style.background = 'var(--color-zinc-hairline)';
          avatarEl.style.color = 'var(--color-steel-gray)';
        }
        if (nameEl) nameEl.style.color = 'var(--color-steel-gray)';
      }
    });
  }

  // Update dots active state
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

function stopTestimonialTimer() {
  if (testTimer) clearInterval(testTimer);
}

// Build Sidebar and Dots
if (testSidebar) {
  testSidebar.innerHTML = TESTIMONIALS.map((item, idx) => `
    <button onclick="setTestimonial(${idx})" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:var(--radius-xl); background:transparent; border:1px solid transparent; cursor:pointer; text-align:left; transition:all 0.18s ease; width:100%">
      <div class="test-sidebar-avatar font-primary fs-11 fw-medium" style="width:32px; height:32px; border-radius:var(--radius-md); flex-shrink:0; background:var(--color-zinc-hairline); display:flex; align-items:center; justify-content:center; color:var(--color-steel-gray); transition:all 0.18s ease; overflow:hidden;">
        ${item.clientImage ? `<img src="${item.clientImage}" style="width:100%; height:100%; object-fit:cover;" />` : item.avatar}
      </div>
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

window.setTestimonial = function (idx) {
  testActiveIdx = idx;
  renderTestimonial();
  startTestimonialTimer();
};

// Bind prev/next buttons
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

// Preload all testimonial images so they’re cached before the carousel rotates
(function preloadTestimonialImages() {
  const seen = {};
  TESTIMONIALS.forEach(function(t) {
    if (t.image && !seen[t.image]) {
      seen[t.image] = true;
      var img = new Image();
      img.src = t.image;
    }
  });
}());

// ────────────────────────────────────────────────────────────────
// 12. TRAVEL GUIDES CONTROLLER
// ────────────────────────────────────────────────────────────────

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

const CATEGORIES = ['All', 'Packing Guide', 'Destination Intel', 'Health & Safety', 'Culture'];
if (guidesCategories) {
  guidesCategories.innerHTML = CATEGORIES.map(c => `
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

// ────────────────────────────────────────────────────────────────
// 13. JOURNEY PLANNER MULTI-STEP WIZARD
// ────────────────────────────────────────────────────────────────

const plannerRoot = document.getElementById('journey-planner-root');
window.plannerStep = 0;
window.plannerAnswers = {};
window.plannerCustomInputs = {};
window.plannerCaptchaSvg = '';
window.plannerCaptchaToken = '';
window.plannerSubmitted = false;
window.plannerIsLoading = false;
window.plannerIsCaptchaLoading = false;

window.fetchPlannerCaptcha = async function () {
  window.plannerIsCaptchaLoading = true;
  window.plannerCaptchaSvg = '';
  window.renderPlanner();
  try {
    const res = await fetch('/api/captcha');
    if (res.ok) {
      const data = await res.json();
      window.plannerCaptchaSvg = data.svg;
      window.plannerCaptchaToken = data.token;
      const errorEl = document.getElementById('planner-captcha-error');
      if (errorEl) errorEl.style.display = 'none';
      const inputEl = document.getElementById('planner-captcha-input');
      if (inputEl) inputEl.value = '';
      window.renderPlanner();
    }
  } catch (err) {
    console.error('Planner CAPTCHA load error', err);
  } finally {
    window.plannerIsCaptchaLoading = false;
    window.renderPlanner();
  }
};

window.renderPlanner = function () {
  if (!plannerRoot) return;

  const current = PLANNER_STEPS[window.plannerStep];
  const progress = Math.round((window.plannerStep / (PLANNER_STEPS.length - 1)) * 100);
  const isLastStep = window.plannerStep === PLANNER_STEPS.length - 1;
  const isNotesStep = current.id === 'notes';

  // Left Sidebar column + Right form card
  plannerRoot.innerHTML = `
    <!-- Left Sidebar -->
    <div class="planner-sidebar">
      <p class="section-label" style="margin-bottom:8px">Journey Planner</p>
      <h2 class="heading-md" style="margin-bottom:8px">Build your perfect private escape.</h2>
      <p class="font-primary text-sm lh-16 text-muted" style="margin-bottom:24px">
        ${PLANNER_STEPS.length} steps to your dream itinerary. Every field is fully customisable.
      </p>
      <div style="display:flex; flex-direction:column; gap:2px">
        ${PLANNER_STEPS.map((s, i) => {
    const isActive = window.plannerStep === i;
    const isDone = i < window.plannerStep;
    return `
            <button type="button" onclick="window.setPlannerStep(${i})" style="display:flex; align-items:center; gap:10px; padding:8px 12px; background:${isActive ? 'var(--color-lime-07)' : 'transparent'}; border:1px solid ${isActive ? 'var(--color-lime-25)' : 'transparent'}; border-radius:var(--radius-md); cursor:${i <= window.plannerStep ? 'pointer' : 'default'}; text-align:left; width:100%; transition:all 0.18s ease">
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
              ${window.plannerAnswers[s.id] ? `
                <span class="font-primary fs-9" style="color:var(--color-highlighter-lime); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:64px">${window.plannerAnswers[s.id]}</span>
              ` : ''}
            </button>
          `;
  }).join('')}
      </div>
    </div>

    <!-- Right Panel (Content Card) -->
    <div style="background:var(--color-carbon); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); padding:32px; min-height:480px; display:flex; flex-direction:column">
      ${window.plannerSubmitted ? `
        <div style="display:flex; flex-direction:column; align-items:flex-start; gap:20px; animation:scaleIn 0.5s var(--ease-spring) both">
          <div style="width:48px; height:48px; border-radius:var(--radius-md); background:var(--color-highlighter-lime); display:flex; align-items:center; justify-content:center; color:var(--color-onyx-black)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div>
            <h3 class="font-secondary fs-24 fw-regular lh-13" style="color:var(--color-pure-white); margin-bottom:8px">Your Journey Brief is On Its Way! 🎉</h3>
            <p class="font-primary fs-13 lh-16 text-muted" style="max-width:400px">Our travel specialist will contact you within 2 hours with a personalised draft itinerary based on your selections.</p>
          </div>
          <div style="display:flex; gap:10px; flex-wrap:wrap">
            <button class="btn-primary" onclick="window.openPlannerWhatsApp()">WhatsApp Planner Now</button>
            <a href="mailto:info@shivalaytravels.com" class="btn-ghost" style="text-decoration:none">Send Email</a>
          </div>
        </div>
      ` : `
        <!-- Progress bar -->
        <div style="margin-bottom:28px">
          <div style="display:flex; justify-content:space-between; margin-bottom:8px">
            <span class="font-primary fs-11" style="color:var(--color-ash-gray)">Step ${window.plannerStep + 1} of ${PLANNER_STEPS.length}</span>
            <span class="font-primary fs-11 fw-medium" style="color:var(--color-highlighter-lime)">${progress}%</span>
          </div>
          <div style="height:3px; background:var(--color-zinc-hairline); border-radius:3px; overflow:hidden">
            <div style="height:100%; width:${progress}%; background:var(--color-highlighter-lime); border-radius:3px; transition:width 0.5s var(--ease-out)"></div>
          </div>
        </div>

        <!-- Step content -->
        <div style="flex:1; display:flex; flex-direction:column">
          <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px">
            <span style="font-size:20px">${current.icon}</span>
            <h3 class="fs-planner-q" style="color:var(--color-pure-white); font-size:18px">${current.question}</h3>
          </div>
          ${current.subtext ? `<p class="font-primary text-sm lh-15 text-muted" style="margin-bottom:20px; margin-left:30px">${current.subtext}</p>` : ''}

          <!-- Options selection -->
          ${current.options.length > 0 ? `
            <div style="display:flex; flex-wrap:wrap; gap:7px; margin-bottom:24px">
              ${current.options.map(opt => {
    const isSelected = window.plannerAnswers[current.id] === opt;
    return `
                  <button type="button" class="font-primary text-sm" onclick="window.selectPlannerOption('${opt}')" style="padding:7px 14px; border-radius:var(--radius-md); border:1px solid ${isSelected ? 'var(--color-highlighter-lime)' : 'var(--color-zinc-hairline)'}; background:${isSelected ? 'var(--color-highlighter-lime)' : 'transparent'}; color:${isSelected ? 'var(--color-onyx-black)' : 'var(--color-steel-gray)'}; cursor:pointer; transition:all 0.18s ease">${opt}</button>
                `;
  }).join('')}
            </div>
          ` : ''}

          <!-- Custom Inputs -->
          ${!isLastStep ? `
            <div style="${current.options.length > 0 ? 'border-top:1px solid var(--color-zinc-hairline); padding-top:18px' : ''}">
              ${current.options.length > 0 ? `<p class="font-primary text-xs fw-medium uppercase ls-05" style="color:var(--color-ash-gray); margin-bottom:10px">Or enter custom details:</p>` : ''}
              <div style="display:flex; gap:8px; align-items:flex-start">
                ${isNotesStep ? `
                  <textarea id="planner-notes-input" class="input-terminal" rows="4" style="resize:vertical; line-height:1.6; flex:1" placeholder="${current.inputPlaceholder || ''}">${window.plannerCustomInputs[current.id] || ''}</textarea>
                ` : `
                  <input type="text" id="planner-text-input" class="input-terminal" style="flex:1" placeholder="${current.inputPlaceholder || ''}" value="${window.plannerCustomInputs[current.id] || ''}">
                `}
                <button type="button" class="btn-primary fs-13" style="padding:10px 18px; flex-shrink:0" onclick="window.submitPlannerCustomValue()">Next →</button>
              </div>
              ${isNotesStep ? `
                <button type="button" class="font-primary text-sm underline" onclick="window.skipPlannerNotes()" style="margin-top:10px; color:var(--color-ash-gray); background:none; border:none; cursor:pointer; padding:0">Skip this step</button>
              ` : ''}
            </div>
          ` : `
            <!-- Last Step Form -->
            <form onsubmit="window.handlePlannerSubmit(event)" style="display:flex; flex-direction:column; gap:14px; max-width:440px">
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

              <!-- Brief summary -->
              <div style="background:var(--color-onyx-black); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); padding:14px 16px; display:flex; flex-direction:column; gap:8px">
                <p class="font-primary text-xs fw-medium uppercase ls-05" style="color:var(--color-steel-gray); margin-bottom:4px">Your journey summary</p>
                ${Object.entries(window.plannerAnswers).map(([k, v]) => {
    const stepDef = PLANNER_STEPS.find(s => s.id === k);
    return `
                    <div style="display:flex; justify-content:space-between; gap:16px; align-items:flex-start">
                      <span class="font-primary fs-11" style="color:var(--color-ash-gray); flex-shrink:0">${stepDef ? stepDef.label.replace(/^\d+ — /, '') : k}</span>
                      <span class="font-primary fs-11 fw-medium text-right" style="color:var(--color-pure-white)">${v}</span>
                    </div>
                  `;
  }).join('')}
              </div>

              <!-- CAPTCHA -->
              <div style="display:flex; flex-direction:column; gap:8px; margin-top:4px">
                <label class="text-field-label">Security Verification (CAPTCHA)</label>
                <div style="display:grid; grid-template-columns:auto 1fr; alignItems:center; gap:12px; background:rgba(255,255,255,0.01); border:1px solid rgba(255,255,255,0.05); border-radius:8px; padding:12px">
                  <div style="display:flex; align-items:center; gap:8px">
                    ${window.plannerCaptchaSvg && !window.plannerIsCaptchaLoading ? `
                      <div style="display:flex; align-items:center; border-radius:4px; overflow:hidden">${window.plannerCaptchaSvg}</div>
                    ` : `
                      <div style="width:140px; height:44px; background:#121212; display:flex; align-items:center; justify-content:center; font-size:11px; color:#666">
                        <div style="
                          width: 14px;
                          height: 14px;
                          border: 2px solid rgba(255,255,255,0.1);
                          border-top: 2px solid #fff;
                          border-radius: 50%;
                          animation: adminSpin 1s linear infinite;
                          margin-right: 8px;
                          display: inline-block;
                        "></div>
                        Loading...
                      </div>
                    `}
                    <button
                      type="button"
                      onclick="window.fetchPlannerCaptcha()"
                      ${window.plannerIsCaptchaLoading ? 'disabled' : ''}
                      style="
                        background: rgba(255,255,255,0.05);
                        border: 1px solid rgba(255,255,255,0.08);
                        color: #fff;
                        border-radius: 6px;
                        width: 38px;
                        height: 38px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: ${window.plannerIsCaptchaLoading ? 'not-allowed' : 'pointer'};
                        transition: all 0.2s;
                        opacity: ${window.plannerIsCaptchaLoading ? 0.6 : 1};
                      "
                      title="Refresh CAPTCHA"
                    >
                      <svg 
                        width="15" 
                        height="15" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="currentColor" 
                        stroke-width="2" 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        style="
                          color: var(--color-steel-gray);
                          animation: ${window.plannerIsCaptchaLoading ? 'adminSpin 1s linear infinite' : 'none'};
                        "
                      >
                        <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67" />
                      </svg>
                    </button>
                  </div>
                  <input type="text" id="planner-captcha-input" class="input-terminal" placeholder="Enter CAPTCHA code" style="font-family:monospace; letter-spacing:2px" required>
                </div>
                <p id="planner-captcha-error" style="color:#ff4444; font-size:12px; margin-top:4px; font-weight:500; display:none"></p>
              </div>

              <button type="submit" class="btn-primary fs-13" style="align-self:flex-start" ${window.plannerIsLoading ? 'disabled' : ''}>
                ${window.plannerIsLoading ? `
                  <span class="spinner" style="border: 2px solid rgba(255,255,255,0.2); border-top: 2px solid #fff; border-radius: 50%; width: 14px; height: 14px; display: inline-block; animation: adminSpin 0.8s linear infinite; margin-right: 8px;"></span> Loading...
                ` : 'Send My Journey Brief →'}
              </button>
            </form>
          `}
        </div>

        <!-- Back Button -->
        ${window.plannerStep > 0 ? `
          <button type="button" class="font-primary text-sm" onclick="window.prevPlannerStep()" style="margin-top:20px; background:none; border:none; cursor:pointer; color:var(--color-ash-gray); display:flex; align-items:center; gap:5px; transition:color 0.18s" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">← Back</button>
        ` : ''}
      `}
    </div>
  `;
}

window.setPlannerStep = function (stepIdx) {
  if (stepIdx <= window.plannerStep) {
    window.plannerStep = stepIdx;
    window.renderPlanner();
  }
};

window.prevPlannerStep = function () {
  if (window.plannerStep > 0) {
    window.plannerStep--;
    window.renderPlanner();
  }
};

window.selectPlannerOption = function (opt) {
  const current = PLANNER_STEPS[window.plannerStep];
  window.plannerAnswers[current.id] = opt;
  window.plannerCustomInputs[current.id] = '';

  window.advancePlanner();
};

window.submitPlannerCustomValue = function () {
  const current = PLANNER_STEPS[window.plannerStep];
  const el = document.getElementById(window.plannerStep === 7 ? 'planner-notes-input' : 'planner-text-input');
  if (el && el.value.trim()) {
    const val = el.value.trim();
    window.plannerAnswers[current.id] = val;
    window.plannerCustomInputs[current.id] = val;
    window.advancePlanner();
  }
};

window.skipPlannerNotes = function () {
  window.plannerAnswers['notes'] = '';
  window.advancePlanner();
};

window.advancePlanner = function () {
  if (window.plannerStep < PLANNER_STEPS.length - 1) {
    window.plannerStep++;
    if (window.plannerStep === PLANNER_STEPS.length - 1) {
      window.fetchPlannerCaptcha();
    } else {
      window.renderPlanner();
    }
  }
};

window.handlePlannerSubmit = async function (e) {
  e.preventDefault();
  const errorEl = document.getElementById('planner-captcha-error');
  if (errorEl) errorEl.style.display = 'none';

  const name = document.getElementById('planner-name').value;
  const email = document.getElementById('planner-email').value;
  const phone = document.getElementById('planner-phone').value;
  const captchaInput = document.getElementById('planner-captcha-input').value;

  const summaryLines = Object.entries(window.plannerAnswers)
    .filter(([, v]) => v)
    .map(([k, v]) => {
      const stepDef = PLANNER_STEPS.find(s => s.id === k);
      const label = stepDef ? stepDef.label.replace(/^\d+ — /, '') : k;
      return `${label}: ${v}`;
    });

  const travelersVal = window.plannerAnswers['travelers'] || '1';
  let passengersCount = 1;
  const match = travelersVal.match(/\d+/);
  if (match) {
    passengersCount = parseInt(match[0], 10);
  }

  window.plannerIsLoading = true;
  window.renderPlanner();

  try {
    const res = await fetch('/api/admin/inquiries', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        customerName: name,
        customerPhone: phone || 'Not provided',
        customerEmail: email,
        destinations: window.plannerAnswers['destination'] || 'Custom Pilgrimage',
        duration: window.plannerAnswers['duration'] || 'Not specified',
        travelers: passengersCount,
        budget: window.plannerAnswers['budget'] || 'Standard',
        accommodation: window.plannerAnswers['accommodation'] || 'Standard',
        notes: `Journey Planner Brief:\n${summaryLines.join('\n')}`,
        isPublicInquiry: true,
        captchaToken: window.plannerCaptchaToken,
        captchaInput: captchaInput,
      })
    });

    if (!res.ok) {
      const data = await res.json();
      if (errorEl) {
        errorEl.textContent = data.error || 'CAPTCHA validation failed.';
        errorEl.style.display = 'block';
      }
      window.fetchPlannerCaptcha();
      window.plannerIsLoading = false;
      window.renderPlanner();
      return;
    }

    window.plannerSubmitted = true;
    window.plannerIsLoading = false;
    window.renderPlanner();

    setTimeout(() => { window.openPlannerWhatsApp(name, email, phone, summaryLines); }, 800);

  } catch (err) {
    console.error('Server DB submit failed, direct handoff to WhatsApp', err);
    window.plannerIsLoading = false;
    window.renderPlanner();
    window.openPlannerWhatsApp(name, email, phone, summaryLines);
  }
};

window.openPlannerWhatsApp = function (name, email, phone, summaryLines) {
  if (!name) {
    name = document.getElementById('planner-name') ? document.getElementById('planner-name').value : 'Guest';
    email = document.getElementById('planner-email') ? document.getElementById('planner-email').value : '';
    phone = document.getElementById('planner-phone') ? document.getElementById('planner-phone').value : '';
    summaryLines = Object.entries(window.plannerAnswers)
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

window.renderPlanner();

// ────────────────────────────────────────────────────────────────
// 12. INTERACTIVE PROPERTY MODAL (HOTELS / VILLAS)
// ────────────────────────────────────────────────────────────────

window.openPropertyModal = function(item, type) {
  const modal = document.getElementById('property-modal');
  if (!modal) return;

  // Set hidden inputs
  document.getElementById('modal-property-id').value = item.id;
  document.getElementById('modal-property-type').value = type;
  document.getElementById('modal-property-name').value = item.name;
  document.getElementById('modal-property-location').value = item.location;
  document.getElementById('modal-property-price').value = item.price;

  // Render left info panel with gallery
  const infoPanel = document.getElementById('property-modal-info');
  if (infoPanel) {
    const gallery = [item.imagePath].concat(item.gallery || []).filter(Boolean);
    window.currentModalGallery = gallery;
    infoPanel.innerHTML = `
      <!-- Main Image Container -->
      <div style="position:relative; height:240px; overflow:hidden; cursor:zoom-in;" onclick="window.openLightbox(window.currentModalGallery, window.currentModalGallery.findIndex(url => document.getElementById('modal-main-img').src.endsWith(url)), event)">
        <img id="modal-main-img" src="${gallery[0]}" alt="${item.name}" style="width:100%; height:100%; object-fit:cover; transition: opacity 0.3s ease;" />
        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(12,12,12,0.9), transparent);"></div>
        <div style="position:absolute; bottom:16px; left:20px; right:20px;">
          <span style="font-size:10px; font-weight:600; color:var(--color-onyx-black); background:var(--color-highlighter-lime); padding:3px 8px; border-radius:12px; margin-bottom:8px; display:inline-block;">
            ★ ${item.rating}
          </span>
          <h2 class="font-secondary fs-24" style="color:#fff; line-height:1.2; margin:0;">${item.name}</h2>
        </div>
      </div>
      
      <!-- Gallery Thumbnails (only if multiple images exist) -->
      ${gallery.length > 1 ? `
      <div style="display:flex; gap:8px; padding:12px 24px; background:rgba(0,0,0,0.25); overflow-x:auto; border-bottom:1px solid var(--color-zinc-hairline);">
        ${gallery.map((img, idx) => `
          <img 
            src="${img}" 
            alt="Gallery ${idx + 1}" 
            onclick="document.getElementById('modal-main-img').src='${img}'; document.querySelectorAll('.gallery-thumb').forEach(t => t.style.borderColor='transparent'); this.style.borderColor='var(--color-highlighter-lime)';"
            class="gallery-thumb"
            style="width:50px; height:50px; object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid ${idx === 0 ? 'var(--color-highlighter-lime)' : 'transparent'}; transition:all 0.2s;"
          />
        `).join('')}
      </div>
      ` : ''}
      
      <div style="padding:24px; display:flex; flex-direction:column; gap:16px;">
        <div>
          <span style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; display:block;">Location</span>
          <p class="font-primary text-sm" style="color:#eee; margin:2px 0 0 0;">📍 ${item.location}</p>
        </div>
        <div>
          <span style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; display:block;">Price Range</span>
          <p class="font-primary fs-18 fw-medium" style="color:var(--color-highlighter-lime); margin:2px 0 0 0;">${item.price}</p>
        </div>
        <div>
          <span style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; display:block;">Basic Information</span>
          <p class="font-primary text-sm text-muted lh-15" style="margin:2px 0 0 0;">${item.description}</p>
        </div>
        <div>
          <span style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; display:block; margin-bottom:6px;">Amenities Included</span>
          <div style="display:flex; gap:6px; flex-wrap:wrap;">
            ${(item.amenities || []).map(am => `
              <span class="font-primary" style="font-size:10px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); color:#aaa; padding:3px 8px; border-radius:6px;">
                ${am}
              </span>
            `).join('')}
          </div>
        </div>
      </div>
    `;
  }

  // Clear previous values
  document.getElementById('prop-captcha-input').value = '';
  const errorEl = document.getElementById('prop-captcha-error');
  if (errorEl) errorEl.style.display = 'none';

  // Open modal
  modal.style.display = 'flex';
  window.fetchPropCaptcha();
};

window.closePropertyModal = function() {
  const modal = document.getElementById('property-modal');
  if (modal) modal.style.display = 'none';
};

window.fetchPropCaptcha = function() {
  fetch('/api/captcha')
    .then(r => r.json())
    .then(data => {
      const container = document.getElementById('prop-captcha-svg-container');
      if (container) container.innerHTML = data.svg;
    })
    .catch(err => console.error('Prop captcha load failed', err));
};

window.handlePropertyInquirySubmit = async function(e) {
  e.preventDefault();
  const errorEl = document.getElementById('prop-captcha-error');
  if (errorEl) errorEl.style.display = 'none';

  const submitBtn = document.getElementById('prop-submit-btn');
  if (submitBtn) submitBtn.disabled = true;

  const propId = document.getElementById('modal-property-id').value;
  const propType = document.getElementById('modal-property-type').value;
  const propName = document.getElementById('modal-property-name').value;
  const propLoc = document.getElementById('modal-property-location').value;
  const propPrice = document.getElementById('modal-property-price').value;

  const guestName = document.getElementById('prop-guest-name').value;
  const guestPhone = document.getElementById('prop-guest-phone').value;
  const checkin = document.getElementById('prop-checkin').value;
  const checkout = document.getElementById('prop-checkout').value;
  const males = parseInt(document.getElementById('prop-males').value || '0', 10);
  const females = parseInt(document.getElementById('prop-females').value || '0', 10);
  const kids = parseInt(document.getElementById('prop-kids').value || '0', 10);
  const notes = document.getElementById('prop-notes').value;
  const captchaVal = document.getElementById('prop-captcha-input').value;

  const totalGuests = males + females + kids;
  const durationStr = `${checkin} to ${checkout}`;
  const notesStr = `Males: ${males}, Females: ${females}, Children: ${kids}. Guest Notes: ${notes}`;

  try {
    const res = await fetch('/api/admin/inquiries', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        customerName: guestName,
        customerPhone: guestPhone,
        customerEmail: 'inquiry@shivalay.in',
        destinations: `${propType.toUpperCase()} - ${propName}`,
        duration: durationStr,
        travelers: totalGuests,
        budget: propPrice,
        accommodation: propType === 'hotel' ? 'Hotel Stay' : 'Villa Stay',
        notes: notesStr,
        captchaInput: captchaVal
      })
    });

    if (!res.ok) {
      const errData = await res.json();
      if (errorEl) {
        errorEl.textContent = errData.error || 'CAPTCHA verification failed.';
        errorEl.style.display = 'block';
      }
      window.fetchPropCaptcha();
      if (submitBtn) submitBtn.disabled = false;
      return;
    }

    // Success: close modal, open WhatsApp
    window.closePropertyModal();
    if (submitBtn) submitBtn.disabled = false;

    const whatsappText = `Hello Shivalay Travels! I would like to book a stay at the ${propType}: *${propName}*:\n\n` +
      `📍 *Location:* ${propLoc}\n` +
      `📅 *Check-in:* ${checkin}\n` +
      `📅 *Check-out:* ${checkout}\n` +
      `👥 *Guests:* ${males} Male(s), ${females} Female(s), ${kids} Child(ren) (Total: ${totalGuests})\n` +
      `📲 *Contact Phone:* ${guestPhone}\n` +
      `📝 *Special Requests:* ${notes || 'None'}\n\n` +
      `Please confirm availability. Thanks!`;

    window.open(`https://wa.me/919340994628?text=${encodeURIComponent(whatsappText)}`, '_blank');

  } catch (err) {
    console.error('Property inquiry submission error', err);
    if (submitBtn) submitBtn.disabled = false;
    
    // Direct WhatsApp fallback if API fails
    window.closePropertyModal();
    const whatsappText = `Hello Shivalay Travels! I would like to book a stay at the ${propType}: *${propName}*:\n\n` +
      `📍 *Location:* ${propLoc}\n` +
      `📅 *Check-in:* ${checkin}\n` +
      `📅 *Check-out:* ${checkout}\n` +
      `👥 *Guests:* ${males} Male(s), ${females} Female(s), ${kids} Child(ren)\n` +
      `📲 *Contact Phone:* ${guestPhone}\n` +
      `📝 *Special Requests:* ${notes || 'None'}\n\n` +
      `Please confirm availability. Thanks!`;
    window.open(`https://wa.me/919340994628?text=${encodeURIComponent(whatsappText)}`, '_blank');
  }
};

// ────────────────────────────────────────────────────────────────
// 13. DYNAMIC CARD IMAGE GALLERY & FULLSCREEN LIGHTBOX
// ────────────────────────────────────────────────────────────────

window.lazyLoadCardImages = function(wrapper) {
  if (!wrapper) return;
  const lazyImages = wrapper.querySelectorAll('img[data-src]');
  lazyImages.forEach(img => {
    img.src = img.getAttribute('data-src');
    img.removeAttribute('data-src');
  });
};

window.changeCardImage = function(btn, dir) {
  const wrapper = btn.closest('.property-card-gallery-wrapper');
  if (!wrapper) return;
  
  // Preload/lazy-load all remaining images in this wrapper before switching
  window.lazyLoadCardImages(wrapper);

  const images = wrapper.querySelectorAll('.prop-gallery-img');
  if (images.length <= 1) return;

  let activeIdx = 0;
  images.forEach((img, idx) => {
    if (img.style.opacity === "1") {
      activeIdx = idx;
    }
  });

  // Hide current
  images[activeIdx].style.opacity = "0";

  // Calculate new index
  let newIdx = activeIdx + dir;
  if (newIdx >= images.length) newIdx = 0;
  if (newIdx < 0) newIdx = images.length - 1;

  // Show new
  images[newIdx].style.opacity = "1";

  // Update dots
  const dots = wrapper.querySelectorAll('.prop-gallery-dot');
  dots.forEach((dot, idx) => {
    if (idx === newIdx) {
      dot.style.background = 'var(--color-highlighter-lime)';
    } else {
      dot.style.background = 'rgba(255,255,255,0.4)';
    }
  });
};

window.getCardActiveIdx = function(wrapper) {
  if (!wrapper) return 0;
  const images = wrapper.querySelectorAll('.prop-gallery-img');
  for (let i = 0; i < images.length; i++) {
    if (images[i].style.opacity === "1") {
      return i;
    }
  }
  return 0;
};

let lightboxImages = [];
let lightboxIndex = 0;

window.openLightbox = function(images, index, event) {
  if (event) event.stopPropagation();
  lightboxImages = (images || []).filter(Boolean);
  lightboxIndex = index || 0;
  if (lightboxImages.length === 0) return;

  const lightbox = document.getElementById('image-lightbox');
  const img = document.getElementById('lightbox-img');
  const caption = document.getElementById('lightbox-caption');
  const prevBtn = document.getElementById('lightbox-prev');
  const nextBtn = document.getElementById('lightbox-next');

  if (!lightbox || !img) return;

  img.src = lightboxImages[lightboxIndex];
  if (caption) {
    caption.textContent = `Image ${lightboxIndex + 1} of ${lightboxImages.length}`;
  }

  if (lightboxImages.length <= 1) {
    if (prevBtn) prevBtn.style.display = 'none';
    if (nextBtn) nextBtn.style.display = 'none';
  } else {
    if (prevBtn) prevBtn.style.display = 'flex';
    if (nextBtn) nextBtn.style.display = 'flex';
  }

  lightbox.style.display = 'flex';
  setTimeout(() => {
    lightbox.style.opacity = '1';
  }, 10);
};

window.closeLightbox = function() {
  const lightbox = document.getElementById('image-lightbox');
  if (lightbox) {
    lightbox.style.opacity = '0';
    setTimeout(() => {
      lightbox.style.display = 'none';
    }, 250);
  }
};

window.navigateLightbox = function(dir) {
  if (lightboxImages.length <= 1) return;
  lightboxIndex += dir;
  if (lightboxIndex >= lightboxImages.length) lightboxIndex = 0;
  if (lightboxIndex < 0) lightboxIndex = lightboxImages.length - 1;

  const img = document.getElementById('lightbox-img');
  const caption = document.getElementById('lightbox-caption');
  if (img) {
    img.style.opacity = '0.7';
    setTimeout(() => {
      img.src = lightboxImages[lightboxIndex];
      img.style.opacity = '1';
    }, 100);
  }
  if (caption) {
    caption.textContent = `Image ${lightboxIndex + 1} of ${lightboxImages.length}`;
  }
};

// Keyboard listener for lightbox
document.addEventListener('keydown', function(e) {
  const lightbox = document.getElementById('image-lightbox');
  if (!lightbox || lightbox.style.display === 'none') return;

  if (e.key === 'Escape') {
    window.closeLightbox();
  } else if (e.key === 'ArrowLeft' || e.key === 'Left') {
    window.navigateLightbox(-1);
  } else if (e.key === 'ArrowRight' || e.key === 'Right') {
    window.navigateLightbox(1);
  }
});
