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
        <div style="font-size: 44, margin-bottom: 12px;">📈</div>
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
                    <span class="an-kpi-ico">💰</span>
                </div>
                <div class="an-kpi-val" style="color: #22c55e;" id="kpiRevenue">₹0</div>
            </div>
            <div class="an-kpi-card">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Total Inquiries</span>
                    <span class="an-kpi-ico">📋</span>
                </div>
                <div class="an-kpi-val" style="color: #3b82f6;" id="kpiInquiries">0</div>
            </div>
            <div class="an-kpi-card">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Booking Rate</span>
                    <span class="an-kpi-ico">⚡</span>
                </div>
                <div class="an-kpi-val" style="color: #f59e0b;" id="kpiRate">0%</div>
            </div>
            <div class="an-kpi-card">
                <div class="an-kpi-top">
                    <span class="an-kpi-lbl">Total Passengers</span>
                    <span class="an-kpi-ico">👥</span>
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

        // 2. Filter bookings
        const filtered = bookings.filter(b => {
            const created = new Date(b.createdAt || b.date);
            const matchDate = created >= cutoff;
            const matchType = typeFilter === 'all' || b.travelType === typeFilter;
            return matchDate && matchType;
        });

        if (filtered.length === 0) {
            document.getElementById('analyticsContent').style.display = 'none';
            document.getElementById('emptyState').style.display = 'block';
            return;
        } else {
            document.getElementById('analyticsContent').style.display = 'block';
            document.getElementById('emptyState').style.display = 'none';
        }

        // 3. KPIs calculations
        const totalRevenue = filtered.filter(b => b.status !== 'cancelled').reduce((sum, b) => sum + Number(b.amount || 0), 0);
        const confirmed = filtered.filter(b => b.status === 'confirmed').length;
        const pending = filtered.filter(b => b.status === 'pending').length;
        const cancelled = filtered.filter(b => b.status === 'cancelled').length;
        const completed = filtered.filter(b => b.status === 'completed').length;
        const totalPassengers = filtered.reduce((sum, b) => sum + Number(b.passengers || 1), 0);
        const confirmationRate = filtered.length > 0 ? ((confirmed + completed) / filtered.length * 100) : 0;

        document.getElementById('kpiRevenue').innerText = `₹${totalRevenue.toLocaleString('en-IN')}`;
        document.getElementById('kpiInquiries').innerText = filtered.length;
        document.getElementById('kpiRate').innerText = `${confirmationRate.toFixed(1)}%`;
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
            const rev = filtered
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
            value: filtered.filter(b => b.travelType === type).length,
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
        filtered.forEach(b => {
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
    }

    // Initialize
    updateAnalytics();
});
</script>
@endsection
