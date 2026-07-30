<!-- ═══════════════ FOOTER ═══════════════ -->
<footer style="background:var(--surface-canvas);border-top:1px solid var(--color-zinc-hairline);padding:48px 0 32px">
  <div class="container">
    <div class="footer-grid">
      <!-- Brand -->
      <div>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
          <div style="width:24px;height:24px;border-radius:var(--radius-md);background:var(--color-highlighter-lime);display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--color-onyx-black)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
               <path d="M22 2L15 22L11 13L2 9L22 2Z" />
            </svg>
          </div>
          <span class="font-primary fw-medium text-md" style="color:var(--color-pure-white)">Shivalay Travels</span>
        </div>
        <p class="font-primary text-sm lh-16 text-dim">
          Complete travel solutions for all your pilgrimage and holiday needs.
        </p>
        <div style="display:flex;flex-direction:column;gap:8px;margin-top:20px">
          <a href="mailto:info@shivalaytravels.com" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">
            info@shivalaytravels.com
          </a>
          <a href="https://wa.me/919340994628" target="_blank" rel="noopener noreferrer" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">
            WhatsApp: +919340994628
          </a>
        </div>
      </div>

      <!-- Link columns -->
      <div class="footer-links-grid">
        <div>
          <p class="font-primary text-xs fw-medium uppercase ls-08 text-muted" style="margin-bottom:16px">Destinations</p>
          <div style="display:flex;flex-direction:column;gap:10px">
            <a href="#destinations" onclick="smoothScroll('destinations'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Kedarnath</a>
            <a href="#destinations" onclick="smoothScroll('destinations'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Chardham Yatra</a>
            <a href="#destinations" onclick="smoothScroll('destinations'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Varanasi Yatra</a>
            <a href="#destinations" onclick="smoothScroll('destinations'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Kashmir Valley</a>
            <a href="#destinations" onclick="smoothScroll('destinations'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Goa Beaches</a>
            <a href="#destinations" onclick="smoothScroll('destinations'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">All Indian Tours</a>
          </div>
        </div>

        <div>
          <p class="font-primary text-xs fw-medium uppercase ls-08 text-muted" style="margin-bottom:16px">Services</p>
          <div style="display:flex;flex-direction:column;gap:10px">
            <a href="#tickets" onclick="smoothScroll('tickets'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Bus Booking</a>
            <a href="#tickets" onclick="smoothScroll('tickets'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Taxi Booking</a>
            <a href="#hotels" onclick="smoothScroll('hotels'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Hotel Stays</a>
            <a href="#villas" onclick="smoothScroll('villas'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Villa Stays</a>
            <a href="#planner" onclick="smoothScroll('planner'); return false;" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Customised Tour Packages</a>
          </div>
        </div>

        <div>
          <p class="font-primary text-xs fw-medium uppercase ls-08 text-muted" style="margin-bottom:16px">Contact Office</p>
          <div style="display:flex;flex-direction:column;gap:14px">
            <div>
              <p class="font-primary text-xs fw-semibold" style="color:var(--color-pure-white);margin:0 0 4px">{{ $settings['staff1_name'] ?? 'Nisha Chouhan' }}</p>
              @php
                $staff1Phone = $settings['staff1_phone'] ?? '+91 93409 94628';
                $staff1CleanPhone = preg_replace('/[^0-9+]/', '', $staff1Phone);
                $staff1Email = $settings['staff1_email'] ?? 'shivalaytravels385@gmail.com';
              @endphp
              <a href="tel:{{ $staff1CleanPhone }}" class="text-link-sm" style="display:block;margin-bottom:2px" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Phone: {{ $staff1Phone }}</a>
              <a href="mailto:{{ $staff1Email }}" class="text-link-sm" style="font-size:11px" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">{{ $staff1Email }}</a>
            </div>
            <div>
              <p class="font-primary text-xs fw-semibold" style="color:var(--color-pure-white);margin:0 0 4px">{{ $settings['staff2_name'] ?? 'Manisha' }}</p>
              @php
                $staff2Phone = $settings['staff2_phone'] ?? '+91 62618 53598';
                $staff2CleanPhone = preg_replace('/[^0-9+]/', '', $staff2Phone);
                $staff2Email = $settings['staff2_email'] ?? 'shivalaytravels385@gmail.com';
              @endphp
              <a href="tel:{{ $staff2CleanPhone }}" class="text-link-sm" style="display:block;margin-bottom:2px" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Phone: {{ $staff2Phone }}</a>
              <a href="mailto:{{ $staff2Email }}" class="text-link-sm" style="font-size:11px" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">{{ $staff2Email }}</a>
            </div>
            <div style="margin-top:4px">
              <a href="https://maps.google.com/?q=Indore%2C%20Madhya%20Pradesh%2C%20India" target="_blank" rel="noopener noreferrer" class="text-link-sm" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">Indore, Madhya Pradesh, India</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom bar -->
    <div style="border-top:1px solid var(--color-zinc-hairline);padding-top:24px;margin-top:40px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px">
      <p class="font-primary text-sm text-dim">
        © 2026 Shivalay Travels. All rights reserved.
      </p>
      <div style="display:flex;gap:6px;align-items:center">
        <span style="width:5px;height:5px;border-radius:50%;background:var(--color-highlighter-lime);display:inline-block;animation:pulse 2s infinite"></span>
        <p class="font-primary text-sm text-dim">
          Your Journey, Our Responsibility.
        </p>
      </div>
    </div>
  </div>

  <style>
    @media (max-width: 768px) {
      .footer-grid { grid-template-columns: 1fr !important; gap: 32px !important; }
      .footer-links-grid { grid-template-columns: 1fr 1fr !important; }
    }
    @media (max-width: 480px) {
      .footer-links-grid { grid-template-columns: 1fr !important; gap: 24px !important; }
    }
  </style>
</footer>
