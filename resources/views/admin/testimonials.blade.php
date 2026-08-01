@extends('layouts.admin')

@section('title', 'Manage Testimonials')

@section('page_title', 'Client Testimonials')
@section('page_subtitle')
    {{ count($testimonials) }} testimonials in local database
@endsection

@section('content')
<div class="gd-root">
    @if ($errors->any())
        <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#ef4444; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
            <ul style="margin:0; padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.2); color:#22c55e; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="gd-header">
        <div></div>
        <button class="gd-add-btn" id="toggleAddBtn">+ Add Testimonial</button>
    </div>

    <!-- Form (Creates or Edits) -->
    <div class="gd-form-card" id="testimonialForm" style="display: none;">
        <h3 class="form-card-title" id="formTitle">Add New Testimonial</h3>
        <form action="/admin/testimonials" method="POST">
            @csrf
            <input type="hidden" name="editing_id" id="editingId" value="" />
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-lbl">Client Name *</label>
                    <input type="text" name="name" id="inName" class="form-input" placeholder="e.g. Rajesh Joshi" required minlength="2" maxlength="150" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Location</label>
                    <input type="text" name="location" id="inLocation" class="form-input" placeholder="e.g. Indore, Madhya Pradesh" maxlength="150" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Trip details</label>
                    <input type="text" name="trip" id="inTrip" class="form-input" placeholder="e.g. Pilgrim · 11 Nights" maxlength="150" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Rating *</label>
                    <input type="number" name="rating" id="inRating" class="form-input" placeholder="5" min="1" max="5" value="5" required />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Avatar Initials (Optional)</label>
                    <input type="text" name="avatar" id="inAvatar" class="form-input" placeholder="e.g. RJ (Auto-generated if empty)" maxlength="10" />
                </div>
                
                <div class="form-group">
                    <label class="form-lbl">Client Profile Picture (Optional)</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" name="clientImage" id="inClientImage" class="form-input" placeholder="Enter image URL or upload..." />
                        <label class="gd-add-btn" style="padding: 10px 12px; font-size: 11px; display: inline-flex; align-items: center; cursor: pointer; margin: 0; white-space: nowrap;">
                            📁 Upload
                            <input type="file" onchange="handleImageUpload(this, 'inClientImage')" style="display: none;" accept="image/*" />
                        </label>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label class="form-lbl">Trip Background Image (Optional)</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" name="image" id="inImage" class="form-input" placeholder="e.g. /images/chardham.webp (Enter URL or upload...)" />
                        <label class="gd-add-btn" style="padding: 10px 12px; font-size: 11px; display: inline-flex; align-items: center; cursor: pointer; margin: 0; white-space: nowrap;">
                            📁 Upload
                            <input type="file" onchange="handleImageUpload(this, 'inImage')" style="display: none;" accept="image/*" />
                        </label>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label class="form-lbl">Review Quote *</label>
                    <textarea name="quote" id="inQuote" rows="4" class="form-textarea" placeholder="Enter review quote/text details here..." required minlength="10"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="gd-cancel-btn" id="cancelBtn">Cancel</button>
                <button type="submit" class="gd-save-btn" id="submitBtn">Save Testimonial</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="gd-table-wrap">
        <table class="gd-table datatable-enabled">
            <thead>
                <tr>
                    <th style="width: 60px;">Client</th>
                    <th>Name / Location</th>
                    <th>Trip Details</th>
                    <th>Rating</th>
                    <th>Quote / Review</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($testimonials as $t)
                    <tr>
                        <td>
                            @if(!empty($t['clientImage']))
                                <img src="{{ $t['clientImage'] }}" alt="{{ $t['name'] }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid rgba(255,255,255,0.08);" />
                            @else
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #ff0000; font-size: 14px;">
                                    {{ $t['avatar'] ?? substr($t['name'] ?? 'A', 0, 2) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="guide-title-cell">
                                <span class="guide-title-text">{{ $t['name'] }}</span>
                                <span class="guide-title-sub">{{ $t['location'] ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $t['trip'] ?? 'N/A' }}</td>
                        <td>⭐ {{ $t['rating'] }}</td>
                        <td style="max-width: 300px; white-space: normal; font-size: 12px; color: #888;">
                            "{{ $t['quote'] }}"
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons">
                                <button class="edit-btn" data-testimonial="{{ json_encode($t) }}" onclick="editTestimonial(JSON.parse(this.getAttribute('data-testimonial')))">Edit</button>
                                <a href="/admin/testimonials/delete/{{ $t['id'] }}" class="delete-btn" onclick="return confirm('Delete this testimonial?');" style="text-decoration: none;">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(count($testimonials) === 0)
            <div class="gd-empty">No testimonials found in the database. Add one to get started!</div>
        @endif
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

    .gd-table-wrap { background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; overflow-x: auto; }
    .gd-table { width: 100%; border-collapse: collapse; text-align: left; }
    .gd-table th { padding: 14px 16px; font-size: 11px; font-weight: 600; color: #555; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid rgba(255,255,255,0.06); white-space: nowrap; }
    .gd-table td { padding: 14px 16px; font-size: 13px; color: #bbb; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
    .gd-table tr:hover td { background: rgba(255,255,255,0.02); }
    .guide-title-cell { display: flex; flex-direction: column; gap: 2px; }
    .guide-title-text { font-weight: 600; color: #fff; }
    .guide-title-sub { font-size: 11px; color: #666; }

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
    const testimonialForm = document.getElementById('testimonialForm');
    const formTitle = document.getElementById('formTitle');
    const submitBtn = document.getElementById('submitBtn');

    if (toggleAddBtn) {
        toggleAddBtn.addEventListener('click', function() {
            resetForm();
            formTitle.innerText = 'Add New Testimonial';
            submitBtn.innerText = 'Save Testimonial';
            testimonialForm.style.display = testimonialForm.style.display === 'none' ? 'block' : 'none';
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            testimonialForm.style.display = 'none';
            resetForm();
        });
    }

    window.handleImageUpload = function(inputEl, targetInputId) {
        const file = inputEl.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);

        const labelBtn = inputEl.parentElement;
        const originalText = labelBtn.textContent;
        labelBtn.textContent = '⏳ ...';
        labelBtn.style.opacity = '0.6';
        labelBtn.style.pointerEvents = 'none';

        fetch('/api/upload', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(r => {
            if (!r.ok) return r.json().then(e => { throw new Error(e.error || 'Upload failed') });
            return r.json();
        })
        .then(data => {
            document.getElementById(targetInputId).value = data.url;
        })
        .catch(err => {
            alert(err.message);
        })
        .finally(() => {
            labelBtn.textContent = originalText;
            labelBtn.style.opacity = '1';
            labelBtn.style.pointerEvents = 'auto';
            inputEl.value = '';
        });
    };

    function resetForm() {
        document.getElementById('editingId').value = '';
        document.getElementById('inName').value = '';
        document.getElementById('inLocation').value = '';
        document.getElementById('inTrip').value = '';
        document.getElementById('inRating').value = '5';
        document.getElementById('inAvatar').value = '';
        document.getElementById('inClientImage').value = '';
        document.getElementById('inImage').value = '';
        document.getElementById('inQuote').value = '';
    }

    window.editTestimonial = function(t) {
        document.getElementById('editingId').value = t.id;
        document.getElementById('inName').value = t.name || '';
        document.getElementById('inLocation').value = t.location || '';
        document.getElementById('inTrip').value = t.trip || '';
        document.getElementById('inRating').value = t.rating || '5';
        document.getElementById('inAvatar').value = t.avatar || '';
        document.getElementById('inClientImage').value = t.clientImage || '';
        document.getElementById('inImage').value = t.image || '';
        document.getElementById('inQuote').value = t.quote || '';

        formTitle.innerText = 'Edit Testimonial';
        submitBtn.innerText = 'Save Changes';
        testimonialForm.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
});
</script>
@endsection
