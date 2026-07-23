<!-- ═══════════════ EARTH OUTRO ═══════════════ -->
<section style="position:relative;padding:80px 0;background:var(--surface-canvas);overflow:hidden;border-bottom:1px solid var(--color-zinc-hairline)">
  <!-- Background image -->
  <div style="position:absolute;inset:0;backgroundImage:url(/images/goa.png);backgroundSize:cover;backgroundPosition:center;opacity:0.12;zIndex:1;transition:transform 1.2s ease"></div>
  <!-- Overlay -->
  <div style="position:absolute;inset:0;background:var(--surface-canvas);opacity:0.6;zIndex:2"></div>

  <div class="container" style="position:relative;zIndex:3">
    <div style="display:flex;flex-direction:column;align-items:center;textAlign:center;gap:24px;maxWidth:600px;margin:0 auto">
      <div class="announcement-banner reveal">
        <span style="width:5px;height:5px;borderRadius:50%;background:var(--color-highlighter-lime);animation:pulse 2s infinite;display:inline-block"></span>
        Begin your story
      </div>

      <h2 class="reveal font-secondary fs-outro fw-regular lh-115" style="color:var(--color-pure-white)">
        Your Indian Odyssey<br>
        <span style="color:var(--color-ash-gray)">starts here.</span>
      </h2>

      <p class="reveal reveal-d1 font-primary text-md fw-regular lh-17 text-muted" style="maxWidth:480px">
        Every extraordinary journey begins with a single conversation. Tell us where you want to go — we'll handle every extraordinary detail.
      </p>

      <!-- Email CTA form -->
      <form class="reveal reveal-d2" onsubmit="event.preventDefault(); smoothScroll('planner')" style="display:flex;gap:8px;width:100%;maxWidth:420px">
        <input type="email" placeholder="Enter your email" class="input-terminal" style="flex:1" required>
        <button type="submit" class="btn-primary fs-13" style="flexShrink:0;whiteSpace:nowrap">
          Plan my journey
        </button>
      </form>

      <!-- Secondary CTAs -->
      <div class="reveal reveal-d3" style="display:flex;gap:16px;flexWrap:wrap;justifyContent:center;alignItems:center">
        <a href="https://wa.me/919340994628" target="_blank" rel="noopener noreferrer" class="font-primary fs-13 no-underline text-muted" style="display:inline-flex;alignItems:center;gap:6px;transition:color 0.18s ease" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-steel-gray)'">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="#25D366">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
          </svg>
          WhatsApp a travel expert
        </a>
        <span style="color:var(--color-zinc-hairline)">·</span>
        <a href="mailto:info@shivalaytravels.com" class="font-primary fs-13 no-underline text-muted" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-steel-gray)'">info@shivalaytravels.com</a>
      </div>
    </div>
  </div>
</section>
