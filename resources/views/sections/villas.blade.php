{{-- ═══════════════ VILLAS — EDITORIAL FEATURE SPREADS ═══════════════ --}}
<section id="villas" style="background:#040406;padding:96px 0;position:relative;overflow:hidden;">

{{-- Decorative ambient glow --}}
<div style="position:absolute;top:20%;left:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(184,136,42,0.04) 0%,transparent 70%);pointer-events:none;"></div>
<div style="position:absolute;bottom:10%;right:-150px;width:500px;height:500px;background:radial-gradient(circle,rgba(184,136,42,0.03) 0%,transparent 70%);pointer-events:none;"></div>

<style>
/* Gold rule line */
.villas-rule { display:block; width:48px; height:1px; background:linear-gradient(90deg,#b8882a,transparent); margin-bottom:14px; }

/* Spread layout */
.vs-spread { display:grid; grid-template-columns:1fr 1fr; gap:0; margin-bottom:1px; overflow:hidden; height:420px; }
.vs-spread.flip { direction:rtl; }
.vs-spread.flip > * { direction:ltr; }

.vs-img-panel { position:relative; overflow:hidden; background:#111; cursor:pointer; }
.vs-img-panel img.vs-main-img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform 0.8s cubic-bezier(0.4,0,0.2,1); }
.vs-img-panel:hover img.vs-main-img { transform:scale(1.06); }
.vs-img-panel::after { content:''; position:absolute; inset:0; background:rgba(0,0,0,0.18); transition:background 0.4s; pointer-events:none; }
.vs-img-panel:hover::after { background:rgba(0,0,0,0.05); }

/* Gallery nav on image panel */
.vs-gnav { position:absolute; top:50%; z-index:5; transform:translateY(-50%); background:rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.1); color:#fff; width:36px; height:36px; border-radius:50%; display:none; align-items:center; justify-content:center; cursor:pointer; font-size:18px; transition:background 0.18s; }
.vs-img-panel:hover .vs-gnav { display:flex; }
.vs-gnav:hover { background:rgba(0,0,0,0.85) !important; }

/* Image strip thumbnails at bottom of img panel */
.vs-thumb-strip { position:absolute; bottom:0; left:0; right:0; z-index:4; display:flex; gap:3px; padding:8px 10px; background:linear-gradient(to top,rgba(0,0,0,0.75) 0%,transparent 100%); overflow-x:auto; scrollbar-width:none; }
.vs-thumb { width:44px; height:32px; object-fit:cover; border-radius:3px; cursor:pointer; border:1.5px solid transparent; transition:all 0.18s; flex-shrink:0; opacity:0.6; }
.vs-thumb:hover,.vs-thumb.vson { border-color:#b8882a; opacity:1; }

/* Info panel */
.vs-info-panel { background:#0a0a0d; display:flex; flex-direction:column; justify-content:center; padding:48px 52px; position:relative; cursor:pointer; overflow:hidden; }
.vs-info-panel::before { content:''; position:absolute; top:0; bottom:0; width:1px; background:linear-gradient(to bottom,transparent,rgba(184,136,42,0.15),transparent); }
.vs-spread:not(.flip) .vs-info-panel::before { left:0; }
.vs-spread.flip .vs-info-panel::before { right:0; }
.vs-info-panel:hover { background:#0c0c10; }

.vs-prop-num { font-family:'DM Sans',sans-serif; font-size:11px; font-weight:700; letter-spacing:3px; color:rgba(184,136,42,0.4); margin-bottom:16px; }
.vs-prop-name { font-family:'DM Sans',sans-serif; font-size:clamp(20px,2.5vw,28px); font-weight:800; color:#fff; line-height:1.15; letter-spacing:-0.8px; margin:0 0 6px; }
.vs-prop-loc { display:flex; align-items:center; gap:5px; margin-bottom:18px; }
.vs-prop-desc { font-family:'DM Sans',sans-serif; font-size:13px; color:rgba(255,255,255,0.35); line-height:1.75; margin:0 0 22px; display:-webkit-box; -webkit-line-clamp:4; -webkit-box-orient:vertical; overflow:hidden; }
.vs-amenity-row { display:flex; flex-wrap:wrap; gap:6px; margin-bottom:28px; }
.vs-amenity { font-family:'DM Sans',sans-serif; font-size:10px; color:rgba(184,136,42,0.8); background:rgba(184,136,42,0.07); border:1px solid rgba(184,136,42,0.18); padding:4px 11px; border-radius:20px; }
.vs-price-row { display:flex; align-items:center; justify-content:space-between; padding-top:20px; border-top:1px solid rgba(255,255,255,0.05); }
.vs-price { font-family:'DM Sans',sans-serif; font-size:20px; font-weight:800; color:#b8882a; letter-spacing:-0.5px; }
.vs-price-sub { font-family:'DM Sans',sans-serif; font-size:10px; color:#333; text-transform:uppercase; letter-spacing:1px; margin-bottom:3px; }
.vs-reserve-btn { font-family:'DM Sans',sans-serif; font-size:11px; font-weight:700; letter-spacing:0.5px; color:#b8882a; background:transparent; border:1px solid rgba(184,136,42,0.35); padding:10px 22px; border-radius:6px; cursor:pointer; transition:all 0.2s; }
.vs-reserve-btn:hover { background:rgba(184,136,42,0.1); border-color:#b8882a; }
.vs-rating-chip { display:flex; align-items:center; gap:4px; }

/* Compact grid for overflow villas */
.vs-compact-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:2px; margin-top:2px; }
@media(max-width:900px){
  .vs-spread { grid-template-columns:1fr; height:auto; }
  .vs-img-panel { height:280px; }
  .vs-info-panel { padding:28px 24px; }
  .vs-compact-grid { grid-template-columns:repeat(2,1fr); }
}
@media(max-width:600px){ .vs-compact-grid { grid-template-columns:1fr 1fr; } }

/* Compact villa tile */
.vs-compact { position:relative; height:200px; overflow:hidden; cursor:pointer; background:#111; }
.vs-compact img { width:100%; height:100%; object-fit:cover; transition:transform 0.5s; }
.vs-compact:hover img { transform:scale(1.07); }
.vs-compact::after { content:''; position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,0.85) 0%,transparent 55%); pointer-events:none; }
.vs-compact-info { position:absolute; bottom:0; left:0; right:0; padding:12px 14px; z-index:2; }
</style>

<div class="container">
  {{-- Section Header --}}
  <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:52px;flex-wrap:wrap;gap:20px;">
    <div>
      <span class="villas-rule"></span>
      <p style="font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#b8882a;margin:0 0 10px;">Ultra Luxury</p>
      <h2 style="font-family:'DM Sans',sans-serif;font-size:clamp(30px,5vw,52px);font-weight:900;letter-spacing:-2px;color:#fff;line-height:1;margin:0;">
        Private Villas<br>
        <span style="font-weight:300;color:rgba(255,255,255,0.18);letter-spacing:-1px;">&amp; Estates</span>
      </h2>
    </div>
    <button onclick="smoothScroll('planner')"
      style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;color:#b8882a;background:transparent;border:1px solid rgba(184,136,42,0.3);padding:11px 26px;border-radius:6px;cursor:pointer;transition:all 0.2s;letter-spacing:0.5px;align-self:flex-start;"
      onmouseenter="this.style.background='rgba(184,136,42,0.08)';this.style.borderColor='#b8882a'"
      onmouseleave="this.style.background='transparent';this.style.borderColor='rgba(184,136,42,0.3)'">
      Private Concierge →
    </button>
  </div>
</div>

{{-- Feature spreads (full bleed, max 4 featured) --}}
@php $villasArr = is_array($villas) ? array_values($villas) : []; $villasVisible = array_slice($villasArr,0,3); $villasHidden = array_slice($villasArr,3); @endphp

@foreach($villasVisible as $vi => $v)
@php
  $vg = array_values(array_filter(array_merge([$v['imagePath']??null],$v['gallery']??[])));
  $vgc = count($vg);
  $isFlip = ($vi % 2 !== 0);
  $spreadId = 'vs-'.$vi;
@endphp
<div class="vs-spread{{ $isFlip?' flip':'' }}" id="{{ $spreadId }}" data-property="{{ json_encode($v) }}">

  {{-- Image Panel --}}
  <div class="vs-img-panel" id="{{ $spreadId }}-imgpanel"
       onclick="window.openPropertyModal(JSON.parse(this.closest('.vs-spread').getAttribute('data-property')),'villa')">

    {{-- Images --}}
    @foreach($vg as $gi => $gsrc)
      <img class="vs-main-img prop-gallery-img prop-img-{{ $gi }}"
           src="{{ $gi===0?$gsrc:'' }}"
           data-src="{{ $gi>0?$gsrc:'' }}"
           alt="{{ $v['name'] }}"
           loading="lazy"
           style="opacity:{{ $gi===0?0:0 }};{{ $gi>0?'display:none;':'' }}"
           onload="this.style.opacity=1;" />
    @endforeach

    {{-- Nav --}}
    @if($vgc>1)
      <button type="button" class="vs-gnav" style="left:12px;" onclick="event.stopPropagation();vsNav('{{ $spreadId }}',-1)">‹</button>
      <button type="button" class="vs-gnav" style="right:12px;" onclick="event.stopPropagation();vsNav('{{ $spreadId }}',1)">›</button>
    @endif

    {{-- Thumbnail strip --}}
    @if($vgc>1)
      <div class="vs-thumb-strip" id="{{ $spreadId }}-thumbs">
        @foreach($vg as $ti => $tsrc)
          <img class="vs-thumb{{ $ti===0?' vson':'' }}" src="{{ $tsrc }}" alt="{{ $v['name'] }} thumbnail" loading="lazy" data-idx="{{ $ti }}"
               onclick="event.stopPropagation();vsJump('{{ $spreadId }}',{{ $ti }})" />
        @endforeach
      </div>
    @endif

    {{-- Image count label --}}
    @if($vgc>1)
      <div style="position:absolute;top:14px;left:14px;z-index:5;background:rgba(0,0,0,0.55);backdrop-filter:blur(6px);border:1px solid rgba(184,136,42,0.2);border-radius:20px;padding:4px 11px;display:flex;align-items:center;">
        <span style="font-family:'DM Sans',sans-serif;font-size:10px;color:#b8882a;display:flex;align-items:center;gap:4px;">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
          {{ $vgc }} photos
        </span>
      </div>
    @endif
  </div>

  {{-- Info Panel --}}
  <div class="vs-info-panel" onclick="window.openPropertyModal(JSON.parse(this.closest('.vs-spread').getAttribute('data-property')),'villa')">
    <div class="vs-prop-num">0{{ $vi+1 }} / 0{{ count(array_slice($villasArr,0,4)) }}</div>

    <h3 class="vs-prop-name">{{ $v['name'] }}</h3>

    <div class="vs-prop-loc">
      <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="rgba(184,136,42,0.6)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      <span style="font-family:'DM Sans',sans-serif;font-size:11px;color:rgba(255,255,255,0.35);">{{ $v['location']??'' }}</span>
    </div>

    <p class="vs-prop-desc">{{ $v['description'] }}</p>

    @if(!empty($v['amenities']))
    <div class="vs-amenity-row">
      @foreach(array_slice($v['amenities'],0,6) as $am)
        <span class="vs-amenity">{{ $am }}</span>
      @endforeach
      @if(count($v['amenities'])>6)
        <span style="font-family:'DM Sans',sans-serif;font-size:10px;color:#333;padding:4px 6px;">+{{ count($v['amenities'])-6 }}</span>
      @endif
    </div>
    @endif

    <div class="vs-price-row">
      <div>
        <div class="vs-price-sub">Starting from</div>
        <div class="vs-price">{{ $v['price'] }}</div>
      </div>
      <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
        <div class="vs-rating-chip">
          <span style="color:#facc15;font-size:11px;">★</span>
          <span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;color:#fff;">{{ $v['rating']??'5.0' }}</span>
        </div>
        <button type="button" class="vs-reserve-btn"
          onclick="event.stopPropagation();window.openPropertyModal(JSON.parse(this.closest('.vs-spread').getAttribute('data-property')),'villa')">
          Reserve →
        </button>
      </div>
    </div>
  </div>
</div>
@endforeach

{{-- Hidden extra villas (show more) --}}
@if(count($villasHidden) > 0)
<div id="vs-extra" style="display:none;">
  @foreach($villasHidden as $vi => $v)
  @php
    $vg = array_values(array_filter(array_merge([$v['imagePath']??null],$v['gallery']??[])));
    $vgc = count($vg);
    $vi2 = $vi + count($villasVisible);
    $isFlip = ($vi2 % 2 !== 0);
    $spreadId = 'vs-x'.$vi;
  @endphp
  <div class="vs-spread{{ $isFlip?' flip':'' }}" id="{{ $spreadId }}" data-property="{{ json_encode($v) }}">
    <div class="vs-img-panel" id="{{ $spreadId }}-imgpanel"
         onclick="window.openPropertyModal(JSON.parse(this.closest('.vs-spread').getAttribute('data-property')),'villa')">
      @foreach($vg as $gi => $gsrc)
        <img class="vs-main-img prop-gallery-img prop-img-{{ $gi }}"
             src="{{ $gi===0?$gsrc:'' }}" data-src="{{ $gi>0?$gsrc:'' }}"
             alt="{{ $v['name'] }}"
             loading="lazy"
             style="opacity:0;{{ $gi===0?'':'display:none;' }}" onload="this.style.opacity=1;" />
      @endforeach
      @if($vgc>1)
        <button type="button" class="vs-gnav" style="left:12px;" onclick="event.stopPropagation();vsNav('{{ $spreadId }}',-1)">‹</button>
        <button type="button" class="vs-gnav" style="right:12px;" onclick="event.stopPropagation();vsNav('{{ $spreadId }}',1)">›</button>
        <div class="vs-thumb-strip" id="{{ $spreadId }}-thumbs">
          @foreach($vg as $ti => $tsrc)
            <img class="vs-thumb{{ $ti===0?' vson':'' }}" src="{{ $tsrc }}" alt="{{ $v['name'] }} thumbnail" loading="lazy" data-idx="{{ $ti }}"
                 onclick="event.stopPropagation();vsJump('{{ $spreadId }}',{{ $ti }})" />
          @endforeach
        </div>
        <div style="position:absolute;top:14px;left:14px;z-index:5;background:rgba(0,0,0,0.55);backdrop-filter:blur(6px);border:1px solid rgba(184,136,42,0.2);border-radius:20px;padding:4px 11px;display:flex;align-items:center;">
          <span style="font-family:'DM Sans',sans-serif;font-size:10px;color:#b8882a;display:flex;align-items:center;gap:4px;">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            {{ $vgc }} photos
          </span>
        </div>
      @endif
    </div>
    <div class="vs-info-panel" onclick="window.openPropertyModal(JSON.parse(this.closest('.vs-spread').getAttribute('data-property')),'villa')">
      <div class="vs-prop-num">0{{ $vi2+1 }}</div>
      <h3 class="vs-prop-name">{{ $v['name'] }}</h3>
      <div class="vs-prop-loc">
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="rgba(184,136,42,0.6)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <span style="font-family:'DM Sans',sans-serif;font-size:11px;color:rgba(255,255,255,0.35);">{{ $v['location']??'' }}</span>
      </div>
      <p class="vs-prop-desc">{{ $v['description'] }}</p>
      @if(!empty($v['amenities']))
      <div class="vs-amenity-row">
        @foreach(array_slice($v['amenities'],0,6) as $am)<span class="vs-amenity">{{ $am }}</span>@endforeach
      </div>
      @endif
      <div class="vs-price-row">
        <div><div class="vs-price-sub">Starting from</div><div class="vs-price">{{ $v['price'] }}</div></div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
          <div class="vs-rating-chip"><span style="color:#facc15;font-size:11px;">★</span><span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;color:#fff;">{{ $v['rating']??'5.0' }}</span></div>
          <button type="button" class="vs-reserve-btn" onclick="event.stopPropagation();window.openPropertyModal(JSON.parse(this.closest('.vs-spread').getAttribute('data-property')),'villa')">Reserve →</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

<div style="text-align:center;padding:32px 0 0;" id="vs-show-more-wrap">
  <button id="vs-show-more-btn" onclick="document.getElementById('vs-extra').style.display='block';this.closest('#vs-show-more-wrap').style.display='none';"
    style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:700;color:#b8882a;background:transparent;border:1px solid rgba(184,136,42,0.3);padding:12px 32px;border-radius:6px;cursor:pointer;transition:all 0.2s;letter-spacing:0.5px;"
    onmouseenter="this.style.background='rgba(184,136,42,0.08)';this.style.borderColor='#b8882a'"
    onmouseleave="this.style.background='transparent';this.style.borderColor='rgba(184,136,42,0.3)'">
    Show {{ count($villasHidden) }} More Villa{{ count($villasHidden)===1?'':'s' }} ↓
  </button>
</div>
@endif

<script>
// Per-spread gallery navigation
const _vsState = {};

function vsNav(id, dir) {
  const panel = document.getElementById(id + '-imgpanel');
  if (!panel) return;
  const imgs = panel.querySelectorAll('.prop-gallery-img');
  if (!_vsState[id]) _vsState[id] = 0;
  let cur = _vsState[id];
  imgs[cur].style.opacity = '0';
  imgs[cur].style.display = 'none';
  let next = (cur + dir + imgs.length) % imgs.length;
  // Lazy load
  if (imgs[next].dataset.src) { imgs[next].src = imgs[next].dataset.src; imgs[next].removeAttribute('data-src'); }
  imgs[next].style.display = '';
  setTimeout(() => imgs[next].style.opacity = '1', 10);
  _vsState[id] = next;
  _vsUpdateThumbs(id, next);
}

function vsJump(id, idx) {
  const panel = document.getElementById(id + '-imgpanel');
  if (!panel) return;
  const imgs = panel.querySelectorAll('.prop-gallery-img');
  if (!_vsState[id]) _vsState[id] = 0;
  let cur = _vsState[id];
  if (cur === idx) return;
  imgs[cur].style.opacity = '0';
  imgs[cur].style.display = 'none';
  if (imgs[idx].dataset.src) { imgs[idx].src = imgs[idx].dataset.src; imgs[idx].removeAttribute('data-src'); }
  imgs[idx].style.display = '';
  setTimeout(() => imgs[idx].style.opacity = '1', 10);
  _vsState[id] = idx;
  _vsUpdateThumbs(id, idx);
}

function _vsUpdateThumbs(id, activeIdx) {
  const strip = document.getElementById(id + '-thumbs');
  if (!strip) return;
  strip.querySelectorAll('.vs-thumb').forEach((t, i) => {
    t.classList.toggle('vson', i === activeIdx);
  });
}
</script>
</section>
