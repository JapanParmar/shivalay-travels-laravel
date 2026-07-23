@extends('layouts.admin')

@section('title', 'Travel Guides & Intel')

@section('page_title', 'Travel Guides & Intel')
@section('page_subtitle')
    Manage blogs, checklists, and cultural rules displayed in the Travel Intelligence section
@endsection

@section('content')
<div class="gd-root">
    <div class="gd-header">
        <div></div>
        <button class="gd-add-btn" id="toggleAddBtn">+ Create Article</button>
    </div>

    <!-- Form (Creates or Edits) -->
    <div class="gd-form-card" id="guideForm" style="display: none;">
        <h3 class="form-card-title" id="formTitle">Create New Guide Article</h3>
        <form action="/admin/guides" method="POST" id="pkgForm">
            @csrf
            <input type="hidden" name="editing_id" id="editingId" value="" />
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-lbl">Category *</label>
                    <select name="category" id="inCategory" class="form-select" required>
                        <option value="Packing Guide">Packing Guide</option>
                        <option value="Destination Intel">Destination Intel</option>
                        <option value="Health & Safety">Health & Safety</option>
                        <option value="Culture">Culture</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-lbl">Read Time *</label>
                    <input type="text" name="readTime" id="inReadTime" class="form-input" placeholder="e.g. 7 min read" required />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Badge Label (optional)</label>
                    <input type="text" name="badge" id="inBadge" class="form-input" placeholder="e.g. Popular, Insider, New" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Emoji Icon *</label>
                    <input type="text" name="icon" id="inIcon" class="form-input" placeholder="e.g. 🏔️, ❄️, 📋" required />
                </div>
                <div class="form-group full-width">
                    <label class="form-lbl">Image Path *</label>
                    <input type="text" name="image" id="inImage" class="form-input" placeholder="/images/ladakh.png" required />
                </div>
                <div class="form-group full-width">
                    <label class="form-lbl">Article Title *</label>
                    <textarea name="title" id="inTitle" rows="3" class="form-textarea" placeholder="The ultimate cold desert packing checklist for Ladakh..." required></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="gd-cancel-btn" id="cancelBtn">Cancel</button>
                <button type="submit" class="gd-save-btn" id="submitBtn">Create Article</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="gd-table-wrap">
        <table class="gd-table datatable-enabled">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">Icon</th>
                    <th>Article Title</th>
                    <th>Category</th>
                    <th>Read Time</th>
                    <th>Badge</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody id="guidesTableBody">
                @foreach($guides as $g)
                    <tr class="guide-row" data-title="{{ strtolower($g['title']) }}" data-category="{{ strtolower($g['category']) }}">
                        <td style="font-size: 20px; text-align: center;">{{ $g['icon'] }}</td>
                        <td>
                            <div class="guide-title-cell">
                                <span class="guide-title-text">{{ $g['title'] }}</span>
                                <span class="guide-title-sub">Image: {{ $g['image'] }}</span>
                            </div>
                        </td>
                        <td>{{ $g['category'] }}</td>
                        <td>{{ $g['readTime'] }}</td>
                        <td>
                            @if(!empty($g['badge']))
                                <span class="badge-pill">{{ $g['badge'] }}</span>
                            @else
                                <span style="color: #444;">—</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons">
                                <button class="edit-btn" onclick='editGuide({!! json_encode($g) !!})'>Edit</button>
                                <a href="/admin/guides/delete/{{ $g['id'] }}" class="delete-btn" onclick="return confirm('Delete this travel guide?');" style="text-decoration: none;">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="gd-empty" id="noGuidesMsg" style="display: none;">No travel guides found.</div>
    </div>
</div>

<style>
    .gd-root { display: flex; flex-direction: column; gap: 20px; }
    .gd-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
    .gd-add-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.2s; font-family: 'DM Sans', sans-serif; }
    .gd-add-btn:hover { background: #cc0000; }

    .gd-form-card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,0,0,0.15); border-radius: 14px; padding: 24px; }
    .form-card-title { font-size: 15px; font-weight: 700; color: #fff; margin: 0 0 20px 0; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 10px; }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full-width { grid-column: 1 / -1; }
    .form-lbl { font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-input, .form-select, .form-textarea { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 10px 12px; color: #fff; font-size: 13px; outline: none; font-family: inherit; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: rgba(255,0,0,0.5); }
    .form-textarea { resize: vertical; }
    .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px; }
    .gd-cancel-btn { background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #888; border-radius: 8px; padding: 10px 20px; font-size: 13px; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .gd-save-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; }

    .gd-search-row { margin-bottom: 4px; }
    .gd-search-input { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 13px; outline: none; font-family: 'DM Sans', sans-serif; }
    .gd-search-input:focus { border-color: rgba(255,255,255,0.15); }

    .gd-table-wrap { background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; overflow-x: auto; }
    .gd-table { width: 100%; border-collapse: collapse; text-align: left; }
    .gd-table th { padding: 14px 16px; font-size: 11px; font-weight: 600; color: #555; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06); white-space: nowrap; }
    .gd-table td { padding: 14px 16px; font-size: 13px; color: #bbb; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .gd-table tr:hover td { background: rgba(255,255,255,0.02); }
    .guide-title-cell { display: flex; flex-direction: column; gap: 2px; }
    .guide-title-text { font-weight: 600; color: #fff; }
    .guide-title-sub { font-size: 11px; color: #666; }

    .badge-pill { background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.2); color: #ff0000; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }

    .action-buttons { display: flex; justify-content: flex-end; gap: 8px; }
    .edit-btn { background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2); color: #3b82f6; border-radius: 6px; padding: 5px 10px; font-size: 12px; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .delete-btn { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #ef4444; border-radius: 6px; padding: 5px 10px; font-size: 12px; cursor: pointer; font-family: 'DM Sans', sans-serif; }

    .gd-empty { text-align: center; padding: 48px; color: #666; font-size: 14px; }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleAddBtn = document.getElementById('toggleAddBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const guideForm = document.getElementById('guideForm');
    const formTitle = document.getElementById('formTitle');
    const submitBtn = document.getElementById('submitBtn');

    // Add Toggle
    if (toggleAddBtn) {
        toggleAddBtn.addEventListener('click', function() {
            resetForm();
            formTitle.innerText = 'Create New Guide Article';
            submitBtn.innerText = 'Create Article';
            guideForm.style.display = guideForm.style.display === 'none' ? 'block' : 'none';
        });
    }

    // Cancel Click
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            guideForm.style.display = 'none';
            resetForm();
        });
    }

    function resetForm() {
        document.getElementById('editingId').value = '';
        document.getElementById('inCategory').value = 'Destination Intel';
        document.getElementById('inReadTime').value = '6 min read';
        document.getElementById('inBadge').value = '';
        document.getElementById('inImage').value = '/images/ladakh.png';
        document.getElementById('inIcon').value = '🏔️';
        document.getElementById('inTitle').value = '';
    }

    window.editGuide = function(g) {
        document.getElementById('editingId').value = g.id;
        document.getElementById('inCategory').value = g.category || 'Destination Intel';
        document.getElementById('inReadTime').value = g.readTime || '6 min read';
        document.getElementById('inBadge').value = g.badge || '';
        document.getElementById('inImage').value = g.image || '';
        document.getElementById('inIcon').value = g.icon || '';
        document.getElementById('inTitle').value = g.title || '';

        formTitle.innerText = 'Edit Travel Guide Article';
        submitBtn.innerText = 'Save Changes';
        guideForm.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
});
</script>
@endsection
