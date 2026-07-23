@extends('layouts.admin')

@section('title', 'Cities & Routes')

@section('page_title', 'Cities & Routes')
@section('page_subtitle')
    {{ count($cities) }} cities in local database
@endsection

@section('content')
<div class="ct-root">
    <div class="ct-header">
        <div>
            <h1 class="ct-title" style="display: none;">Cities & Routes</h1>
        </div>
        @if(session('admin_role') === 'super_admin' || session('admin_role') === 'manager')
            <button class="ct-add-btn" id="toggleAddBtn">+ Add City</button>
        @endif
    </div>

    <!-- Live API Search -->
    <div class="city-search-wrap">
        <p class="city-search-label">🔍 Live City Search (Open-Meteo Geocoding API)</p>
        <div class="city-search-input-wrap">
            <input
                id="citySearchInput"
                class="city-search-input"
                placeholder="Type a city name to search (e.g. Varanasi, Jaipur…)"
                autocomplete="off"
            />
            <span class="city-search-spinner" id="citySearchSpinner" style="display: none;"></span>
        </div>
        <div class="city-search-results" id="citySearchResults" style="display: none;"></div>
    </div>

    <!-- Add Form -->
    @if(session('admin_role') === 'super_admin' || session('admin_role') === 'manager')
        <div class="ct-add-form" id="addCityForm" style="display: none;">
            <h3 class="ct-form-title">Add New City</h3>
            <form action="/admin/cities" method="POST">
                @csrf
                <div class="ct-form-grid">
                    <div>
                        <label class="ct-lbl">City Name *</label>
                        <input class="ct-input" name="name" placeholder="Indore" required />
                    </div>
                    <div>
                        <label class="ct-lbl">Code *</label>
                        <input class="ct-input" name="code" placeholder="IDR" maxlength="5" style="text-transform: uppercase;" required />
                    </div>
                    <div>
                        <label class="ct-lbl">State</label>
                        <input class="ct-input" name="state" placeholder="Madhya Pradesh" />
                    </div>
                    <div>
                        <label class="ct-lbl">Type</label>
                        <select class="ct-select" name="type">
                            <option value="airport">Airport</option>
                            <option value="railway">Railway</option>
                            <option value="bus_stand">Bus Stand</option>
                            <option value="port">Port</option>
                        </select>
                    </div>
                </div>
                <div class="ct-form-footer">
                    <label class="ct-checkbox-label">
                        <input type="checkbox" name="isPopular" value="1" />
                        Mark as Popular
                    </label>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="ct-cancel-btn" id="cancelAddBtn">Cancel</button>
                        <button type="submit" class="ct-save-btn">Save City</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- Filters -->
    <div class="ct-filters">
        <input class="ct-search" id="listSearch" placeholder="Search city, code, state…" />
        <select class="ct-select-sm" id="typeFilter">
            <option value="all">All Types</option>
            <option value="airport">Airport</option>
            <option value="railway">Railway</option>
            <option value="bus_stand">Bus Stand</option>
            <option value="port">Port</option>
        </select>
        <button class="ct-popular-btn" id="popularFilterBtn">
            ★ Popular Only
        </button>
        <span class="ct-count" id="filteredCount">{{ count($cities) }} cities</span>
    </div>

    <!-- Table -->
    <div class="ct-table-wrap">
        <table class="ct-table" id="citiesTable">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>City Name</th>
                    <th>State</th>
                    <th>Type</th>
                    <th>Popular</th>
                    @if(session('admin_role') === 'super_admin' || session('admin_role') === 'manager')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($cities as $c)
                    <tr class="city-row" data-name="{{ strtolower($c['name']) }}" data-code="{{ strtolower($c['code']) }}" data-state="{{ strtolower($c['state'] ?? '') }}" data-type="{{ $c['type'] }}" data-popular="{{ ($c['isPopular'] ?? false) ? '1' : '0' }}">
                        <td><span class="ct-code">{{ $c['code'] }}</span></td>
                        <td class="ct-name">{{ $c['name'] }}</td>
                        <td class="ct-state">{{ $c['state'] ?? '—' }}</td>
                        <td>
                            @php
                            $colors = ['airport' => '#3b82f6', 'railway' => '#f59e0b', 'bus_stand' => '#22c55e', 'port' => '#8b5cf6'];
                            $color = $colors[$c['type']] ?? '#3b82f6';
                            @endphp
                            <span class="ct-type-pill" style="color: {{ $color }}; background: {{ $color }}15; border-color: {{ $color }}30">
                                {{ str_replace('_', ' ', $c['type']) }}
                            </span>
                        </td>
                        <td>
                            @if(session('admin_role') === 'super_admin' || session('admin_role') === 'manager')
                                <form action="/admin/cities/popular/{{ $c['id'] }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="ct-star-btn {{ ($c['isPopular'] ?? false) ? 'active' : '' }}">
                                        {{ ($c['isPopular'] ?? false) ? '★' : '☆' }}
                                    </button>
                                </form>
                            @else
                                <span class="ct-star-btn {{ ($c['isPopular'] ?? false) ? 'active' : '' }}">
                                    {{ ($c['isPopular'] ?? false) ? '★' : '☆' }}
                                </span>
                            @endif
                        </td>
                        @if(session('admin_role') === 'super_admin' || session('admin_role') === 'manager')
                            <td>
                                @if(session('admin_role') === 'super_admin')
                                    <a href="/admin/cities/delete/{{ $c['id'] }}" class="ct-del-btn" onclick="return confirm('Delete this city?');" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">✕</a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="ct-empty" id="noCitiesMsg" style="display: none;">No cities match your filters.</div>
    </div>
</div>

<style>
    .ct-root { display: flex; flex-direction: column; gap: 20px; }
    .ct-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px; }
    .ct-title { font-size: 22px; font-weight: 700; color: #fff; }
    .ct-add-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'DM Sans',sans-serif; transition: background 0.2s; }
    .ct-add-btn:hover { background: #cc0000; }

    .city-search-wrap { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 20px; }
    .city-search-label { font-size: 12px; font-weight: 600; color: #666; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
    .city-search-input-wrap { position: relative; }
    .city-search-input { width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 14px; outline: none; font-family: 'DM Sans',sans-serif; transition: border-color 0.2s; }
    .city-search-input:focus { border-color: rgba(255,0,0,0.5); }
    .city-search-input::placeholder { color: #444; }
    .city-search-spinner { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; border: 2px solid rgba(255,0,0,0.2); border-top-color: #ff0000; border-radius: 50%; animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: translateY(-50%) rotate(360deg); } }
    .city-search-results { margin-top: 12px; display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 8px; }
    .city-result-item { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 8px; padding: 10px 14px; cursor: pointer; transition: all 0.2s; }
    .city-result-item:hover { background: rgba(255,0,0,0.08); border-color: rgba(255,0,0,0.2); }
    .city-result-name { font-size: 13px; font-weight: 600; color: #ddd; }
    .city-result-state { font-size: 11px; color: #555; margin-top: 2px; }
    .city-api-badge { grid-column: 1/-1; font-size: 10px; color: #444; margin-top: 4px; text-align: right; }

    .ct-add-form { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,0,0,0.15); border-radius: 14px; padding: 24px; }
    .ct-form-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 16px; }
    .ct-form-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 16px; }
    .ct-lbl { display: block; font-size: 11px; color: #555; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .ct-input { width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 9px 12px; color: #fff; font-size: 13px; outline: none; font-family: 'DM Sans',sans-serif; }
    .ct-select { width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 9px 12px; color: #aaa; font-size: 13px; outline: none; cursor: pointer; font-family: 'DM Sans',sans-serif; }
    .ct-form-footer { display: flex; align-items: center; justify-content: space-between; }
    .ct-checkbox-label { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #aaa; cursor: pointer; }
    .ct-cancel-btn { background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #666; border-radius: 8px; padding: 8px 16px; font-size: 13px; cursor: pointer; font-family: 'DM Sans',sans-serif; }
    .ct-save-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'DM Sans',sans-serif; }

    .ct-filters { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .ct-search { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 8px 14px; color: #fff; font-size: 13px; outline: none; width: 220px; font-family: 'DM Sans',sans-serif; }
    .ct-search::placeholder { color: #444; }
    .ct-search:focus { border-color: rgba(255,0,0,0.3); }
    .ct-select-sm { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 8px 14px; color: #aaa; font-size: 13px; outline: none; cursor: pointer; font-family: 'DM Sans',sans-serif; }
    .ct-popular-btn { background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #666; border-radius: 8px; padding: 8px 14px; font-size: 13px; cursor: pointer; font-family: 'DM Sans',sans-serif; transition: all 0.2s; }
    .ct-popular-btn.active { background: rgba(245,158,11,0.1); border-color: rgba(245,158,11,0.3); color: #f59e0b; }
    .ct-count { font-size: 12px; color: #555; margin-left: auto; }

    .ct-table-wrap { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; overflow-x: auto; }
    .ct-table { width: 100%; border-collapse: collapse; }
    .ct-table th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #555; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06); }
    .ct-table td { padding: 13px 16px; font-size: 13px; color: #bbb; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .ct-table tr:last-child td { border-bottom: none; }
    .ct-table tr:hover td { background: rgba(255,255,255,0.02); }
    .ct-code { font-family: monospace; font-weight: 700; color: #ff0000; background: rgba(255,0,0,0.08); padding: 2px 8px; border-radius: 4px; }
    .ct-name { font-weight: 600; color: #ddd; }
    .ct-state { color: #777; font-size: 12px; }
    .ct-type-pill { padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; border: 1px solid; text-transform: capitalize; }
    .ct-star-btn { background: transparent; border: none; font-size: 18px; cursor: pointer; color: #444; transition: color 0.2s; }
    .ct-star-btn.active { color: #f59e0b; }
    .ct-del-btn { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.15); color: #ef4444; border-radius: 6px; width: 28px; height: 28px; cursor: pointer; font-size: 13px; }
    .ct-empty { text-align: center; padding: 48px; color: #444; font-size: 13px; }
    @media (max-width: 768px) {
        .ct-form-grid { grid-template-columns: 1fr 1fr; }
        .ct-count { margin-left: 0; width: 100%; text-align: right; }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Collapsible Add Form
    const toggleAddBtn = document.getElementById('toggleAddBtn');
    const cancelAddBtn = document.getElementById('cancelAddBtn');
    const addCityForm = document.getElementById('addCityForm');

    if (toggleAddBtn && addCityForm) {
        toggleAddBtn.addEventListener('click', function() {
            addCityForm.style.display = addCityForm.style.display === 'none' ? 'block' : 'none';
        });
    }
    if (cancelAddBtn && addCityForm) {
        cancelAddBtn.addEventListener('click', function() {
            addCityForm.style.display = 'none';
        });
    }

    // Live geocoding search using Open-Meteo API
    const citySearchInput = document.getElementById('citySearchInput');
    const citySearchSpinner = document.getElementById('citySearchSpinner');
    const citySearchResults = document.getElementById('citySearchResults');
    let searchTimeout = null;

    if (citySearchInput) {
        citySearchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = citySearchInput.value.trim();
            if (query.length < 2) {
                citySearchResults.style.display = 'none';
                citySearchResults.innerHTML = '';
                return;
            }

            citySearchSpinner.style.display = 'block';
            searchTimeout = setTimeout(function() {
                fetch(`https://geocoding-api.open-meteo.com/v1/search?name=${encodeURIComponent(query)}&count=6&language=en&format=json`)
                    .then(res => res.json())
                    .then(data => {
                        citySearchSpinner.style.display = 'none';
                        citySearchResults.style.display = 'grid';
                        
                        if (data.results && data.results.length > 0) {
                            let html = '';
                            data.results.forEach(r => {
                                const state = r.admin1 || '';
                                const country = r.country || '';
                                const displayState = state + (state && country ? ', ' : '') + country;
                                html += `
                                    <div class="city-result-item" data-name="${r.name}" data-state="${state}">
                                        <div class="city-result-name">${r.name}</div>
                                        <div class="city-result-state">${displayState}</div>
                                    </div>
                                `;
                            });
                            html += `<p class="city-api-badge">Results from: Open-Meteo Geocoding API</p>`;
                            citySearchResults.innerHTML = html;

                            // Click handler to prefill add form
                            document.querySelectorAll('.city-result-item').forEach(item => {
                                item.addEventListener('click', function() {
                                    const name = this.getAttribute('data-name');
                                    const state = this.getAttribute('data-state');
                                    
                                    if (addCityForm) {
                                        addCityForm.style.display = 'block';
                                        addCityForm.querySelector('input[name="name"]').value = name;
                                        addCityForm.querySelector('input[name="code"]').value = name.substring(0, 3).toUpperCase();
                                        addCityForm.querySelector('input[name="state"]').value = state;
                                        addCityForm.querySelector('input[name="name"]').focus();
                                    }
                                });
                            });
                        } else {
                            citySearchResults.innerHTML = `<div style="grid-column: 1/-1; font-size: 13px; color: #444; padding: 8px;">No cities found. Try another query.</div>`;
                        }
                    })
                    .catch(err => {
                        citySearchSpinner.style.display = 'none';
                        console.error('Error fetching geocoding data:', err);
                    });
            }, 400);
        });
    }

    // Client-side table filtering
    const listSearch = document.getElementById('listSearch');
    const typeFilter = document.getElementById('typeFilter');
    const popularFilterBtn = document.getElementById('popularFilterBtn');
    let popularOnly = false;

    if (popularFilterBtn) {
        popularFilterBtn.addEventListener('click', function() {
            popularOnly = !popularOnly;
            popularFilterBtn.classList.toggle('active', popularOnly);
            filterTable();
        });
    }

    if (listSearch) listSearch.addEventListener('input', filterTable);
    if (typeFilter) typeFilter.addEventListener('change', filterTable);

    function filterTable() {
        const query = listSearch ? listSearch.value.toLowerCase().trim() : '';
        const selectedType = typeFilter ? typeFilter.value : 'all';
        const rows = document.querySelectorAll('.city-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const code = row.getAttribute('data-code');
            const state = row.getAttribute('data-state');
            const type = row.getAttribute('data-type');
            const isPopular = row.getAttribute('data-popular') === '1';

            const matchesSearch = !query || name.includes(query) || code.includes(query) || state.includes(query);
            const matchesType = selectedType === 'all' || type === selectedType;
            const matchesPopular = !popularOnly || isPopular;

            if (matchesSearch && matchesType && matchesPopular) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('filteredCount').innerText = `${visibleCount} cities`;
        document.getElementById('noCitiesMsg').style.display = visibleCount === 0 ? 'block' : 'none';
    }
});
</script>
@endsection
