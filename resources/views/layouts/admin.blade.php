@php
$role = session('admin_role', 'viewer');
$rolePermissions = [
    'super_admin' => [
        'label' => 'Super Admin',
        'color' => '#ff0000',
        'canManageBookings' => true,
        'canManageUsers' => true,
        'canManageCities' => true,
        'canManageSettings' => true,
        'canViewAnalytics' => true,
        'canDeleteRecords' => true,
    ],
    'manager' => [
        'label' => 'Manager',
        'color' => '#f59e0b',
        'canManageBookings' => true,
        'canManageUsers' => false,
        'canManageCities' => true,
        'canManageSettings' => false,
        'canViewAnalytics' => true,
        'canDeleteRecords' => true,
    ],
    'agent' => [
        'label' => 'Agent',
        'color' => '#3b82f6',
        'canManageBookings' => true,
        'canManageUsers' => false,
        'canManageCities' => false,
        'canManageSettings' => false,
        'canViewAnalytics' => false,
        'canDeleteRecords' => false,
    ],
    'viewer' => [
        'label' => 'Viewer',
        'color' => '#6b7280',
        'canManageBookings' => false,
        'canManageUsers' => false,
        'canManageCities' => false,
        'canManageSettings' => false,
        'canViewAnalytics' => true,
        'canDeleteRecords' => false,
    ],
];
$currentPerms = $rolePermissions[$role] ?? $rolePermissions['viewer'];
$email = session('admin_email', '');
$isDev = ($email === 'dev@shivalay.in');

try {
    $pendingBookingsCount = \App\Models\Booking::where('status', 'pending')->count();
    $pendingInquiriesCount = \App\Models\Inquiry::where('status', 'pending')->count();
} catch (\Exception $e) {
    $pendingBookingsCount = 0;
    $pendingInquiriesCount = 0;
}
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — Shivalay Travels</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@8.0.1/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@8.0.1" type="text/javascript"></script>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif
    <style>
        :root {
            --color-primary: #ff0000;
            --color-bg: #060608;
            --color-surface: #0a0a0c;
            --color-card: rgba(255, 255, 255, 0.02);
            --color-border: rgba(255, 255, 255, 0.06);
            --color-border-hover: rgba(255, 255, 255, 0.12);
            --color-text: #e2e8f0;
            --color-muted: #6b7280;
            --color-text-dim: #4b5563;
            --radius-md: 8px;
            --radius-lg: 14px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
            overflow-x: hidden;
            min-height: 100vh;
        }

        .admin-shell {
            display: flex;
            min-height: 100vh;
            background: #060608;
        }

        /* ── Sidebar ── */
        .admin-sidebar {
            display: flex;
            flex-direction: column;
            background: #0a0a0c;
            border-right: 1px solid rgba(255,255,255,0.06);
            transition: width 0.3s cubic-bezier(0.16,1,0.3,1);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            overflow: hidden;
        }
        .admin-sidebar.open { width: 240px; }
        .admin-sidebar.collapsed { width: 64px; }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            min-height: 64px;
            position: relative;
        }
        .sidebar-logo-icon {
            width: 36px; height: 36px;
            background: #ff0000;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 0 16px rgba(255,0,0,0.3);
            font-weight: bold;
            font-size: 16px;
        }
        .sidebar-brand { flex: 1; min-width: 0; }
        .sidebar-brand-name {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
            white-space: nowrap;
        }
        .sidebar-brand-sub {
            display: block;
            font-size: 10px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .sidebar-toggle {
            width: 24px; height: 24px;
            border-radius: 6px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            color: #555;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.2s;
            margin-left: auto;
        }
        .sidebar-toggle:hover { color: #fff; border-color: rgba(255,255,255,0.15); }

        .sidebar-nav {
            flex: 1;
            padding: 16px 8px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            overflow-y: auto;
        }
        .sidebar-nav-label {
            font-size: 10px;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 8px 8px;
            white-space: nowrap;
        }
        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 8px;
            color: #666;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
            position: relative;
        }
        .sidebar-nav-item:hover { background: rgba(255,255,255,0.04); color: #ccc; }
        .sidebar-nav-item.active { background: rgba(255,0,0,0.08); color: #ff0000; }
        .sidebar-nav-item.active .sidebar-nav-icon { color: #ff0000; }
        .sidebar-nav-icon { flex-shrink: 0; display: flex; align-items: center; }
        .sidebar-nav-text { flex: 1; }
        .sidebar-badge {
            background: #ff0000;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 20px;
            flex-shrink: 0;
        }

        .sidebar-user {
            padding: 12px 8px;
            border-top: 1px solid rgba(255,255,255,0.05);
            position: relative;
        }
        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
        }
        .sidebar-user-card:hover { background: rgba(255,255,255,0.04); }
        .sidebar-avatar {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-name {
            display: block; font-size: 13px; font-weight: 600; color: #ddd;
            overflow: hidden; text-overflow: ellipsis;
        }
        .sidebar-user-role { display: block; font-size: 11px; }

        .sidebar-user-menu {
            position: absolute;
            bottom: 100%;
            left: 8px; right: 8px;
            background: #111;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 8px;
            margin-bottom: 4px;
            display: none;
            z-index: 105;
        }
        .user-menu-email {
            font-size: 11px;
            color: #444;
            padding: 4px 8px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            margin-bottom: 6px;
            overflow: hidden; text-overflow: ellipsis;
        }
        .user-menu-item {
            display: flex; align-items: center; gap: 8px;
            width: 100%; padding: 8px 10px;
            border-radius: 6px; font-size: 13px; color: #aaa;
            cursor: pointer; transition: all 0.15s;
            background: transparent;
            border: none;
            text-align: left;
            font-family: 'DM Sans', sans-serif;
        }
        .user-menu-item:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .user-menu-item.danger { color: #ff6060; }
        .user-menu-item.danger:hover { background: rgba(255,0,0,0.08); color: #ff4040; }

        /* ── Main ── */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 240px;
            transition: margin-left 0.3s cubic-bezier(0.16,1,0.3,1);
            min-width: 0;
        }
        .admin-sidebar.collapsed ~ .admin-main {
            margin-left: 64px;
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            height: 64px;
            background: rgba(6,6,8,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .topbar-title-wrap {
            display: flex;
            flex-direction: column;
        }
        .topbar-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }
        .topbar-subtitle {
            font-size: 11px;
            color: var(--color-muted);
        }
        .topbar-right {
            display: flex; align-items: center; gap: 12px;
        }
        .topbar-role-badge {
            display: flex; align-items: center; gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid;
            font-size: 12px;
            font-weight: 600;
        }
        .role-badge-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
        }
        .topbar-site-link {
            display: flex; align-items: center; gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            color: #888;
            font-size: 12px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .topbar-site-link:hover { color: #fff; border-color: rgba(255,255,255,0.2); }

        .admin-content {
            flex: 1;
            padding: 28px;
            overflow-x: hidden;
        }

        @media (max-width: 768px) {
            .admin-sidebar { display: none; }
            .admin-main { margin-left: 0 !important; }
            .admin-content { padding: 16px; }
        }

        /* ── Simple-DataTables Custom Premium Dark Theme ── */
        .datatable-wrapper {
            width: 100%;
        }
        .datatable-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 0 16px 0;
            gap: 12px;
        }
        .datatable-selector {
            background: #0f0f12 !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            color: #bbb !important;
            padding: 8px 12px !important;
            border-radius: 8px !important;
            outline: none !important;
            font-size: 13px !important;
            cursor: pointer !important;
            font-family: inherit;
        }
        .datatable-selector:focus {
            border-color: #ff0000 !important;
        }
        .datatable-input {
            background: #0f0f12 !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            color: #fff !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            outline: none !important;
            font-size: 13px !important;
            width: 260px !important;
            font-family: inherit;
        }
        .datatable-input::placeholder {
            color: #444 !important;
        }
        .datatable-input:focus {
            border-color: rgba(255,0,0,0.5) !important;
        }
        .datatable-container {
            background: rgba(255, 255, 255, 0.01) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 12px !important;
            overflow-x: auto !important;
            margin-bottom: 16px !important;
        }
        .datatable-table {
            border-collapse: collapse !important;
            width: 100% !important;
            text-align: left !important;
        }
        .datatable-table th {
            background: rgba(255, 255, 255, 0.01) !important;
            color: #555 !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 14px 16px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
            cursor: pointer !important;
        }
        .datatable-table th a {
            color: inherit !important;
            text-decoration: none !important;
        }
        .datatable-table td {
            padding: 14px 16px !important;
            font-size: 13px !important;
            color: #bbb !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
            vertical-align: middle !important;
        }
        .datatable-table tbody tr:hover td {
            background: rgba(255, 255, 255, 0.02) !important;
        }
        .datatable-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px !important;
            background: rgba(255,255,255,0.01) !important;
            border: 1px solid rgba(255,255,255,0.05) !important;
            border-radius: 10px !important;
        }
        .datatable-info {
            font-size: 12px !important;
            color: #555 !important;
        }
        .datatable-pagination {
            display: flex !important;
            gap: 4px !important;
        }
        .datatable-pagination ul {
            display: flex !important;
            list-style: none !important;
            gap: 4px !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .datatable-pagination a {
            background: rgba(255,255,255,0.03) !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            color: #ccc !important;
            border-radius: 6px !important;
            padding: 6px 12px !important;
            font-size: 12px !important;
            cursor: pointer !important;
            text-decoration: none !important;
            transition: all 0.2s !important;
            display: inline-block !important;
        }
        .datatable-pagination a:hover {
            border-color: rgba(255,0,0,0.4) !important;
            color: #ff0000 !important;
            background: rgba(255,0,0,0.05) !important;
        }
        .datatable-pagination .active a {
            background: #ff0000 !important;
            border-color: #ff0000 !important;
            color: #fff !important;
            font-weight: bold !important;
        }
        .datatable-pagination .disabled a {
            opacity: 0.4 !important;
            cursor: not-allowed !important;
            pointer-events: none !important;
        }

        /* ── Common Admin UI Styles ── */
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        @media (max-width: 1024px) {
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 640px) {
            .grid-4 {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 24px;
            transition: all 0.2s ease;
        }
        .card:hover {
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 18px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-primary {
            background: #ff0000;
            color: #fff;
        }
        .btn-primary:hover {
            background: #cc0000;
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
        }
        .btn-secondary:hover {
            border-color: rgba(255, 0, 0, 0.4);
            color: #ff0000;
            background: rgba(255, 0, 0, 0.05);
        }
        .btn-danger {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }
        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #ff6b6b;
        }

        /* Tables & Table Container */
        .table-container {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            overflow-x: auto;
            margin-bottom: 24px;
        }
        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(255, 255, 255, 0.01);
        }
        .table-title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        .admin-table th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            white-space: nowrap;
        }
        .admin-table td {
            padding: 14px 16px;
            font-size: 13px;
            color: #bbb;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            white-space: nowrap;
            vertical-align: middle;
        }
        .admin-table tr:last-child td {
            border-bottom: none;
        }
        .admin-table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Status Pills */
        .status-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid;
            text-transform: capitalize;
        }
        .status-pill.status-confirmed, .status-pill.status-active {
            background: rgba(34, 197, 94, 0.1) !important;
            color: #22c55e !important;
            border-color: rgba(34, 197, 94, 0.3) !important;
        }
        .status-pill.status-pending {
            background: rgba(245, 158, 11, 0.1) !important;
            color: #f59e0b !important;
            border-color: rgba(245, 158, 11, 0.3) !important;
        }
        .status-pill.status-cancelled, .status-pill.status-inactive {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
        }
        .status-pill.status-completed, .status-pill.status-contacted {
            background: rgba(59, 130, 246, 0.1) !important;
            color: #3b82f6 !important;
            border-color: rgba(59, 130, 246, 0.3) !important;
        }

        /* Modal & Form Elements */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            align-items: center;
            justify-content: center;
            z-index: 999;
            padding: 20px;
            backdrop-filter: blur(4px);
        }
        .modal-card {
            background: #0c0c0c;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            width: 100%;
            max-width: 580px;
            overflow: hidden;
            animation: modalIn 0.2s ease;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            padding: 24px;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.97); }
            to { opacity: 1; transform: none; }
        }
        .modal-title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 14px;
        }
        .form-label {
            font-size: 11px;
            color: #555;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            padding: 8px 12px;
            color: #fff;
            font-size: 13px;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            width: 100%;
        }
        .form-input:focus {
            border-color: rgba(255, 0, 0, 0.4);
            background: rgba(255, 255, 255, 0.05);
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
        }
    </style>
    @yield('styles')
</head>
<body>

    <div class="admin-shell">
        <!-- Sidebar -->
        <aside class="admin-sidebar open">
            <!-- Logo -->
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">S</div>
                <div class="sidebar-brand">
                    <span class="sidebar-brand-name">SHIVALAY</span>
                    <span class="sidebar-brand-sub">Admin Portal</span>
                </div>
                <button class="sidebar-toggle" title="Toggle sidebar">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
            </div>

            <!-- Nav -->
            <nav class="sidebar-nav">
                <span class="sidebar-nav-label">Main Menu</span>
                
                <a href="/admin/dashboard" class="sidebar-nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1" /><rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" /><rect x="3" y="14" width="7" height="7" rx="1" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Dashboard</span>
                </a>

                <a href="/admin/bookings" class="sidebar-nav-item {{ Request::is('admin/bookings') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" /><line x1="16" y1="13" x2="8" y2="13" /><line x1="16" y1="17" x2="8" y2="17" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Bookings</span>
                    @if($pendingBookingsCount > 0)
                        <span class="sidebar-badge">{{ $pendingBookingsCount }}</span>
                    @endif
                </a>

                <a href="/admin/inquiries" class="sidebar-nav-item {{ Request::is('admin/inquiries') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Yatra Inquiries</span>
                    @if($pendingInquiriesCount > 0)
                        <span class="sidebar-badge">{{ $pendingInquiriesCount }}</span>
                    @endif
                </a>

                @if($currentPerms['canManageCities'])
                <a href="/admin/cities" class="sidebar-nav-item {{ Request::is('admin/cities') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" /><line x1="2" y1="12" x2="22" y2="12" />
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Cities & Routes</span>
                </a>
                <a href="/admin/hotels" class="sidebar-nav-item {{ Request::is('admin/hotels*') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
                            <line x1="9" y1="22" x2="9" y2="16"/>
                            <line x1="15" y1="22" x2="15" y2="16"/>
                            <line x1="9" y1="16" x2="15" y2="16"/>
                            <path d="M8 6h2M8 10h2M14 6h2M14 10h2"/>
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Hotels</span>
                </a>
                <a href="/admin/villas" class="sidebar-nav-item {{ Request::is('admin/villas*') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Villas</span>
                </a>
                @endif

                @if($currentPerms['canManageUsers'])
                <a href="/admin/users" class="sidebar-nav-item {{ Request::is('admin/users') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Users & Roles</span>
                </a>
                @endif

                @if($currentPerms['canViewAnalytics'])
                <a href="/admin/analytics" class="sidebar-nav-item {{ Request::is('admin/analytics') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10" /><line x1="12" y1="20" x2="12" y2="4" />
                            <line x1="6" y1="20" x2="6" y2="14" /><line x1="2" y1="20" x2="22" y2="20" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Analytics</span>
                </a>
                @endif

                @if($isDev)
                <a href="/admin/destinations" class="sidebar-nav-item {{ Request::is('admin/destinations') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Destinations</span>
                </a>
                <a href="/admin/guides" class="sidebar-nav-item {{ Request::is('admin/guides') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Travel Guides</span>
                </a>
                @endif

                @if($currentPerms['canManageSettings'])
                <a href="/admin/settings" class="sidebar-nav-item {{ Request::is('admin/settings') ? 'active' : '' }}">
                    <span class="sidebar-nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                    </span>
                    <span class="sidebar-nav-text">Settings</span>
                </a>
                @endif
            </nav>

            <!-- User section -->
            <div class="sidebar-user">
                <div class="sidebar-user-card" role="button" tabIndex="0">
                    <div class="sidebar-avatar" style="background: {{ $currentPerms['color'] }}">
                        {{ substr(session('admin_name', 'A'), 0, 2) }}
                    </div>
                    <div class="sidebar-user-info">
                        <span class="sidebar-user-name">{{ session('admin_name', 'Admin') }}</span>
                        <span class="sidebar-user-role" style="color: {{ $currentPerms['color'] }}">{{ $currentPerms['label'] }}</span>
                    </div>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </div>

                <div class="sidebar-user-menu">
                    <div class="user-menu-email">{{ $email }}</div>
                    <a href="/" class="user-menu-item" style="text-decoration: none;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style="vertical-align: middle; margin-right: 4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" /><polyline points="9 22 9 12 15 12 15 22" /></svg>
                        Main Website
                    </a>
                    <a href="/admin/logout" class="user-menu-item danger" style="text-decoration: none;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style="vertical-align: middle; margin-right: 4px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" /><polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" /></svg>
                        Sign Out
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="admin-main">
            <!-- Top bar -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <div class="topbar-title-wrap">
                        <h2 class="topbar-title">@yield('page_title', 'Shivalay Travels')</h2>
                        <span class="topbar-subtitle">@yield('page_subtitle', 'Admin Portal Dashboard')</span>
                    </div>
                </div>
                <div class="topbar-right">
                    <div class="topbar-role-badge" style="border-color: {{ $currentPerms['color'] }}; color: {{ $currentPerms['color'] }};">
                        <span class="role-badge-dot" style="background: {{ $currentPerms['color'] }};"></span>
                        {{ $currentPerms['label'] }}
                    </div>
                    <a href="/" class="topbar-site-link" target="_blank">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" /><polyline points="15 3 21 3 21 9" /><line x1="10" y1="14" x2="21" y2="3" /></svg>
                        Live Site
                    </a>
                </div>
            </header>

            <!-- Content -->
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.admin-sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const toggleIcon = toggleBtn.querySelector('svg');
            
            toggleBtn.addEventListener('click', function() {
                if (sidebar.classList.contains('open')) {
                    sidebar.classList.remove('open');
                    sidebar.classList.add('collapsed');
                    toggleIcon.innerHTML = '<path d="M9 18l6-6-6-6" />';
                    localStorage.setItem('sidebar_state', 'collapsed');
                } else {
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.add('open');
                    toggleIcon.innerHTML = '<path d="M15 18l-6-6 6-6" />';
                    localStorage.setItem('sidebar_state', 'open');
                }
            });

            // Restore state
            const savedState = localStorage.getItem('sidebar_state');
            if (savedState === 'collapsed') {
                sidebar.classList.remove('open');
                sidebar.classList.add('collapsed');
                toggleIcon.innerHTML = '<path d="M9 18l6-6-6-6" />';
            }

            // Toggle user menu
            const userCard = document.querySelector('.sidebar-user-card');
            const userMenu = document.querySelector('.sidebar-user-menu');
            if (userCard && userMenu) {
                userCard.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isVisible = userMenu.style.display === 'block';
                    userMenu.style.display = isVisible ? 'none' : 'block';
                });
                document.addEventListener('click', function() {
                    userMenu.style.display = 'none';
                });
            }

            // Initialize simple-datatables on .datatable-enabled tables
            const tables = document.querySelectorAll('.datatable-enabled');
            tables.forEach(table => {
                new simpleDatatables.DataTable(table, {
                    searchable: true,
                    fixedHeight: false,
                    perPage: 10,
                    labels: {
                        placeholder: "Search...",
                        perPage: "{select} entries per page",
                        noRows: "No entries found",
                        info: "Showing {start} to {end} of {rows} entries",
                    }
                });
            });
        });
    </script>

    <!-- Global Toast Notification Banner -->
    @if(session('success') || session('error') || $errors->any())
        <div id="global-toast" class="global-toast {{ session('error') || $errors->any() ? 'toast-error' : 'toast-success' }}">
            <div class="toast-content">
                <span class="toast-icon">
                    @if(session('error') || $errors->any())
                        ⚠️
                    @else
                        ✓
                    @endif
                </span>
                <span class="toast-message">
                    @if(session('success'))
                        {{ session('success') }}
                    @elseif(session('error'))
                        {{ session('error') }}
                    @else
                        {{ $errors->first() }}
                    @endif
                </span>
            </div>
            <button class="toast-close" onclick="closeGlobalToast()">&times;</button>
        </div>

        <style>
            .global-toast {
                position: fixed;
                bottom: 24px;
                right: 24px;
                background: #18181b;
                border: 1px solid rgba(255,255,255,0.08);
                color: #fff;
                padding: 14px 18px;
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                display: flex;
                align-items: center;
                gap: 12px;
                z-index: 10000;
                transform: translateY(150%);
                opacity: 0;
                animation: toastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                font-family: system-ui, -apple-system, sans-serif;
                font-size: 13px;
                min-width: 300px;
                max-width: 420px;
            }
            .global-toast.toast-success {
                border-left: 4px solid var(--color-highlighter-lime, #a3e635);
            }
            .global-toast.toast-error {
                border-left: 4px solid #ef4444;
            }
            .toast-content {
                display: flex;
                align-items: center;
                gap: 10px;
                flex: 1;
            }
            .toast-icon {
                font-size: 16px;
            }
            .toast-message {
                line-height: 1.4;
                font-weight: 500;
            }
            .toast-close {
                background: none;
                border: none;
                color: rgba(255,255,255,0.4);
                font-size: 20px;
                cursor: pointer;
                padding: 0 4px;
                transition: color 0.15s;
                line-height: 1;
            }
            .toast-close:hover {
                color: #fff;
            }
            @keyframes toastSlideIn {
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
            @keyframes toastSlideOut {
                to {
                    transform: translateY(150%);
                    opacity: 0;
                }
            }
        </style>

        <script>
            function closeGlobalToast() {
                const toast = document.getElementById('global-toast');
                if (toast) {
                    toast.style.animation = 'toastSlideOut 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards';
                    setTimeout(() => toast.remove(), 350);
                }
            }
            // Auto dismiss toast after 6 seconds
            setTimeout(closeGlobalToast, 6000);
        </script>
    @endif

    @yield('scripts')
</body>
</html>
