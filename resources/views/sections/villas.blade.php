<!-- Villas Section -->
<section id="villas" style="background: var(--color-onyx-black-98); padding: 80px 0; border-bottom: 1px solid var(--color-zinc-hairline);">
  <div class="container">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
      <div>
        <p class="font-primary text-xs fw-medium uppercase ls-2 text-muted" style="margin-bottom: 8px;">✦ Ultra Luxury Escapes</p>
        <h2 class="font-secondary fs-36 fw-regular" style="color: var(--color-pure-white); line-height: 1.1;">Private Villas &amp; Estates</h2>
      </div>
      <p class="font-primary text-sm text-muted" style="max-width: 360px;">
        Indulge in spacious, high-end private villas featuring stunning views, dedicated chefs, and absolute privacy.
      </p>
    </div>

    <!-- Grid -->
    <div class="villas-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
      @foreach($villas as $v)
        <div class="villa-card" style="background: var(--color-carbon); border: 1px solid var(--color-zinc-hairline); border-radius: var(--radius-xl); overflow: hidden; display: flex; flex-direction: column; transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);"
             onmouseenter="this.style.transform='translateY(-6px)'; this.style.borderColor='rgba(255, 0, 0, 0.3)';"
             onmouseleave="this.style.transform='none'; this.style.borderColor='var(--color-zinc-hairline)';">
          <!-- Image Carousel -->
          @php
            $gallery = array_filter(array_merge([$v['imagePath'] ?? null], $v['gallery'] ?? []));
          @endphp
          <div class="property-card-gallery-wrapper skeleton-loading" style="height: 220px; position: relative; overflow: hidden; cursor: zoom-in;" onmouseenter="window.lazyLoadCardImages(this)" onclick='window.openLightbox({!! json_encode(array_values($gallery)) !!}, window.getCardActiveIdx(this), event)'>
            <div class="property-card-gallery" style="position: relative; width: 100%; height: 100%;">
              @foreach($gallery as $idx => $img)
                @if($idx === 0)
                  <img src="{{ $img }}" class="prop-gallery-img prop-img-{{ $idx }}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: opacity 0.4s ease; opacity: 0;" onload="this.style.opacity=1; this.closest('.property-card-gallery-wrapper').classList.remove('skeleton-loading');" />
                @else
                  <img data-src="{{ $img }}" class="prop-gallery-img prop-img-{{ $idx }}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: opacity 0.4s ease; opacity: 0; pointer-events: none;" />
                @endif
              @endforeach
            </div>
            
            <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(12, 12, 12, 0.8) 0%, transparent 100%); pointer-events: none;"></div>
            
            @if(count($gallery) > 1)
              <!-- Left/Right navigation for card gallery -->
              <button type="button" class="prop-gallery-nav-btn prev" onclick="event.stopPropagation(); window.changeCardImage(this, -1)" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); border: none; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; opacity: 0; transition: opacity 0.25s, background 0.2s, transform 0.2s;">
                ‹
              </button>
              <button type="button" class="prop-gallery-nav-btn next" onclick="event.stopPropagation(); window.changeCardImage(this, 1)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); border: none; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; opacity: 0; transition: opacity 0.25s, background 0.2s, transform 0.2s;">
                ›
              </button>
              
              <!-- Dots indicator -->
              <div class="prop-gallery-dots" style="position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); display: flex; gap: 4px; z-index: 10;">
                @foreach($gallery as $idx => $img)
                  <span class="prop-gallery-dot" style="width: 6px; height: 6px; border-radius: 50%; background: {{ $idx === 0 ? 'var(--color-highlighter-lime)' : 'rgba(255,255,255,0.4)' }}; transition: all 0.2s;"></span>
                @endforeach
              </div>
            @endif

            <!-- Magnifier icon on top-left -->
            <div class="gallery-zoom-icon" style="position: absolute; top: 12px; left: 12px; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: #fff; z-index: 10; transition: transform 0.2s, background 0.2s, color 0.2s;">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
            </div>

            <div style="position: absolute; top: 12px; right: 12px; display: flex; gap: 6px; z-index: 10;">
              <span style="font-size: 10px; font-weight: 600; color: var(--color-onyx-black); background: var(--color-highlighter-lime); padding: 4px 10px; border-radius: 12px;">
                ★ {{ $v['rating'] }}
              </span>
            </div>
            <div style="position: absolute; bottom: 12px; left: 16px; z-index: 10; pointer-events: none;">
              <span class="font-primary text-xs text-muted" style="display: flex; align-items: center; gap: 4px;">
                📍 {{ $v['location'] }}
              </span>
            </div>
          </div>

          <!-- Body -->
          <div style="padding: 24px; flex: 1; display: flex; flex-direction: column; gap: 16px;">
            <div>
              <h3 class="font-secondary fs-20 fw-regular" style="color: var(--color-pure-white); margin-bottom: 8px;">{{ $v['name'] }}</h3>
              <p class="font-primary text-sm text-muted lh-15" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $v['description'] }}
              </p>
            </div>

            <!-- Amenities -->
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: auto;">
              @foreach($v['amenities'] as $am)
                <span class="font-primary" style="font-size: 10px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); color: #888; padding: 3px 8px; border-radius: 6px;">
                  {{ $am }}
                </span>
              @endforeach
            </div>

            <div style="border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px; display: flex; align-items: center; justify-content: space-between; margin-top: auto;">
              <div>
                <span class="font-primary text-xs text-muted" style="display: block;">Starting from</span>
                <span class="font-primary fs-18 fw-medium" style="color: var(--color-highlighter-lime);">{{ $v['price'] }}</span>
              </div>
              <button type="button" onclick='window.openPropertyModal({!! json_encode($v) !!}, "villa")' class="btn-primary" style="padding: 8px 16px; font-size: 12px; border: none; cursor: pointer;">
                Book Now →
              </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
