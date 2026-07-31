var e=window.DB_PACKAGES||[],t=window.DB_GUIDES||[],n=window.DB_TESTIMONIALS||[],r={bus:[`AC Sleeper`,`Non-AC Sleeper`,`AC Seater`,`Luxury Volvo`],taxi:[`Sedan (Dzire/Etios)`,`SUV (Ertiga/Tavera)`,`Premium SUV (Innova Crysta)`,`Tempo Traveller`]},i=[{id:`destination`,label:`01 — Where`,question:`Where in India does your soul want to go?`,subtext:`Choose from our curated regions or describe your dream destination.`,options:[`Kedarnath`,`Chardham Yatra`,`Varanasi`,`Kashmir`,`Goa`,`Kerala`,`Rajasthan`,`Leh Ladakh`,`Surprise me`],inputType:`text`,inputPlaceholder:`e.g. Kedarnath, Spiti Valley, Coorg, or a multi-city circuit…`,icon:`map`},{id:`dates`,label:`02 — When`,question:`When are you planning to travel?`,subtext:`Select a timeframe or enter specific dates.`,options:[`Next month`,`In 2–3 months`,`In 6 months`,`Next year`,`Flexible / Open`],inputType:`text`,inputPlaceholder:`e.g. Dec 20 – Jan 5, or around Diwali 2026…`,icon:`calendar`},{id:`duration`,label:`03 — Duration`,question:`How many nights are you envisioning?`,subtext:`We can design anything from a 3-night escape to a 21-night odyssey.`,options:[`3–5 nights`,`6–8 nights`,`9–12 nights`,`13–18 nights`,`3+ weeks`],inputType:`text`,inputPlaceholder:`e.g. 10 nights, or flexible based on budget…`,icon:`moon`},{id:`travelers`,label:`04 — Who`,question:`Who's joining you on this journey?`,subtext:`Tell us about your group composition — we tailor every detail.`,options:[`Solo traveller`,`Couple / Honeymoon`,`Small group (3–6)`,`Family with children`,`Family with seniors`,`Corporate team`],inputType:`text`,inputPlaceholder:`e.g. 2 adults + 1 child (8 yrs), or 4 couples…`,icon:`users`},{id:`budget`,label:`05 — Budget`,question:`What's your investment range per traveller?`,subtext:`All prices are per person. This helps us recommend the right properties.`,options:[`Under ₹50,000`,`₹50k – ₹1.5 Lakhs`,`₹1.5L – ₹3 Lakhs`,`₹3L – ₹5 Lakhs`,`₹5 Lakhs+`,`Flexible`],inputType:`text`,inputPlaceholder:`e.g. ₹8 Lakhs total for 2 people, or best value…`,icon:`indian-rupee`},{id:`style`,label:`06 — Style`,question:`What kind of experience do you seek?`,subtext:`Mix and match — your journey can blend multiple styles.`,options:[`Luxury Stays & Wellness`,`Himalayan Trek & Adventure`,`Heritage Trails & History`,`Wildlife & Nature`,`Honeymoon Retreat`,`Spiritual & Wellness`,`Family Magic`,`Culinary Journey`],inputType:`text`,inputPlaceholder:`e.g. Active days, luxury nights, with some local food exploration…`,icon:`sparkles`},{id:`accommodation`,label:`07 — Stay`,question:`Any accommodation preferences?`,subtext:`We partner with premium hotels, guest houses, camps, and heritage resorts.`,options:[`Premium 3/4 Star Hotels`,`Comfortable Guest Houses`,`Boutique Resorts`,`Luxury Tented Camps`,`Houseboats`,`Mix of Stays`],inputType:`text`,inputPlaceholder:`e.g. Near the temple shrine, pool required, family suite…`,icon:`home`},{id:`notes`,label:`08 — Notes`,question:`Anything else we should know?`,subtext:`Dietary needs, medical considerations, must-do experiences, or special occasions.`,options:[],inputType:`textarea`,inputPlaceholder:`e.g. Celebrating our anniversary, vegetarian only, one guest uses a wheelchair, must see a sunrise…`,icon:`file-text`},{id:`contact`,label:`09 — Contact`,question:`Last step — how do we reach you?`,subtext:`We respond within 2 hours with a personalised itinerary draft.`,options:[],icon:`phone`}],a=window.DB_CITIES&&window.DB_CITIES.length>0?window.DB_CITIES:[{name:`Mumbai`,code:`BOM`,state:`Maharashtra`,country:`India`},{name:`Delhi`,code:`DEL`,state:`Delhi`,country:`India`},{name:`New Delhi`,code:`NDLS`,state:`Delhi`,country:`India`},{name:`Bangalore`,code:`BLR`,state:`Karnataka`,country:`India`},{name:`Bengaluru`,code:`BLR`,state:`Karnataka`,country:`India`},{name:`Chennai`,code:`MAA`,state:`Tamil Nadu`,country:`India`},{name:`Kolkata`,code:`CCU`,state:`West Bengal`,country:`India`},{name:`Hyderabad`,code:`HYD`,state:`Telangana`,country:`India`},{name:`Pune`,code:`PNQ`,state:`Maharashtra`,country:`India`},{name:`Ahmedabad`,code:`AMD`,state:`Gujarat`,country:`India`},{name:`Indore`,code:`IDR`,state:`Madhya Pradesh`,country:`India`},{name:`Bhopal`,code:`BHO`,state:`Madhya Pradesh`,country:`India`},{name:`Gwalior`,code:`GWL`,state:`Madhya Pradesh`,country:`India`},{name:`Jabalpur`,code:`JLR`,state:`Madhya Pradesh`,country:`India`},{name:`Ujjain`,code:`UJN`,state:`Madhya Pradesh`,country:`India`},{name:`Raipur`,code:`RPR`,state:`Chhattisgarh`,country:`India`},{name:`Nagpur`,code:`NAG`,state:`Maharashtra`,country:`India`},{name:`Jaipur`,code:`JAI`,state:`Rajasthan`,country:`India`},{name:`Jodhpur`,code:`JDH`,state:`Rajasthan`,country:`India`},{name:`Udaipur`,code:`UDR`,state:`Rajasthan`,country:`India`},{name:`Ajmer`,code:`AII`,state:`Rajasthan`,country:`India`},{name:`Bikaner`,code:`BKB`,state:`Rajasthan`,country:`India`},{name:`Lucknow`,code:`LKO`,state:`Uttar Pradesh`,country:`India`},{name:`Varanasi`,code:`VNS`,state:`Uttar Pradesh`,country:`India`},{name:`Agra`,code:`AGR`,state:`Uttar Pradesh`,country:`India`},{name:`Prayagraj`,code:`IXD`,state:`Uttar Pradesh`,country:`India`},{name:`Kanpur`,code:`KNU`,state:`Uttar Pradesh`,country:`India`},{name:`Mathura`,code:`MTJ`,state:`Uttar Pradesh`,country:`India`},{name:`Vrindavan`,code:`MTJ`,state:`Uttar Pradesh`,country:`India`},{name:`Ayodhya`,code:`AYJ`,state:`Uttar Pradesh`,country:`India`},{name:`Gorakhpur`,code:`GOP`,state:`Uttar Pradesh`,country:`India`},{name:`Amritsar`,code:`ATQ`,state:`Punjab`,country:`India`},{name:`Chandigarh`,code:`IXC`,state:`Punjab`,country:`India`},{name:`Ludhiana`,code:`LUH`,state:`Punjab`,country:`India`},{name:`Haridwar`,code:`HRW`,state:`Uttarakhand`,country:`India`},{name:`Rishikesh`,code:`DED`,state:`Uttarakhand`,country:`India`},{name:`Kedarnath`,code:`KTH`,state:`Uttarakhand`,country:`India`},{name:`Badrinath`,code:`BDN`,state:`Uttarakhand`,country:`India`},{name:`Dehradun`,code:`DED`,state:`Uttarakhand`,country:`India`},{name:`Jammu`,code:`IXJ`,state:`Jammu & Kashmir`,country:`India`},{name:`Srinagar`,code:`SXR`,state:`Jammu & Kashmir`,country:`India`},{name:`Leh`,code:`IXL`,state:`Ladakh`,country:`India`},{name:`Tirupati`,code:`TIR`,state:`Andhra Pradesh`,country:`India`},{name:`Shirdi`,code:`SAG`,state:`Maharashtra`,country:`India`},{name:`Nashik`,code:`ISK`,state:`Maharashtra`,country:`India`},{name:`Kochi`,code:`COK`,state:`Kerala`,country:`India`},{name:`Thiruvananthapuram`,code:`TRV`,state:`Kerala`,country:`India`},{name:`Kozhikode`,code:`CCJ`,state:`Kerala`,country:`India`},{name:`Madurai`,code:`IXM`,state:`Tamil Nadu`,country:`India`},{name:`Coimbatore`,code:`CJB`,state:`Tamil Nadu`,country:`India`},{name:`Mysuru`,code:`MYQ`,state:`Karnataka`,country:`India`},{name:`Mangalore`,code:`IXE`,state:`Karnataka`,country:`India`},{name:`Vijayawada`,code:`VGA`,state:`Andhra Pradesh`,country:`India`},{name:`Visakhapatnam`,code:`VTZ`,state:`Andhra Pradesh`,country:`India`},{name:`Bhubaneswar`,code:`BBI`,state:`Odisha`,country:`India`},{name:`Puri`,code:`PUR`,state:`Odisha`,country:`India`},{name:`Patna`,code:`PAT`,state:`Bihar`,country:`India`},{name:`Gaya`,code:`GAY`,state:`Bihar`,country:`India`},{name:`Ranchi`,code:`IXR`,state:`Jharkhand`,country:`India`},{name:`Guwahati`,code:`GAU`,state:`Assam`,country:`India`},{name:`Goa`,code:`GOI`,state:`Goa`,country:`India`},{name:`Panaji`,code:`GOI`,state:`Goa`,country:`India`},{name:`Surat`,code:`STV`,state:`Gujarat`,country:`India`},{name:`Vadodara`,code:`BDQ`,state:`Gujarat`,country:`India`},{name:`Rajkot`,code:`RAJ`,state:`Gujarat`,country:`India`},{name:`Dwarka`,code:`DWK`,state:`Gujarat`,country:`India`},{name:`Shimla`,code:`SLV`,state:`Himachal Pradesh`,country:`India`},{name:`Manali`,code:`KUU`,state:`Himachal Pradesh`,country:`India`},{name:`Dharamshala`,code:`DHM`,state:`Himachal Pradesh`,country:`India`},{name:`Mussoorie`,code:`DED`,state:`Uttarakhand`,country:`India`},{name:`Darjeeling`,code:`DAR`,state:`West Bengal`,country:`India`},{name:`Ooty`,code:`CJB`,state:`Tamil Nadu`,country:`India`},{name:`Munnar`,code:`COK`,state:`Kerala`,country:`India`},{name:`Aurangabad`,code:`IXU`,state:`Maharashtra`,country:`India`},{name:`Solapur`,code:`SSE`,state:`Maharashtra`,country:`India`},{name:`Kolhapur`,code:`KLH`,state:`Maharashtra`,country:`India`},{name:`Srinagar`,code:`SXR`,state:`Jammu & Kashmir`,country:`India`},{name:`Jamshedpur`,code:`IXW`,state:`Jharkhand`,country:`India`},{name:`Allahabad`,code:`IXD`,state:`Uttar Pradesh`,country:`India`},{name:`Meerut`,code:`MRT`,state:`Uttar Pradesh`,country:`India`},{name:`Kota`,code:`KTU`,state:`Rajasthan`,country:`India`},{name:`Sikar`,code:`SKI`,state:`Rajasthan`,country:`India`}];window.smoothScroll=function(e){let t=document.getElementById(e);t&&t.scrollIntoView({behavior:`smooth`,block:`start`})};var o=window.scrollY,s=document.getElementById(`main-nav`),c=document.getElementById(`scroll-progress`);window.addEventListener(`scroll`,()=>{let e=window.scrollY,t=document.documentElement.scrollHeight-window.innerHeight,n=t>0?e/t*100:0;c&&(c.style.width=`${n}%`),s&&(e>60&&e>o?s.style.transform=`translateY(-100%)`:s.style.transform=`translateY(0)`),o=e},{passive:!0});var l=document.getElementById(`mobile-menu`);window.toggleMobileMenu=function(){if(l){let e=l.style.display===`flex`;l.style.display=e?`none`:`flex`}},document.addEventListener(`click`,e=>{if(l&&l.style.display===`flex`){let t=document.getElementById(`hamburger-btn`);!l.contains(e.target)&&t&&!t.contains(e.target)&&(l.style.display=`none`)}});var u=[`fast`,`lowest-fare`,`reliable`,`hassle-free`,`secured`],d=0,f=document.getElementById(`cycling-word`);f&&setInterval(()=>{f.style.opacity=0,setTimeout(()=>{d=(d+1)%u.length,f.textContent=u[d],f.style.opacity=1},300)},4e3);var p=document.getElementById(`ticker-track`);if(p){let e=[`Kedarnath Tour`,`Chardham Yatra`,`Kashmir Escape`,`Goa Beach Resort`,`Kerala Houseboat`,`Leh Himalayan Camp`],t=``;for(let n=0;n<3;n++)e.forEach(e=>{t+=`<span class="ticker-item font-primary fs-11 fw-medium uppercase ls-1 text-muted" style="margin: 0 28px; white-space: nowrap; display: inline-block;">✦ &nbsp; ${e}</span>`});p.innerHTML=t}var m=document.getElementById(`stats-grid`);if(m){let e=m.querySelectorAll(`.text-stat[data-count]`),t=!1;new IntersectionObserver(n=>{n.forEach(n=>{n.isIntersecting&&!t&&(t=!0,e.forEach(e=>{let t=parseInt(e.getAttribute(`data-count`),10),n=e.getAttribute(`data-suffix`)||``,r=0,i=2e3,a=Math.max(Math.floor(i/t),15),o=setInterval(()=>{r+=Math.ceil(t/(i/a)),r>=t&&(r=t,clearInterval(o)),e.textContent=`${r}${n}`},a)}))})},{threshold:.1}).observe(m)}var h=document.querySelectorAll(`.reveal, .reveal-scale, .reveal-d1, .reveal-d2, .reveal-d3, .reveal-d4`),g=new IntersectionObserver(e=>{e.forEach(e=>{e.isIntersecting&&(e.target.classList.add(`visible`),g.unobserve(e.target))})},{threshold:.05,rootMargin:`0px 0px -40px 0px`});h.forEach(e=>g.observe(e));var _=document.getElementById(`dest-pills`),v=document.getElementById(`dest-scroll-row`),y=document.getElementById(`dest-dots`),b=document.getElementById(`dest-detail`),x=`All`,S=null,C={Easy:`●`,Moderate:`●●`,Challenging:`●●●`,Expedition:`●●●●`};function w(){if(!v)return;let t=x===`All`?e:e.filter(e=>e.tags.some(e=>e.toLowerCase().includes(x.toLowerCase())));v.innerHTML=`
    <div style="width: 140px; height: 380px; border-radius: var(--radius-xl); flex-shrink: 0; background: var(--color-highlighter-lime); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; border: 1px solid var(--color-zinc-hairline);">
      <div style="font-size: 36px;">🇮🇳</div>
      <p class="font-primary text-xs fw-medium ls-2 uppercase text-center lh-16" style="color: var(--color-onyx-black);">Incredible<br />India</p>
    </div>
  `+t.map(e=>{C[e.difficulty];let t=e.bestSeason.split(`,`)[0],n=[e.imagePath].concat(e.gallery||[]).filter(Boolean),r=n.length>1,i=n.map((e,t)=>t===0?`<img src="${e}" class="prop-gallery-img prop-img-${t}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: opacity 0.4s ease; opacity: 0;" onload="this.style.opacity=1; this.closest('.property-card-gallery-wrapper').classList.remove('skeleton-loading');" />`:`<img data-src="${e}" class="prop-gallery-img prop-img-${t}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: opacity 0.4s ease; opacity: 0; pointer-events: none;" />`).join(``),a=r?`
      <div class="prop-gallery-dots" style="position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); display: flex; gap: 4px; z-index: 10;">
        ${n.map((e,t)=>`
          <span class="prop-gallery-dot" style="width: 6px; height: 6px; border-radius: 50%; background: ${t===0?`var(--color-highlighter-lime)`:`rgba(255,255,255,0.4)`}; transition: all 0.2s;"></span>
        `).join(``)}
      </div>
    `:``,o=r?`
      <button type="button" class="prop-gallery-nav-btn prev" onclick="event.stopPropagation(); window.changeCardImage(this, -1)" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); border: none; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; opacity: 0; transition: opacity 0.25s, background 0.2s, transform 0.2s;">
        ‹
      </button>
      <button type="button" class="prop-gallery-nav-btn next" onclick="event.stopPropagation(); window.changeCardImage(this, 1)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); border: none; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; opacity: 0; transition: opacity 0.25s, background 0.2s, transform 0.2s;">
        ›
      </button>
    `:``,s=JSON.stringify(n).replace(/'/g,`\\'`);return`
      <div
        class="portfolio-tile"
        style="width: 300px; height: 380px; flex-shrink: 0; position: relative; overflow: hidden; background: var(--color-carbon);"
        data-id="${e.id}"
      >
        <!-- The top image gallery portion (clickable to zoom/lightbox) -->
        <div class="property-card-gallery-wrapper skeleton-loading" style="position: absolute; inset: 0 0 120px 0; overflow: hidden; cursor: zoom-in;" onmouseenter="window.lazyLoadCardImages(this)" onclick="window.openLightbox(${s}, window.getCardActiveIdx(this), event)">
          <div class="property-card-gallery" style="position: relative; width: 100%; height: 100%;">
            ${i}
          </div>
          
          <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 10, 10, 0.95) 0%, rgba(10, 10, 10, 0.1) 80%, transparent 100%); pointer-events: none;"></div>
          
          ${o}
          ${a}

          <!-- Magnifier icon on top-left of image area -->
          <div class="gallery-zoom-icon" style="position: absolute; top: 12px; left: 12px; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; color: #fff; z-index: 10; transition: transform 0.2s, background 0.2s, color 0.2s;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
          </div>

          <div style="position: absolute; top: 12px; right: 12px; display: flex; justify-content: flex-end; align-items: center; z-index: 10; pointer-events: none;">
            <span class="font-primary fs-9" style="color: var(--color-white-80); padding: 3px 7px; border: 1px solid var(--color-white-20); border-radius: var(--radius-full); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">
              ${t}
            </span>
          </div>
        </div>

        <!-- The bottom text portion (clickable to toggle details below) -->
        <div style="position: absolute; left: 0; right: 0; bottom: 0; height: 120px; padding: 16px; z-index: 10; display: flex; flex-direction: column; justify-content: flex-end; pointer-events: none;">
          <p class="font-primary fs-9 fw-medium uppercase ls-1 text-muted" style="margin-bottom: 4px;">${e.region}</p>
          <h3 class="font-secondary fw-regular fs-18 lh-12" style="color: var(--color-pure-white); margin-bottom: 4px;">${e.name}</h3>
          <p class="font-primary fs-11 lh-14" style="color: var(--color-white-60); margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${e.tagline}</p>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="font-primary fs-11 text-muted">${e.duration}</span>
            <span class="font-primary fs-13 fw-medium" style="color: var(--color-highlighter-lime);">${e.startingFrom}</span>
          </div>
        </div>
      </div>
    `}).join(``),v.querySelectorAll(`.portfolio-tile`).forEach(e=>{e.addEventListener(`click`,t=>{if(t.target.closest(`.prop-gallery-nav-btn`)||t.target.closest(`.gallery-zoom-icon`)||t.target.closest(`.property-card-gallery-wrapper`))return;let n=e.getAttribute(`data-id`);toggleDestDetail(n)})}),ee(t.length)}function ee(e){if(!y)return;y.innerHTML=Array.from({length:e+1}).map((e,t)=>`
    <span class="scroll-dot" data-idx="${t}" style="transition:all 0.25s ease"></span>
  `).join(``);let t=y.querySelectorAll(`.scroll-dot`);t.length>0&&t[0].classList.add(`active`),t.forEach(n=>{n.addEventListener(`click`,()=>{let r=parseInt(n.getAttribute(`data-idx`),10);if(!v)return;let i=v.scrollWidth-v.clientWidth;v.scrollTo({left:r/e*i,behavior:`smooth`}),t.forEach(e=>e.classList.remove(`active`)),n.classList.add(`active`)})})}window.scrollDestinations=function(e){v&&v.scrollBy({left:e===`left`?-320:320,behavior:`smooth`})},window.toggleDestDetail=function(t){if(S===t){S=null,b&&(b.style.display=`none`);return}S=t;let n=e.find(e=>e.id===t);if(!n)return;document.getElementById(`dest-detail-region`).textContent=n.region,document.getElementById(`dest-detail-difficulty`).textContent=n.difficulty,document.getElementById(`dest-detail-title`).textContent=n.name+` Expedition`,document.getElementById(`dest-detail-tagline`).textContent=n.tagline,document.getElementById(`dest-detail-duration`).textContent=n.duration,document.getElementById(`dest-detail-groupsize`).textContent=n.groupSize,document.getElementById(`dest-detail-bestseason`).textContent=n.bestSeason,document.getElementById(`dest-detail-startingfrom`).textContent=n.startingFrom;let r=document.getElementById(`dest-detail-img-wrap`);r&&r.classList.add(`skeleton-loading`);let i=document.getElementById(`dest-detail-img`);i&&(i.style.opacity=`0`,i.src=n.imagePath,i.alt=n.name),document.getElementById(`dest-detail-highlights`).innerHTML=n.highlights.map(e=>`
    <div style="display:flex; gap:8px; align-items:flex-start">
      <span style="color:var(--color-highlighter-lime); font-size:10px; margin-top:2px; flex-shrink:0">✦</span>
      <span class="font-primary fs-13 text-muted">${e}</span>
    </div>
  `).join(``),document.getElementById(`dest-detail-includes`).innerHTML=n.includes.map(e=>`
    <div style="display:flex; gap:8px; align-items:center; padding:8px 10px; background:var(--color-carbon); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-md); transition:all 0.18s ease"
      onmouseenter="this.style.borderColor='var(--color-highlighter-lime)'"
      onmouseleave="this.style.borderColor='var(--color-zinc-hairline)'">
      <span style="color:var(--color-highlighter-lime); fontSize:10px; flex-shrink:0">✦</span>
      <span class="font-primary text-sm text-muted">${e}</span>
    </div>
  `).join(``),b&&(b.style.display=`block`,b.scrollIntoView({behavior:`smooth`,block:`nearest`}))},_&&(_.innerHTML=[`All`,`Spiritual`,`Adventure`,`Luxury`,`Wellness`,`Heritage`].map(e=>`
    <button class="pill ${e===`All`?`active`:``}" data-filter="${e}">${e}</button>
  `).join(``),_.querySelectorAll(`.pill`).forEach(e=>{e.addEventListener(`click`,()=>{_.querySelectorAll(`.pill`).forEach(e=>e.classList.remove(`active`)),e.classList.add(`active`),x=e.getAttribute(`data-filter`),w(),b&&(b.style.display=`none`),S=null})}));var T=!1,E,D;v&&(v.addEventListener(`mousedown`,e=>{T=!0,E=e.pageX-v.offsetLeft,D=v.scrollLeft}),v.addEventListener(`mouseleave`,()=>{T=!1}),v.addEventListener(`mouseup`,()=>{T=!1}),v.addEventListener(`mousemove`,e=>{if(!T)return;e.preventDefault();let t=(e.pageX-v.offsetLeft-E)*1.5;v.scrollLeft=D-t}),v.addEventListener(`scroll`,()=>{let e=y?y.querySelectorAll(`.scroll-dot`):[];if(e.length===0)return;let t=v.scrollWidth-v.clientWidth,n=v.scrollLeft/(t||1),r=Math.min(Math.round(n*(e.length-1)),e.length-1);e.forEach((e,t)=>{t===r?e.classList.add(`active`):e.classList.remove(`active`)})},{passive:!0})),w();var O=document.getElementById(`ticket-booking-container`);window.ticketActiveTab=`bus`,window.ticketIsRoundTrip=!0,window.ticketCaptchaSvg=``,window.ticketCaptchaToken=``,window.ticketIsSubmitted=!1,window.ticketPhone=``,window.ticketDate=``,window.ticketReturnDate=``,window.ticketPassengers=`1`,window.ticketClassType=`Economy`,window.ticketCaptchaInput=``,window.ticketIsLoading=!1,window.ticketIsCaptchaLoading=!1,window.fromQuery=``,window.toQuery=``,window.fromSuggestions=[],window.toSuggestions=[],window.activeDropdown=null,document.addEventListener(`mousedown`,function(e){let t=document.querySelector(`.route-inputs-wrapper`);t&&!t.contains(e.target)&&window.activeDropdown&&(window.activeDropdown=null,window.fromSuggestions=[],window.toSuggestions=[],[`ticket-from`,`ticket-to`].forEach(function(e){let t=document.getElementById(e);if(t){let e=t.closest(`.travelgo-field-group`);if(e){let t=e.querySelector(`.autocomplete-dropdown`);t&&t.remove()}}}))});function k(e,t){if(!e)return t;let n=e.match(/\(([^)]+)\)/);return n?n[1].toUpperCase():e.slice(0,3).toUpperCase()}window.handleSwapDestinations=function(){let e=window.fromQuery;window.fromQuery=window.toQuery,window.toQuery=e,window.renderTicketBooking()},window.fetchTicketCaptcha=async function(){window.ticketIsCaptchaLoading=!0,window.ticketCaptchaSvg=``,window.renderTicketBooking();try{let e=await fetch(`/api/captcha`);if(e.ok){let t=await e.json();window.ticketCaptchaSvg=t.svg,window.ticketCaptchaToken=t.token,window.ticketCaptchaInput=``;let n=document.getElementById(`ticket-captcha-error`);n&&(n.style.display=`none`),window.renderTicketBooking()}}catch(e){console.error(`CAPTCHA load error`,e)}finally{window.ticketIsCaptchaLoading=!1,window.renderTicketBooking()}},window.renderTicketBooking=function(){if(!O)return;if(window.ticketIsSubmitted){O.innerHTML=`
      <div style="background:var(--color-carbon); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); padding:40px; text-align:center;">
        <div style="width:48px; height:48px; border-radius:50%; background:var(--color-highlighter-lime); display:flex; align-items:center; justify-content:center; color:var(--color-onyx-black); margin:0 auto 20px">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 class="font-secondary fs-20" style="color:var(--color-pure-white); margin-bottom:8px">Ticket Inquiry Received!</h3>
        <p class="font-primary text-sm text-muted" style="margin-bottom:24px">We are checking live seats. Opening WhatsApp details...</p>
        <button class="btn-primary" onclick="window.openTicketWhatsApp()">Open WhatsApp Manually</button>
      </div>
    `;return}let e=r[window.ticketActiveTab];O.innerHTML=`
    <div class="travelgo-card">
      <!-- Card Header -->
      <div class="travelgo-card-header">
        <h3 class="travelgo-card-title">Book Transit</h3>
        <div class="travelgo-tabs-grid" style="grid-template-columns: repeat(2, 1fr);">
          <button type="button" class="travelgo-tab-btn ${window.ticketActiveTab===`bus`?`active`:``}" onclick="window.setTicketTab('bus')">🚌 Buses</button>
          <button type="button" class="travelgo-tab-btn ${window.ticketActiveTab===`taxi`?`active`:``}" onclick="window.setTicketTab('taxi')">🚕 Taxis</button>
        </div>
      </div>

      <!-- Form container -->
      <form id="ticket-booking-form" style="padding: 24px" onsubmit="window.handleTicketSubmit(event)">
        <!-- Trip Type toggle -->
        <div class="travelgo-toggles">
          <span class="toggles-label">Trip Type</span>
          <div class="toggles-row">
            <button type="button" class="toggle-pill ${window.ticketIsRoundTrip?`active`:``}" onclick="window.setTicketRoundTrip(true)">Round Trip</button>
            <button type="button" class="toggle-pill ${window.ticketIsRoundTrip?``:`active`}" onclick="window.setTicketRoundTrip(false)">One Way</button>
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
                <span class="input-box-code">${k(window.fromQuery,`IND`)}</span>
              </div>
              ${window.activeDropdown===`from`&&window.fromSuggestions.length>0?`
                <div class="autocomplete-dropdown">
                  ${window.fromSuggestions.map(e=>`
                    <div class="autocomplete-item" onclick="window.selectFromCity('${e.name} (${e.code})')">
                      <div class="autocomplete-item-name">${e.name} (${e.code})</div>
                      <div class="autocomplete-item-sub">${e.state}, ${e.country}</div>
                    </div>
                  `).join(``)}
                </div>
              `:``}
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
                <span class="input-box-code">${k(window.toQuery,`BOM`)}</span>
              </div>
              ${window.activeDropdown===`to`&&window.toSuggestions.length>0?`
                <div class="autocomplete-dropdown">
                  ${window.toSuggestions.map(e=>`
                    <div class="autocomplete-item" onclick="window.selectToCity('${e.name} (${e.code})')">
                      <div class="autocomplete-item-name">${e.name} (${e.code})</div>
                      <div class="autocomplete-item-sub">${e.state}, ${e.country}</div>
                    </div>
                  `).join(``)}
                </div>
              `:``}
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
          <div class="travelgo-field-group span-1-tablet ${window.ticketIsRoundTrip?``:`disabled`}">
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
                ${window.ticketIsRoundTrip?`required`:`disabled`}
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
                  ${[1,2,3,4,5,6,8,10].map(e=>`
                    <option value="${e}" ${window.ticketPassengers===String(e)?`selected`:``}>${e} Traveler${e>1?`s`:``}</option>
                  `).join(``)}
                </select>
                <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.08)"></div>
                <select
                  id="ticket-class"
                  class="input-box-select"
                  onchange="window.ticketClassType=this.value"
                >
                  ${e.map(e=>`
                    <option value="${e}" ${window.ticketClassType===e?`selected`:``}>${e}</option>
                  `).join(``)}
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
                ${window.ticketCaptchaSvg&&!window.ticketIsCaptchaLoading?`
                  <div style="display: flex; align-items: center; border-radius: 4px; overflow: hidden">${window.ticketCaptchaSvg}</div>
                `:`
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
                  ${window.ticketIsCaptchaLoading?`disabled`:``}
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
                    cursor: ${window.ticketIsCaptchaLoading?`not-allowed`:`pointer`};
                    transition: all 0.2s;
                    opacity: ${window.ticketIsCaptchaLoading?.6:1};
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
                      animation: ${window.ticketIsCaptchaLoading?`adminSpin 1s linear infinite`:`none`};
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
              <button type="submit" class="travelgo-search-btn" style="width: 100%" ${window.ticketIsLoading?`disabled`:``}>
                ${window.ticketIsLoading?`
                  <span class="spinner" style="border: 2px solid rgba(255,255,255,0.2); border-top: 2px solid #fff; border-radius: 50%; width: 14px; height: 14px; display: inline-block; animation: adminSpin 0.8s linear infinite; margin-right: 8px;"></span> Loading...
                `:`SEARCH TRANSIT →`}
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  `},window.setTicketTab=function(e){window.ticketActiveTab=e,window.ticketClassType=r[e][0],window.fromSuggestions=[],window.toSuggestions=[],window.activeDropdown=null,window.renderTicketBooking()},window.setTicketRoundTrip=function(e){window.ticketIsRoundTrip=e,window.renderTicketBooking()},window.renderTicketDropdown=function(e,t){let n=e===`from`?`ticket-from`:`ticket-to`,r=e===`from`?window.fromSuggestions:window.toSuggestions,i=e===`from`?`selectFromCity`:`selectToCity`,a=document.getElementById(n);if(!a)return;let o=a.parentElement.querySelector(`.input-box-code`);o&&(o.textContent=k(a.value,e===`from`?`IND`:`BOM`));let s=a.closest(`.travelgo-field-group`);if(!s)return;let c=s.querySelector(`.autocomplete-dropdown`);if(c&&c.remove(),window.activeDropdown===e){if(t){let e=document.createElement(`div`);e.className=`autocomplete-dropdown`,e.innerHTML=`<div style="padding:14px 16px;display:flex;align-items:center;gap:10px;color:#666;font-size:13px;"><div style="width:12px;height:12px;border:2px solid rgba(255,255,255,0.1);border-top:2px solid #ccc;border-radius:50%;animation:adminSpin 0.8s linear infinite;flex-shrink:0"></div>Searching cities...</div>`,s.appendChild(e);return}if(r.length>0){let e=document.createElement(`div`);e.className=`autocomplete-dropdown`,e.innerHTML=r.slice(0,8).map(function(e){let t=(e.name+` (`+e.code+`)`).replace(/'/g,`\\'`);return`<div class="autocomplete-item" onclick="window.`+i+`('`+t+`')"><div style="display:flex;align-items:center;gap:10px"><span style="font-family:monospace;font-size:10px;font-weight:700;background:rgba(255,255,255,0.06);color:#ccc;padding:2px 6px;border-radius:4px;flex-shrink:0">`+e.code+`</span><div><div class="autocomplete-item-name">`+e.name+`</div><div class="autocomplete-item-sub">`+(e.state||e.admin1||``)+(e.country?`, `+e.country:``)+`</div></div></div></div>`}).join(``),s.appendChild(e)}}};var A={};window.fetchGeocoding=function(e,t){clearTimeout(A[t]),A[t]=setTimeout(function(){var n=`https://geocoding-api.open-meteo.com/v1/search?name=`+encodeURIComponent(e)+`&count=10&language=en&format=json`;fetch(n).then(function(e){return e.json()}).catch(function(){return null}).then(function(n){if(window.activeDropdown===t){var r=[];n&&n.results&&n.results.length>0&&(r=n.results.filter(function(e){return e.country_code===`IN`}).slice(0,8).map(function(e){return{name:e.name,code:e.name.slice(0,3).toUpperCase(),state:e.admin1||``,country:e.country||`India`}}));var i=e.toLowerCase(),o=a.filter(function(e){return e.name.toLowerCase().includes(i)||e.code.toLowerCase().includes(i)}),s={};o.forEach(function(e){s[e.name.toLowerCase()]=!0});var c=o.concat(r.filter(function(e){return!s[e.name.toLowerCase()]}));t===`from`?window.fromSuggestions=c:window.toSuggestions=c,window.renderTicketDropdown(t,!1)}})},280)},window.handleFromInput=function(e){if(window.fromQuery=e,window.activeDropdown=`from`,e.length>=2){var t=e.toLowerCase();window.fromSuggestions=a.filter(function(e){return e.name.toLowerCase().includes(t)||e.code.toLowerCase().includes(t)}),window.renderTicketDropdown(`from`,!1),window.fetchGeocoding(e,`from`)}else window.fromSuggestions=[],window.renderTicketDropdown(`from`,!1)},window.handleToInput=function(e){if(window.toQuery=e,window.activeDropdown=`to`,e.length>=2){var t=e.toLowerCase();window.toSuggestions=a.filter(function(e){return e.name.toLowerCase().includes(t)||e.code.toLowerCase().includes(t)}),window.renderTicketDropdown(`to`,!1),window.fetchGeocoding(e,`to`)}else window.toSuggestions=[],window.renderTicketDropdown(`to`,!1)},window.showFromDropdownList=function(){window.activeDropdown=`from`,window.renderTicketDropdown(`from`)},window.hideFromDropdownList=function(){setTimeout(function(){window.activeDropdown===`from`&&(window.activeDropdown=null,window.renderTicketDropdown(`from`))},200)},window.showToDropdownList=function(){window.activeDropdown=`to`,window.renderTicketDropdown(`to`)},window.hideToDropdownList=function(){setTimeout(function(){window.activeDropdown===`to`&&(window.activeDropdown=null,window.renderTicketDropdown(`to`))},200)},window.selectFromCity=function(e){window.fromQuery=e,window.fromSuggestions=[],window.activeDropdown=null;let t=document.getElementById(`ticket-from`);if(t){t.value=e;let n=t.parentElement.querySelector(`.input-box-code`);n&&(n.textContent=k(e,`IND`))}window.renderTicketDropdown(`from`)},window.selectToCity=function(e){window.toQuery=e,window.toSuggestions=[],window.activeDropdown=null;let t=document.getElementById(`ticket-to`);if(t){t.value=e;let n=t.parentElement.querySelector(`.input-box-code`);n&&(n.textContent=k(e,`BOM`))}window.renderTicketDropdown(`to`)},window.handleTicketSubmit=async function(e){e.preventDefault();let t=document.getElementById(`ticket-captcha-error`);t&&(t.style.display=`none`);let n=document.getElementById(`ticket-phone`).value,r=document.getElementById(`ticket-date`).value,i=document.getElementById(`ticket-return-date`)?document.getElementById(`ticket-return-date`).value:null,a=document.getElementById(`ticket-passengers`).value,o=document.getElementById(`ticket-class`).value,s=document.getElementById(`ticket-captcha-input`).value;window.ticketIsLoading=!0,window.renderTicketBooking();try{let e=await fetch(`/api/admin/bookings`,{method:`POST`,headers:{"Content-Type":`application/json`},body:JSON.stringify({customerName:`Guest Traveller`,customerPhone:n,fromCity:window.fromQuery,toCity:window.toQuery,travelType:window.ticketActiveTab,date:r,returnDate:window.ticketIsRoundTrip?i:null,passengers:parseInt(a,10),classType:o,amount:0,status:`pending`,notes:`Web Ticket Booking Inquiry`,isPublicInquiry:!0,captchaToken:window.ticketCaptchaToken,captchaInput:s})});if(!e.ok){let n=await e.json();t&&(t.textContent=n.error||`CAPTCHA verification failed.`,t.style.display=`block`),window.fetchTicketCaptcha(),window.ticketIsLoading=!1,window.renderTicketBooking();return}window.ticketIsSubmitted=!0,window.ticketIsLoading=!1,window.renderTicketBooking(),setTimeout(()=>{window.openTicketWhatsApp()},800)}catch(e){console.error(`Server DB submit failed, direct handoff to WhatsApp`,e),window.ticketIsLoading=!1,window.renderTicketBooking(),window.openTicketWhatsApp()}},window.openTicketWhatsApp=function(){let e=`Hello Shivalay Travels! I would like to book a *${{bus:`🚌 Bus`,taxi:`🚕 Taxi`}[window.ticketActiveTab]} Ticket*:\n\n📍 *From:* ${window.fromQuery||`Not specified`}\n📍 *To:* ${window.toQuery||`Not specified`}\n📅 *Departure:* ${document.getElementById(`ticket-date`)?document.getElementById(`ticket-date`).value:``}\n`+(window.ticketIsRoundTrip&&document.getElementById(`ticket-return-date`)?`📅 *Return:* ${document.getElementById(`ticket-return-date`).value}\n`:``)+`👥 *Passengers:* ${document.getElementById(`ticket-passengers`)?document.getElementById(`ticket-passengers`).value:`1`}\n✨ *Class:* ${document.getElementById(`ticket-class`)?document.getElementById(`ticket-class`).value:``}\n\nPlease share the best available rates. Thanks!`;window.open(`https://wa.me/919340994628?text=${encodeURIComponent(e)}`,`_blank`)},window.fetchTicketCaptcha();var j=document.querySelectorAll(`.faq-item`);j.forEach(e=>{let t=e.querySelector(`.faq-btn`),n=e.querySelector(`.faq-content`),r=e.querySelector(`.faq-arrow`);t&&n&&r&&t.addEventListener(`click`,()=>{let e=n.style.maxHeight!==`0px`&&n.style.maxHeight!==``;j.forEach(e=>{let t=e.querySelector(`.faq-content`),n=e.querySelector(`.faq-arrow`),r=e.querySelector(`.faq-btn`);t&&(t.style.maxHeight=`0px`),n&&(n.style.transform=`none`),r&&r.classList.remove(`active`)}),e?(n.style.maxHeight=`0px`,r.style.transform=`none`,t.classList.remove(`active`)):(n.style.maxHeight=`200px`,r.style.transform=`rotate(180deg)`,t.classList.add(`active`))})});var M=document.querySelectorAll(`.itinerary-day`);M.forEach(e=>{let t=e.querySelector(`.itinerary-day-header`),n=e.querySelector(`.itinerary-day-content`),r=e.querySelector(`.itinerary-day-arrow`),i=e.querySelector(`.day-num`);t&&n&&r&&t.addEventListener(`click`,()=>{let e=n.style.maxHeight!==`0px`&&n.style.maxHeight!==``;M.forEach(e=>{let t=e.querySelector(`.itinerary-day-content`),n=e.querySelector(`.itinerary-day-arrow`),r=e.querySelector(`.day-num`);t&&(t.style.maxHeight=`0px`),n&&(n.style.transform=`none`),r&&(r.style.background=`var(--color-carbon)`)}),e?(n.style.maxHeight=`0px`,r.style.transform=`none`,i&&(i.style.background=`var(--color-carbon)`)):(n.style.maxHeight=`120px`,r.style.transform=`rotate(180deg)`,i&&(i.style.background=`var(--color-highlighter-lime)`))})});var N=document.getElementById(`testimonial-quote`),P=document.getElementById(`testimonial-dest`),F=document.getElementById(`testimonial-avatar`),I=document.getElementById(`testimonial-name`),L=document.getElementById(`testimonial-meta`),R=document.getElementById(`testimonial-card`),z=document.getElementById(`testimonial-sidebar`),B=document.getElementById(`testimonial-dots`),V=0,H=null;function U(){let e=n[V];e&&(R&&(R.style.opacity=0,R.style.transform=`translateY(4px)`,setTimeout(()=>{if(N&&(N.textContent=`“${e.quote}”`),P&&(P.textContent=e.destination),F)if(e.clientImage){let t=F.querySelector(`img`);(!t||t.getAttribute(`src`)!==e.clientImage)&&(F.innerHTML=`<img src="${e.clientImage}" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;" />`)}else F.textContent.trim()!==e.avatar&&(F.textContent=e.avatar);I&&(I.textContent=e.name),L&&(L.textContent=`${e.location} · ${e.trip}`);let t=document.getElementById(`testimonial-img`);if(t){let n=e.image||`/images/kashmir.png`;t.getAttribute(`data-current-src`)!==n&&(t.src=n,t.setAttribute(`data-current-src`,n))}let n=document.getElementById(`testimonial-rating`);n&&(n.innerHTML=Array.from({length:e.rating}).map(()=>`
          <i data-lucide="star" style="width:12px; height:12px; fill:currentColor"></i>
        `).join(``),window.lucide&&window.lucide.createIcons()),R.style.opacity=1,R.style.transform=`translateY(0)`},180)),z&&z.querySelectorAll(`button`).forEach((e,t)=>{let n=e.querySelector(`.test-sidebar-avatar`),r=e.querySelector(`.test-sidebar-name`);t===V?(e.style.background=`var(--color-carbon)`,e.style.borderColor=`var(--color-zinc-hairline)`,n&&(n.style.background=`var(--color-highlighter-lime)`,n.style.color=`var(--color-onyx-black)`),r&&(r.style.color=`var(--color-pure-white)`)):(e.style.background=`transparent`,e.style.borderColor=`transparent`,n&&(n.style.background=`var(--color-zinc-hairline)`,n.style.color=`var(--color-steel-gray)`),r&&(r.style.color=`var(--color-steel-gray)`))}),B&&B.querySelectorAll(`button`).forEach((e,t)=>{t===V?(e.style.width=`20px`,e.style.background=`var(--color-highlighter-lime)`):(e.style.width=`6px`,e.style.background=`var(--color-zinc-hairline)`)}))}function W(){H&&clearInterval(H),H=setInterval(()=>{V=(V+1)%n.length,U()},7e3)}function te(){H&&clearInterval(H)}z&&(z.innerHTML=n.map((e,t)=>`
    <button onclick="setTestimonial(${t})" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:var(--radius-xl); background:transparent; border:1px solid transparent; cursor:pointer; text-align:left; transition:all 0.18s ease; width:100%">
      <div class="test-sidebar-avatar font-primary fs-11 fw-medium" style="width:32px; height:32px; border-radius:var(--radius-md); flex-shrink:0; background:var(--color-zinc-hairline); display:flex; align-items:center; justify-content:center; color:var(--color-steel-gray); transition:all 0.18s ease; overflow:hidden;">
        ${e.clientImage?`<img src="${e.clientImage}" style="width:100%; height:100%; object-fit:cover;" />`:e.avatar}
      </div>
      <div style="flex:1; min-width:0">
        <p class="test-sidebar-name font-primary fw-medium fs-11" style="color:var(--color-steel-gray); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px">${e.name}</p>
        <p class="font-primary text-xs" style="color:var(--color-ash-gray); white-space:nowrap; overflow:hidden; text-overflow:ellipsis">${e.destination}</p>
      </div>
    </button>
  `).join(``)),B&&(B.innerHTML=n.map((e,t)=>`
    <button onclick="setTestimonial(${t})" style="height:6px; border-radius:3px; border:none; cursor:pointer; transition:all 0.25s ease"></button>
  `).join(``)),window.setTestimonial=function(e){V=e,U(),W()};var G=document.getElementById(`testimonial-prev-btn`),K=document.getElementById(`testimonial-next-btn`);G&&G.addEventListener(`click`,()=>{V=(V-1+n.length)%n.length,U(),W()}),K&&K.addEventListener(`click`,()=>{V=(V+1)%n.length,U(),W()}),R&&(R.addEventListener(`mouseenter`,te),R.addEventListener(`mouseleave`,W)),U(),W(),(function(){let e={};n.forEach(function(t){if(t.image&&!e[t.image]){e[t.image]=!0;var n=new Image;n.src=t.image}})})();var q=document.getElementById(`guides-categories`),J=document.getElementById(`guides-list`),Y=`All`;function ne(e,t){return e=(e||``).trim(),e.includes(`🏔`)||t===`Packing Guide`?`<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-highlighter-lime); vertical-align: middle;"><path d="m8 3 4 8 5-5 5 15H2L8 3z"/></svg>`:e.includes(`❄`)||t===`Destination Intel`?`<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-highlighter-lime); vertical-align: middle;"><path d="M12 2v20M17 5 7 19M19 17 5 7M22 12H2M16 2l-4 4-4-4M8 22l4-4 4 4"/></svg>`:e.includes(`⚕`)||e.includes(`🚨`)||t===`Health & Safety`?`<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-highlighter-lime); vertical-align: middle;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>`:e.includes(`🙏`)||t===`Culture`?`<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-highlighter-lime); vertical-align: middle;"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>`:`<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-highlighter-lime); vertical-align: middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>`}function X(){J&&(J.innerHTML=(Y===`All`?t:t.filter(e=>e.category===Y)).map(e=>`
    <div class="reveal visible" style="display:flex; flex-direction:column; gap:0; cursor:pointer; overflow:hidden; background:var(--color-onyx-black); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); transition:border-color 0.18s ease" onmouseenter="this.style.borderColor='var(--color-smoke)'" onmouseleave="this.style.borderColor='var(--color-zinc-hairline)'" onclick="smoothScroll('planner')">
      <div class="img-zoom-wrap" style="height:110px; position:relative; overflow:hidden; border-radius:0">
        <img src="${e.image}" alt="${e.category}" style="width:100%; height:100%; object-fit:cover">
        <div style="position:absolute; inset:0; background:var(--gradient-visual-overlay)"></div>
        <div style="position:absolute; bottom:8px; left:12px; display:flex; gap:6px; align-items:center">
          <span style="font-size:13px; display:inline-flex; align-items:center;">${ne(e.icon,e.category)}</span>
          <span class="font-primary fs-9 fw-medium uppercase ls-1" style="color:var(--color-white-80)">${e.category}</span>
        </div>
        ${e.badge?`<span class="font-primary fs-9 fw-medium" style="position:absolute; top:8px; right:10px; color:var(--color-onyx-black); background:var(--color-highlighter-lime); padding:2px 6px; border-radius:var(--radius-full)">${e.badge}</span>`:``}
      </div>
      <div style="display:flex; flex-direction:column; gap:10px; padding:14px 16px; flex:1">
        <p class="font-primary fw-medium text-sm lh-15" style="color:var(--color-pure-white); flex:1">${e.title}</p>
        <div style="display:flex; justify-content:space-between; align-items:center">
          <span class="font-primary fs-11 text-muted">${e.readTime}</span>
          <div class="font-primary fs-11" style="display:flex; align-items:center; gap:3px; color:var(--color-highlighter-lime)">
            Read guide
            <svg width="11" height="11" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
      </div>
    </div>
  `).join(``),window.lucide&&window.lucide.createIcons())}q&&(q.innerHTML=[`All`,`Packing Guide`,`Destination Intel`,`Health & Safety`,`Culture`].map(e=>`
    <button class="pill ${e===`All`?`active`:``}" data-cat="${e}">${e}</button>
  `).join(``),q.querySelectorAll(`.pill`).forEach(e=>{e.addEventListener(`click`,()=>{q.querySelectorAll(`.pill`).forEach(e=>e.classList.remove(`active`)),e.classList.add(`active`),Y=e.getAttribute(`data-cat`),X()})})),X();var Z=document.getElementById(`journey-planner-root`);window.plannerStep=0,window.plannerAnswers={},window.plannerCustomInputs={},window.plannerCaptchaSvg=``,window.plannerCaptchaToken=``,window.plannerSubmitted=!1,window.plannerIsLoading=!1,window.plannerIsCaptchaLoading=!1,window.fetchPlannerCaptcha=async function(){window.plannerIsCaptchaLoading=!0,window.plannerCaptchaSvg=``,window.renderPlanner();try{let e=await fetch(`/api/captcha`);if(e.ok){let t=await e.json();window.plannerCaptchaSvg=t.svg,window.plannerCaptchaToken=t.token;let n=document.getElementById(`planner-captcha-error`);n&&(n.style.display=`none`);let r=document.getElementById(`planner-captcha-input`);r&&(r.value=``),window.renderPlanner()}}catch(e){console.error(`Planner CAPTCHA load error`,e)}finally{window.plannerIsCaptchaLoading=!1,window.renderPlanner()}},window.renderPlanner=function(){if(!Z)return;let e=i[window.plannerStep],t=Math.round(window.plannerStep/(i.length-1)*100),n=window.plannerStep===i.length-1,r=e.id===`notes`;Z.innerHTML=`
    <!-- Left Sidebar -->
    <div class="planner-sidebar">
      <p class="section-label" style="margin-bottom:8px">Journey Planner</p>
      <h2 class="heading-md" style="margin-bottom:8px">Build your perfect private escape.</h2>
      <p class="font-primary text-sm lh-16 text-muted" style="margin-bottom:24px">
        ${i.length} steps to your dream itinerary. Every field is fully customisable.
      </p>
      <div style="display:flex; flex-direction:column; gap:2px">
        ${i.map((e,t)=>{let n=window.plannerStep===t,r=t<window.plannerStep;return`
            <button type="button" onclick="window.setPlannerStep(${t})" style="display:flex; align-items:center; gap:10px; padding:8px 12px; background:${n?`var(--color-lime-07)`:`transparent`}; border:1px solid ${n?`var(--color-lime-25)`:`transparent`}; border-radius:var(--radius-md); cursor:${t<=window.plannerStep?`pointer`:`default`}; text-align:left; width:100%; transition:all 0.18s ease">
              <div style="width:20px; height:20px; border-radius:var(--radius-md); flex-shrink:0; display:flex; align-items:center; justify-content:center; background:${r?`var(--color-highlighter-lime)`:n?`var(--color-lime-20)`:`var(--color-zinc-hairline)`}; transition:background 0.18s ease">
                ${r?`
                  <svg width="9" height="9" viewBox="0 0 10 10" fill="none"><path d="M2 5L4 7L8 3" stroke="var(--color-onyx-black)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                `:`
                  <span class="font-primary fs-8 fw-medium" style="color:${n?`var(--color-highlighter-lime)`:`var(--color-ash-gray)`}">${t+1}</span>
                `}
              </div>
              <span class="font-primary fs-11 ${n?`fw-medium`:`fw-regular`}" style="color:${n?`var(--color-pure-white)`:r?`var(--color-steel-gray)`:`var(--color-ash-gray)`}; flex:1">
                ${e.label}
              </span>
              ${window.plannerAnswers[e.id]?`
                <span class="font-primary fs-9" style="color:var(--color-highlighter-lime); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:64px">${window.plannerAnswers[e.id]}</span>
              `:``}
            </button>
          `}).join(``)}
      </div>
    </div>

    <!-- Right Panel (Content Card) -->
    <div style="background:var(--color-carbon); border:1px solid var(--color-zinc-hairline); border-radius:var(--radius-xl); padding:32px; min-height:480px; display:flex; flex-direction:column">
      ${window.plannerSubmitted?`
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
      `:`
        <!-- Progress bar -->
        <div style="margin-bottom:28px">
          <div style="display:flex; justify-content:space-between; margin-bottom:8px">
            <span class="font-primary fs-11" style="color:var(--color-ash-gray)">Step ${window.plannerStep+1} of ${i.length}</span>
            <span class="font-primary fs-11 fw-medium" style="color:var(--color-highlighter-lime)">${t}%</span>
          </div>
          <div style="height:3px; background:var(--color-zinc-hairline); border-radius:3px; overflow:hidden">
            <div style="height:100%; width:${t}%; background:var(--color-highlighter-lime); border-radius:3px; transition:width 0.5s var(--ease-out)"></div>
          </div>
        </div>

        <!-- Step content -->
        <div style="flex:1; display:flex; flex-direction:column">
          <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px">
            <span style="display:inline-flex; align-items:center; justify-content:center; color:var(--color-highlighter-lime); width:24px; height:24px; flex-shrink:0"><i data-lucide="${e.icon}" style="width:20px; height:20px"></i></span>
            <h3 class="fs-planner-q" style="color:var(--color-pure-white); font-size:18px">${e.question}</h3>
          </div>
          ${e.subtext?`<p class="font-primary text-sm lh-15 text-muted" style="margin-bottom:20px; margin-left:30px">${e.subtext}</p>`:``}

          <!-- Options selection -->
          ${e.options.length>0?`
            <div style="display:flex; flex-wrap:wrap; gap:7px; margin-bottom:24px">
              ${e.options.map(t=>{let n=window.plannerAnswers[e.id]===t;return`
                  <button type="button" class="font-primary text-sm" onclick="window.selectPlannerOption('${t}')" style="padding:7px 14px; border-radius:var(--radius-md); border:1px solid ${n?`var(--color-highlighter-lime)`:`var(--color-zinc-hairline)`}; background:${n?`var(--color-highlighter-lime)`:`transparent`}; color:${n?`var(--color-onyx-black)`:`var(--color-steel-gray)`}; cursor:pointer; transition:all 0.18s ease">${t}</button>
                `}).join(``)}
            </div>
          `:``}

          <!-- Custom Inputs -->
          ${n?`
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
                ${Object.entries(window.plannerAnswers).map(([e,t])=>{let n=i.find(t=>t.id===e);return`
                    <div style="display:flex; justify-content:space-between; gap:16px; align-items:flex-start">
                      <span class="font-primary fs-11" style="color:var(--color-ash-gray); flex-shrink:0">${n?n.label.replace(/^\d+ — /,``):e}</span>
                      <span class="font-primary fs-11 fw-medium text-right" style="color:var(--color-pure-white)">${t}</span>
                    </div>
                  `}).join(``)}
              </div>

              <!-- CAPTCHA -->
              <div style="display:flex; flex-direction:column; gap:8px; margin-top:4px">
                <label class="text-field-label">Security Verification (CAPTCHA)</label>
                <div style="display:grid; grid-template-columns:auto 1fr; alignItems:center; gap:12px; background:rgba(255,255,255,0.01); border:1px solid rgba(255,255,255,0.05); border-radius:8px; padding:12px">
                  <div style="display:flex; align-items:center; gap:8px">
                    ${window.plannerCaptchaSvg&&!window.plannerIsCaptchaLoading?`
                      <div style="display:flex; align-items:center; border-radius:4px; overflow:hidden">${window.plannerCaptchaSvg}</div>
                    `:`
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
                      ${window.plannerIsCaptchaLoading?`disabled`:``}
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
                        cursor: ${window.plannerIsCaptchaLoading?`not-allowed`:`pointer`};
                        transition: all 0.2s;
                        opacity: ${window.plannerIsCaptchaLoading?.6:1};
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
                          animation: ${window.plannerIsCaptchaLoading?`adminSpin 1s linear infinite`:`none`};
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

              <button type="submit" class="btn-primary fs-13" style="align-self:flex-start" ${window.plannerIsLoading?`disabled`:``}>
                ${window.plannerIsLoading?`
                  <span class="spinner" style="border: 2px solid rgba(255,255,255,0.2); border-top: 2px solid #fff; border-radius: 50%; width: 14px; height: 14px; display: inline-block; animation: adminSpin 0.8s linear infinite; margin-right: 8px;"></span> Loading...
                `:`Send My Journey Brief →`}
              </button>
            </form>
          `:`
            <div style="${e.options.length>0?`border-top:1px solid var(--color-zinc-hairline); padding-top:18px`:``}">
              ${e.options.length>0?`<p class="font-primary text-xs fw-medium uppercase ls-05" style="color:var(--color-ash-gray); margin-bottom:10px">Or enter custom details:</p>`:``}
              <div style="display:flex; gap:8px; align-items:flex-start">
                ${r?`
                  <textarea id="planner-notes-input" class="input-terminal" rows="4" style="resize:vertical; line-height:1.6; flex:1" placeholder="${e.inputPlaceholder||``}">${window.plannerCustomInputs[e.id]||``}</textarea>
                `:`
                  <input type="text" id="planner-text-input" class="input-terminal" style="flex:1" placeholder="${e.inputPlaceholder||``}" value="${window.plannerCustomInputs[e.id]||``}">
                `}
                <button type="button" class="btn-primary fs-13" style="padding:10px 18px; flex-shrink:0" onclick="window.submitPlannerCustomValue()">Next →</button>
              </div>
              ${r?`
                <button type="button" class="font-primary text-sm underline" onclick="window.skipPlannerNotes()" style="margin-top:10px; color:var(--color-ash-gray); background:none; border:none; cursor:pointer; padding:0">Skip this step</button>
              `:``}
            </div>
          `}
        </div>

        <!-- Back Button -->
        ${window.plannerStep>0?`
          <button type="button" class="font-primary text-sm" onclick="window.prevPlannerStep()" style="margin-top:20px; background:none; border:none; cursor:pointer; color:var(--color-ash-gray); display:flex; align-items:center; gap:5px; transition:color 0.18s" onmouseenter="this.style.color='var(--color-pure-white)'" onmouseleave="this.style.color='var(--color-ash-gray)'">← Back</button>
        `:``}
      `}
    </div>
  `,window.lucide&&window.lucide.createIcons()},window.setPlannerStep=function(e){e<=window.plannerStep&&(window.plannerStep=e,window.renderPlanner())},window.prevPlannerStep=function(){window.plannerStep>0&&(window.plannerStep--,window.renderPlanner())},window.selectPlannerOption=function(e){let t=i[window.plannerStep];window.plannerAnswers[t.id]=e,window.plannerCustomInputs[t.id]=``,window.advancePlanner()},window.submitPlannerCustomValue=function(){let e=i[window.plannerStep],t=document.getElementById(window.plannerStep===7?`planner-notes-input`:`planner-text-input`);if(t&&t.value.trim()){let n=t.value.trim();window.plannerAnswers[e.id]=n,window.plannerCustomInputs[e.id]=n,window.advancePlanner()}},window.skipPlannerNotes=function(){window.plannerAnswers.notes=``,window.advancePlanner()},window.advancePlanner=function(){window.plannerStep<i.length-1&&(window.plannerStep++,window.plannerStep===i.length-1?window.fetchPlannerCaptcha():window.renderPlanner())},window.handlePlannerSubmit=async function(e){e.preventDefault();let t=document.getElementById(`planner-captcha-error`);t&&(t.style.display=`none`);let n=document.getElementById(`planner-name`).value,r=document.getElementById(`planner-email`).value,a=document.getElementById(`planner-phone`).value,o=document.getElementById(`planner-captcha-input`).value,s=Object.entries(window.plannerAnswers).filter(([,e])=>e).map(([e,t])=>{let n=i.find(t=>t.id===e);return`${n?n.label.replace(/^\d+ — /,``):e}: ${t}`}),c=window.plannerAnswers.travelers||`1`,l=1,u=c.match(/\d+/);u&&(l=parseInt(u[0],10)),window.plannerIsLoading=!0,window.renderPlanner();try{let e=await fetch(`/api/admin/inquiries`,{method:`POST`,headers:{"Content-Type":`application/json`},body:JSON.stringify({customerName:n,customerPhone:a||`Not provided`,customerEmail:r,destinations:window.plannerAnswers.destination||`Custom Pilgrimage`,duration:window.plannerAnswers.duration||`Not specified`,travelers:l,budget:window.plannerAnswers.budget||`Standard`,accommodation:window.plannerAnswers.accommodation||`Standard`,notes:`Journey Planner Brief:\n${s.join(`
`)}`,isPublicInquiry:!0,captchaToken:window.plannerCaptchaToken,captchaInput:o})});if(!e.ok){let n=await e.json();t&&(t.textContent=n.error||`CAPTCHA validation failed.`,t.style.display=`block`),window.fetchPlannerCaptcha(),window.plannerIsLoading=!1,window.renderPlanner();return}window.plannerSubmitted=!0,window.plannerIsLoading=!1,window.renderPlanner(),setTimeout(()=>{window.openPlannerWhatsApp(n,r,a,s)},800)}catch(e){console.error(`Server DB submit failed, direct handoff to WhatsApp`,e),window.plannerIsLoading=!1,window.renderPlanner(),window.openPlannerWhatsApp(n,r,a,s)}},window.openPlannerWhatsApp=function(e,t,n,r){e||(e=document.getElementById(`planner-name`)?document.getElementById(`planner-name`).value:`Guest`,t=document.getElementById(`planner-email`)?document.getElementById(`planner-email`).value:``,n=document.getElementById(`planner-phone`)?document.getElementById(`planner-phone`).value:``,r=Object.entries(window.plannerAnswers).filter(([,e])=>e).map(([e,t])=>{let n=i.find(t=>t.id===e);return`${n?n.label.replace(/^\d+ — /,``):e}: ${t}`}));let a=`Hello Shivalay Travels! Here is my journey brief:\n\n${r.join(`
`)}\n\n*Name:* ${e}\n*Email:* ${t}\n${n?`*Phone:* ${n}`:``}`;window.open(`https://wa.me/919340994628?text=${encodeURIComponent(a)}`,`_blank`)},window.renderPlanner(),window.openPropertyModal=function(e,t){let n=document.getElementById(`property-modal`);if(!n)return;document.getElementById(`modal-property-id`).value=e.id,document.getElementById(`modal-property-type`).value=t,document.getElementById(`modal-property-name`).value=e.name,document.getElementById(`modal-property-location`).value=e.location,document.getElementById(`modal-property-price`).value=e.price;let r=document.getElementById(`property-modal-info`);if(r){let t=[e.imagePath].concat(e.gallery||[]).filter(Boolean);window.currentModalGallery=t,r.innerHTML=`
      <!-- Main Image Container -->
      <div style="position:relative; height:240px; overflow:hidden; cursor:zoom-in;" onclick="window.openLightbox(window.currentModalGallery, window.currentModalGallery.findIndex(url => document.getElementById('modal-main-img').src.endsWith(url)), event)">
        <img id="modal-main-img" src="${t[0]}" alt="${e.name}" style="width:100%; height:100%; object-fit:cover; transition: opacity 0.3s ease;" />
        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(12,12,12,0.9), transparent);"></div>
        <div style="position:absolute; bottom:16px; left:20px; right:20px;">
          <span style="font-size:10px; font-weight:600; color:var(--color-onyx-black); background:var(--color-highlighter-lime); padding:3px 8px; border-radius:12px; margin-bottom:8px; display:inline-block;">
            ★ ${e.rating}
          </span>
          <h2 class="font-secondary fs-24" style="color:#fff; line-height:1.2; margin:0;">${e.name}</h2>
        </div>
      </div>
      
      <!-- Gallery Thumbnails (only if multiple images exist) -->
      ${t.length>1?`
      <div style="display:flex; gap:8px; padding:12px 24px; background:rgba(0,0,0,0.25); overflow-x:auto; border-bottom:1px solid var(--color-zinc-hairline);">
        ${t.map((e,t)=>`
          <img 
            src="${e}" 
            alt="Gallery ${t+1}" 
            onclick="document.getElementById('modal-main-img').src='${e}'; document.querySelectorAll('.gallery-thumb').forEach(t => t.style.borderColor='transparent'); this.style.borderColor='var(--color-highlighter-lime)';"
            class="gallery-thumb"
            style="width:50px; height:50px; object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid ${t===0?`var(--color-highlighter-lime)`:`transparent`}; transition:all 0.2s;"
          />
        `).join(``)}
      </div>
      `:``}
      
      <div style="padding:24px; display:flex; flex-direction:column; gap:16px;">
        <div>
          <span style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; display:block;">Location</span>
          <p class="font-primary text-sm" style="color:#eee; margin:2px 0 0 0;">📍 ${e.location}</p>
        </div>
        <div>
          <span style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; display:block;">Price Range</span>
          <p class="font-primary fs-18 fw-medium" style="color:var(--color-highlighter-lime); margin:2px 0 0 0;">${e.price}</p>
        </div>
        <div>
          <span style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; display:block;">Basic Information</span>
          <p class="font-primary text-sm text-muted lh-15" style="margin:2px 0 0 0;">${e.description}</p>
        </div>
        <div>
          <span style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px; display:block; margin-bottom:6px;">Amenities Included</span>
          <div style="display:flex; gap:6px; flex-wrap:wrap;">
            ${(e.amenities||[]).map(e=>`
              <span class="font-primary" style="font-size:10px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); color:#aaa; padding:3px 8px; border-radius:6px;">
                ${e}
              </span>
            `).join(``)}
          </div>
        </div>
      </div>
    `}document.getElementById(`prop-captcha-input`).value=``;let i=document.getElementById(`prop-captcha-error`);i&&(i.style.display=`none`),n.style.display=`flex`,window.fetchPropCaptcha()},window.closePropertyModal=function(){let e=document.getElementById(`property-modal`);e&&(e.style.display=`none`)},window.fetchPropCaptcha=function(){fetch(`/api/captcha`).then(e=>e.json()).then(e=>{let t=document.getElementById(`prop-captcha-svg-container`);t&&(t.innerHTML=e.svg)}).catch(e=>console.error(`Prop captcha load failed`,e))},window.handlePropertyInquirySubmit=async function(e){e.preventDefault();let t=document.getElementById(`prop-captcha-error`);t&&(t.style.display=`none`);let n=document.getElementById(`prop-submit-btn`);n&&(n.disabled=!0),document.getElementById(`modal-property-id`).value;let r=document.getElementById(`modal-property-type`).value,i=document.getElementById(`modal-property-name`).value,a=document.getElementById(`modal-property-location`).value,o=document.getElementById(`modal-property-price`).value,s=document.getElementById(`prop-guest-name`).value,c=document.getElementById(`prop-guest-phone`).value,l=document.getElementById(`prop-checkin`).value,u=document.getElementById(`prop-checkout`).value,d=parseInt(document.getElementById(`prop-males`).value||`0`,10),f=parseInt(document.getElementById(`prop-females`).value||`0`,10),p=parseInt(document.getElementById(`prop-kids`).value||`0`,10),m=document.getElementById(`prop-notes`).value,h=document.getElementById(`prop-captcha-input`).value,g=d+f+p,_=`${l} to ${u}`,v=`Males: ${d}, Females: ${f}, Children: ${p}. Guest Notes: ${m}`;try{let e=await fetch(`/api/admin/inquiries`,{method:`POST`,headers:{"Content-Type":`application/json`},body:JSON.stringify({customerName:s,customerPhone:c,customerEmail:`inquiry@shivalay.in`,destinations:`${r.toUpperCase()} - ${i}`,duration:_,travelers:g,budget:o,accommodation:r===`hotel`?`Hotel Stay`:`Villa Stay`,notes:v,captchaInput:h})});if(!e.ok){let r=await e.json();t&&(t.textContent=r.error||`CAPTCHA verification failed.`,t.style.display=`block`),window.fetchPropCaptcha(),n&&(n.disabled=!1);return}window.closePropertyModal(),n&&(n.disabled=!1);let y=`Hello Shivalay Travels! I would like to book a stay at the ${r}: *${i}*:\n\n📍 *Location:* ${a}\n📅 *Check-in:* ${l}\n📅 *Check-out:* ${u}\n👥 *Guests:* ${d} Male(s), ${f} Female(s), ${p} Child(ren) (Total: ${g})\n📲 *Contact Phone:* ${c}\n📝 *Special Requests:* ${m||`None`}\n\nPlease confirm availability. Thanks!`;window.open(`https://wa.me/919340994628?text=${encodeURIComponent(y)}`,`_blank`)}catch(e){console.error(`Property inquiry submission error`,e),n&&(n.disabled=!1),window.closePropertyModal();let t=`Hello Shivalay Travels! I would like to book a stay at the ${r}: *${i}*:\n\n📍 *Location:* ${a}\n📅 *Check-in:* ${l}\n📅 *Check-out:* ${u}\n👥 *Guests:* ${d} Male(s), ${f} Female(s), ${p} Child(ren)\n📲 *Contact Phone:* ${c}\n📝 *Special Requests:* ${m||`None`}\n\nPlease confirm availability. Thanks!`;window.open(`https://wa.me/919340994628?text=${encodeURIComponent(t)}`,`_blank`)}},window.lazyLoadCardImages=function(e){e&&e.querySelectorAll(`img[data-src]`).forEach(e=>{e.src=e.getAttribute(`data-src`),e.removeAttribute(`data-src`)})},window.changeCardImage=function(e,t){let n=e.closest(`.property-card-gallery-wrapper`);if(!n)return;window.lazyLoadCardImages(n);let r=n.querySelectorAll(`.prop-gallery-img`);if(r.length<=1)return;let i=0;r.forEach((e,t)=>{e.style.opacity===`1`&&(i=t)}),r[i].style.opacity=`0`;let a=i+t;a>=r.length&&(a=0),a<0&&(a=r.length-1),r[a].style.opacity=`1`,n.querySelectorAll(`.prop-gallery-dot`).forEach((e,t)=>{t===a?e.style.background=`var(--color-highlighter-lime)`:e.style.background=`rgba(255,255,255,0.4)`})},window.getCardActiveIdx=function(e){if(!e)return 0;let t=e.querySelectorAll(`.prop-gallery-img`);for(let e=0;e<t.length;e++)if(t[e].style.opacity===`1`)return e;return 0};var Q=[],$=0;window.openLightbox=function(e,t,n){if(n&&n.stopPropagation(),Q=(e||[]).filter(Boolean),$=t||0,Q.length===0)return;let r=document.getElementById(`image-lightbox`),i=document.getElementById(`lightbox-img`),a=document.getElementById(`lightbox-caption`),o=document.getElementById(`lightbox-prev`),s=document.getElementById(`lightbox-next`);!r||!i||(i.src=Q[$],a&&(a.textContent=`Image ${$+1} of ${Q.length}`),Q.length<=1?(o&&(o.style.display=`none`),s&&(s.style.display=`none`)):(o&&(o.style.display=`flex`),s&&(s.style.display=`flex`)),r.style.display=`flex`,setTimeout(()=>{r.style.opacity=`1`},10))},window.closeLightbox=function(){let e=document.getElementById(`image-lightbox`);e&&(e.style.opacity=`0`,setTimeout(()=>{e.style.display=`none`},250))},window.navigateLightbox=function(e){if(Q.length<=1)return;$+=e,$>=Q.length&&($=0),$<0&&($=Q.length-1);let t=document.getElementById(`lightbox-img`),n=document.getElementById(`lightbox-caption`);t&&(t.style.opacity=`0.7`,setTimeout(()=>{t.src=Q[$],t.style.opacity=`1`},100)),n&&(n.textContent=`Image ${$+1} of ${Q.length}`)},document.addEventListener(`keydown`,function(e){let t=document.getElementById(`image-lightbox`);!t||t.style.display===`none`||(e.key===`Escape`?window.closeLightbox():e.key===`ArrowLeft`||e.key===`Left`?window.navigateLightbox(-1):(e.key===`ArrowRight`||e.key===`Right`)&&window.navigateLightbox(1))}),document.addEventListener(`DOMContentLoaded`,()=>{window.lucide&&window.lucide.createIcons()});