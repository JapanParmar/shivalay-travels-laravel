@extends('layouts.admin')

@section('title', 'Business Settings')

@section('styles')
<style>
    .st-root { display: flex; flex-direction: column; gap: 20px; }
    .st-header { display: flex; align-items: center; justify-content: space-between; }
    .st-title { font-size: 22px; font-weight: 700; color: #fff; margin: 0; }
    .st-sub { font-size: 12px; color: #555; margin-top: 2px; }
    .st-save-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'DM Sans',sans-serif; transition: all 0.3s; }
    .st-save-btn:hover { background: #cc0000; }
    .st-save-btn.saved { background: #22c55e; }
    .st-sections { display: flex; flex-direction: column; gap: 16px; }
    .st-section { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; padding: 24px; }
    .st-section-head { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 20px; }
    .st-section-icon { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px; background: rgba(255,0,0,0.08); border: 1px solid rgba(255,0,0,0.2); color: #ff0000; flex-shrink: 0; }
    .st-section-title { font-size: 16px; font-weight: 700; color: #fff; margin: 0; }
    .st-section-sub { font-size: 12px; color: #555; margin-top: 2px; }
    .st-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    .st-field { display: flex; flex-direction: column; gap: 8px; }
    .st-lbl { font-size: 11px; color: #555; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
    .st-input { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 10px 12px; color: #fff; font-size: 13px; outline: none; font-family: 'DM Sans',sans-serif; transition: border-color 0.2s; }
    .st-input:focus { border-color: rgba(255,0,0,0.4); }
    .st-select { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 10px 12px; color: #aaa; font-size: 13px; outline: none; cursor: pointer; font-family: 'DM Sans',sans-serif; }
    .st-select option { background: #111; color: #fff; }
    .st-toggles { display: flex; flex-direction: column; gap: 0; }
    .st-toggle-item { display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .st-toggle-item:last-child { border-bottom: none; }
    .st-toggle-label { font-size: 14px; font-weight: 600; color: #ddd; margin-bottom: 3px; }
    .st-toggle-desc { font-size: 12px; color: #555; }
    .st-toggle-btn { width: 44px; height: 24px; border-radius: 12px; border: none; cursor: pointer; position: relative; transition: background 0.2s; flex-shrink: 0; }
    .st-toggle-btn.on { background: #ff0000; }
    .st-toggle-btn.off { background: rgba(255,255,255,0.1); }
    .st-toggle-thumb { position: absolute; top: 2px; width: 20px; height: 20px; border-radius: 50%; background: #fff; transition: left 0.2s; box-shadow: 0 1px 4px rgba(0,0,0,0.3); }
    .st-toggle-btn.on .st-toggle-thumb { left: 22px; }
    .st-toggle-btn.off .st-toggle-thumb { left: 2px; }
    .st-api-info { display: flex; flex-direction: column; gap: 14px; }
    .st-api-status { display: flex; align-items: center; gap: 8px; }
    .st-api-dot { width: 8px; height: 8px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 8px #22c55e; animation: pulse 2s infinite; flex-shrink: 0; display: inline-block; }
    @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.5; } }
    .st-api-active { font-size: 13px; font-weight: 600; color: #22c55e; }
    .st-api-desc { font-size: 13px; color: #666; line-height: 1.6; }
    .st-api-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .st-api-card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 14px; transition: all 0.2s; }
    .st-api-card.active { border-color: rgba(34,197,94,0.25); background: rgba(34,197,94,0.04); }
    .st-api-card-name { font-size: 13px; font-weight: 600; color: #ddd; margin-bottom: 4px; display: flex; align-items: center; gap: 4px; }
    .st-api-card-desc { font-size: 11px; color: #555; }
    @media (max-width: 900px) { .st-grid { grid-template-columns: 1fr 1fr; } .st-api-cards { grid-template-columns: 1fr; } }
    @media (max-width: 600px) { .st-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="st-root">
    <div class="st-header">
        <div>
            <h1 class="st-title">Settings</h1>
            <p class="st-sub">Configure your travel agency platform</p>
        </div>
        <button type="submit" form="settingsForm" class="st-save-btn">Save Changes</button>
    </div>

    @if(session('success'))
        <div style="background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #22c55e; border-radius: 8px; padding: 12px 16px; font-size: 13px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/admin/settings" id="settingsForm">
        @csrf

        <!-- Hidden inputs for custom toggles & api selection -->
        <input type="hidden" name="bookingNotifications" id="inBookingNotifications" value="{{ ($settings['bookingNotifications'] ?? false) ? '1' : '0' }}">
        <input type="hidden" name="whatsappIntegration" id="inWhatsappIntegration" value="{{ ($settings['whatsappIntegration'] ?? false) ? '1' : '0' }}">
        <input type="hidden" name="autoConfirm" id="inAutoConfirm" value="{{ ($settings['autoConfirm'] ?? false) ? '1' : '0' }}">
        <input type="hidden" name="requirePhone" id="inRequirePhone" value="{{ ($settings['requirePhone'] ?? false) ? '1' : '0' }}">
        <input type="hidden" name="cityApi" id="inCityApi" value="{{ $settings['cityApi'] ?? 'open_meteo' }}">

        <div class="st-sections">
            <!-- Business Info -->
            <div class="st-section">
                <div class="st-section-head">
                    <div class="st-section-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="16"/><line x1="15" y1="22" x2="15" y2="16"/><line x1="9" y1="16" x2="15" y2="16"/><path d="M8 6h2M8 10h2M14 6h2M14 10h2"/></svg>
                    </div>
                    <div>
                        <h2 class="st-section-title">Business Information</h2>
                        <p class="st-section-sub">Your travel agency details</p>
                    </div>
                </div>
                <div class="st-grid">
                    <div class="st-field">
                        <label class="st-lbl">Business Name</label>
                        <input name="businessName" class="st-input" value="{{ $settings['businessName'] ?? '' }}" required>
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Phone</label>
                        <input name="phone" class="st-input" value="{{ $settings['phone'] ?? '' }}" required>
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Email</label>
                        <input name="email" type="email" class="st-input" value="{{ $settings['email'] ?? '' }}" required>
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">WhatsApp Number</label>
                        <input name="whatsapp" class="st-input" value="{{ $settings['whatsapp'] ?? '' }}" required>
                    </div>
                    <div class="st-field" style="grid-column: span 2;">
                        <label class="st-lbl">Address</label>
                        <input name="address" class="st-input" value="{{ $settings['address'] ?? '' }}" required>
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">GST Number</label>
                        <input name="gstNumber" class="st-input" value="{{ $settings['gstNumber'] ?? '' }}">
                    </div>
            </div>

            <!-- Footer Staff Contacts Info -->
            <div class="st-section">
                <div class="st-section-head">
                    <div class="st-section-icon" style="background:rgba(255,0,0,0.08);border:1px solid rgba(255,0,0,0.2);color:#ff0000">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <h2 class="st-section-title">Footer Staff Contacts</h2>
                        <p class="st-section-sub">Manage staff contact details shown in the website footer</p>
                    </div>
                </div>
                <div class="st-grid">
                    <!-- Staff 1 -->
                    <div class="st-field">
                        <label class="st-lbl">Staff 1 Name</label>
                        <input name="staff1_name" class="st-input" value="{{ $settings['staff1_name'] ?? 'Nisha Chouhan' }}">
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Staff 1 Phone</label>
                        <input name="staff1_phone" class="st-input" value="{{ $settings['staff1_phone'] ?? '+91 93409 94628' }}">
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Staff 1 Email</label>
                        <input name="staff1_email" type="email" class="st-input" value="{{ $settings['staff1_email'] ?? 'shivalaytravels@gmail.com' }}">
                    </div>
                    
                    <!-- Staff 2 -->
                    <div class="st-field">
                        <label class="st-lbl">Staff 2 Name</label>
                        <input name="staff2_name" class="st-input" value="{{ $settings['staff2_name'] ?? 'Manisha' }}">
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Staff 2 Phone</label>
                        <input name="staff2_phone" class="st-input" value="{{ $settings['staff2_phone'] ?? '+91 62618 53598' }}">
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Staff 2 Email</label>
                        <input name="staff2_email" type="email" class="st-input" value="{{ $settings['staff2_email'] ?? 'shivalaytravels385@gmail.com' }}">
                    </div>
                </div>
            </div>

            <!-- Localization -->
            <div class="st-section">
                <div class="st-section-head">
                    <div class="st-section-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                    </div>
                    <div>
                        <h2 class="st-section-title">Localization</h2>
                        <p class="st-section-sub">Regional preferences</p>
                    </div>
                </div>
                <div class="st-grid">
                    <div class="st-field">
                        <label class="st-lbl">Currency</label>
                        <select name="currency" class="st-select">
                            <option value="INR" {{ ($settings['currency'] ?? 'INR') === 'INR' ? 'selected' : '' }}>INR — Indian Rupee ₹</option>
                            <option value="USD" {{ ($settings['currency'] ?? '') === 'USD' ? 'selected' : '' }}>USD — US Dollar $</option>
                            <option value="EUR" {{ ($settings['currency'] ?? '') === 'EUR' ? 'selected' : '' }}>EUR — Euro €</option>
                        </select>
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Timezone</label>
                        <select name="timezone" class="st-select">
                            <option value="Asia/Kolkata" {{ ($settings['timezone'] ?? 'Asia/Kolkata') === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST UTC+5:30)</option>
                            <option value="UTC" {{ ($settings['timezone'] ?? '') === 'UTC' ? 'selected' : '' }}>UTC</option>
                            <option value="America/New_York" {{ ($settings['timezone'] ?? '') === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                        </select>
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Default Passengers</label>
                        <select name="defaultPassengers" class="st-select">
                            @foreach(['1','2','3','4','5'] as $n)
                                <option value="{{ $n }}" {{ strval($settings['defaultPassengers'] ?? '1') === $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="st-field">
                        <label class="st-lbl">Default Class</label>
                        <select name="defaultClass" class="st-select">
                            @foreach(['Economy', 'Business', 'First Class', 'AC 3 Tier', 'AC 2 Tier', 'AC Sleeper'] as $c)
                                <option value="{{ $c }}" {{ ($settings['defaultClass'] ?? 'Economy') === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Integrations -->
            <div class="st-section">
                <div class="st-section-head">
                    <div class="st-section-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    </div>
                    <div>
                        <h2 class="st-section-title">Features & Integrations</h2>
                        <p class="st-section-sub">Toggle platform capabilities</p>
                    </div>
                </div>
                <div class="st-toggles">
                    @foreach([
                        ['key' => 'bookingNotifications', 'label' => 'Booking Notifications', 'desc' => 'Receive alerts for new and updated bookings'],
                        ['key' => 'whatsappIntegration', 'label' => 'WhatsApp Integration', 'desc' => 'Send booking details via WhatsApp'],
                        ['key' => 'autoConfirm', 'label' => 'Auto-Confirm Bookings', 'desc' => 'Automatically confirm new booking requests'],
                        ['key' => 'requirePhone', 'label' => 'Require Phone Number', 'desc' => 'Make phone number mandatory in booking form']
                    ] as $t)
                        @php
                        $val = ($settings[$t['key']] ?? false);
                        @endphp
                        <div class="st-toggle-item">
                            <div>
                                <div class="st-toggle-label">{{ $t['label'] }}</div>
                                <div class="st-toggle-desc">{{ $t['desc'] }}</div>
                            </div>
                            <button
                                type="button"
                                id="btn{{ ucfirst($t['key']) }}"
                                class="st-toggle-btn {{ $val ? 'on' : 'off' }}"
                                onclick="toggleField('{{ $t['key'] }}')"
                            >
                                <div class="st-toggle-thumb"></div>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- City API -->
            <div class="st-section">
                <div class="st-section-head">
                    <div class="st-section-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                    </div>
                    <div>
                        <h2 class="st-section-title">City Autocomplete API</h2>
                        <p class="st-section-sub">Configuration for city search</p>
                    </div>
                </div>
                <div class="st-api-info">
                    <div class="st-api-status">
                        <span class="st-api-dot"></span>
                        <span class="st-api-active" id="apiActiveStatus">
                            @if(($settings['cityApi'] ?? 'open_meteo') === 'open_meteo')
                                Active — Open-Meteo Geocoding API
                            @elseif(($settings['cityApi'] ?? '') === 'geodb')
                                Active — GeoDB Cities API
                            @else
                                Active — Local Database
                            @endif
                        </span>
                    </div>
                    <p class="st-api-desc" id="apiActiveDesc">
                        @if(($settings['cityApi'] ?? 'open_meteo') === 'open_meteo')
                            Using Open-Meteo Geocoding API (completely free, no API key required). Supports 3M+ cities worldwide with India-first filtering. Fallback to local database of 30 curated Indian cities.
                        @elseif(($settings['cityApi'] ?? '') === 'geodb')
                            Using GeoDB Cities API on RapidAPI (requires API key). Highly accurate geolocation details.
                        @else
                            Using built-in local database of 30 curated Indian cities. Safe, fast, and does not require external network requests.
                        @endif
                    </p>
                    <div class="st-api-cards">
                        @php
                        $activeApi = $settings['cityApi'] ?? 'open_meteo';
                        @endphp
                        <div 
                            id="card-open_meteo"
                            class="st-api-card {{ $activeApi === 'open_meteo' ? 'active' : '' }}"
                            onclick="selectApi('open_meteo')"
                            style="cursor: pointer;"
                        >
                            <div class="st-api-card-name">
                                <span class="st-api-check">{{ $activeApi === 'open_meteo' ? '✓ ' : '' }}</span><span>Open-Meteo Geocoding</span>
                            </div>
                            <div class="st-api-card-desc">Free, no key needed. geocoding-api.open-meteo.com</div>
                        </div>
                        <div 
                            id="card-geodb"
                            class="st-api-card {{ $activeApi === 'geodb' ? 'active' : '' }}"
                            onclick="selectApi('geodb')"
                            style="cursor: pointer;"
                        >
                            <div class="st-api-card-name">
                                <span class="st-api-check">{{ $activeApi === 'geodb' ? '✓ ' : '' }}</span><span>GeoDB Cities</span>
                            </div>
                            <div class="st-api-card-desc">RapidAPI — requires API key</div>
                        </div>
                        <div 
                            id="card-local"
                            class="st-api-card {{ $activeApi === 'local' ? 'active' : '' }}"
                            onclick="selectApi('local')"
                            style="cursor: pointer;"
                        >
                            <div class="st-api-card-name">
                                <span class="st-api-check">{{ $activeApi === 'local' ? '✓ ' : '' }}</span><span>Local Database</span>
                            </div>
                            <div class="st-api-card-desc">30 curated Indian cities — always available</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleField(key) {
        const inputId = 'in' + key.charAt(0).toUpperCase() + key.slice(1);
        const btnId = 'btn' + key.charAt(0).toUpperCase() + key.slice(1);
        const input = document.getElementById(inputId);
        const btn = document.getElementById(btnId);

        if (input.value === '1') {
            input.value = '0';
            btn.classList.remove('on');
            btn.classList.add('off');
        } else {
            input.value = '1';
            btn.classList.remove('off');
            btn.classList.add('on');
        }
    }

    function selectApi(apiName) {
        document.getElementById('inCityApi').value = apiName;
        
        document.querySelectorAll('.st-api-card').forEach(card => {
            card.classList.remove('active');
            const checkEl = card.querySelector('.st-api-check');
            if (checkEl) checkEl.textContent = '';
        });

        const activeCard = document.getElementById('card-' + apiName);
        if (activeCard) {
            activeCard.classList.add('active');
            const activeCheck = activeCard.querySelector('.st-api-check');
            if (activeCheck) activeCheck.textContent = '✓ ';
        }

        let apiText = '';
        let apiDesc = '';
        if (apiName === 'open_meteo') {
            apiText = 'Active — Open-Meteo Geocoding API';
            apiDesc = 'Using Open-Meteo Geocoding API (completely free, no API key required). Supports 3M+ cities worldwide with India-first filtering. Fallback to local database of 30 curated Indian cities.';
        } else if (apiName === 'geodb') {
            apiText = 'Active — GeoDB Cities API';
            apiDesc = 'Using GeoDB Cities API on RapidAPI (requires API key). Highly accurate geolocation details.';
        } else if (apiName === 'local') {
            apiText = 'Active — Local Database';
            apiDesc = 'Using built-in local database of 30 curated Indian cities. Safe, fast, and does not require external network requests.';
        }
        document.getElementById('apiActiveStatus').innerText = apiText;
        document.getElementById('apiActiveDesc').innerText = apiDesc;
    }
</script>
@endsection
