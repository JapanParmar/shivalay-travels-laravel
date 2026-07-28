{{-- ═══════════════ HOTELS — CINEMATIC FILM-STRIP ═══════════════ --}}
<section id="hotels" style="background:#07070a;padding:96px 0 80px;overflow:hidden;position:relative;">

<style>
/* Film strip track */
.hs-track-wrap { position:relative; }
.hs-track { display:flex; gap:16px; padding:8px 0 24px; overflow-x:auto; scroll-snap-type:x mandatory; scrollbar-width:none; cursor:grab; user-select:none; -webkit-overflow-scrolling:touch; }
.hs-track::-webkit-scrollbar { display:none; }
.hs-track.dragging { cursor:grabbing; }
.hs-track.dragging .hs-card { pointer-events:none; }

/* Film card — tall portrait format, no border-radius normality */
.hs-card { position:relative; width:300px; min-width:300px; height:440px; border-radius:4px; overflow:hidden; scroll-snap-align:start; flex-shrink:0; background:#111; transform-style:preserve-3d; transition:transform 0.08s ease-out; }
.hs-card::before { content:''; position:absolute; inset:0; background:linear-gradient(to top,rgba(0,0,0,0.95) 0%,rgba(0,0,0,0.3) 45%,rgba(0,0,0,0) 100%); z-index:2; pointer-events:none; }
.hs-card-img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform 0.6s cubic-bezier(0.4,0,0.2,1); }
.hs-card:hover .hs-card-img { transform:scale(1.06); }
/* Glass info panel */
.hs-card-info { position:absolute; bottom:0; left:0; right:0; padding:0 20px 22px; z-index:3; }
.hs-card-loc { display:flex; align-items:center; gap:5px; margin-bottom:6px; }
.hs-card-name { font-family:'DM Sans',sans-serif; font-size:17px; font-weight:700; color:#fff; line-height:1.25; margin:0 0 10px; letter-spacing:-0.3px; }
.hs-card-meta { display:flex; align-items:center; justify-content:space-between; }
.hs-card-price { font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; color:#a3e635; }
.hs-card-rating { display:flex; align-items:center; gap:3px; background:rgba(250,204,21,0.1); border:1px solid rgba(250,204,21,0.2); border-radius:20px; padding:3px 9px; }
/* Image counter pill */
.hs-img-cnt { position:absolute; top:12px; right:12px; z-index:4; background:rgba(0,0,0,0.55); backdrop-filter:blur(6px); border:1px solid rgba(255,255,255,0.1); border-radius:20px; padding:3px 10px; font-family:'DM Sans',sans-serif; font-size:10px; color:rgba(255,255,255,0.7); display:flex; align-items:center; gap:4px; }
/* Gallery nav inside card */
.hs-nav { position:absolute; top:50%; z-index:4; transform:translateY(-50%); background:rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.1); color:#fff; width:30px; height:30px; border-radius:50%; display:none; align-items:center; justify-content:center; cursor:pointer; font-size:16px; transition:background 0.18s; }
.hs-card:hover .hs-nav { display:flex; }
.hs-nav:hover { background:rgba(0,0,0,0.85) !important; }
/* Dot indicators at card bottom above info */
.hs-dots { display:flex; gap:3px; justify-content:center; margin-bottom:8px; }
.hs-dot { width:4px; height:4px; border-radius:50%; background:rgba(255,255,255,0.35); transition:all 0.2s; }
.hs-dot.on { background:#a3e635; width:14px; border-radius:4px; }

/* Tab filters */
.hs-tab { font-family:'DM Sans',sans-serif; font-size:12px; font-weight:600; padding:7px 18px; border:none; background:transparent; color:#444; cursor:pointer; position:relative; transition:color 0.2s; letter-spacing:0.3px; }
.hs-tab::after { content:''; position:absolute; bottom:-1px; left:18px; right:18px; height:2px; background:#a3e635; transform:scaleX(0); transition:transform 0.2s; border-radius:2px; }
.hs-tab.active { color:#fff; }
.hs-tab.active::after { transform:scaleX(1); }
.hs-tab:hover { color:#ccc; }

/* Sort dropdown */
.hs-sort { font-family:'DM Sans',sans-serif; font-size:11px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); color:#888; padding:6px 10px; border-radius:8px; cursor:pointer; outline:none; }

/* Progress bar */
.hs-progress-bar { height:2px; background:rgba(255,255,255,0.05); border-radius:2px; overflow:hidden; margin-top:16px; }
.hs-progress-fill { height:100%; background:linear-gradient(90deg,#a3e635,#65a30d); border-radius:2px; transition:width 0.2s; }

/* Hidden */
.hs-hidden { display:none !important; }
</style>

<div class="container">
  {{-- Header row --}}
  <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px;gap:16px;flex-wrap:wrap;">
    <div>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
        <div style="width:28px;height:2px;background:#a3e635;border-radius:2px;"></div>
        <p style="font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#a3e635;margin:0;">Handpicked Stays</p>
      </div>
      <h2 style="font-family:'DM Sans',sans-serif;font-size:clamp(28px,4vw,44px);font-weight:800;color:#fff;line-height:1.05;margin:0;letter-spacing:-1.5px;">
        Premium<br><span style="color:rgba(255,255,255,0.25);font-weight:300;letter-spacing:-1px;">Hotels &amp; Retreats</span>
      </h2>
    </div>
    <div style="display:flex;align-items:center;gap:12px;">
      <span id="hs-count" style="font-family:'DM Sans',sans-serif;font-size:12px;color:#333;"></span>
      <select id="hs-sort" class="hs-sort" onchange="hsApply()">
        <option value="">Default</option>
        <option value="rating">Top Rated</option>
        <option value="name">A–Z</option>
      </select>
      <div style="display:flex;gap:2px;">
        <button onclick="hsScroll(-1)" style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#666;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.18s;font-size:18px;" onmouseenter="this.style.borderColor='rgba(163,230,53,0.4)';this.style.color='#a3e635'" onmouseleave="this.style.borderColor='rgba(255,255,255,0.08)';this.style.color='#666'">‹</button>
        <button onclick="hsScroll(1)" style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#666;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.18s;font-size:18px;" onmouseenter="this.style.borderColor='rgba(163,230,53,0.4)';this.style.color='#a3e635'" onmouseleave="this.style.borderColor='rgba(255,255,255,0.08)';this.style.color='#666'">›</button>
      </div>
    </div>
  </div>

  {{-- Tab filters --}}
  @php $hotelLocs = array_unique(array_filter(array_map(fn($h)=>$h['location']??'', is_array($hotels)?$hotels:[]))); @endphp
  <div style="display:flex;align-items:center;border-bottom:1px solid rgba(255,255,255,0.06);margin-bottom:24px;gap:0;overflow-x:auto;scrollbar-width:none;">
    <button class="hs-tab active" data-loc="all" onclick="hsTab(this,'all')">All</button>
    @foreach($hotelLocs as $loc)
      <button class="hs-tab" data-loc="{{ $loc }}" onclick="hsTab(this,'{{ addslashes($loc) }}')">{{ $loc }}</button>
    @endforeach
  </div>

  {{-- Film strip track --}}
  <div class="hs-track-wrap">
    {{-- Left/right fade edges --}}
    <div style="position:absolute;top:0;bottom:24px;left:0;width:48px;background:linear-gradient(to right,#07070a,transparent);z-index:10;pointer-events:none;"></div>
    <div style="position:absolute;top:0;bottom:24px;right:0;width:48px;background:linear-gradient(to left,#07070a,transparent);z-index:10;pointer-events:none;"></div>

    <div id="hs-track" class="hs-track">
      @foreach(is_array($hotels)?$hotels:[] as $idx => $h)
      @php
        $hg = array_values(array_filter(array_merge([$h['imagePath']??null],$h['gallery']??[])));
        $hgc = count($hg);
      @endphp
      <div class="hs-card" data-loc="{{ $h['location']??'' }}" data-rating="{{ $h['rating']??0 }}" data-name="{{ $h['name']??'' }}"
           data-property="{{ json_encode($h) }}"
           onclick="window.openPropertyModal(JSON.parse(this.getAttribute('data-property')),'hotel')">

        {{-- Background images (first shown, rest lazy) --}}
        @foreach($hg as $gi => $gsrc)
          @if($gi===0)
            <img class="hs-card-img prop-gallery-img prop-img-{{ $gi }}" src="{{ $gsrc }}" style="opacity:0;" onload="this.style.opacity=1;" />
          @else
            <img class="hs-card-img prop-gallery-img prop-img-{{ $gi }}" data-src="{{ $gsrc }}" style="opacity:0;display:none;" />
          @endif
        @endforeach

        {{-- Image count --}}
        @if($hgc>1)
        <div class="hs-img-cnt">
          <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          {{ $hgc }}
        </div>
        @endif

        {{-- Nav inside card --}}
        @if($hgc>1)
        <button type="button" class="hs-nav" style="left:8px;" onclick="event.stopPropagation();window.hsCardNav(this,-1)">‹</button>
        <button type="button" class="hs-nav" style="right:8px;" onclick="event.stopPropagation();window.hsCardNav(this,1)">›</button>
        @endif

        {{-- View Details button overlay --}}
        <button type="button" class="hs-detail-btn"
          onclick="event.stopPropagation();window.openPropertyModal(JSON.parse(this.closest('.hs-card').getAttribute('data-property')),'hotel')"
          style="position:absolute;bottom:20px;right:16px;z-index:6;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.4px;color:#000;background:#a3e635;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;opacity:0;transition:opacity 0.25s,transform 0.25s;transform:translateY(6px);">View Details →</button>

        {{-- Info --}}
        <div class="hs-card-info">
          @if($hgc>1)
          <div class="hs-dots">
            @foreach($hg as $di=>$ds)
            <span class="prop-gallery-dot hs-dot{{ $di===0?' on':'' }}"></span>
            @endforeach
          </div>
          @endif
          <div class="hs-card-loc">
            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span style="font-family:'DM Sans',sans-serif;font-size:10px;color:rgba(255,255,255,0.4);">{{ $h['location']??'' }}</span>
          </div>
          <p class="hs-card-name">{{ $h['name'] }}</p>
          <div class="hs-card-meta">
            <span class="hs-card-price">{{ $h['price'] }}</span>
            <div class="hs-card-rating">
              <span style="color:#facc15;font-size:10px;">★</span>
              <span style="font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;color:#fff;">{{ $h['rating']??'5.0' }}</span>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Progress bar --}}
    <div class="hs-progress-bar"><div id="hs-prog" class="hs-progress-fill" style="width:20%;"></div></div>
  </div>

  {{-- No results --}}
  <div id="hs-empty" style="display:none;text-align:center;padding:48px;color:#333;font-family:'DM Sans',sans-serif;font-size:13px;">No hotels for this location.</div>
</div>

<script>
(function(){
  const track = document.getElementById('hs-track');
  if(!track) return;
  let activeLoc = 'all';

  // Drag to scroll
  let isDown=false,startX,scrollLeft,dragged=false;
  track.addEventListener('mousedown',e=>{
    isDown=true;
    startX=e.pageX-track.offsetLeft;
    scrollLeft=track.scrollLeft;
    dragged=false;
  });
  document.addEventListener('mouseup',()=>{
    isDown=false;
    track.classList.remove('dragging');
  });
  track.addEventListener('mousemove',e=>{
    if(!isDown)return;
    const x=e.pageX-track.offsetLeft;
    const walk=x-startX;
    if(Math.abs(walk)>6){
      dragged=true;
      track.classList.add('dragging');
    }
    if(dragged){
      e.preventDefault();
      track.scrollLeft=scrollLeft-walk*1.2;
      updateProg();
    }
  });
  track.addEventListener('scroll',updateProg);

  function updateProg(){
    const max=track.scrollWidth-track.clientWidth;
    const pct=max>0?Math.round((track.scrollLeft/max)*100):0;
    const prog=document.getElementById('hs-prog');
    if(prog) prog.style.width=Math.max(8,pct)+'%';
  }

  window.hsScroll=function(dir){track.scrollBy({left:dir*320,behavior:'smooth'});};

  // 3D tilt on mouse move
  track.querySelectorAll('.hs-card').forEach(card=>{
    card.addEventListener('mousemove',e=>{
      if(track.classList.contains('dragging')) return;
      const r=card.getBoundingClientRect();
      const x=((e.clientX-r.left)/r.width-0.5)*12;
      const y=((e.clientY-r.top)/r.height-0.5)*-10;
      card.style.transform=`perspective(800px) rotateY(${x}deg) rotateX(${y}deg) scale(1.02)`;
    });
    card.addEventListener('mouseleave',()=>{card.style.transform='';});
  });

  // Per-card state map
  const _hsIdx = new WeakMap();

  // Lazy load + show/hide detail btn on hover
  track.querySelectorAll('.hs-card').forEach(card=>{
    card.addEventListener('mouseenter',()=>{
      // Lazy-load all images in card
      card.querySelectorAll('img[data-src]').forEach(img=>{
        img.src=img.dataset.src; img.removeAttribute('data-src'); img.style.display='';
      });
      const btn = card.querySelector('.hs-detail-btn');
      if(btn){btn.style.opacity='1';btn.style.transform='translateY(0)';}
    });
    card.addEventListener('mouseleave',()=>{
      const btn = card.querySelector('.hs-detail-btn');
      if(btn){btn.style.opacity='0';btn.style.transform='translateY(6px)';}
    });
  });

  // Self-contained card image nav (no wrapper dependency)
  window.hsCardNav = function(btn, dir){
    const card = btn.closest('.hs-card');
    if(!card) return;
    const imgs = Array.from(card.querySelectorAll('.hs-card-img'));
    if(imgs.length <= 1) return;
    let cur = _hsIdx.get(card) || 0;
    
    imgs[cur].style.opacity = '0';
    imgs[cur].style.display = 'none';
    
    let next = (cur + dir + imgs.length) % imgs.length;
    // Ensure src loaded
    if(imgs[next].dataset.src){
      imgs[next].src=imgs[next].dataset.src;
      imgs[next].removeAttribute('data-src');
    }
    imgs[next].style.display = '';
    setTimeout(() => { imgs[next].style.opacity = '1'; }, 10);
    
    _hsIdx.set(card, next);
    // Sync dots
    card.querySelectorAll('.hs-dot').forEach((d,i)=>{
      d.style.background = i===next ? '#a3e635' : 'rgba(255,255,255,0.35)';
      d.style.width = i===next ? '14px' : '4px';
    });
  };

  // Filter
  function hsApplyFilter(){
    const cards=Array.from(track.querySelectorAll('.hs-card'));
    let vis=cards.filter(c=>activeLoc==='all'||(c.dataset.loc||'').toLowerCase().includes(activeLoc.toLowerCase()));
    const sort=document.getElementById('hs-sort')?.value||'';
    if(sort==='rating') vis.sort((a,b)=>parseFloat(b.dataset.rating||0)-parseFloat(a.dataset.rating||0));
    if(sort==='name') vis.sort((a,b)=>(a.dataset.name||'').localeCompare(b.dataset.name||''));
    cards.forEach(c=>c.classList.add('hs-hidden'));
    vis.forEach(c=>{c.classList.remove('hs-hidden');track.appendChild(c);});
    const empty=document.getElementById('hs-empty');
    if(empty)empty.style.display=vis.length===0?'block':'none';
    const lbl=document.getElementById('hs-count');
    if(lbl)lbl.textContent=vis.length+' propert'+(vis.length===1?'y':'ies');
    track.scrollTo({left:0,behavior:'smooth'});updateProg();
  }

  window.hsTab=function(btn,loc){
    activeLoc=loc;
    document.querySelectorAll('.hs-tab').forEach(t=>t.classList.remove('active'));
    btn.classList.add('active');
    hsApplyFilter();
  };
  window.hsApply=hsApplyFilter;

  // Init
  const total=(document.querySelectorAll('#hs-track .hs-card')||[]).length;
  const lbl=document.getElementById('hs-count');
  if(lbl)lbl.textContent=total+' propert'+(total===1?'y':'ies');
  updateProg();
})();
</script>
</section>
