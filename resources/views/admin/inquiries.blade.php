@extends('layouts.admin')

@section('title', 'Journey Planner Inquiries')

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
    .bk-date { color: #777; }
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
    .bk-page-select option { background: #1a1a1a; color: #fff; padding: 10px 14px; font-family: 'DM Sans',sans-serif; font-size: 12px; }

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
            <h1 class="bk-title">Journey Planner Inquiries</h1>
            <p class="bk-sub" id="entriesSummary">0 of 0 total entries</p>
        </div>
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
            <button class="bk-tab" onclick="setFilter('contacted')">
                Contacted
                <span class="bk-tab-count" id="count-contacted">0</span>
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
                placeholder="Search name, phone, route..." 
                oninput="handleSearch(this.value)"
            />
        </div>
    </div>

    <!-- Table -->
    <div class="bk-table-wrap">
        <table class="bk-table">
            <thead>
                <tr>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('id')">
                            Inquiry ID <span id="sort-icon-id"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('customerName')">
                            Customer Detail <span id="sort-icon-customerName"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('destinations')">
                            Destinations Chosen <span id="sort-icon-destinations"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('duration')">
                            Duration & Travelers <span id="sort-icon-duration"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('budget')">
                            Stay Preferences <span id="sort-icon-budget"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('createdAt')">
                            Date Created <span id="sort-icon-createdAt"></span>
                        </span>
                    </th>
                    <th>
                        <span class="bk-header-sortable" onclick="toggleSort('status')">
                            Status <span id="sort-icon-status"></span>
                        </span>
                    </th>
                    @if($canManage)
                        <th style="text-align: right;">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody id="inquiriesTableBody">
                <!-- Javascript will populate this dynamic content -->
            </tbody>
        </table>
        <div class="bk-empty" id="noInquiriesMsg" style="display: none;">No inquiries found matching filters.</div>
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
<div id="inquiryModal" class="modal-overlay" onclick="closeModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <form id="inquiryForm" method="POST" action="">
            @csrf
            <div class="modal-head">
                <h3 class="modal-title" id="modalTitle">Manage Inquiry</h3>
                <button type="button" class="modal-close" onclick="closeModal()">✕</button>
            </div>
            
            <div class="modal-body" style="display: flex; flex-direction: column; gap: 16px;">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-lbl">Customer Name</label>
                        <input type="text" name="customerName" id="inCustomerName" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">WhatsApp Phone</label>
                        <input type="text" name="customerPhone" id="inCustomerPhone" class="form-input" required />
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-lbl">Email Address</label>
                        <input type="email" name="customerEmail" id="inCustomerEmail" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">Destinations</label>
                        <input type="text" name="destinations" id="inDestinations" class="form-input" required />
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-lbl">Duration</label>
                        <input type="text" name="duration" id="inDuration" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">Travelers Count</label>
                        <input type="number" name="travelers" id="inTravelers" class="form-input" min="1" required />
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-lbl">Budget Category</label>
                        <select name="budget" id="inBudget" class="form-select">
                            <option value="Budget">Budget</option>
                            <option value="Standard">Standard</option>
                            <option value="Premium">Premium</option>
                            <option value="Luxury">Luxury</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-lbl">Stay Standard</label>
                        <select name="accommodation" id="inAccommodation" class="form-select">
                            <option value="Homestay / Dharamshala">Homestay / Dharamshala</option>
                            <option value="2 Star Hotel">2 Star Hotel</option>
                            <option value="3 Star Hotel">3 Star Hotel</option>
                            <option value="4 Star Hotel">4 Star Hotel</option>
                            <option value="5 Star Hotel">5 Star Hotel</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-lbl">Inquiry Status</label>
                        <select name="status" id="inStatus" class="form-select" style="font-weight: bold;">
                            <option value="pending" style="color: #f59e0b;">PENDING</option>
                            <option value="contacted" style="color: #3b82f6;">CONTACTED</option>
                            <option value="completed" style="color: #22c55e;">COMPLETED</option>
                            <option value="cancelled" style="color: #ef4444;">CANCELLED</option>
                        </select>
                    </div>
                    <div class="form-group" style="justify-content: center;">
                        <a 
                            id="modalWhatsAppLink"
                            href="#"
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="form-whatsapp-btn"
                            style="margin-top: 16px; text-align: center; justify-content: center;"
                        >
                            💬 Contact on WhatsApp
                        </a>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-lbl">Journey Planner Brief & Notes</label>
                    <textarea name="notes" id="inNotes" class="form-textarea" rows="4" placeholder="Enter itinerary draft, prices, customized options here..."></textarea>
                </div>

                <!-- Submit actions -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 10px;">
                    @if($canDelete)
                        <button 
                            type="button" 
                            class="modal-delete-btn-inline" 
                            id="modalDeleteBtn"
                        >
                            Delete Inquiry Permanently
                        </button>
                    @else
                        <div></div>
                    @endif
                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="form-cancel-btn" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="form-save-btn">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initial data from Laravel backend
    const inquiries = {!! json_encode($inquiries) !!};
    const canManageInquiries = {{ $canManage ? 'true' : 'false' }};
    const canDeleteInquiries = {{ $canDelete ? 'true' : 'false' }};

    const STATUS_COLORS = {
        pending: { text: '#f59e0b', bg: 'rgba(245,158,11,0.08)', border: 'rgba(245,158,11,0.2)' },
        contacted: { text: '#3b82f6', bg: 'rgba(59,130,246,0.08)', border: 'rgba(59,130,246,0.2)' },
        completed: { text: '#22c55e', bg: 'rgba(34,197,94,0.08)', border: 'rgba(34,197,94,0.2)' },
        cancelled: { text: '#ef4444', bg: 'rgba(239,68,68,0.08)', border: 'rgba(239,68,68,0.2)' }
    };

    // UI state
    let state = {
        filter: 'all',
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
        const filtered = getFilteredInquiries();
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

    function getFilteredInquiries() {
        return inquiries.filter(i => {
            const matchStatus = state.filter === 'all' || i.status === state.filter;
            const matchSearch = !state.search || 
                (i.customerName || '').toLowerCase().includes(state.search.toLowerCase()) ||
                (i.id || '').toLowerCase().includes(state.search.toLowerCase()) || 
                (i.destinations || '').toLowerCase().includes(state.search.toLowerCase()) ||
                (i.customerPhone || '').toLowerCase().includes(state.search.toLowerCase());
            return matchStatus && matchSearch;
        });
    }

    function getSortedInquiries(filtered) {
        const key = state.sorting.key;
        const desc = state.sorting.desc;

        return [...filtered].sort((a, b) => {
            let valA, valB;
            if (key === 'customerName') {
                valA = (a.customerName || '').toLowerCase();
                valB = (b.customerName || '').toLowerCase();
            } else if (key === 'travelers') {
                valA = Number(a.travelers) || 0;
                valB = Number(b.travelers) || 0;
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
        document.getElementById('count-all').innerText = inquiries.length;
        document.getElementById('count-pending').innerText = inquiries.filter(i => i.status === 'pending').length;
        document.getElementById('count-contacted').innerText = inquiries.filter(i => i.status === 'contacted').length;
        document.getElementById('count-completed').innerText = inquiries.filter(i => i.status === 'completed').length;
        document.getElementById('count-cancelled').innerText = inquiries.filter(i => i.status === 'cancelled').length;

        // Sort Icons
        const columns = ['id', 'customerName', 'destinations', 'duration', 'budget', 'createdAt', 'status'];
        columns.forEach(col => {
            const iconEl = document.getElementById(`sort-icon-${col}`);
            if (state.sorting.key === col) {
                iconEl.innerText = state.sorting.desc ? ' ⬇️' : ' ⬆️';
            } else {
                iconEl.innerText = '';
            }
        });

        const filtered = getFilteredInquiries();
        const sorted = getSortedInquiries(filtered);

        // Entries Summary
        document.getElementById('entriesSummary').innerText = `${filtered.length} of ${inquiries.length} total entries`;

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
        const tbody = document.getElementById('inquiriesTableBody');
        tbody.innerHTML = '';

        if (paginated.length === 0) {
            document.getElementById('noInquiriesMsg').style.display = 'block';
            return;
        } else {
            document.getElementById('noInquiriesMsg').style.display = 'none';
        }

        paginated.forEach(i => {
            const tr = document.createElement('tr');

            // ID
            const tdId = document.createElement('td');
            tdId.innerHTML = `<span class="bk-id">${i.id}</span>`;
            tr.appendChild(tdId);

            // Customer
            const tdCust = document.createElement('td');
            const initials = i.customerName
                ? i.customerName.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase()
                : '?';
            tdCust.innerHTML = `
                <div class="bk-customer">
                    <div class="bk-avatar">
                        ${initials}
                    </div>
                    <div>
                        <div class="bk-name">${i.customerName || 'Guest'}</div>
                        <div class="bk-phone">${i.customerPhone || 'No Phone'}</div>
                    </div>
                </div>
            `;
            tr.appendChild(tdCust);

            // Destinations
            const tdDest = document.createElement('td');
            tdDest.innerHTML = `<span class="bk-route" title="${i.destinations}">${i.destinations}</span>`;
            tr.appendChild(tdDest);

            // Duration & Travelers
            const tdDuration = document.createElement('td');
            tdDuration.innerHTML = `
                <div>
                    <div style="color: #fff; font-size: 13px; font-weight: 500;">${i.duration}</div>
                    <div style="color: #555; font-size: 11px;">${i.travelers} Traveler(s)</div>
                </div>
            `;
            tr.appendChild(tdDuration);

            // Budget
            const tdPreferences = document.createElement('td');
            tdPreferences.innerHTML = `
                <div>
                    <div style="color: #aaa; font-size: 12px;">Budget: ${i.budget}</div>
                    <div style="color: #777; font-size: 11px;">Stay: ${i.accommodation}</div>
                </div>
            `;
            tr.appendChild(tdPreferences);

            // Created At
            const tdDate = document.createElement('td');
            const d = new Date(i.createdAt);
            const formattedDate = isNaN(d.getTime()) ? i.createdAt : d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
            tdDate.innerHTML = `<span class="bk-date">${formattedDate}</span>`;
            tr.appendChild(tdDate);

            // Status
            const tdStatus = document.createElement('td');
            const colors = STATUS_COLORS[i.status] || { text: '#aaa', bg: 'rgba(255,255,255,0.02)', border: 'rgba(255,255,255,0.1)' };
            tdStatus.innerHTML = `
                <span class="bk-status" style="background: ${colors.bg}; color: ${colors.text}; border-color: ${colors.border}">
                    ${i.status}
                </span>
            `;
            tr.appendChild(tdStatus);

            // Actions
            if (canManageInquiries) {
                const tdActions = document.createElement('td');
                tdActions.style.textAlign = 'right';
                const editBtn = document.createElement('button');
                editBtn.className = 'bk-edit-btn';
                editBtn.innerText = 'Edit / Manage';
                editBtn.onclick = () => openEdit(i);
                tdActions.appendChild(editBtn);
                tr.appendChild(tdActions);
            }

            tbody.appendChild(tr);
        });
    }

    // Modal Control
    const modal = document.getElementById('inquiryModal');
    const form = document.getElementById('inquiryForm');

    function openEdit(i) {
        document.getElementById('modalTitle').innerText = `Manage Inquiry: ${i.id}`;
        form.action = `/admin/inquiries/update/${i.id}`;

        // Populate Inputs
        document.getElementById('inCustomerName').value = i.customerName || '';
        document.getElementById('inCustomerPhone').value = i.customerPhone || '';
        document.getElementById('inCustomerEmail').value = i.customerEmail || '';
        document.getElementById('inDestinations').value = i.destinations || '';
        document.getElementById('inDuration').value = i.duration || '';
        document.getElementById('inTravelers').value = i.travelers || 1;
        document.getElementById('inBudget').value = i.budget || 'Standard';
        document.getElementById('inAccommodation').value = i.accommodation || '3 Star Hotel';
        document.getElementById('inStatus').value = i.status || 'pending';
        document.getElementById('inNotes').value = i.notes || '';

        // Setup WhatsApp link
        const cleanPhone = (i.customerPhone || '').replace(/[^0-9]/g, '');
        const messageText = `Hello ${i.customerName || ''}! This is Shivalay Travels. We have received your pilgrimage/custom travel inquiry for: ${i.destinations || ''} (${i.duration || ''}). Let's discuss details and plan your journey!`;
        document.getElementById('modalWhatsAppLink').href = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(messageText)}`;

        // Setup Delete Action
        if (canDeleteInquiries) {
            const delBtn = document.getElementById('modalDeleteBtn');
            if (delBtn) {
                delBtn.onclick = () => {
                    if (confirm('Delete this custom inquiry permanently?')) {
                        window.location.href = `/admin/inquiries/delete/${i.id}`;
                    }
                };
            }
        }

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
