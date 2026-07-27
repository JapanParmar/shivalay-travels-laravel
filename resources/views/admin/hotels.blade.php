@extends('layouts.admin')

@section('title', 'Manage Hotels')

@section('page_title', 'Hotels Inventory')
@section('page_subtitle')
    {{ count($hotels) }} hotels in local database
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
        <button class="gd-add-btn" id="toggleAddBtn">+ Add Hotel</button>
    </div>

    <!-- Form (Creates or Edits) -->
    <div class="gd-form-card" id="hotelForm" style="display: none;">
        <h3 class="form-card-title" id="formTitle">Add New Hotel</h3>
        <form action="/admin/hotels" method="POST">
            @csrf
            <input type="hidden" name="editing_id" id="editingId" value="" />
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-lbl">Hotel Name *</label>
                    <input type="text" name="name" id="inName" class="form-input" placeholder="e.g. The Grand Shivalay Heritage" required minlength="3" maxlength="150" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Location *</label>
                    <input type="text" name="location" id="inLocation" class="form-input" placeholder="e.g. Kedarnath Valley, Uttarakhand" required minlength="3" maxlength="150" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Starting Price *</label>
                    <input type="text" name="price" id="inPrice" class="form-input" placeholder="e.g. ₹4,500 / night" required minlength="2" maxlength="50" />
                </div>
                <div class="form-group">
                    <label class="form-lbl">Rating *</label>
                    <input type="number" name="rating" id="inRating" class="form-input" placeholder="e.g. 5.0" min="1" max="5" step="0.1" required />
                </div>
                <div class="form-group full-width" style="border: 1px solid rgba(255,255,255,0.06); padding: 16px; border-radius: 10px; background: rgba(0,0,0,0.1); grid-column: 1 / -1; display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; font-weight: 600; color: #fff;">Property Gallery (Max 8 Images)</span>
                        <button type="button" id="add-slot-btn" onclick="addImageSlot()" class="gd-add-btn" style="padding: 6px 12px; font-size: 11px; margin: 0; cursor: pointer;">+ Add Image Slot</button>
                    </div>
                    
                    <!-- Hidden inputs that submit to backend -->
                    <input type="hidden" name="imagePath" id="inImagePath" value="" required />
                    <input type="hidden" name="gallery" id="inGallery" value="" />
                    
                    <!-- Dynamic slots container -->
                    <div id="gallery-slots-list" style="display: flex; flex-direction: column; gap: 10px;">
                        <!-- Rendered by JS -->
                    </div>
                </div>
                <div class="form-group full-width">
                    <label class="form-lbl">Amenities (Comma separated or one per line) *</label>
                    <textarea name="amenities" id="inAmenities" rows="2" class="form-textarea" placeholder="e.g. Hot Water 24/7, VIP Darshan Assist, Spiritual Library" required minlength="5"></textarea>
                </div>
                <div class="form-group full-width">
                    <label class="form-lbl">Description *</label>
                    <textarea name="description" id="inDescription" rows="4" class="form-textarea" placeholder="Describe the hotel details, room choices, proximity..." required minlength="10"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="gd-cancel-btn" id="cancelBtn">Cancel</button>
                <button type="submit" class="gd-save-btn" id="submitBtn">Save Hotel</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="gd-table-wrap">
        <table class="gd-table datatable-enabled">
            <thead>
                <tr>
                    <th style="width: 100px;">Photo</th>
                    <th>Hotel Info</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Rating</th>
                    <th>Amenities</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hotels as $h)
                    <tr>
                        <td>
                            <img src="{{ $h['imagePath'] }}" alt="{{ $h['name'] }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08);" />
                        </td>
                        <td>
                            <div class="guide-title-cell">
                                <span class="guide-title-text">{{ $h['name'] }}</span>
                                <span class="guide-title-sub" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $h['description'] }}</span>
                            </div>
                        </td>
                        <td>{{ $h['location'] }}</td>
                        <td><span style="color: var(--color-highlighter-lime, #22c55e); font-weight: 600;">{{ $h['price'] }}</span></td>
                        <td>⭐ {{ $h['rating'] }}</td>
                        <td>
                            <div style="display: flex; gap: 4px; flex-wrap: wrap; max-width: 200px;">
                                @foreach($h['amenities'] as $am)
                                    <span style="font-size: 10px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); padding: 2px 6px; border-radius: 4px; color: #aaa;">{{ $am }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons">
                                <button class="edit-btn" onclick='editHotel({!! json_encode($h) !!})'>Edit</button>
                                <a href="/admin/hotels/delete/{{ $h['id'] }}" class="delete-btn" onclick="return confirm('Delete this hotel?');" style="text-decoration: none;">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(count($hotels) === 0)
            <div class="gd-empty">No hotels found in the database. Add one to get started!</div>
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
    const hotelForm = document.getElementById('hotelForm');
    const formTitle = document.getElementById('formTitle');
    const submitBtn = document.getElementById('submitBtn');

    // Add Toggle
    if (toggleAddBtn) {
        toggleAddBtn.addEventListener('click', function() {
            resetForm();
            formTitle.innerText = 'Add New Hotel';
            submitBtn.innerText = 'Save Hotel';
            hotelForm.style.display = hotelForm.style.display === 'none' ? 'block' : 'none';
        });
    }

    // Cancel Click
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            hotelForm.style.display = 'none';
            resetForm();
        });
    }

    let galleryImages = []; // Array of objects: { url: string, isUploaded: boolean }

    window.renderGallerySlots = function() {
        const container = document.getElementById('gallery-slots-list');
        const addBtn = document.getElementById('add-slot-btn');
        if (!container) return;
        
        if (addBtn) {
            addBtn.disabled = galleryImages.length >= 8;
            addBtn.style.opacity = galleryImages.length >= 8 ? '0.5' : '1';
            addBtn.style.pointerEvents = galleryImages.length >= 8 ? 'none' : 'auto';
        }
        
        container.innerHTML = '';
        
        if (galleryImages.length === 0) {
            container.innerHTML = `<div style="text-align:center; padding:12px; color:#666; font-size:12px;">No images added yet. Click "+ Add Image Slot" to start.</div>`;
            updateHiddenInputs();
            return;
        }
        
        galleryImages.forEach((img, idx) => {
            const isCover = idx === 0;
            const isUploaded = img.isUploaded;
            
            const slotEl = document.createElement('div');
            slotEl.style.display = 'flex';
            slotEl.style.gap = '10px';
            slotEl.style.alignItems = 'center';
            slotEl.style.background = 'rgba(255,255,255,0.02)';
            slotEl.style.border = '1px solid rgba(255,255,255,0.06)';
            slotEl.style.padding = '8px 12px';
            slotEl.style.borderRadius = '8px';
            
            slotEl.innerHTML = `
                <!-- Index indicator & preview -->
                <div style="display:flex; flex-direction:column; align-items:center; width:60px;">
                    <span style="font-size: 9px; color:${isCover ? '#22c55e' : '#aaa'}; font-weight:600; text-transform:uppercase; margin-bottom:4px;">
                        ${isCover ? 'Cover' : 'Slot ' + (idx + 1)}
                    </span>
                    <div style="width:50px; height:35px; border-radius:4px; background:rgba(255,255,255,0.05); overflow:hidden; border:1px solid rgba(255,255,255,0.08);">
                        ${img.url ? `<img src="${img.url}" style="width:100%; height:100%; object-fit:cover;" />` : `<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:10px; color:#444;">No img</div>`}
                    </div>
                </div>
                
                <!-- URL Field / Upload -->
                <div style="flex:1; display:flex; gap:8px; align-items:center;">
                    <input 
                        type="text" 
                        class="form-input" 
                        style="flex:1; height:36px; padding:6px 10px; font-size:12px; background:${isUploaded ? 'rgba(255,255,255,0.01)' : 'rgba(255,255,255,0.04)'}; color:${isUploaded ? '#888' : '#fff'};" 
                        placeholder="Enter image URL or click upload..." 
                        value="${img.url}" 
                        oninput="updateSlotUrl(${idx}, this.value)" 
                        ${isUploaded ? 'readonly' : ''} 
                        ${isCover ? 'required' : ''}
                    />
                    
                    <label class="gd-add-btn" style="padding: 10px 12px; font-size: 11px; display: inline-flex; align-items: center; cursor: pointer; margin: 0; height:36px; line-height:16px;">
                        📁 Upload
                        <input type="file" onchange="handleSlotImageUpload(this, ${idx})" style="display: none;" accept="image/*" />
                    </label>
                </div>
                
                <!-- Reorder & Action buttons -->
                <div style="display:flex; gap:4px; align-items:center;">
                    <button type="button" onclick="moveSlotUp(${idx})" ${idx === 0 ? 'disabled style="opacity:0.3; pointer-events:none;"' : ''} class="gd-add-btn" style="padding: 6px 8px; font-size: 11px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); margin:0; cursor:pointer;">▲</button>
                    <button type="button" onclick="moveSlotDown(${idx})" ${idx === galleryImages.length - 1 ? 'disabled style="opacity:0.3; pointer-events:none;"' : ''} class="gd-add-btn" style="padding: 6px 8px; font-size: 11px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); margin:0; cursor:pointer;">▼</button>
                    <button type="button" onclick="removeImageSlot(${idx})" style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; padding: 6px 10px; border-radius: 6px; font-size: 11px; cursor: pointer;">Remove</button>
                </div>
            `;
            
            container.appendChild(slotEl);
        });
        
        updateHiddenInputs();
    };

    window.addImageSlot = function() {
        if (galleryImages.length >= 8) {
            alert('Maximum of 8 images allowed.');
            return;
        }
        galleryImages.push({ url: '', isUploaded: false });
        renderGallerySlots();
    };

    window.removeImageSlot = function(index) {
        galleryImages.splice(index, 1);
        renderGallerySlots();
    };

    window.moveSlotUp = function(index) {
        if (index === 0) return;
        const temp = galleryImages[index];
        galleryImages[index] = galleryImages[index - 1];
        galleryImages[index - 1] = temp;
        renderGallerySlots();
    };

    window.moveSlotDown = function(index) {
        if (index === galleryImages.length - 1) return;
        const temp = galleryImages[index];
        galleryImages[index] = galleryImages[index + 1];
        galleryImages[index + 1] = temp;
        renderGallerySlots();
    };

    window.updateSlotUrl = function(index, value) {
        if (galleryImages[index]) {
            galleryImages[index].url = value;
            galleryImages[index].isUploaded = value.startsWith('/uploads/');
            updateHiddenInputs();
        }
    };

    window.handleSlotImageUpload = function(inputEl, index) {
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
            galleryImages[index] = {
                url: data.url,
                isUploaded: true
            };
            renderGallerySlots();
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

    function updateHiddenInputs() {
        const mainImgInput = document.getElementById('inImagePath');
        const galleryInput = document.getElementById('inGallery');
        
        if (mainImgInput && galleryInput) {
            if (galleryImages.length > 0) {
                mainImgInput.value = galleryImages[0].url;
            } else {
                mainImgInput.value = '';
            }
            
            const remainingUrls = galleryImages.slice(1).map(img => img.url).filter(Boolean);
            galleryInput.value = remainingUrls.join(', ');
        }
    }

    function resetForm() {
        document.getElementById('editingId').value = '';
        document.getElementById('inName').value = '';
        document.getElementById('inLocation').value = '';
        document.getElementById('inPrice').value = '';
        document.getElementById('inRating').value = '';
        document.getElementById('inAmenities').value = '';
        document.getElementById('inDescription').value = '';
        
        galleryImages = [];
        renderGallerySlots();
    }

    window.editHotel = function(h) {
        document.getElementById('editingId').value = h.id;
        document.getElementById('inName').value = h.name || '';
        document.getElementById('inLocation').value = h.location || '';
        document.getElementById('inPrice').value = h.price || '';
        document.getElementById('inRating').value = h.rating || '';
        document.getElementById('inAmenities').value = (h.amenities || []).join(', ');
        document.getElementById('inDescription').value = h.description || '';

        const mainImg = h.imagePath || '';
        const galleryArray = h.gallery || [];
        
        galleryImages = [];
        if (mainImg) {
            galleryImages.push({
                url: mainImg,
                isUploaded: mainImg.startsWith('/uploads/')
            });
        }
        galleryArray.forEach(img => {
            if (img) {
                galleryImages.push({
                    url: img,
                    isUploaded: img.startsWith('/uploads/')
                });
            }
        });
        
        galleryImages = galleryImages.slice(0, 8);
        renderGallerySlots();

        formTitle.innerText = 'Edit Hotel';
        submitBtn.innerText = 'Save Changes';
        hotelForm.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
});
</script>
@endsection
