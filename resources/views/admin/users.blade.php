@extends('layouts.admin')

@section('title', 'Users & Roles')

@section('page_title', 'Users & Roles')
@section('page_subtitle')
    {{ count($users) }} team members
@endsection

@section('content')
@php
$ROLE_ORDER = ['super_admin', 'manager', 'agent', 'viewer'];
$ROLE_PERMISSIONS = [
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
@endphp

<div class="usr-root">
    <div class="usr-header">
        <div>
            <h1 class="usr-title" style="display: none;">Users & Roles</h1>
        </div>
        <button class="usr-add-btn" id="toggleAddBtn">+ Add User</button>
    </div>

    <!-- Role legend -->
    <div class="role-legend">
        @foreach($ROLE_ORDER as $role)
            @php
            $info = $ROLE_PERMISSIONS[$role];
            $count = count(array_filter($users, function($u) use ($role) { return ($u['role'] ?? '') === $role; }));
            @endphp
            <div class="role-legend-card" style="border-color: {{ $info['color'] }}30;">
                <div class="role-legend-top">
                    <span class="role-legend-dot" style="background: {{ $info['color'] }};"></span>
                    <span class="role-legend-name" style="color: {{ $info['color'] }};">{{ $info['label'] }}</span>
                    <span class="role-legend-count">{{ $count }}</span>
                </div>
                <div class="role-legend-perms">
                    @if($info['canManageBookings']) <span class="role-perm">Bookings</span> @endif
                    @if($info['canManageUsers']) <span class="role-perm">Users</span> @endif
                    @if($info['canManageCities']) <span class="role-perm">Cities</span> @endif
                    @if($info['canManageSettings']) <span class="role-perm">Settings</span> @endif
                    @if($info['canViewAnalytics']) <span class="role-perm">Analytics</span> @endif
                    @if($info['canDeleteRecords']) <span class="role-perm">Delete</span> @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Add form -->
    <div class="usr-add-form" id="addUserForm" style="display: none;">
        <h3 style="color: #fff; font-size: 15px; margin-bottom: 16px;">Add Team Member</h3>
        <form action="/admin/users" method="POST">
            @csrf
            <div class="usr-form-grid">
                <div>
                    <label class="usr-lbl">Full Name *</label>
                    <input class="usr-input" name="name" placeholder="Rahul Kumar" required />
                </div>
                <div>
                    <label class="usr-lbl">Email *</label>
                    <input class="usr-input" type="email" name="email" placeholder="rahul@shivalay.in" required />
                </div>
                <div>
                    <label class="usr-lbl">Password *</label>
                    <input class="usr-input" type="password" name="password" placeholder="••••••••" required />
                </div>
                <div>
                    <label class="usr-lbl">Role</label>
                    <select class="usr-select" name="role">
                        @foreach($ROLE_ORDER as $r)
                            <option value="{{ $r }}">{{ $ROLE_PERMISSIONS[$r]['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end; marginTop: 16px;">
                <button type="button" class="usr-cancel-btn" id="cancelAddBtn">Cancel</button>
                <button type="submit" class="usr-save-btn" style="margin-top: 16px;">Add User</button>
            </div>
        </form>
    </div>

    <!-- Users list -->
    <div class="usr-table-wrap">
        <table class="usr-table datatable-enabled">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    @php
                    $userRole = $u['role'] ?? 'viewer';
                    $roleInfo = $ROLE_PERMISSIONS[$userRole] ?? $ROLE_PERMISSIONS['viewer'];
                    $isSelf = ($u['id'] === session('admin_id'));
                    @endphp
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="usr-avatar" style="background: {{ $roleInfo['color'] }}25; color: {{ $roleInfo['color'] }};">
                                    {{ $u['avatar'] ?? substr($u['name'] ?? 'A', 0, 2) }}
                                </div>
                                <div>
                                    <div style="font-size: 13px; font-weight: 600; color: #ddd;">
                                        {{ $u['name'] }}
                                        @if($isSelf) <span class="usr-self-badge">You</span> @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="color: #777; font-size: 12px;">{{ $u['email'] }}</td>
                        <td>
                            @if(!$isSelf)
                                <form action="/admin/users/role/{{ $u['id'] }}" method="POST" style="display: inline;">
                                    @csrf
                                    <select class="usr-role-select" name="role" onchange="this.form.submit();">
                                        @foreach($ROLE_ORDER as $r)
                                            <option value="{{ $r }}" {{ $userRole === $r ? 'selected' : '' }}>
                                                {{ $ROLE_PERMISSIONS[$r]['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            @else
                                <span class="usr-role-pill" style="background: {{ $roleInfo['color'] }}15; color: {{ $roleInfo['color'] }}; border-color: {{ $roleInfo['color'] }}30;">
                                    {{ $roleInfo['label'] }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if(!$isSelf)
                                <form action="/admin/users/status/{{ $u['id'] }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="usr-status-btn {{ ($u['status'] ?? 'active') === 'active' ? 'active' : 'inactive' }}">
                                        <span class="usr-status-dot"></span>
                                        {{ $u['status'] ?? 'active' }}
                                    </button>
                                </form>
                            @else
                                <span class="usr-status-btn active" style="cursor: default;">
                                    <span class="usr-status-dot"></span>
                                    active
                                </span>
                            @endif
                        </td>
                        <td>
                            @if(!$isSelf)
                                <a href="/admin/users/delete/{{ $u['id'] }}" class="usr-del-btn" onclick="return confirm('Remove {{ $u['name'] }}?');" style="text-decoration: none;">Remove</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .usr-root { display: flex; flex-direction: column; gap: 20px; }
    .usr-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px; }
    .usr-title { font-size: 22px; font-weight: 700; color: #fff; }
    .usr-add-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'DM Sans',sans-serif; transition: background 0.2s; }
    .usr-add-btn:hover { background: #cc0000; }

    .role-legend { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
    .role-legend-card { background: rgba(255,255,255,0.02); border: 1px solid; border-radius: 12px; padding: 16px; }
    .role-legend-top { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    .role-legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .role-legend-name { font-size: 13px; font-weight: 700; flex: 1; }
    .role-legend-count { background: rgba(255,255,255,0.06); border-radius: 10px; padding: 1px 8px; font-size: 12px; color: #aaa; }
    .role-legend-perms { display: flex; flex-wrap: wrap; gap: 4px; }
    .role-perm { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); border-radius: 4px; padding: 2px 6px; font-size: 10px; color: #666; }

    .usr-add-form { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,0,0,0.15); border-radius: 14px; padding: 24px; }
    .usr-form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; }
    .usr-lbl { display: block; font-size: 11px; color: #555; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .usr-input { width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 9px 12px; color: #fff; font-size: 13px; outline: none; font-family: 'DM Sans',sans-serif; }
    .usr-select { width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 9px 12px; color: #aaa; font-size: 13px; outline: none; cursor: pointer; font-family: 'DM Sans',sans-serif; }
    .usr-cancel-btn { background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #666; border-radius: 8px; padding: 8px 16px; font-size: 13px; cursor: pointer; font-family: 'DM Sans',sans-serif; }
    .usr-save-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'DM Sans',sans-serif; }

    .usr-table-wrap { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; overflow-x: auto; }
    .usr-table { width: 100%; border-collapse: collapse; }
    .usr-table th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #555; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06); white-space: nowrap; }
    .usr-table td { padding: 14px 16px; font-size: 13px; color: #bbb; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .usr-table tr:last-child td { border-bottom: none; }
    .usr-table tr:hover td { background: rgba(255,255,255,0.02); }
    .usr-avatar { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
    .usr-self-badge { margin-left: 8px; background: rgba(255,0,0,0.1); color: #ff0000; font-size: 10px; padding: 1px 6px; border-radius: 10px; font-weight: 600; }
    .usr-role-pill { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; border: 1px solid; display: inline-block; }
    .usr-role-select { background: #111; border: 1px solid rgba(255,0,0,0.3); border-radius: 6px; padding: 4px 8px; color: #fff; font-size: 12px; outline: none; cursor: pointer; font-family: 'DM Sans',sans-serif; }
    .usr-status-btn { display: flex; align-items: center; gap: 6px; background: transparent; border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 4px 10px; font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'DM Sans',sans-serif; text-transform: capitalize; transition: all 0.2s; }
    .usr-status-btn.active { color: #22c55e; border-color: rgba(34,197,94,0.3); background: rgba(34,197,94,0.08); }
    .usr-status-btn.inactive { color: #ef4444; border-color: rgba(239,68,68,0.3); background: rgba(239,68,68,0.08); }
    .usr-status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .usr-del-btn { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.15); color: #ef4444; border-radius: 6px; padding: 5px 12px; font-size: 12px; cursor: pointer; font-family: 'DM Sans',sans-serif; }
    @media (max-width: 900px) {
        .role-legend { grid-template-columns: 1fr 1fr; }
        .usr-form-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleAddBtn = document.getElementById('toggleAddBtn');
    const cancelAddBtn = document.getElementById('cancelAddBtn');
    const addUserForm = document.getElementById('addUserForm');

    if (toggleAddBtn && addUserForm) {
        toggleAddBtn.addEventListener('click', function() {
            addUserForm.style.display = addUserForm.style.display === 'none' ? 'block' : 'none';
        });
    }
    if (cancelAddBtn && addUserForm) {
        cancelAddBtn.addEventListener('click', function() {
            addUserForm.style.display = 'none';
        });
    }
});
</script>
@endsection
