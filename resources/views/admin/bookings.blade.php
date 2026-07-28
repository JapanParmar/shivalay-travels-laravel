@extends('layouts.admin')

@section('title', 'Manage Bookings')

@php
$role = session('admin_role', 'viewer');
$canManage = in_array($role, ['super_admin', 'manager', 'agent']);
$canDelete = in_array($role, ['super_admin', 'manager']);
@endphp

@section('styles')
<style>
    .bk-root { display: flex; flex-direction: column; gap: 20px; }
    .bk-header { display: flex; align-items: center; justify-content: space-between; }
    .bk-title { font-size: 22px; font-weight: 700; color: #fff; margin: 0; }
    .bk-sub { font-size: 12px; color: #555; margin-top: 2px; }
    .bk-add-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans',sans-serif; text-decoration: none; }
    .bk-add-btn:hover { background: #cc0000; transform: translateY(-1px); }
    .bk-filters { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .bk-status-tabs { display: flex; gap: 4px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 4px; }
    .bk-tab { display: flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 6px; background: transparent; border: none; color: #666; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans',sans-serif; }
    .bk-tab.active { background: rgba(255,0,0,0.1); color: #ff0000; }
    .bk-tab-count { background: rgba(255,255,255,0.08); border-radius: 10px; padding: 1px 6px; font-size: 10px; color: #aaa; }
    .bk-tab.active .bk-tab-count { background: rgba(255,0,0,0.2); color: #ff0000; }
    .bk-right-filters { display: flex; gap: 10px; }
    .bk-search { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 8px 14px; color: #fff; font-size: 13px; outline: none; width: 220px; font-family: 'DM Sans',sans-serif; }
    .bk-search::placeholder { color: #444; }
    .bk-search:focus { border-color: rgba(255,0,0,0.4); }
    .bk-select { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 8px 14px; color: #aaa; font-size: 13px; outline: none; cursor: pointer; font-family: 'DM Sans',sans-serif; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 28px; }
    .bk-select option, .bk-page-select option { background: #1a1a1a; color: #fff; padding: 10px 14px; font-family: 'DM Sans',sans-serif; font-size: 13px; }
    .bk-table-wrap { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; overflow-x: auto; }
    .bk-table { width: 100%; border-collapse: collapse; }
    .bk-table th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #555; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06); white-space: nowrap; }
    .bk-table td { padding: 14px 16px; font-size: 13px; color: #bbb; border-bottom: 1px solid rgba(255,255,255,0.04); white-space: nowrap; vertical-align: middle; }
    .bk-table tr:last-child td { border-bottom: none; }
    .bk-table tr:hover td { background: rgba(255,255,255,0.02); }
    .bk-header-sortable { color: #555; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; user-select: none; }
    .bk-header-sortable:hover { color: #fff; }
    .bk-id { font-family: monospace; color: #ff0000; background: rgba(255,0,0,0.08); padding: 2px 8px; border-radius: 4px; font-size: 11px; }
    .bk-customer { display: flex; align-items: center; gap: 10px; }
    .bk-avatar { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.02); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0; }
    .bk-name { font-size: 13px; font-weight: 600; color: #ddd; }
    .bk-phone { font-size: 11px; color: #555; }
    .bk-route { color: #888; font-size: 13px; font-weight: 500; }
    .bk-type { font-size: 12px; display: inline-flex; align-items: center; }
    .bk-date { color: #777; }
    .bk-amount { font-weight: 600; }
    .bk-status { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; border: 1px solid; text-transform: capitalize; }
    .bk-edit-btn { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); color: #aaa; border-radius: 6px; padding: 5px 12px; font-size: 12px; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans',sans-serif; }
    .bk-edit-btn:hover { border-color: rgba(255,0,0,0.4); color: #ff0000; background: rgba(255,0,0,0.05); }
    .bk-empty { text-align: center; padding: 48px; color: #444; font-size: 13px; }
    
    /* Pagination Controls */
    .bk-pagination { display: flex; align-items: center; justify-content: space-between; margin-top: 16px; padding: 12px 16px; background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; }
    .bk-pagination-left { font-size: 12px; color: #555; }
    .bk-pagination-right { display: flex; align-items: center; gap: 8px; }
    .bk-page-btn { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: #ccc; border-radius: 6px; padding: 5px 12px; font-size: 12px; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans',sans-serif; }
    .bk-page-btn:hover:not(:disabled) { border-color: rgba(255,0,0,0.4); color: #ff0000; background: rgba(255,0,0,0.05); }
    .bk-page-btn:disabled { opacity: 0.4; cursor: not-allowed; }
    .bk-page-select { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 6px; padding: 5px 28px 5px 10px; color: #aaa; font-size: 12px; cursor: pointer; font-family: 'DM Sans',sans-serif; outline: none; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 8px center; }

    /* Modal Editor Form Styles */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.85); display: none; justify-content: center; align-items: flex-start; z-index: 999; padding: 40px 16px; backdrop-filter: blur(4px); overflow-y: auto; }
    .modal-box { background: #0c0c0c; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; width: 100%; max-width: 580px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); display: flex; flex-direction: column; position: relative; margin: 0 auto 40px; }
    .modal-head { display: flex; align-items: center; justify-content: space-between; padding: 18px 24px; border-bottom: 1px solid rgba(255,255,255,0.07); background: rgba(255,255,255,0.01); flex-shrink: 0; }
    .modal-title { font-size: 15px; font-weight: 700; color: #fff; margin: 0; }
    .modal-close { background: rgba(255,255,255,0.06); border: none; color: #aaa; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; font-size: 13px; display: flex; align-items: center; justify-content: center; }
    .modal-close:hover { color: #fff; background: rgba(255,255,255,0.1); }
    .modal-body { padding: 24px; }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-lbl { font-size: 11px; color: #555; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-input, .form-select, .form-textarea { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 8px 12px; color: #fff; font-size: 13px; outline: none; font-family: 'DM Sans',sans-serif; width: 100%; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: rgba(255,0,0,0.4); background: rgba(255,255,255,0.05); }
    .form-select option { background: #1a1a1a; color: #fff; padding: 10px 14px; font-family: 'DM Sans',sans-serif; }
    .highlight-price { border-color: rgba(34,197,94,0.3); color: #22c55e; font-weight: bold; }
    .highlight-price:focus { border-color: #22c55e; }
    .form-save-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans',sans-serif; }
    .form-save-btn:hover { background: #cc0000; }
    .form-cancel-btn { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #ccc; border-radius: 8px; padding: 10px 20px; font-size: 13px; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans',sans-serif; }
    .form-cancel-btn:hover { background: rgba(255,255,255,0.1); }
    .form-whatsapp-btn { display: inline-flex; align-items: center; gap: 6px; background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #22c55e; border-radius: 8px; padding: 8px 14px; font-size: 12px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans',sans-serif; }
    .form-whatsapp-btn:hover { background: rgba(34,197,94,0.2); }
    .modal-delete-btn-inline { background: transparent; border: none; color: #ef4444; font-size: 12px; cursor: pointer; text-decoration: underline; padding: 0; }
    .modal-delete-btn-inline:hover { color: #ff6b6b; }
    @media (max-width: 580px) {
        .modal-overlay { padding: 20px 10px; }
        .modal-box { margin-bottom: 20px; }
        .modal-body { padding: 16px; }
        .form-grid { grid-template-columns: 1fr !important; }
    }
</style>
@endsection

@section('content')
<div class="bk-root">
    <div class="bk-header">
        <div>
            <h1 class="bk-title">Bookings Manager</h1>
            <p class="bk-sub" id="entriesSummary">0 of 0 total entries</p>
        </div>
        @if($canManage)
            <button class="bk-add-btn" onclick="openCreate()">+ Add Custom Booking</button>
        @endif
    </div>

    <!-- Filter bar -->
    <div class="bk-filters">
        <div class="bk-status-tabs">
            <button class="bk-tab active" onclick="setFilter('all')">
                All
                <span class="bk-tab-count" id="count-all">0</span>
            </button>
            <button class="bk-tab" onclick="setFilter('pending')">
                Pending
                <span class="bk-tab-count" id="count-pending">0</span>
            </button>
            <button class="bk-tab" onclick="setFilter('confirmed')">
                Confirmed
                <span class="bk-tab-count" id="count-confirmed">0</span>
            </button>
            <button class="bk-tab" onclick="setFilter('completed')">
                Completed
                <span class="bk-tab-count" id="count-completed">0</span>
            </button>
            <button class="bk-tab" onclick="setFilter('cancelled')">
                Cancelled
                <span class="bk-tab-count" id="count-cancelled">0</span>
            </button>
        </div>
        <div class="bk-right-filters">
            <input 
                id="searchFilter"
                class="bk-search" 
                placeholder="Search name, phone, city..." 
                oninput="handleSearch(this.value)"
            />
            <select id="typeFilter" class="bk-select" onchange="handleTypeFilter(this.value)">
                <option value="all">All Types</option>
                <option value="flight">Flight</option>
                <option value="train">Train</option>
                <option value="bus">Bus</option>
                <option value="cruise">Cruise</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bk-table-wrap">
        <table class="bk-table">
            <thead>
                <tr>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('id')">
                            ID <span id="sort-icon-id"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('customerName')">
                            Customer Details <span id="sort-icon-customerName"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('route')">
                            Route / Journey <span id="sort-icon-route"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('travelType')">
                            Type <span id="sort-icon-travelType"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('date')">
                            Travel Date <span id="sort-icon-date"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('passengers')">
                            Pax <span id="sort-icon-passengers"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('amount')">
                            Price (₹) <span id="sort-icon-amount"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('status')">
                            Status <span id="sort-icon-status"></span>
                        </span>
                    </th>
                    @if($canManage)
                        <th style="text-align: right;">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody id="bookingsTableBody">
                <!-- Javascript will populate this dynamic content -->
            </tbody>
        </table>
        <div class="bk-empty" id="noBookingsMsg" style="display: none;">No bookings found matching filters.</div>
    </div>

    <!-- Pagination controls -->
    <div class="bk-pagination">
        <div class="bk-pagination-left" id="paginationSummary">
            Showing 0 of 0 records (Page 1 of 1)
        </div>
        <div class="bk-pagination-right">
            <button class="bk-page-btn" id="prevPageBtn" onclick="previousPage()">Previous</button>
            <button class="bk-page-btn" id="nextPageBtn" onclick="nextPage()">Next</button>
            <select class="bk-page-select" id="pageSizeSelect" onchange="setPageSize(this.value)">
                <option value="5">Show 5</option>
                <option value="10" selected>Show 10</option>
                <option value="20">Show 20</option>
                <option value="50">Show 50</option>
            </select>
        </div>
    </div>
</div>

<!-- Modal Editor -->
<div id="bookingModal" class="modal-overlay" onclick="closeModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <form id="bookingForm" method="POST" action="/admin/bookings">
            @csrf
            <div class="modal-head">
                <h3 class="modal-title" id="modalTitle">Create Custom Booking</h3>
                <button type="button" class="modal-close" onclick="closeModal()">✕</button>
            </div>
            
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-lbl">Customer Name</label>
                        <input type="text" name="customerName" id="inCustomerName" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">WhatsApp / Phone</label>
                        <input type="text" name="customerPhone" id="inCustomerPhone" class="form-input" required />
                    </div>

                    <div class="form-group">
                        <label class="form-lbl">From City / Station</label>
                        <input type="text" name="fromCity" id="inFromCity" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">To City / Destination</label>
                        <input type="text" name="toCity" id="inToCity" class="form-input" required />
                    </div>

                    <div class="form-group">
                        <label class="form-lbl">Travel Date</label>
                        <input type="date" name="date" id="inDate" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">Transit Type</label>
                        <select name="travelType" id="inTravelType" class="form-select">
                            <option value="flight">FLIGHT</option>
                            <option value="train">TRAIN</option>
                            <option value="bus">BUS</option>
                            <option value="cruise">CRUISE</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-lbl">Class Preference</label>
                        <input type="text" name="classType" id="inClassType" class="form-input" placeholder="e.g. Economy, AC Tier 3" />
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">No. of Passengers</label>
                        <input type="number" name="passengers" id="inPassengers" class="form-input" min="1" required />
                    </div>

                    <div class="form-group">
                        <label class="form-lbl">Amount Price (₹)</label>
                        <input type="number" name="amount" id="inAmount" class="form-input highlight-price" min="0" required />
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">Booking Status</label>
                        <select name="status" id="inStatus" class="form-select" style="font-weight: bold;">
                            <option value="pending" style="color: #f59e0b;">PENDING</option>
                            <option value="confirmed" style="color: #22c55e;">CONFIRMED</option>
                            <option value="completed" style="color: #3b82f6;">COMPLETED</option>
                            <option value="cancelled" style="color: #ef4444;">CANCELLED</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 14px;">
                    <label class="form-lbl">Owner Notes / Routing Notes</label>
                    <textarea name="notes" id="inNotes" class="form-textarea" rows="3" placeholder="Enter itinerary details, PNR references, or special requests..."></textarea>
                </div>

                <!-- Submit and Helper triggers -->
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="form-save-btn" id="modalSaveBtn">Create Entry</button>
                    <button type="button" class="form-cancel-btn" onclick="closeModal()">Cancel</button>
                </div>

                <div id="modalFooterActions" style="display: none; justify-content: space-between; align-items: center; marginTop: 24px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px;">
                    <a 
                        id="modalWhatsAppLink"
                        href="#"
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="form-whatsapp-btn"
                    >
                        💬 Contact on WhatsApp
                    </a>
                    
                    @if($canDelete)
                        <button 
                            type="button" 
                            class="modal-delete-btn-inline" 
                            id="modalDeleteBtn"
                        >
                            Delete booking
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initial data from Laravel backend
    const bookings = {!! json_encode($bookings) !!};
    const canManageBookings = {{ $canManage ? 'true' : 'false' }};
    const canDeleteRecords = {{ $canDelete ? 'true' : 'false' }};

    const STATUS_COLORS = {
        confirmed: '#22c55e',
        pending: '#f59e0b',
        cancelled: '#ef4444',
        completed: '#3b82f6'
    };

    // UI state
    let state = {
        filter: 'all',
        typeFilter: 'all',
        search: '',
        sorting: { key: 'createdAt', desc: true },
        pagination: { pageIndex: 0, pageSize: 10 }
    };

    function setFilter(status) {
        state.filter = status;
        state.pagination.pageIndex = 0;
        
        // Update active tab styles
        document.querySelectorAll('.bk-tab').forEach(tab => {
            if (tab.getAttribute('onclick').includes(`'${status}'`)) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });

        render();
    }

    function handleTypeFilter(type) {
        state.typeFilter = type;
        state.pagination.pageIndex = 0;
        render();
    }

    function handleSearch(query) {
        state.search = query;
        state.pagination.pageIndex = 0;
        render();
    }

    function toggleSort(key) {
        if (state.sorting.key === key) {
            state.sorting.desc = !state.sorting.desc;
        } else {
            state.sorting.key = key;
            state.sorting.desc = false;
        }
        render();
    }

    function previousPage() {
        if (state.pagination.pageIndex > 0) {
            state.pagination.pageIndex--;
            render();
        }
    }

    function nextPage() {
        const filtered = getFilteredBookings();
        const pageCount = Math.ceil(filtered.length / state.pagination.pageSize);
        if (state.pagination.pageIndex < pageCount - 1) {
            state.pagination.pageIndex++;
            render();
        }
    }

    function setPageSize(size) {
        state.pagination.pageSize = parseInt(size, 10);
        state.pagination.pageIndex = 0;
        render();
    }

    function getFilteredBookings() {
        return bookings.filter(b => {
            const matchStatus = state.filter === 'all' || b.status === state.filter;
            const matchType = state.typeFilter === 'all' || b.travelType === state.typeFilter;
            const fromCity = b.fromCity || b.from || '';
            const toCity = b.toCity || b.to || '';
            const matchSearch = !state.search || 
                (b.customerName || '').toLowerCase().includes(state.search.toLowerCase()) ||
                (b.id || '').toLowerCase().includes(state.search.toLowerCase()) || 
                fromCity.toLowerCase().includes(state.search.toLowerCase()) || 
                toCity.toLowerCase().includes(state.search.toLowerCase()) ||
                (b.customerPhone || '').toLowerCase().includes(state.search.toLowerCase());
            return matchStatus && matchType && matchSearch;
        });
    }

    function getSortedBookings(filtered) {
        const key = state.sorting.key;
        const desc = state.sorting.desc;

        return [...filtered].sort((a, b) => {
            let valA, valB;
            if (key === 'route') {
                valA = `${a.fromCity || a.from || ''} ${a.toCity || a.to || ''}`.toLowerCase();
                valB = `${b.fromCity || b.from || ''} ${b.toCity || b.to || ''}`.toLowerCase();
            } else if (key === 'customerName') {
                valA = (a.customerName || '').toLowerCase();
                valB = (b.customerName || '').toLowerCase();
            } else if (key === 'amount') {
                valA = Number(a.amount) || 0;
                valB = Number(b.amount) || 0;
            } else if (key === 'passengers') {
                valA = Number(a.passengers) || 0;
                valB = Number(b.passengers) || 0;
            } else {
                valA = (a[key] || '').toLowerCase ? (a[key] || '').toLowerCase() : (a[key] || '');
                valB = (b[key] || '').toLowerCase ? (b[key] || '').toLowerCase() : (b[key] || '');
            }

            if (valA < valB) return desc ? 1 : -1;
            if (valA > valB) return desc ? -1 : 1;
            return 0;
        });
    }

    function render() {
        // Update Counts
        document.getElementById('count-all').innerText = bookings.length;
        document.getElementById('count-pending').innerText = bookings.filter(b => b.status === 'pending').length;
        document.getElementById('count-confirmed').innerText = bookings.filter(b => b.status === 'confirmed').length;
        document.getElementById('count-completed').innerText = bookings.filter(b => b.status === 'completed').length;
        document.getElementById('count-cancelled').innerText = bookings.filter(b => b.status === 'cancelled').length;

        // Sort Icons
        const columns = ['id', 'customerName', 'route', 'travelType', 'date', 'passengers', 'amount', 'status'];
        columns.forEach(col => {
            const iconEl = document.getElementById(`sort-icon-${col}`);
            if (state.sorting.key === col) {
                iconEl.innerText = state.sorting.desc ? ' ↓' : ' ↑';
            } else {
                iconEl.innerText = '';
            }
        });

        const filtered = getFilteredBookings();
        const sorted = getSortedBookings(filtered);

        // Entries Summary
        document.getElementById('entriesSummary').innerText = `${filtered.length} of ${bookings.length} total entries`;

        // Pagination
        const total = filtered.length;
        const pageIndex = state.pagination.pageIndex;
        const pageSize = state.pagination.pageSize;
        const pageCount = Math.ceil(total / pageSize) || 1;

        const startIdx = pageIndex * pageSize;
        const endIdx = Math.min(startIdx + pageSize, total);
        const paginated = sorted.slice(startIdx, endIdx);

        // Update Pagination controls
        document.getElementById('paginationSummary').innerText = `Showing ${paginated.length} of ${total} records (Page ${pageIndex + 1} of ${pageCount})`;
        document.getElementById('prevPageBtn').disabled = (pageIndex === 0);
        document.getElementById('nextPageBtn').disabled = (pageIndex >= pageCount - 1);

        // Render rows
        const tbody = document.getElementById('bookingsTableBody');
        tbody.innerHTML = '';

        if (paginated.length === 0) {
            document.getElementById('noBookingsMsg').style.display = 'block';
            return;
        } else {
            document.getElementById('noBookingsMsg').style.display = 'none';
        }

        paginated.forEach(b => {
            const tr = document.createElement('tr');

            // ID
            const tdId = document.createElement('td');
            tdId.innerHTML = `<span class="bk-id">${b.id}</span>`;
            tr.appendChild(tdId);

            // Customer
            const tdCust = document.createElement('td');
            const initials = b.customerName ? b.customerName[0].toUpperCase() : '?';
            const hasAmount = Number(b.amount) > 0;
            const avatarColor = hasAmount ? '#22c55e' : '#ef4444';
            const avatarBorder = hasAmount ? '#22c55e44' : '#ef444444';

            tdCust.innerHTML = `
                <div class="bk-customer">
                    <div class="bk-avatar" style="border: 1px solid ${avatarBorder}; color: ${avatarColor}">
                        ${initials}
                    </div>
                    <div>
                        <div class="bk-name">${b.customerName || 'Guest Traveller'}</div>
                        <div class="bk-phone">${b.customerPhone || 'No Phone'}</div>
                    </div>
                </div>
            `;
            tr.appendChild(tdCust);

            // Route
            const tdRoute = document.createElement('td');
            tdRoute.innerHTML = `<span class="bk-route">${b.fromCity || b.from || 'Anywhere'} → ${b.toCity || b.to || 'Anywhere'}</span>`;
            tr.appendChild(tdRoute);

            // Type
            const tdType = document.createElement('td');
            const typeIcon = b.travelType === 'flight' 
                ? `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 4px; color: #3b82f6;"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4Z"/></svg>`
                : b.travelType === 'train' 
                    ? `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 4px; color: #a855f7;"><rect x="4" y="3" width="16" height="16" rx="2"/><path d="M4 11h16M12 3v8M8 19l-2 3M16 19l2 3"/></svg>`
                    : b.travelType === 'bus' 
                        ? `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 4px; color: #f59e0b;"><rect x="4" y="4" width="16" height="12" rx="2"/><path d="M4 10h16M8 16h8M6 20h2M16 20h2"/></svg>`
                        : `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 4px; color: #06b6d4;"><path d="M2 21h20M19.3 14.8C21.1 13.5 22 12.1 22 10.8c0-2-2.5-3.3-6.5-3.3-3 0-5.5.8-8 1.8L3 6v9.8c0 1 1 1.7 2.2 1.7L12 17.5l7.3-2.7z"/></svg>`;
            tdType.innerHTML = `
                <span class="bk-type">
                    ${typeIcon}
                    <span style="margin-left: 2px; text-transform: capitalize;">${b.travelType}</span>
                </span>
            `;
            tr.appendChild(tdType);

            // Date
            const tdDate = document.createElement('td');
            const d = new Date(b.date);
            const formattedDate = isNaN(d.getTime()) ? b.date : d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
            tdDate.innerHTML = `<span class="bk-date">${formattedDate}</span>`;
            tr.appendChild(tdDate);

            // Passengers
            const tdPax = document.createElement('td');
            tdPax.innerText = b.passengers;
            tr.appendChild(tdPax);

            // Price
            const tdPrice = document.createElement('td');
            const priceVal = Number(b.amount) || 0;
            tdPrice.innerHTML = `
                <span class="bk-amount" style="color: ${priceVal > 0 ? '#22c55e' : '#ef4444'}">
                    ${priceVal > 0 ? '₹' + priceVal.toLocaleString('en-IN') : 'Needs Quote'}
                </span>
            `;
            tr.appendChild(tdPrice);

            // Status
            const tdStatus = document.createElement('td');
            const statusColor = STATUS_COLORS[b.status] || '#666';
            tdStatus.innerHTML = `
                <span class="bk-status" style="background: ${statusColor}15; color: ${statusColor}; border-color: ${statusColor}30">
                    ${b.status}
                </span>
            `;
            tr.appendChild(tdStatus);

            // Actions
            if (canManageBookings) {
                const tdActions = document.createElement('td');
                tdActions.style.textAlign = 'right';
                const editBtn = document.createElement('button');
                editBtn.className = 'bk-edit-btn';
                editBtn.innerText = 'Edit Entry';
                editBtn.onclick = () => openEdit(b);
                tdActions.appendChild(editBtn);
                tr.appendChild(tdActions);
            }

            tbody.appendChild(tr);
        });
    }

    // Modal Control
    const modal = document.getElementById('bookingModal');
    const form = document.getElementById('bookingForm');

    function openCreate() {
        document.getElementById('modalTitle').innerText = 'Create Custom Booking';
        form.action = '/admin/bookings';
        
        // Reset Inputs
        document.getElementById('inCustomerName').value = '';
        document.getElementById('inCustomerPhone').value = '';
        document.getElementById('inFromCity').value = '';
        document.getElementById('inToCity').value = '';
        document.getElementById('inDate').value = new Date().toISOString().split('T')[0];
        document.getElementById('inTravelType').value = 'flight';
        document.getElementById('inClassType').value = 'Economy';
        document.getElementById('inPassengers').value = 1;
        document.getElementById('inAmount').value = 0;
        document.getElementById('inStatus').value = 'pending';
        document.getElementById('inNotes').value = '';

        document.getElementById('modalSaveBtn').innerText = 'Create Entry';
        document.getElementById('modalFooterActions').style.display = 'none';

        modal.style.display = 'flex';
    }

    function openEdit(b) {
        document.getElementById('modalTitle').innerText = `Manage Booking: ${b.id}`;
        form.action = `/admin/bookings/update/${b.id}`;

        // Populate Inputs
        document.getElementById('inCustomerName').value = b.customerName || '';
        document.getElementById('inCustomerPhone').value = b.customerPhone || '';
        document.getElementById('inFromCity').value = b.fromCity || b.from || '';
        document.getElementById('inToCity').value = b.toCity || b.to || '';
        document.getElementById('inDate').value = b.date || '';
        document.getElementById('inTravelType').value = b.travelType || 'flight';
        document.getElementById('inClassType').value = b.classType || '';
        document.getElementById('inPassengers').value = b.passengers || 1;
        document.getElementById('inAmount').value = b.amount || 0;
        document.getElementById('inStatus').value = b.status || 'pending';
        document.getElementById('inNotes').value = b.notes || '';

        document.getElementById('modalSaveBtn').innerText = 'Save Changes';

        // Setup WhatsApp link
        const cleanPhone = (b.customerPhone || '').replace(/[^0-9]/g, '');
        const messageText = `Hello ${b.customerName || ''}, this is Shivalay Travels. Regarding your booking request ${b.id} from ${b.fromCity || b.from || ''} to ${b.toCity || b.to || ''}. Your status is currently ${b.status.toUpperCase()} with quote of ₹${b.amount || 0}.`;
        document.getElementById('modalWhatsAppLink').href = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(messageText)}`;

        // Setup Delete Action
        if (canDeleteRecords) {
            const delBtn = document.getElementById('modalDeleteBtn');
            if (delBtn) {
                delBtn.onclick = () => {
                    if (confirm('Delete this booking permanently?')) {
                        window.location.href = `/admin/bookings/delete/${b.id}`;
                    }
                };
            }
        }

        document.getElementById('modalFooterActions').style.display = 'flex';
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    // Initial render
    document.addEventListener('DOMContentLoaded', () => {
        render();
    });
</script>
@endsection
