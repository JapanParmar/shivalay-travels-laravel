@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')
@section('page_subtitle')
    Here's what's happening at Shivalay Travels today.
@endsection

@section('content')
    <!-- Statistics Grid -->
    <div class="stats-grid-4">
        <div class="stat-card" style="border-color: rgba(255,0,0,0.2);">
            <div class="stat-card-top">
                <div class="stat-icon" style="background: rgba(255,0,0,0.12); color: #ff0000;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /></svg>
                </div>
                <div class="stat-trend positive">
                    ↑ 12%
                </div>
            </div>
            <div class="stat-value">{{ count($bookings) }}</div>
            <div class="stat-label">Total Bookings</div>
            @php
                $pendingCount = count(array_filter($bookings, function($b) { return ($b['status'] ?? '') === 'pending'; }));
            @endphp
            <div class="stat-sub">{{ $pendingCount }} pending</div>
        </div>

        <div class="stat-card" style="border-color: rgba(34,197,94,0.2);">
            <div class="stat-card-top">
                <div class="stat-icon" style="background: rgba(34,197,94,0.12); color: #22c55e;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23" /><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" /></svg>
                </div>
                <div class="stat-trend positive">
                    ↑ 8.3%
                </div>
            </div>
            @php
                $revenue = collect($bookings)->where('status', '!=', 'cancelled')->sum('amount');
                $fmtRevenue = $revenue >= 100000 
                    ? '₹' . number_format($revenue / 100000, 1) . 'L'
                    : ($revenue >= 1000 ? '₹' . number_format($revenue / 1000, 0) . 'K' : '₹' . $revenue);
            @endphp
            <div class="stat-value">{{ $fmtRevenue }}</div>
            <div class="stat-label">Monthly Revenue</div>
            <div class="stat-sub">July 2026</div>
        </div>

        <div class="stat-card" style="border-color: rgba(59,130,246,0.2);">
            <div class="stat-card-top">
                <div class="stat-icon" style="background: rgba(59,130,246,0.12); color: #3b82f6;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /></svg>
                </div>
                <div class="stat-trend positive">
                    ↑ 15%
                </div>
            </div>
            @php
                $totalCustomers = count(array_unique(array_column($bookings, 'customerPhone')));
                $newCustomers = max(1, round($totalCustomers * 0.2));
            @endphp
            <div class="stat-value">{{ $totalCustomers }}</div>
            <div class="stat-label">Total Customers</div>
            <div class="stat-sub">+{{ $newCustomers }} new this month</div>
        </div>

        <div class="stat-card" style="border-color: rgba(245,158,11,0.2);">
            <div class="stat-card-top">
                <div class="stat-icon" style="background: rgba(245,158,11,0.12); color: #f59e0b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12" /></svg>
                </div>
                <div class="stat-trend positive">
                    ↑ 2.6%
                </div>
            </div>
            @php
                $cancelledCount = count(array_filter($bookings, function($b) { return ($b['status'] ?? '') === 'cancelled'; }));
                $cancelledRate = count($bookings) ? round(($cancelledCount / count($bookings)) * 100) : 0;
            @endphp
            <div class="stat-value">{{ $cancelledRate }}%</div>
            <div class="stat-label">Cancellation Rate</div>
            <div class="stat-sub">vs 6.8% last month</div>
        </div>
    </div>

    <!-- Charts and Breakdown -->
    <div class="dashboard-row-2" style="margin-bottom: 32px;">
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <h3 class="dash-card-title">Daily Estimated Bookings Value</h3>
                    <p class="dash-card-sub">Daily bookings revenue overview</p>
                </div>
            </div>
            <div style="height: 240px; position: relative;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="dash-card" style="display: flex; flex-direction: column;">
            <div class="dash-card-header">
                <h3 class="dash-card-title">Travel Types Breakdown</h3>
            </div>
            <div style="height: 180px; position: relative; margin-bottom: 12px;">
                <canvas id="typeChart"></canvas>
            </div>
            @php
                $role = session('admin_role', 'viewer');
                $roleLabels = [
                    'super_admin' => ['label' => 'Super Admin', 'color' => '#ff0000', 'desc' => 'Full Control'],
                    'manager' => ['label' => 'Manager', 'color' => '#f59e0b', 'desc' => 'High Access'],
                    'agent' => ['label' => 'Agent', 'color' => '#3b82f6', 'desc' => 'Limited Access'],
                    'viewer' => ['label' => 'Viewer', 'color' => '#6b7280', 'desc' => 'Read Only']
                ];
                $currentRole = $roleLabels[$role] ?? $roleLabels['viewer'];
            @endphp
            <div class="role-access-panel" style="border-color: {{ $currentRole['color'] }}30;">
                <span class="role-access-dot" style="background: {{ $currentRole['color'] }};"></span>
                <div>
                    <span class="role-access-role" style="color: {{ $currentRole['color'] }};">{{ $currentRole['label'] }}</span>
                    <span class="role-access-desc">Access level: {{ $currentRole['desc'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">Recent Travel Bookings</h3>
            <a href="/admin/bookings" class="btn btn-secondary" style="font-size: 12px; padding: 6px 12px;">View All Bookings</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Customer Details</th>
                    <th>Departure / Destination</th>
                    <th>Type</th>
                    <th>Travel Date</th>
                    <th>Estimated Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse(array_slice($bookings, 0, 5) as $b)
                    <tr>
                        <td><span class="booking-id">{{ $b['id'] }}</span></td>
                        <td>
                            <div class="customer-cell">
                                <div class="customer-avatar">{{ substr($b['customerName'] ?? 'A', 0, 1) }}</div>
                                <div>
                                    <div class="customer-name">{{ $b['customerName'] }}</div>
                                    <div class="customer-phone">{{ $b['customerPhone'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="route-cell">{{ $b['fromCity'] }} → {{ $b['toCity'] }}</td>
                        <td>
                            <span class="type-pill">
                                @if($b['travelType'] == 'flight') ✈️ Flight
                                @elseif($b['travelType'] == 'train') 🚆 Train
                                @elseif($b['travelType'] == 'bus') 🚌 Bus
                                @else 🚢 Cruise
                                @endif
                            </span>
                        </td>
                        <td class="date-cell">{{ date('d M Y', strtotime($b['date'])) }}</td>
                        <td class="amount-cell">₹{{ number_format($b['amount']) }}</td>
                        <td>
                            <span class="status-pill status-{{ $b['status'] }}">
                                {{ $b['status'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--color-muted); padding: 40px;">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        // Prepare Revenue Chart Data
        const bookings = @json($bookings);
        const revenueMap = {};
        
        // Sum up amounts per date
        bookings.forEach(b => {
            if (b.status !== 'cancelled') {
                const dateStr = new Date(b.date).toLocaleDateString('en-IN', { day: '2-digit', month: 'short' });
                revenueMap[dateStr] = (revenueMap[dateStr] || 0) + Number(b.amount || 0);
            }
        });

        const revenueLabels = Object.keys(revenueMap).slice(-7);
        const revenueValues = revenueLabels.map(l => revenueMap[l]);

        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'bar',
            data: {
                labels: revenueLabels.length ? revenueLabels : ['No Data'],
                datasets: [{
                    label: 'Revenue (₹)',
                    data: revenueValues.length ? revenueValues : [0],
                    backgroundColor: 'rgba(255, 0, 0, 0.4)',
                    borderColor: '#ff0000',
                    borderWidth: 1.5,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: '#888' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#888' }
                    }
                }
            }
        });

        // Prepare Type distribution
        const typeMap = { flight: 0, train: 0, bus: 0, cruise: 0 };
        bookings.forEach(b => {
            if (typeMap[b.travelType] !== undefined) {
                typeMap[b.travelType]++;
            }
        });

        const ctxType = document.getElementById('typeChart').getContext('2d');
        new Chart(ctxType, {
            type: 'doughnut',
            data: {
                labels: ['Flight', 'Train', 'Bus', 'Cruise'],
                datasets: [{
                    data: [typeMap.flight, typeMap.train, typeMap.bus, typeMap.cruise],
                    backgroundColor: ['#3b82f6', '#f59e0b', '#22c55e', '#8b5cf6'],
                    borderColor: '#0c0c0c',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#aaa',
                            font: { size: 11 }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    </script>
@endsection

@section('styles')
<style>
    .dashboard-root { display: flex; flex-direction: column; gap: 24px; }
    .dashboard-welcome {
      display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;
    }
    .dashboard-title { font-size: 22px; font-weight: 700; color: #fff; }
    .dashboard-subtitle { font-size: 13px; color: #666; margin-top: 2px; }
    .dashboard-date { font-size: 12px; color: #555; }

    .stats-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat-card {
      background: rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 14px;
      padding: 20px;
      transition: all 0.2s;
    }
    .stat-card:hover { border-color: rgba(255,255,255,0.1); transform: translateY(-2px); }
    .stat-card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 16px; }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    .stat-trend { font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 20px; }
    .stat-trend.positive { background: rgba(34,197,94,0.1); color: #22c55e; }
    .stat-trend.negative { background: rgba(239,68,68,0.1); color: #ef4444; }
    .stat-value { font-size: 28px; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 6px; }
    .stat-label { font-size: 13px; color: #666; font-weight: 500; }
    .stat-sub { font-size: 11px; color: #444; margin-top: 4px; }

    .dashboard-row-2 { display: grid; grid-template-columns: 1.6fr 1fr; gap: 16px; }
    .dash-card {
      background: rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 14px;
      padding: 24px;
    }
    .dash-card-header {
      display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;
    }
    .dash-card-title { font-size: 15px; font-weight: 700; color: #fff; }
    .dash-card-sub { font-size: 12px; color: #555; margin-top: 2px; }
    .dash-total-badge {
      background: rgba(255,0,0,0.08);
      border: 1px solid rgba(255,0,0,0.2);
      color: #ff6060;
      font-size: 12px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 20px;
    }
    .dash-see-all { font-size: 12px; color: #ff0000; text-decoration: none; }
    .dash-see-all:hover { color: #ff4040; }

    .travel-type-list { display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px; }
    .travel-type-item { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .travel-type-info { display: flex; align-items: center; gap: 8px; min-width: 70px; }
    .travel-type-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .travel-type-name { font-size: 13px; color: #aaa; }
    .travel-type-right { flex: 1; display: flex; align-items: center; gap: 10px; }
    .travel-type-count { font-size: 13px; font-weight: 600; color: #ddd; min-width: 28px; text-align: right; }
    .travel-type-bar-wrap { flex: 1; height: 4px; background: rgba(255,255,255,0.06); border-radius: 2px; }
    .travel-type-bar-fill { height: 100%; border-radius: 2px; transition: width 0.5s ease; }

    .role-access-panel {
      display: flex; align-items: flex-start; gap: 10px;
      background: rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 10px;
      padding: 10px 14px;
      margin-top: auto;
    }
    .role-access-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
    .role-access-role { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .role-access-desc { display: block; font-size: 11px; color: #555; margin-top: 2px; line-height: 1.5; }

    .recent-bookings-table { overflow-x: auto; }
    .booking-id { font-family: monospace; font-size: 12px; color: #ff0000; background: rgba(255,0,0,0.08); padding: 2px 8px; border-radius: 4px; }
    .customer-cell { display: flex; align-items: center; gap: 10px; }
    .customer-avatar { width: 30px; height: 30px; border-radius: 8px; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #aaa; flex-shrink: 0; }
    .customer-name { font-size: 13px; font-weight: 600; color: #ddd; }
    .customer-phone { font-size: 11px; color: #555; }
    .route-cell { font-size: 12px; color: #888; max-width: 200px; overflow: hidden; text-overflow: ellipsis; }
    .date-cell { color: #888; }
    .amount-cell { font-weight: 600; color: #22c55e; }
    .type-pill { font-size: 12px; color: #888; }

    @media (max-width: 1100px) {
      .stats-grid-4 { grid-template-columns: repeat(2, 1fr); }
      .dashboard-row-2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
      .stats-grid-4 { grid-template-columns: 1fr 1fr; }
    }
</style>
@endsection
