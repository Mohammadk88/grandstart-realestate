@extends('admin.layout')

@section('title', 'تعديل مشروع')
@section('page-title', 'تعديل: ' . $project->getTitle())

@push('styles')
<style>
.nav-tabs .nav-link { color: #666; }
.nav-tabs .nav-link.active { color: var(--gold); border-bottom-color: var(--gold); font-weight: 600; }
.upload-area { border: 2px dashed #dee2e6; border-radius: 8px; cursor: pointer; overflow: hidden; }
.upload-area:hover { border-color: var(--gold); }
</style>
@endpush

@section('content')
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع
    </a>
    <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-eye me-1"></i> عرض على الموقع
    </a>
</div>

<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="row g-4">
        <!-- Language Tabs -->
        <div class="col-12">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-language"></i> محتوى المشروع (حسب اللغة)</div>

                <ul class="nav nav-tabs mb-3">
                    @foreach($languages as $i => $lang)
                    <li class="nav-item">
                        <button class="nav-link {{ $i === 0 ? 'active' : '' }}" type="button"
                            data-bs-toggle="tab" data-bs-target="#tab-{{ $lang->code }}">
                            {{ $lang->name_native }}
                            @if($lang->is_default)
                            <span class="badge ms-1" style="background:var(--gold);color:#000;font-size:0.65em;">افتراضي</span>
                            @endif
                        </button>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($languages as $i => $lang)
                    @php $t = $project->translations->firstWhere('locale', $lang->code); @endphp
                    <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="tab-{{ $lang->code }}"
                        @if($lang->direction === 'rtl') dir="rtl" @endif>
                        <div class="mb-3">
                            <label class="form-label">اسم المشروع بـ {{ $lang->name_native }}
                                @if($lang->is_default)<span class="text-danger">*</span>@endif
                            </label>
                            <input type="text" name="translations[{{ $lang->code }}][title]"
                                class="form-control" {{ $lang->is_default ? 'required' : '' }}
                                value="{{ old("translations.{$lang->code}.title", $t?->title) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الموقع بـ {{ $lang->name_native }}</label>
                            <input type="text" name="translations[{{ $lang->code }}][location]" class="form-control"
                                value="{{ old("translations.{$lang->code}.location", $t?->location) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف بـ {{ $lang->name_native }}</label>
                            <textarea name="translations[{{ $lang->code }}][description]" class="form-control" rows="5">{{ old("translations.{$lang->code}.description", $t?->description) }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-dollar-sign"></i> الأسعار</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">USD ($)</label>
                        <input type="number" name="price_usd" class="form-control" step="0.01" min="0"
                            value="{{ old('price_usd', $project->price_usd) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">TRY (₺)</label>
                        <input type="number" name="price_try" class="form-control" min="0"
                            value="{{ old('price_try', $project->price_try) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">IQD (د.ع)</label>
                        <input type="number" name="price_iqd" class="form-control" min="0"
                            value="{{ old('price_iqd', $project->price_iqd) }}">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-info-circle"></i> تفاصيل المشروع</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">المساحة</label>
                        <input type="text" name="area" class="form-control" value="{{ old('area', $project->area) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الطوابق</label>
                        <input type="number" name="floors" class="form-control" value="{{ old('floors', $project->floors) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الوحدات</label>
                        <input type="number" name="units" class="form-control" value="{{ old('units', $project->units) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تاريخ التسليم</label>
                        <input type="date" name="delivery_date" class="form-control"
                            value="{{ old('delivery_date', $project->delivery_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رابط الفيديو</label>
                        <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $project->video_url) }}">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-map-marker-alt"></i> الموقع الجغرافي</div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">خط العرض (Latitude)</label>
                        <input type="number" name="latitude" id="input-lat" class="form-control" step="any"
                               value="{{ old('latitude', $project->latitude) }}"
                               placeholder="مثال: 41.0082">
                    </div>
                    <div class="col-6">
                        <label class="form-label">خط الطول (Longitude)</label>
                        <input type="number" name="longitude" id="input-lng" class="form-control" step="any"
                               value="{{ old('longitude', $project->longitude) }}"
                               placeholder="مثال: 28.9784">
                    </div>
                </div>
                <p class="text-muted small mb-2"><i class="fas fa-info-circle me-1"></i> انقر على الخريطة لتحديد موقع المشروع تلقائياً، أو أدخل الإحداثيات يدوياً.</p>
                <div id="admin-pick-map" style="height:320px;border-radius:10px;border:1px solid #dee2e6;"></div>
            </div>

            <!-- Features -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-list-check"></i> مميزات المشروع</div>
                <div class="row g-2 mb-2">
                    @foreach($languages as $lang)
                    <div class="col"><small class="text-muted fw-bold">{{ $lang->name_native }}</small></div>
                    @endforeach
                    <div class="col-auto"><small class="text-muted fw-bold">أيقونة</small></div>
                    <div class="col-auto" style="width:40px;"></div>
                </div>
                <div id="featuresContainer">
                    @foreach($project->features as $i => $feature)
                    <div class="feature-row row g-2 mb-2 align-items-center" id="fr{{ $i }}">
                        @foreach($languages as $lang)
                        @php $ft = $feature->translations->firstWhere('locale', $lang->code); @endphp
                        <div class="col">
                            <input type="text" name="features[{{ $i }}][{{ $lang->code }}]"
                                class="form-control form-control-sm"
                                dir="{{ $lang->direction }}"
                                value="{{ $ft?->text }}"
                                placeholder="{{ $lang->name_native }}">
                        </div>
                        @endforeach
                        <div class="col-auto">
                            <input type="text" name="features[{{ $i }}][icon]"
                                class="form-control form-control-sm"
                                value="{{ $feature->icon }}" style="width:130px;">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.feature-row').remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addFeatureBtn">
                    <i class="fas fa-plus me-1"></i> إضافة ميزة
                </button>
            </div>

            <!-- Gallery Images -->
            @if($project->images->count())
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-images"></i> معرض الصور الحالي</div>
                <div class="row g-2" id="galleryImages">
                    @foreach($project->images as $image)
                    <div class="col-3 col-md-2" id="image-{{ $image->id }}">
                        <div class="position-relative">
                            <img src="{{ $image->getUrl() }}" alt="" class="img-fluid rounded">
                            <button type="button" onclick="deleteImage({{ $image->id }})"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0"
                                style="width:20px;height:20px;font-size:10px;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-upload"></i> رفع صور إضافية</div>
                <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*">
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-tag"></i> التصنيف</div>
                <div class="mb-3">
                    <label class="form-label">النوع <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        @foreach(['residential' => 'سكني', 'commercial' => 'تجاري', 'villa' => 'فيلا', 'apartment' => 'شقة', 'compound' => 'مجمع', 'tower' => 'برج'] as $val => $label)
                        <option value="{{ $val }}" {{ old('type', $project->type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">الحالة <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['available' => 'متاح', 'under_construction' => 'قيد الإنشاء', 'coming_soon' => 'قريباً', 'sold_out' => 'مباع'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $project->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">ترتيب العرض</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $project->sort_order) }}">
                </div>
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" class="form-check-input" name="active" value="1" {{ old('active', $project->active) ? 'checked' : '' }}>
                    <label class="form-check-label">نشط</label>
                </div>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" name="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }}>
                    <label class="form-check-label">مميز</label>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-image"></i> الصورة الرئيسية</div>
                @if($project->main_image)
                <img src="{{ asset('uploads/' . $project->main_image) }}" alt="" class="img-fluid rounded mb-2">
                @endif
                <div class="upload-area" id="uploadArea">
                    <div class="upload-placeholder text-center py-2">
                        <i class="fas fa-cloud-upload-alt text-muted mb-1 d-block"></i>
                        <small class="text-muted">تغيير الصورة</small>
                    </div>
                    <img id="imgPreview" src="" style="display:none; max-width:100%; border-radius:8px;">
                    <input type="file" name="main_image" id="mainImageInput" class="d-none" accept="image/*">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-gold btn-lg">
                    <i class="fas fa-save me-2"></i> حفظ التغييرات
                </button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const uploadArea = document.getElementById('uploadArea');
const mainImageInput = document.getElementById('mainImageInput');
const imgPreview = document.getElementById('imgPreview');
uploadArea.addEventListener('click', () => mainImageInput.click());
mainImageInput.addEventListener('change', function() {
    if (this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            imgPreview.src = e.target.result;
            imgPreview.style.display = 'block';
            uploadArea.querySelector('.upload-placeholder').style.display = 'none';
        };
        reader.readAsDataURL(this.files[0]);
    }
});

function deleteImage(id) {
    if (!confirm('حذف هذه الصورة؟')) return;
    fetch(`/admin/projects/{{ $project->id }}/images/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    }).then(r => r.json()).then(data => {
        if (data.success) document.getElementById(`image-${id}`)?.remove();
    });
}

const languages = @json($languages->map(fn($l) => ['code' => $l->code, 'name' => $l->name_native, 'direction' => $l->direction]));
let featureCount = {{ $project->features->count() }};

function buildFeatureRow(index) {
    let cols = languages.map(lang =>
        `<div class="col">
            <input type="text" name="features[${index}][${lang.code}]"
                class="form-control form-control-sm"
                placeholder="${lang.name}" dir="${lang.direction}">
        </div>`
    ).join('');
    return `<div class="feature-row row g-2 mb-2 align-items-center" id="fr${index}">
        ${cols}
        <div class="col-auto">
            <input type="text" name="features[${index}][icon]" class="form-control form-control-sm"
                value="fas fa-check" style="width:130px;">
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('fr${index}').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>`;
}

document.getElementById('addFeatureBtn').addEventListener('click', function() {
    document.getElementById('featuresContainer').insertAdjacentHTML('beforeend', buildFeatureRow(featureCount++));
});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV/XN/WLcE=" crossorigin="anonymous"></script>
<script>
(function() {
    var latInput = document.getElementById('input-lat');
    var lngInput = document.getElementById('input-lng');
    var initLat  = parseFloat(latInput.value) || 41.0082;
    var initLng  = parseFloat(lngInput.value) || 28.9784;
    var zoom     = (latInput.value && lngInput.value) ? 13 : 5;

    var map = L.map('admin-pick-map').setView([initLat, initLng], zoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors', maxZoom: 18
    }).addTo(map);

    var marker = null;
    if (latInput.value && lngInput.value) {
        marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
        bindDrag(marker);
    }

    map.on('click', function(e) {
        setCoords(e.latlng.lat, e.latlng.lng);
        if (marker) { marker.setLatLng(e.latlng); }
        else { marker = L.marker(e.latlng, { draggable: true }).addTo(map); bindDrag(marker); }
    });

    [latInput, lngInput].forEach(function(inp) {
        inp.addEventListener('change', function() {
            var lat = parseFloat(latInput.value), lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                map.setView([lat, lng], 13);
                if (marker) { marker.setLatLng([lat, lng]); }
                else { marker = L.marker([lat, lng], { draggable: true }).addTo(map); bindDrag(marker); }
            }
        });
    });

    function bindDrag(m) {
        m.on('dragend', function(e) {
            var ll = e.target.getLatLng();
            setCoords(ll.lat, ll.lng);
        });
    }
    function setCoords(lat, lng) {
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
    }
})();
</script>
@endpush
