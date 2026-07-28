@extends('layouts.admin')

@section('title', 'Business Analytics')

@section('page_title', 'Business Analytics')
@section('page_subtitle')
    Realtime performance indicators & booking statistics
@endsection

@section('content')
<div class="an-root">
    <div class="an-header-row" style="margin-bottom: 20px;">
        <div></div>
        <div class="an-filters">
            <select class="an-select" id="typeFilter">
                <option value="all">All Transits</option>
                <option value="flight">Flights</option>
                <option value="train">Trains</option>
                <option value="bus">Buses</option>
                <option value="cruise">Cruises</option>
            </select>
            <button class="an-range-btn active" data-range="30d">30 Days</button>
            <button class="an-range-btn" data-range="7d">7 Days</button>
            <button class="an-range-btn" data-range="90d">90 Days</button>
            <button class="an-range-btn" data-range="all">All Time</button>
        </div>
    </div>

    <!-- Empty State -->
    <div class="an-empty-state" id="emptyState" style="display: none;">
        <div style="margin-bottom: 12px; display: flex; justify-content: center;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(255,0,0,0.4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10" /><line x1="12" y1="20" x2="12" y2="4" /><line x1="6" y1="20" x2="6" y2="14" /><line x1="2" y1="20" x2="22" y2="20" /></svg>
        </div>
        <p style="color: #fff; font-size: 14px; font-weight: bold;">No booking records found.</p>
        <p style="color: #555; font-size: 12px; marginTop: 4px;">Add custom bookings inside the manager to generate owner reports.</p>
    </div>

    <!-- Main Analytics Content -->
    <div id="analyticsContent">
        <!-- KPI Stats -->
        <div class="an-kpi-row">
            <div class="an-kpi-card">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Gross Revenue</span>
                    <span class="an-kpi-ico" style="color: #22c55e;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23" /><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" /></svg>
                    </span>
                </div>
                <div class="an-kpi-val" style="color: #22c55e;" id="kpiRevenue">₹0</div>
            </div>
            <div class="an-kpi-card">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Transit Bookings</span>
                    <span class="an-kpi-ico" style="color: #3b82f6;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /></svg>
                    </span>
                </div>
                <div class="an-kpi-val" style="color: #3b82f6;" id="kpiInquiries">0</div>
            </div>
            <div class="an-kpi-card">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Property Inquiries</span>
                    <span class="an-kpi-ico" style="color: #f59e0b;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="16"/><line x1="15" y1="22" x2="15" y2="16"/><line x1="9" y1="16" x2="15" y2="16"/><path d="M8 6h2M8 10h2M14 6h2M14 10h2"/></svg>
                    </span>
                </div>
                <div class="an-kpi-val" style="color: #f59e0b;" id="kpiPropertyInqs">0</div>
            </div>
            <div class="an-kpi-card">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Total Travelers</span>
                    <span class="an-kpi-ico" style="color: #8b5cf6;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M23 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>
                    </span>
                </div>
                <div class="an-kpi-val" style="color: #8b5cf6;" id="kpiPassengers">0</div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="an-charts-grid" style="margin-top: 20px;">
            <div class="an-chart-card span-2">
                <h3 class="an-chart-title">Revenue Intake Trend (₹)</h3>
                <div class="an-chart-canvas-wrap">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            <div class="an-chart-card">
                <h3 class="an-chart-title">Transit Type Split</h3>
                <div class="an-chart-canvas-wrap">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Split Row: Status + Top Routes -->
        <div class="an-charts-grid" style="margin-top: 20px;">
            <div class="an-chart-card">
                <h3 class="an-chart-title">Booking Status Distribution</h3>
                <div class="an-chart-canvas-wrap">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
            <div class="an-chart-card span-2">
                <h3 class="an-chart-title">Top Revenue Routes</h3>
                <div class="an-table-wrap">
                    <table class="an-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Route Station</th>
                                <th>Type</th>
                                <th>Total Inquiries</th>
                                <th>Combined Revenue</th>
                            </tr>
                        </thead>
                        <tbody id="topRoutesBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Section: Hotels & Villas Analytics -->
        <div style="margin-top: 32px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 24px;">
            <h2 style="font-family:'DM Sans',sans-serif;font-size:14px;font-weight:700;color:#fff;margin-bottom:16px;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #ff0000;"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="16"/><line x1="15" y1="22" x2="15" y2="16"/><line x1="9" y1="16" x2="15" y2="16"/><path d="M8 6h2M8 10h2M14 6h2M14 10h2"/></svg>
                Properties &amp; Yatras Inquiries
            </h2>
        </div>

        <div class="an-kpi-row" style="margin-top: 8px; margin-bottom: 16px;">
            <div class="an-kpi-card" style="border-color: rgba(139,92,246,0.15);">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Total Pipeline Value</span>
                    <span class="an-kpi-ico" style="color: #c084fc;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </span>
                </div>
                <div class="an-kpi-val" style="color: #c084fc; font-size: 22px;" id="kpiPropPipeline">₹0</div>
                <div style="font-size: 11px; color: #555; margin-top: 4px;">Potential lodging/yatra budget</div>
            </div>
            <div class="an-kpi-card" style="border-color: rgba(34,197,94,0.15);">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Converted Pipeline</span>
                    <span class="an-kpi-ico" style="color: #4ade80;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" /><path d="m9 12 2 2 4-4"/></svg>
                    </span>
                </div>
                <div class="an-kpi-val" style="color: #4ade80; font-size: 22px;" id="kpiPropConverted">₹0</div>
                <div style="font-size: 11px; color: #555; margin-top: 4px;">Confirmed booking budget</div>
            </div>
            <div class="an-kpi-card" style="border-color: rgba(245,158,11,0.15);">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Pending Pipeline</span>
                    <span class="an-kpi-ico" style="color: #fbbf24;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" /><polyline points="12 6 12 12 16 14" /></svg>
                    </span>
                </div>
                <div class="an-kpi-val" style="color: #fbbf24; font-size: 22px;" id="kpiPropPending">₹0</div>
                <div style="font-size: 11px; color: #555; margin-top: 4px;">Follow-up opportunities</div>
            </div>
        </div>

        <div class="an-charts-grid" style="margin-top: 16px; margin-bottom: 24px;">
            <div class="an-chart-card">
                <h3 class="an-chart-title">Accommodation Split</h3>
                <div class="an-chart-canvas-wrap">
                    <canvas id="propTypeChart"></canvas>
                </div>
            </div>
            <div class="an-chart-card">
                <h3 class="an-chart-title">Inquiry Status Split</h3>
                <div class="an-chart-canvas-wrap">
                    <canvas id="inqStatusChart"></canvas>
                </div>
            </div>
            <div class="an-chart-card">
                <h3 class="an-chart-title">Popular Properties &amp; Packages</h3>
                <div class="an-table-wrap" style="max-height: 180px; overflow-y: auto;">
                    <table class="an-table">
                        <thead>
                            <tr>
                                <th>Property / Yatra Name</th>
                                <th>Type</th>
                                <th style="text-align:right;">Inquiries</th>
                            </tr>
                        </thead>
                        <tbody id="topPropsBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .an-root { display: flex; flex-direction: column; gap: 20px; }
    .an-header-row { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    .an-title { font-size: 22px; font-weight: 700; color: #fff; }
    .an-sub { font-size: 12px; color: #555; margin-top: 2px; }
    
    .an-filters { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .an-select { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: #ccc; font-size: 12px; padding: 7px 12px; border-radius: 8px; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .an-select option { background: #111; color: #fff; }
    .an-range-btn { background: transparent; border: 1px solid rgba(255,255,255,0.08); color: #666; font-size: 11px; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: all 0.2s; font-family: 'DM Sans', sans-serif; }
    .an-range-btn.active { background: rgba(255,0,0,0.12); border-color: rgba(255,0,0,0.3); color: #ff6060; }
    .an-range-btn:hover { border-color: rgba(255,255,255,0.2); color: #ccc; }
    
    .an-kpi-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .an-kpi-card { background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 18px; display: flex; flex-direction: column; gap: 10px; }
    .an-kpi-top { display: flex; align-items: center; justify-content: space-between; }
    .an-kpi-lbl { font-size: 11px; color: #555; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
    .an-kpi-ico { font-size: 16px; }
    .an-kpi-val { font-size: 20px; font-weight: 700; }
    
    .an-charts-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .an-chart-card { background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; padding: 20px; display: flex; flex-direction: column; gap: 16px; }
    .an-chart-card.span-2 { grid-column: span 2; }
    .an-chart-title { font-size: 13px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 8px; }
    .an-chart-canvas-wrap { position: relative; height: 180px; width: 100%; }
    
    .an-empty-state { text-align: center; padding: 60px 24px; background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; }
    .an-table-wrap { overflow-x: auto; }
    .an-table { width: 100%; border-collapse: collapse; }
    .an-table th { padding: 8px 10px; text-align: left; font-size: 10px; color: #555; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06); }
    .an-table td { padding: 10px; border-bottom: 1px solid rgba(255,255,255,0.04); font-size: 12px; color: #bbb; }
    .an-table tr:last-child td { border-bottom: none; }
    .an-type-badge { font-size: 10px; padding: 2px 8px; border-radius: 4px; border: 1px solid; text-transform: capitalize; font-weight: 600; display: inline-block; }
    
    @media (max-width: 1024px) {
      .an-kpi-row { grid-template-columns: repeat(2, 1fr); }
      .an-charts-grid { grid-template-columns: 1fr; }
      .an-chart-card.span-2 { grid-column: span 1; }
    }
    @media (max-width: 640px) {
      .an-kpi-row { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookings = @json($bookings);
    const inquiries = @json($inquiries);

    let rangeFilter = '30d';
    let typeFilter = 'all';

    // Chart instances
    let revChart = null;
    let typeChart = null;
    let statusChart = null;
    let propTypeChart = null;
    let inqStatusChart = null;

    const TYPE_COLORS = {
        flight: '#ef4444', train: '#f59e0b', bus: '#3b82f6', cruise: '#8b5cf6'
    };
    const STATUS_COLORS = {
        confirmed: '#22c55e', pending: '#f59e0b', cancelled: '#ef4444', completed: '#3b82f6'
    };

    // Range Button Click Handlers
    document.querySelectorAll('.an-range-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.an-range-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            rangeFilter = this.getAttribute('data-range');
            updateAnalytics();
        });
    });

    // Transit Type Filter
    const typeSelect = document.getElementById('typeFilter');
    if (typeSelect) {
        typeSelect.addEventListener('change', function() {
            typeFilter = this.value;
            updateAnalytics();
        });
    }

    function updateAnalytics() {
        // 1. Cutoff calculations
        const now = new Date();
        let cutoff = new Date(0);
        if (rangeFilter === '7d') cutoff = new Date(now.getTime() - 7 * 86400000);
        else if (rangeFilter === '30d') cutoff = new Date(now.getTime() - 30 * 86400000);
        else if (rangeFilter === '90d') cutoff = new Date(now.getTime() - 90 * 86400000);

        // 2. Filter bookings & inquiries
        const filteredBookings = bookings.filter(b => {
            const created = new Date(b.createdAt || b.date);
            const matchDate = created >= cutoff;
            const matchType = typeFilter === 'all' || b.travelType === typeFilter;
            return matchDate && matchType;
        });

        const filteredInquiries = inquiries.filter(inq => {
            const created = new Date(inq.created_at || inq.createdAt || inq.date);
            return created >= cutoff;
        });

        if (filteredBookings.length === 0 && filteredInquiries.length === 0) {
            document.getElementById('analyticsContent').style.display = 'none';
            document.getElementById('emptyState').style.display = 'block';
            return;
        } else {
            document.getElementById('analyticsContent').style.display = 'block';
            document.getElementById('emptyState').style.display = 'none';
        }

        // 3. KPIs calculations
        const totalRevenue = filteredBookings.filter(b => b.status !== 'cancelled').reduce((sum, b) => sum + Number(b.amount || 0), 0);
        const totalPassengers = filteredBookings.reduce((sum, b) => sum + Number(b.passengers || 1), 0) + 
                                 filteredInquiries.reduce((sum, inq) => sum + Number(inq.travelers || 1), 0);

        document.getElementById('kpiRevenue').innerText = `₹${totalRevenue.toLocaleString('en-IN')}`;
        document.getElementById('kpiInquiries').innerText = filteredBookings.length;
        document.getElementById('kpiPropertyInqs').innerText = filteredInquiries.length;
        document.getElementById('kpiPassengers').innerText = totalPassengers;

        // 4. Daily Revenue Intake Graph Data
        const days = rangeFilter === '7d' ? 7 : rangeFilter === '30d' ? 14 : 30;
        const revenueByDay = [];
        for (let i = days - 1; i >= 0; i--) {
            const d = new Date(now.getTime() - i * 86400000);
            const label = days <= 7
                ? ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][d.getDay()]
                : `${d.getDate()}/${d.getMonth() + 1}`;
            const dayStr = d.toISOString().split('T')[0];
            const rev = filteredBookings
                .filter(b => (b.createdAt || b.date).startsWith(dayStr) && b.status !== 'cancelled')
                .reduce((sum, b) => sum + Number(b.amount || 0), 0);
            revenueByDay.push({ label, value: rev });
        }

        // Render line chart
        if (revChart) revChart.destroy();
        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        revChart = new Chart(ctxRev, {
            type: 'line',
            data: {
                labels: revenueByDay.map(d => d.label),
                datasets: [{
                    label: 'Daily Revenue (₹)',
                    data: revenueByDay.map(d => d.value),
                    borderColor: '#ff0000',
                    backgroundColor: 'rgba(255, 0, 0, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#ff0000',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#888' } },
                    x: { grid: { display: false }, ticks: { color: '#888' } }
                }
            }
        });

        // 5. Type distribution
        const byTypeData = ['flight', 'train', 'bus', 'cruise'].map(type => ({
            label: type.charAt(0).toUpperCase() + type.slice(1),
            value: filteredBookings.filter(b => b.travelType === type).length,
            color: TYPE_COLORS[type]
        }));

        if (typeChart) typeChart.destroy();
        const ctxType = document.getElementById('typeChart').getContext('2d');
        typeChart = new Chart(ctxType, {
            type: 'doughnut',
            data: {
                labels: byTypeData.map(t => t.label),
                datasets: [{
                    data: byTypeData.map(t => t.value),
                    backgroundColor: byTypeData.map(t => t.color),
                    borderColor: '#0a0a0c',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#bbb', font: { size: 11 } }
                    }
                }
            }
        });

        // 6. Status distribution
        const confirmed = filteredBookings.filter(b => b.status === 'confirmed').length;
        const pending = filteredBookings.filter(b => b.status === 'pending').length;
        const cancelled = filteredBookings.filter(b => b.status === 'cancelled').length;
        const completed = filteredBookings.filter(b => b.status === 'completed').length;

        const byStatusData = [
            { label: 'Confirmed', value: confirmed, color: STATUS_COLORS.confirmed },
            { label: 'Pending', value: pending, color: STATUS_COLORS.pending },
            { label: 'Completed', value: completed, color: STATUS_COLORS.completed },
            { label: 'Cancelled', value: cancelled, color: STATUS_COLORS.cancelled },
        ].filter(s => s.value > 0);

        if (statusChart) statusChart.destroy();
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        statusChart = new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: byStatusData.map(s => s.label),
                datasets: [{
                    data: byStatusData.map(s => s.value),
                    backgroundColor: byStatusData.map(s => s.color),
                    borderColor: '#0a0a0c',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#bbb', font: { size: 11 } }
                    }
                }
            }
        });

        // 7. Route Ranking
        const routeMap = {};
        filteredBookings.forEach(b => {
            const from = (b.fromCity || b.from || '').split(' ')[0];
            const to = (b.toCity || b.to || '').split(' ')[0];
            if (!from || !to) return;
            const key = `${from} → ${to}`;
            if (!routeMap[key]) routeMap[key] = { count: 0, revenue: 0, type: b.travelType };
            routeMap[key].count++;
            if (b.status !== 'cancelled') routeMap[key].revenue += Number(b.amount || 0);
        });

        const topRoutes = Object.entries(routeMap)
            .sort((a, b) => b[1].revenue - a[1].revenue)
            .slice(0, 5);

        let routesHtml = '';
        topRoutes.forEach(([route, rdata], i) => {
            routesHtml += `
                <tr>
                    <td style="color: #555; font-weight: bold;">#${i + 1}</td>
                    <td style="color: #ddd; font-weight: 500;">${route}</td>
                    <td>
                        <span class="an-type-badge" style="border-color: ${TYPE_COLORS[rdata.type]}44; color: ${TYPE_COLORS[rdata.type]}">
                            ${rdata.type}
                        </span>
                    </td>
                    <td>${rdata.count}</td>
                    <td style="color: #22c55e; font-weight: bold;">₹${rdata.revenue.toLocaleString('en-IN')}</td>
                </tr>
            `;
        });
        if (topRoutes.length === 0) {
            routesHtml = `<tr><td colSpan="5" style="text-align: center; color: #444;">No route stats yet.</td></tr>`;
        }
        document.getElementById('topRoutesBody').innerHTML = routesHtml;

        // 8. Properties (Hotels & Villas) & Yatras Split & Pipeline calculations
        let hotelInq = 0;
        let villaInq = 0;
        let packageInq = 0;
        let totalPipeline = 0;
        let totalConverted = 0;
        let totalPending = 0;
        const propMap = {};

        const parseBudget = (bStr) => {
            if (!bStr) return 0;
            const cleaned = String(bStr).replace(/[^0-9]/g, '');
            return Number(cleaned) || 0;
        };

        filteredInquiries.forEach(inq => {
            const budgetVal = parseBudget(inq.budget);
            totalPipeline += budgetVal;

            if (inq.status === 'confirmed' || inq.status === 'completed') {
                totalConverted += budgetVal;
            } else if (inq.status === 'pending') {
                totalPending += budgetVal;
            }

            const acc = (inq.accommodation || '').toLowerCase();
            const dest = (inq.destinations || '').toLowerCase();
            let cat = 'Package';
            let catColor = '#8b5cf6'; // purple

            if (acc.includes('hotel') || dest.includes('hotel')) {
                cat = 'Hotel';
                catColor = '#a3e635'; // lime
                hotelInq++;
            } else if (acc.includes('villa') || dest.includes('villa')) {
                cat = 'Villa';
                catColor = '#b8882a'; // gold
                villaInq++;
            } else {
                packageInq++;
            }

            let name = inq.destinations || 'Custom Package';
            name = name.replace(/^(HOTEL|VILLA|PACKAGE)\s*-\s*/i, '');
            if (!propMap[name]) {
                propMap[name] = { count: 0, type: cat, color: catColor };
            }
            propMap[name].count++;
        });

        // Set Pipeline KPIs
        document.getElementById('kpiPropPipeline').innerText = `₹${totalPipeline.toLocaleString('en-IN')}`;
        document.getElementById('kpiPropConverted').innerText = `₹${totalConverted.toLocaleString('en-IN')}`;
        document.getElementById('kpiPropPending').innerText = `₹${totalPending.toLocaleString('en-IN')}`;

        // Accommodation split chart
        if (propTypeChart) propTypeChart.destroy();
        const ctxPropType = document.getElementById('propTypeChart').getContext('2d');
        propTypeChart = new Chart(ctxPropType, {
            type: 'doughnut',
            data: {
                labels: ['Hotels', 'Villas', 'Tour Packages'],
                datasets: [{
                    data: [hotelInq, villaInq, packageInq],
                    backgroundColor: ['#a3e635', '#b8882a', '#8b5cf6'],
                    borderColor: '#0a0a0c',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#bbb', font: { size: 11 } }
                    }
                }
            }
        });

        // Inquiry status chart
        const inqPending = filteredInquiries.filter(i => i.status === 'pending').length;
        const inqConfirmed = filteredInquiries.filter(i => i.status === 'confirmed').length;
        const inqCompleted = filteredInquiries.filter(i => i.status === 'completed').length;
        const inqCancelled = filteredInquiries.filter(i => i.status === 'cancelled').length;

        if (inqStatusChart) inqStatusChart.destroy();
        const ctxInqStatus = document.getElementById('inqStatusChart').getContext('2d');
        inqStatusChart = new Chart(ctxInqStatus, {
            type: 'pie',
            data: {
                labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
                datasets: [{
                    data: [inqPending, inqConfirmed, inqCompleted, inqCancelled],
                    backgroundColor: ['#f59e0b', '#22c55e', '#3b82f6', '#ef4444'],
                    borderColor: '#0a0a0c',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#bbb', font: { size: 11 } }
                    }
                }
            }
        });

        // Popular properties table
        const topProps = Object.entries(propMap)
            .sort((a, b) => b[1].count - a[1].count)
            .slice(0, 8);

        let propsHtml = '';
        topProps.forEach(([name, pdata]) => {
            propsHtml += `
                <tr>
                    <td style="color: #ddd; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;">${name}</td>
                    <td>
                        <span class="an-type-badge" style="border-color: ${pdata.color}44; color: ${pdata.color}; font-size: 9px; padding: 1px 6px;">
                            ${pdata.type}
                        </span>
                    </td>
                    <td style="color: #fff; font-weight: bold; text-align: right;">${pdata.count}</td>
                </tr>
            `;
        });
        if (topProps.length === 0) {
            propsHtml = `<tr><td colSpan="3" style="text-align: center; color: #444; padding: 20px;">No property inquiries yet.</td></tr>`;
        }
        document.getElementById('topPropsBody').innerHTML = propsHtml;
    }

    // Initialize
    updateAnalytics();
});
</script>
@endsection
