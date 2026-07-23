@extends('layouts.admin')

@section('title', 'Destinations & Packages')

@section('page_title', 'Destinations & Packages')
@section('page_subtitle')
    {{ count($packages) }} active pilgrimage itineraries & holiday packages
@endsection

@section('content')
<div class="dst-root">
    <div class="dst-header">
        <div></div>
        <button class="dst-add-btn" id="toggleAddBtn">+ Add Destination</button>
    </div>

    <!-- Form (Creates or Edits) -->
    <div class="dst-form-card" id="destinationForm" style="display: none;">
        <h3 class="form-card-title" id="formTitle">Create New Destination</h3>
        <form action="/admin/destinations" method="POST" id="pkgForm">
            @csrf
            <input type="hidden" name="editing_id" id="editingId" value="" />
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-lbl">Package Name *</label>
                    <input type="text" name="name" id="inName" class="form-input" placeholder="e.g. Chardham Pilgrimage" required />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Region / State *</label>
                    <input type="text" name="region" id="inRegion" class="form-input" placeholder="e.g. Uttarakhand" required />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Duration</label>
                    <input type="text" name="duration" id="inDuration" class="form-input" placeholder="e.g. 5 Nights – 6 Days" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Group Size</label>
                    <input type="text" name="groupSize" id="inGroupSize" class="form-input" placeholder="e.g. 2–12 Travelers" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Difficulty</label>
                    <select name="difficulty" id="inDifficulty" class="form-select">
                        <option value="Easy">Easy</option>
                        <option value="Moderate">Moderate</option>
                        <option value="Challenging">Challenging</option>
                        <option value="Expedition">Expedition</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-lbl">Best Season</label>
                    <input type="text" name="bestSeason" id="inBestSeason" class="form-input" placeholder="e.g. May – Oct" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Starting Price</label>
                    <input type="text" name="startingFrom" id="inStartingFrom" class="form-input" placeholder="e.g. ₹18,500" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Image Path</label>
                    <input type="text" name="imagePath" id="inImagePath" class="form-input" placeholder="/images/kedarnath.png" />
                </div>
            </div>

            <div class="form-group full-width" style="margin-top: 14px;">
                <label class="form-lbl">Tags (comma-separated)</label>
                <input type="text" name="tags" id="inTags" class="form-input" placeholder="Spiritual, Adventure, Scenic" />
            </div>

            <div class="form-grid" style="margin-top: 14px;">
                <div class="form-group">
                    <label class="form-lbl">Highlights (One item per line)</label>
                    <textarea name="highlights" id="inHighlights" rows="4" class="form-textarea" placeholder="VIP Darshan at shrine&#10;Private boat ride at Dashashwamedh"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-lbl">Package Inclusions (One item per line)</label>
                    <textarea name="includes" id="inIncludes" rows="4" class="form-textarea" placeholder="Premium hotel stays & food&#10;Station/Airport transfers"></textarea>
                </div>
            </div>

            <div class="form-group full-width" style="margin-top: 14px;">
                <label class="form-lbl">Short Tagline Description</label>
                <input type="text" name="tagline" id="inTagline" class="form-input" placeholder="Spiritual yatra with divine scenic valley views and VIP arrangements..." />
            </div>

            <div class="form-actions">
                <button type="button" class="dest-cancel-btn" id="cancelBtn">Cancel</button>
                <button type="submit" class="dest-save-btn" id="submitBtn">Create Package</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="dst-table-wrap">
        <table class="dst-table datatable-enabled">
            <thead>
                <tr>
                    <th>Destination</th>
                    <th>Region</th>
                    <th>Duration</th>
                    <th>Difficulty</th>
                    <th>Price</th>
                    <th>Tags</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody id="packagesTableBody">
                @foreach($packages as $pkg)
                    <tr class="pkg-row" data-name="{{ strtolower($pkg['name']) }}" data-region="{{ strtolower($pkg['region']) }}" data-difficulty="{{ strtolower($pkg['difficulty']) }}">
                        <td>
                            <div class="dest-info-cell">
                                <span class="dest-info-name">{{ $pkg['name'] }}</span>
                                <span class="dest-info-sub">{{ Str::limit($pkg['tagline'] ?? '', 50) }}</span>
                            </div>
                        </td>
                        <td>{{ $pkg['region'] }}</td>
                        <td>{{ $pkg['duration'] ?? '—' }}</td>
                        <td>
                            @php
                            $diff = strtolower($pkg['difficulty'] ?? 'easy');
                            @endphp
                            <span class="diff-badge {{ $diff }}">
                                {{ $pkg['difficulty'] ?? 'Easy' }}
                            </span>
                        </td>
                        <td>{{ $pkg['startingFrom'] ?? '—' }}</td>
                        <td>
                            <div class="tag-pills">
                                @if(isset($pkg['tags']) && is_array($pkg['tags']))
                                    @foreach($pkg['tags'] as $t)
                                        <span class="tag-pill">{{ $t }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons">
                                <button class="edit-btn" onclick='editPackage({!! json_encode($pkg) !!})'>Edit</button>
                                <a href="/admin/destinations/delete/{{ $pkg['id'] }}" class="delete-btn" onclick="return confirm('Delete this package?');" style="text-decoration: none;">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="dst-empty" id="noPackagesMsg" style="display: none;">No packages found.</div>
    </div>
</div>

<style>
    .dst-root { display: flex; flex-direction: column; gap: 20px; }
    .dst-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
    .dst-add-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.2s; font-family: 'DM Sans', sans-serif; }
    .dst-add-btn:hover { background: #cc0000; }

    .dst-form-card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,0,0,0.15); border-radius: 14px; padding: 24px; }
    .form-card-title { font-size: 15px; font-weight: 700; color: #fff; margin: 0 0 20px 0; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 10px; }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full-width { grid-column: 1 / -1; }
    .form-lbl { font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-input, .form-select, .form-textarea { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 10px 12px; color: #fff; font-size: 13px; outline: none; font-family: inherit; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: rgba(255,0,0,0.5); }
    .form-textarea { resize: vertical; }
    .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px; }
    .dest-cancel-btn { background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #888; border-radius: 8px; padding: 10px 20px; font-size: 13px; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .dest-save-btn { background: #ff0000; color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; }

    .dst-search-row { margin-bottom: 4px; }
    .dst-search-input { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 13px; outline: none; font-family: 'DM Sans', sans-serif; }
    .dst-search-input:focus { border-color: rgba(255,255,255,0.15); }

    .dst-table-wrap { background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; overflow-x: auto; }
    .dst-table { width: 100%; border-collapse: collapse; text-align: left; }
    .dst-table th { padding: 14px 16px; font-size: 11px; font-weight: 600; color: #555; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06); white-space: nowrap; }
    .dst-table td { padding: 14px 16px; font-size: 13px; color: #bbb; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .dst-table tr:hover td { background: rgba(255,255,255,0.02); }
    .dest-info-cell { display: flex; flex-direction: column; gap: 2px; }
    .dest-info-name { font-weight: 600; color: #fff; }
    .dest-info-sub { font-size: 11px; color: #666; }

    .diff-badge { padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 500; display: inline-block; text-transform: capitalize; }
    .diff-badge.easy { background: rgba(34,197,94,0.1); color: #22c55e; }
    .diff-badge.moderate { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .diff-badge.challenging { background: rgba(239,68,68,0.1); color: #ef4444; }
    .diff-badge.expedition { background: rgba(139,92,246,0.1); color: #8b5cf6; }

    .tag-pills { display: flex; flex-wrap: wrap; gap: 4px; }
    .tag-pill { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 4px; padding: 2px 6px; font-size: 10px; color: #999; }

    .action-buttons { display: flex; justify-content: flex-end; gap: 8px; }
    .edit-btn { background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2); color: #3b82f6; border-radius: 6px; padding: 5px 10px; font-size: 12px; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .delete-btn { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #ef4444; border-radius: 6px; padding: 5px 10px; font-size: 12px; cursor: pointer; font-family: 'DM Sans', sans-serif; }

    .dst-empty { text-align: center; padding: 48px; color: #666; font-size: 14px; }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleAddBtn = document.getElementById('toggleAddBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const destinationForm = document.getElementById('destinationForm');
    const formTitle = document.getElementById('formTitle');
    const submitBtn = document.getElementById('submitBtn');
    const pkgForm = document.getElementById('pkgForm');

    // Add Toggle
    if (toggleAddBtn) {
        toggleAddBtn.addEventListener('click', function() {
            resetForm();
            formTitle.innerText = 'Create New Destination';
            submitBtn.innerText = 'Create Package';
            destinationForm.style.display = destinationForm.style.display === 'none' ? 'block' : 'none';
        });
    }

    // Cancel Click
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            destinationForm.style.display = 'none';
            resetForm();
        });
    }

    function resetForm() {
        document.getElementById('editingId').value = '';
        document.getElementById('inName').value = '';
        document.getElementById('inRegion').value = '';
        document.getElementById('inDuration').value = '';
        document.getElementById('inGroupSize').value = '2-12';
        document.getElementById('inDifficulty').value = 'Easy';
        document.getElementById('inBestSeason').value = '';
        document.getElementById('inStartingFrom').value = '₹15,000';
        document.getElementById('inImagePath').value = '/images/kedarnath.png';
        document.getElementById('inTags').value = '';
        document.getElementById('inHighlights').value = '';
        document.getElementById('inIncludes').value = '';
        document.getElementById('inTagline').value = '';
    }

    window.editPackage = function(pkg) {
        document.getElementById('editingId').value = pkg.id;
        document.getElementById('inName').value = pkg.name;
        document.getElementById('inRegion').value = pkg.region;
        document.getElementById('inDuration').value = pkg.duration || '';
        document.getElementById('inGroupSize').value = pkg.groupSize || '';
        document.getElementById('inDifficulty').value = pkg.difficulty || 'Easy';
        document.getElementById('inBestSeason').value = pkg.bestSeason || '';
        document.getElementById('inStartingFrom').value = pkg.startingFrom || '';
        document.getElementById('inImagePath').value = pkg.imagePath || '';
        document.getElementById('inTags').value = pkg.tags ? pkg.tags.join(', ') : '';
        document.getElementById('inHighlights').value = pkg.highlights ? pkg.highlights.join('\n') : '';
        document.getElementById('inIncludes').value = pkg.includes ? pkg.includes.join('\n') : '';
        document.getElementById('inTagline').value = pkg.tagline || '';

        formTitle.innerText = 'Edit Destination Package';
        submitBtn.innerText = 'Save Changes';
        destinationForm.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

});
</script>
@endsection
