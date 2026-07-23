<!-- ═══════════════ MEMORIES (GUEST REVIEWS) ═══════════════ -->
<section id="stories" style="background:var(--surface-canvas);padding:48px 0;border-bottom:1px solid var(--color-zinc-hairline)">
  <div class="container">
    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:28px;flex-wrap:wrap;gap:16px">
      <div>
        <p class="section-label" style="margin-bottom:8px">Guest Reviews</p>
        <h2 class="heading-lg">What Our Guests Say.<br>Honest Experiences.</h2>
      </div>
      <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px">
        <div style="display:flex;gap:2px">
          <span style="color:var(--color-highlighter-lime);fontSize:14px">★</span>
          <span style="color:var(--color-highlighter-lime);fontSize:14px">★</span>
          <span style="color:var(--color-highlighter-lime);fontSize:14px">★</span>
          <span style="color:var(--color-highlighter-lime);fontSize:14px">★</span>
          <span style="color:var(--color-highlighter-lime);fontSize:14px">★</span>
        </div>
        <p class="font-primary text-sm text-muted">4.97 / 5 from 860+ families</p>
      </div>
    </div>

    <!-- Main layout -->
    <div style="display:grid;grid-template-columns:1fr 280px;gap:20px;margin-bottom:28px">
      <!-- Main card -->
      <div id="testimonial-card" style="background:var(--color-carbon);border:1px solid var(--color-zinc-hairline);border-radius:var(--radius-xl);padding:28px;display:flex;gap:24px;position:relative;overflow:hidden;transition:opacity 0.18s ease, transform 0.18s ease">
        <!-- Text content column -->
        <div style="flex:1; display:flex; flex-direction:column; min-width:0">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px">
            <div style="display:flex;gap:2px" id="testimonial-rating">
              <span style="color:var(--color-highlighter-lime);fontSize:12px">★</span>
              <span style="color:var(--color-highlighter-lime);fontSize:12px">★</span>
              <span style="color:var(--color-highlighter-lime);fontSize:12px">★</span>
              <span style="color:var(--color-highlighter-lime);fontSize:12px">★</span>
              <span style="color:var(--color-highlighter-lime);fontSize:12px">★</span>
            </div>
            <span class="font-primary text-xs" style="color:var(--color-steel-gray);padding:3px 8px;border:1px solid var(--color-zinc-hairline);border-radius:var(--radius-full)" id="testimonial-dest">Kashmir</span>
          </div>
          <p class="text-quote" style="flex:1;margin-bottom:24px;position:relative;zIndex:1" id="testimonial-quote">
            &ldquo;Our Kashmir honeymoon was beyond imagination. Every detail — the scenic houseboat, the private saffron farm walk — felt tailored to our exact pace.&rdquo;
          </p>
          <div style="display:flex;align-items:center;gap:12px;border-top:1px solid var(--color-zinc-hairline);padding-top:18px">
            <div class="font-primary fs-13 fw-medium" style="width:40px;height:40px;border-radius:var(--radius-md);background:var(--color-highlighter-lime);display:flex;align-items:center;justify-content:center;color:var(--color-onyx-black);flex-shrink:0" id="testimonial-avatar">
              PA
            </div>
            <div>
              <p class="font-primary fw-medium fs-13" style="color:var(--color-pure-white);margin-bottom:2px" id="testimonial-name">Priya &amp; Arjun Mehta</p>
              <p class="font-primary fs-11 text-muted" id="testimonial-meta">Mumbai · Honeymoon · 8 nights</p>
            </div>
            <!-- Nav arrows -->
            <div style="margin-left:auto;display:flex;gap:6px">
              <button id="testimonial-prev-btn" style="width:32px;height:32px;border-radius:var(--radius-md);background:transparent;border:1px solid var(--color-zinc-hairline);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--color-steel-gray);transition:all 0.18s ease" onmouseenter="this.style.background='var(--color-zinc-hairline)';this.style.color='var(--color-pure-white)'" onmouseleave="this.style.background='transparent';this.style.color='var(--color-steel-gray)'">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="15 18 9 12 15 6" />
                </svg>
              </button>
              <button id="testimonial-next-btn" style="width:32px;height:32px;border-radius:var(--radius-md);background:transparent;border:1px solid var(--color-zinc-hairline);display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--color-steel-gray);transition:all 0.18s ease" onmouseenter="this.style.background='var(--color-zinc-hairline)';this.style.color='var(--color-pure-white)'" onmouseleave="this.style.background='transparent';this.style.color='var(--color-steel-gray)'">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="9 18 15 12 9 6" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <!-- Image column -->
        <div id="testimonial-image-wrapper" style="width:240px; flex-shrink:0; position:relative; border-radius:var(--radius-lg); overflow:hidden; border:1px solid rgba(255,255,255,0.06); display:flex">
          <img id="testimonial-img" src="/images/kashmir.png" alt="Guest Memory" style="width:100%; height:100%; object-fit:cover; filter:brightness(0.85); transition:all 0.3s ease" />
        </div>
      </div>

      <!-- Sidebar buttons list -->
      <div style="display:flex;flex-direction:column;gap:6px;max-height:340px;overflow-y:auto" id="testimonial-sidebar">
        <!-- Testimonial Items loaded by JS -->
      </div>
    </div>

    <!-- Dots -->
    <div style="display:flex;justify-content:center;gap:4px;margin-bottom:32px" id="testimonial-dots">
      <!-- Dots loaded by JS -->
    </div>

    <!-- Media mentions -->
    <div style="border-top:1px solid var(--color-zinc-hairline);border-bottom:1px solid var(--color-zinc-hairline);padding:16px 0;margin-bottom:24px">
      <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;justify-content:center">
        <p class="font-primary text-xs fw-medium uppercase ls-1" style="color:var(--color-ash-gray);white-space:nowrap">As featured in</p>
        <span class="font-primary text-sm text-muted" style="white-space:nowrap;transition:color 0.18s;cursor:default" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-steel-gray)'">Cond&eacute; Nast Traveller India</span>
        <span class="font-primary text-sm text-muted" style="white-space:nowrap;transition:color 0.18s;cursor:default" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-steel-gray)'">Travel + Leisure India</span>
        <span class="font-primary text-sm text-muted" style="white-space:nowrap;transition:color 0.18s;cursor:default" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-steel-gray)'">National Geographic Traveller</span>
        <span class="font-primary text-sm text-muted" style="white-space:nowrap;transition:color 0.18s;cursor:default" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-steel-gray)'">Forbes India</span>
        <span class="font-primary text-sm text-muted" style="white-space:nowrap;transition:color 0.18s;cursor:default" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-steel-gray)'">Outlook Traveller</span>
        <span class="font-primary text-sm text-muted" style="white-space:nowrap;transition:color 0.18s;cursor:default" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-steel-gray)'">The Hindu Lifestyle</span>
      </div>
    </div>

    <!-- CTA -->
    <div class="reveal" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
      <div>
        <p class="font-secondary text-xl fw-regular" style="color:var(--color-pure-white);margin-bottom:4px">Your story belongs here too.</p>
        <p class="font-primary text-sm text-muted">Join thousands of happy travellers who choose Shivalay Travels.</p>
      </div>
      <button class="btn-primary" onclick="smoothScroll('planner')">Start My Journey</button>
    </div>
  </div>

  <style>
    @media (max-width: 768px) {
      #stories .container > div:nth-child(2) { grid-template-columns: 1fr !important; }
      #stories .container > div:nth-child(2) > div:last-child { display: none !important; }
      #testimonial-card { flex-direction: column !important; }
      #testimonial-image-wrapper { width: 100% !important; height: 180px !important; order: -1; }
    }
  </style>
</section>
