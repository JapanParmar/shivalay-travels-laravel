<!-- ═══════════════ DESTINATIONS ═══════════════ -->
<section id="destinations" style="background:var(--surface-canvas);padding:48px 0;border-bottom:1px solid var(--color-zinc-hairline)">
  <div class="container">
    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:24px;flex-wrap:wrap;gap:16px">
      <div>
        <p class="section-label" style="margin-bottom:8px">Curated Destinations</p>
        <h2 class="heading-lg">Sacred Yatras &amp; Scenic Getaways</h2>
      </div>
      <div style="display:flex;align-items:center;gap:8px">
        <button class="btn-ghost text-sm" style="padding:6px 14px" onclick="smoothScroll('planner')">
          Custom Package
        </button>
        <button
          onclick="scrollDestinations('left')"
          style="width:34px;height:34px;border-radius:var(--radius-md);border:1px solid var(--color-zinc-hairline);background:transparent;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.18s ease;color:var(--color-steel-gray)"
          onmouseenter="this.style.background='var(--color-carbon)';this.style.color='var(--color-pure-white)'"
          onmouseleave="this.style.background='transparent';this.style.color='var(--color-steel-gray)'"
        >
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <button
          onclick="scrollDestinations('right')"
          style="width:34px;height:34px;border-radius:var(--radius-md);border:1px solid var(--color-zinc-hairline);background:transparent;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.18s ease;color:var(--color-steel-gray)"
          onmouseenter="this.style.background='var(--color-carbon)';this.style.color='var(--color-pure-white)'"
          onmouseleave="this.style.background='transparent';this.style.color='var(--color-steel-gray)'"
        >
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Filter pills -->
    <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:20px" id="dest-pills"></div>

    <!-- Scroll row -->
    <div style="position:relative">
      <div style="position:absolute;top:0;bottom:16px;left:0;width:40px;background:linear-gradient(to right, var(--surface-canvas), transparent);z-index:5;pointer-events:none"></div>
      <div style="position:absolute;top:0;bottom:16px;right:0;width:40px;background:linear-gradient(to left, var(--surface-canvas), transparent);z-index:5;pointer-events:none"></div>

      <div
        id="dest-scroll-row"
        class="h-scroll-row"
        style="padding-bottom:12px;user-select:none"
      ></div>
    </div>

    <!-- Scroll dots -->
    <div style="display:flex;justify-content:center;gap:4px;margin-top:12px" id="dest-dots"></div>

    <!-- Expanded Detail -->
    <div id="dest-detail" style="display:none; margin-top: 20px; background: var(--color-onyx-black); border: 1px solid var(--color-zinc-hairline); border-radius: var(--radius-xl); padding: 24px;">
      <div class="destinations-detail-grid">
        <div>
          <div style="display: flex; gap: 6px; margin-bottom: 16px;">
            <span class="font-primary text-xs text-muted" style="padding: 3px 8px; border: 1px solid var(--color-zinc-hairline); border-radius: var(--radius-full);" id="dest-detail-region"></span>
            <span class="font-primary text-xs" style="color: var(--color-highlighter-lime); padding: 3px 8px; border: 1px solid var(--color-highlighter-lime); border-radius: var(--radius-full);" id="dest-detail-difficulty"></span>
          </div>
          <h3 class="heading-md" style="margin-bottom: 8px;" id="dest-detail-title"></h3>
          <p class="font-primary fs-13 text-muted lh-16" style="margin-bottom: 20px;" id="dest-detail-tagline"></p>
          
          <div style="display: flex; gap: 24px; margin-bottom: 24px; flex-wrap: wrap;">
            <div>
              <p class="font-primary text-xs fw-medium uppercase ls-05 text-muted" style="margin-bottom: 4px;">Duration</p>
              <p class="font-primary fs-14 fw-medium" id="dest-detail-duration"></p>
            </div>
            <div>
              <p class="font-primary text-xs fw-medium uppercase ls-05 text-muted" style="margin-bottom: 4px;">Group size</p>
              <p class="font-primary fs-14 fw-medium" id="dest-detail-groupsize"></p>
            </div>
            <div>
              <p class="font-primary text-xs fw-medium uppercase ls-05 text-muted" style="margin-bottom: 4px;">Best season</p>
              <p class="font-primary fs-14 fw-medium" id="dest-detail-bestseason"></p>
            </div>
            <div>
              <p class="font-primary text-xs fw-medium uppercase ls-05 text-muted" style="margin-bottom: 4px;">Starting from</p>
              <p class="font-primary fs-14 fw-medium" style="color: var(--color-highlighter-lime);" id="dest-detail-startingfrom"></p>
            </div>
          </div>
          
          <p class="font-primary text-xs fw-medium uppercase ls-05 text-muted" style="margin-bottom: 12px;">Signature Experiences</p>
          <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;" id="dest-detail-highlights"></div>
          
          <div style="display: flex; gap: 8px;">
            <button class="btn-primary" onclick="smoothScroll('planner')">Plan this journey</button>
            <button class="btn-ghost" onclick="toggleDestDetail(destExpandedId)">Close</button>
          </div>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 16px;">
          <div id="dest-detail-img-wrap" class="img-zoom-wrap skeleton-loading" style="height: 200px; border-radius: var(--radius-xl); overflow: hidden; position: relative;">
            <img id="dest-detail-img" src="" alt="" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.3s ease; opacity: 0;" onload="this.style.opacity=1; this.parentElement.classList.remove('skeleton-loading');">
          </div>
          <p class="font-primary text-xs fw-medium uppercase ls-05 text-muted">Included in every journey</p>
          <div style="display: flex; flex-direction: column; gap: 6px;" id="dest-detail-includes"></div>
        </div>
      </div>
    </div>
  </div>
</section>
