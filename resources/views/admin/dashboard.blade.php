@extends('layouts.admin')

@section('title', 'Owner Dashboard')

@section('page_title', 'Owner Dashboard')
@section('page_subtitle')
    Real-time monitoring of ticket transits, property bookings, and sacred temple yatras.
@endsection

@section('content')
    @php
        // Pending action counts
        $pendingBookings = count(array_filter($bookings, function($b) { return ($b['status'] ?? '') === 'pending'; }));
        $pendingInquiries = count(array_filter($inquiries, function($i) { return ($i['status'] ?? '') === 'pending'; }));
        $totalPending = $pendingBookings + $pendingInquiries;

        // Revenue intake (Confirmed/completed transits)
        $revenue = collect($bookings)->where('status', '!=', 'cancelled')->sum('amount');
        $fmtRevenue = $revenue >= 100000 
            ? '₹' . number_format($revenue / 100000, 2) . ' Lakh'
            : ($revenue >= 1000 ? '₹' . number_format($revenue / 1000, 0) . 'K' : '₹' . $revenue);

        // Lodging & Yatra inquiries pipeline
        $totalInq = count($inquiries);
        $confirmedInq = count(array_filter($inquiries, function($i) { return in_array($i['status'] ?? '', ['confirmed', 'completed']); }));
        $confirmedBkg = count(array_filter($bookings, function($b) { return in_array($b['status'] ?? '', ['confirmed', 'completed']); }));

        // Conversion success rates
        $totalRequests = count($bookings) + $totalInq;
        $totalSuccess = $confirmedBkg + $confirmedInq;
        $successRate = $totalRequests ? round(($totalSuccess / $totalRequests) * 100) : 0;
    @endphp

    <!-- Statistics Grid -->
    <div class="stats-grid-4">
        <!-- Revenue Card -->
        <div class="stat-card" style="border-color: rgba(34,197,94,0.2);">
            <div class="stat-card-top">
                <div class="stat-icon" style="background: rgba(34,197,94,0.12); color: #22c55e;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23" /><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" /></svg>
                </div>
                <div class="stat-trend positive">
                    Live
                </div>
            </div>
            <div class="stat-value" style="color: #22c55e;">{{ $fmtRevenue }}</div>
            <div class="stat-label">Gross Transit Revenue</div>
            <div class="stat-sub">Excluding property quotes</div>
        </div>

        <!-- Follow-ups Card -->
        <div class="stat-card" style="border-color: rgba(255,0,0,0.2);">
            <div class="stat-card-top">
                <div class="stat-icon" style="background: rgba(255,0,0,0.12); color: #ff0000;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /></svg>
                </div>
                <div class="stat-trend {{ $totalPending > 0 ? 'negative' : 'positive' }}">
                    {{ $totalPending > 0 ? 'Urgent' : 'Clear' }}
                </div>
            </div>
            <div class="stat-value" style="color: #ff3333;">{{ $totalPending }}</div>
            <div class="stat-label">Pending Follow-ups</div>
            <div class="stat-sub">{{ $pendingBookings }} transits · {{ $pendingInquiries }} properties</div>
        </div>

        <!-- Property Inquiries Card -->
        <div class="stat-card" style="border-color: rgba(245,158,11,0.2);">
            <div class="stat-card-top">
                <div class="stat-icon" style="background: rgba(245,158,11,0.12); color: #f59e0b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <div class="stat-trend positive" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                    Inquiries
                </div>
            </div>
            <div class="stat-value" style="color: #f59e0b;">{{ $totalInq }}</div>
            <div class="stat-label">Yatras &amp; Stays Pipeline</div>
            <div class="stat-sub">{{ $confirmedInq }} bookings converted</div>
        </div>

        <!-- Success Conversion Card -->
        <div class="stat-card" style="border-color: rgba(59,130,246,0.2);">
            <div class="stat-card-top">
                <div class="stat-icon" style="background: rgba(59,130,246,0.12); color: #3b82f6;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" /><path d="M22 4L12 14.01l-3-3" /></svg>
                </div>
                <div class="stat-trend positive">
                    ↑ 4.2%
                </div>
            </div>
            <div class="stat-value" style="color: #3b82f6;">{{ $successRate }}%</div>
            <div class="stat-label">Combined Conversion</div>
            <div class="stat-sub">Target conversion: 80%</div>
        </div>
    </div>

    <!-- Charts and Breakdown -->
    <div class="dashboard-row-2" style="margin-bottom: 24px;">
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <h3 class="dash-card-title">Estimated Transit Intake Trend (₹)</h3>
                    <p class="dash-card-sub">Daily ticketing volumes</p>
                </div>
            </div>
            <div style="height: 240px; position: relative;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="dash-card" style="display: flex; flex-direction: column;">
            <div class="dash-card-header">
                <h3 class="dash-card-title">Core Business Split</h3>
                <p class="dash-card-sub">Ticketing vs Lodging vs Yatras</p>
            </div>
            <div style="height: 180px; position: relative; margin-bottom: 12px;">
                <canvas id="bizSplitChart"></canvas>
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

    <!-- Dual Action Tables Grid -->
    <div class="dashboard-tables-grid" style="margin-bottom: 32px;">
        <!-- Left Column: Recent Lodging & Tour Inquiries -->
        <div class="table-container">
            <div class="table-header">
                <div>
                    <h3 class="table-title" style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #ff0000; flex-shrink: 0;"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="9" y1="22" x2="9" y2="16"/><line x1="15" y1="22" x2="15" y2="16"/><line x1="9" y1="16" x2="15" y2="16"/><path d="M8 6h2M8 10h2M14 6h2M14 10h2"/></svg>
                        Lodging &amp; Yatra Inquiries
                    </h3>
                    <p style="font-size: 11px; color: #555; margin-top: 2px;">Property and custom pilgrimage requests</p>
                </div>
                <a href="/admin/inquiries" class="btn-link">View All</a>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Destinations / Lodging</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(array_slice($inquiries, 0, 5) as $i)
                        @php
                            // Clean phone number for WhatsApp
                            $cleanPhone = preg_replace('/[^0-9]/', '', $i['customerPhone'] ?? '');
                            if (strlen($cleanPhone) === 10) {
                                $cleanPhone = '91' . $cleanPhone;
                            }
                            $waMessage = rawurlencode("Hello " . ($i['customerName'] ?? 'Guest') . ", this is Shivalay Travels. We received your inquiry for " . ($i['destinations'] ?? 'your trip') . ". How can we assist you today?");
                            $waUrl = "https://wa.me/{$cleanPhone}?text={$waMessage}";
                        @endphp
                        <tr>
                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar">{{ substr($i['customerName'] ?? 'G', 0, 1) }}</div>
                                    <div>
                                        <div class="customer-name">{{ $i['customerName'] }}</div>
                                        <div class="customer-phone">{{ $i['customerPhone'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 12px; color: #ccc; font-weight: 500;">
                                    {{ Str::limit($i['destinations'] ?? 'Custom Package', 25) }}
                                </div>
                                <div style="font-size: 10px; color: #555; margin-top: 2px;">
                                    {{ $i['accommodation'] ?? 'Standard' }} · {{ $i['travelers'] ?? 1 }} Pax
                                </div>
                            </td>
                            <td>
                                <span class="status-pill status-{{ $i['status'] ?? 'pending' }}" style="font-size: 10px; padding: 2px 6px;">
                                    {{ $i['status'] ?? 'pending' }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ $waUrl }}" target="_blank" class="wa-btn">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="margin-right:2px;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    Chat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--color-muted); padding: 40px; font-size: 13px;">No inquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Right Column: Recent Transit Bookings -->
        <div class="table-container">
            <div class="table-header">
                <div>
                    <h3 class="table-title" style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #ff0000; flex-shrink: 0;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /></svg>
                        Transit Bookings
                    </h3>
                    <p style="font-size: 11px; color: #555; margin-top: 2px;">Flight, train, bus &amp; cruise transits</p>
                </div>
                <a href="/admin/bookings" class="btn-link">View All</a>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Route &amp; Transit</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(array_slice($bookings, 0, 5) as $b)
                        <tr>
                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar">{{ substr($b['customerName'] ?? 'B', 0, 1) }}</div>
                                    <div>
                                        <div class="customer-name">{{ $b['customerName'] }}</div>
                                        <div class="customer-phone">{{ $b['customerPhone'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 12px; color: #ccc; font-weight: 500;">
                                    {{ $b['fromCity'] }} → {{ $b['toCity'] }}
                                </div>
                                <div style="font-size: 10px; color: #555; margin-top: 2px;">
                                    @if($b['travelType'] == 'flight')
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 2px; color: #3b82f6;"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4Z"/></svg> Flight
                                    @elseif($b['travelType'] == 'train')
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 2px; color: #a855f7;"><rect x="4" y="3" width="16" height="16" rx="2"/><path d="M4 11h16M12 3v8M8 19l-2 3M16 19l2 3"/></svg> Train
                                    @elseif($b['travelType'] == 'bus')
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 2px; color: #f59e0b;"><rect x="4" y="4" width="16" height="12" rx="2"/><path d="M4 10h16M8 16h8M6 20h2M16 20h2"/></svg> Bus
                                    @else
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align: middle; margin-right: 2px; color: #06b6d4;"><path d="M2 21h20M19.3 14.8C21.1 13.5 22 12.1 22 10.8c0-2-2.5-3.3-6.5-3.3-3 0-5.5.8-8 1.8L3 6v9.8c0 1 1 1.7 2.2 1.7L12 17.5l7.3-2.7z"/></svg> Cruise
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #22c55e; font-size: 12px;">
                                    ₹{{ number_format($b['amount']) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-pill status-{{ $b['status'] }}" style="font-size: 10px; padding: 2px 6px;">
                                    {{ $b['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--color-muted); padding: 40px; font-size: 13px;">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Prepare Revenue Chart Data
        const bookings = @json($bookings);
        const inquiries = @json($inquiries);
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

        // Core business split calculation (Ticketing vs Lodging vs Yatras/Tours)
        const bizSplitMap = { Ticketing: 0, Lodging: 0, Tours: 0 };
        bookings.forEach(b => {
            bizSplitMap.Ticketing++;
        });

        inquiries.forEach(inq => {
            const acc = (inq.accommodation || '').toLowerCase();
            const dest = (inq.destinations || '').toLowerCase();
            if (acc.includes('hotel') || dest.includes('hotel') || acc.includes('villa') || dest.includes('villa')) {
                bizSplitMap.Lodging++;
            } else {
                bizSplitMap.Tours++;
            }
        });

        const ctxBizSplit = document.getElementById('bizSplitChart').getContext('2d');
        new Chart(ctxBizSplit, {
            type: 'doughnut',
            data: {
                labels: ['Ticketing transits', 'Hotels & Villas', 'Pilgrimage Tours'],
                datasets: [{
                    data: [bizSplitMap.Ticketing, bizSplitMap.Lodging, bizSplitMap.Tours],
                    backgroundColor: ['#3b82f6', '#a3e635', '#b8882a'],
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
                            font: { size: 10 }
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
    .stat-value { font-size: 26px; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 6px; }
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

    .dashboard-tables-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .table-container {
      background: rgba(255,255,255,0.01);
      border: 1px solid rgba(255,255,255,0.05);
      border-radius: 14px;
      padding: 20px;
      overflow-x: auto;
    }
    .table-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .table-title { font-size: 14px; font-weight: 700; color: #fff; }
    .btn-link { font-size: 11px; color: #ff0000; text-decoration: none; font-weight: 600; }
    .btn-link:hover { color: #ff4040; }

    .admin-table { width: 100%; border-collapse: collapse; text-align: left; }
    .admin-table th { padding: 10px; font-size: 10px; font-weight: 600; color: #555; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06); }
    .admin-table td { padding: 12px 10px; border-bottom: 1px solid rgba(255,255,255,0.04); font-size: 13px; color: #bbb; vertical-align: middle; }
    .admin-table tr:hover td { background: rgba(255,255,255,0.01); }

    .customer-cell { display: flex; align-items: center; gap: 8px; }
    .customer-avatar { width: 28px; height: 28px; border-radius: 6px; background: rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #aaa; flex-shrink: 0; }
    .customer-name { font-size: 12px; font-weight: 600; color: #ddd; }
    .customer-phone { font-size: 10px; color: #555; margin-top: 1px; }

    .wa-btn {
      background: rgba(34,197,94,0.08);
      border: 1px solid rgba(34,197,94,0.18);
      color: #22c55e;
      border-radius: 6px;
      padding: 4px 8px;
      font-size: 11px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 3px;
      font-weight: 600;
      transition: all 0.2s;
    }
    .wa-btn:hover {
      background: rgba(34,197,94,0.15);
      border-color: rgba(34,197,94,0.3);
      color: #38a169;
    }

    @media (max-width: 1100px) {
      .stats-grid-4 { grid-template-columns: repeat(2, 1fr); }
      .dashboard-row-2 { grid-template-columns: 1fr; }
      .dashboard-tables-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
      .stats-grid-4 { grid-template-columns: 1fr; }
    }
</style>
@endsection
