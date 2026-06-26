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
                @php
                $countries = [
                    'TR' => ['ar' => 'تركيا',        'en' => 'Turkey',       'cities' => ['إسطنبول'=>'Istanbul','أنقرة'=>'Ankara','أنطاليا'=>'Antalya','إزمير'=>'Izmir','بورصة'=>'Bursa','طرابزون'=>'Trabzon','ألانيا'=>'Alanya','مرسين'=>'Mersin']],
                    'IQ' => ['ar' => 'العراق',        'en' => 'Iraq',         'cities' => ['بغداد'=>'Baghdad','أربيل'=>'Erbil','السليمانية'=>'Sulaymaniyah','النجف'=>'Najaf','كركوك'=>'Kirkuk','البصرة'=>'Basra']],
                    'AE' => ['ar' => 'الإمارات',      'en' => 'UAE',          'cities' => ['دبي'=>'Dubai','أبوظبي'=>'Abu Dhabi','الشارقة'=>'Sharjah','عجمان'=>'Ajman','رأس الخيمة'=>'Ras Al Khaimah']],
                    'SA' => ['ar' => 'السعودية',      'en' => 'Saudi Arabia', 'cities' => ['الرياض'=>'Riyadh','جدة'=>'Jeddah','مكة المكرمة'=>'Mecca','المدينة المنورة'=>'Medina','الدمام'=>'Dammam']],
                    'JO' => ['ar' => 'الأردن',        'en' => 'Jordan',       'cities' => ['عمّان'=>'Amman','إربد'=>'Irbid','الزرقاء'=>'Zarqa','العقبة'=>'Aqaba']],
                    'EG' => ['ar' => 'مصر',           'en' => 'Egypt',        'cities' => ['القاهرة'=>'Cairo','الإسكندرية'=>'Alexandria','الغردقة'=>'Hurghada','شرم الشيخ'=>'Sharm El Sheikh']],
                    'KW' => ['ar' => 'الكويت',        'en' => 'Kuwait',       'cities' => ['مدينة الكويت'=>'Kuwait City','حولي'=>'Hawalli','الجهراء'=>'Jahra']],
                    'QA' => ['ar' => 'قطر',           'en' => 'Qatar',        'cities' => ['الدوحة'=>'Doha','الريان'=>'Al Rayyan','الوكرة'=>'Al Wakra']],
                    'OTHER' => ['ar' => 'أخرى',       'en' => 'Other',        'cities' => []],
                ];
                $selectedCountry = old('country', $project->country) ?: 'TR';
                @endphp
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">الدولة <span class="text-danger">*</span></label>
                        <select name="country" id="countrySelect" class="form-select">
                            <option value="">-- اختر الدولة --</option>
                            @foreach($countries as $code => $c)
                            <option value="{{ $code }}" {{ $selectedCountry === $code ? 'selected' : '' }}>
                                {{ $c['ar'] }} — {{ $c['en'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المدينة <span class="text-danger">*</span></label>
                        <select name="city" id="citySelect" class="form-select">
                            <option value="">-- اختر المدينة --</option>
                            @foreach($countries as $code => $c)
                            @foreach($c['cities'] as $arCity => $enCity)
                            <option value="{{ $arCity }}"
                                data-country="{{ $code }}"
                                {{ old('city', $project->city) === $arCity ? 'selected' : '' }}>
                                {{ $arCity }} — {{ $enCity }}
                            </option>
                            @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المنطقة / الحي</label>
                        <input type="text" name="district" class="form-control"
                               value="{{ old('district', $project->district) }}"
                               placeholder="مثال: بشيكتاش، المرسى، وسط المدينة">
                    </div>
                </div>
                <p class="text-muted small mt-2 mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    سيتم استخدام هذه البيانات لعرض موقع المشروع في الفلاتر وصفحة المشروع.
                </p>
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
                <small class="text-muted">JPEG, PNG, WebP — الحد الأقصى 10MB للصورة</small>
            </div>

            {{-- ===== PDF FILES ===== --}}
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-file-pdf text-danger"></i> ملفات PDF (كتيبات، مخططات)</div>

                @php $existingPdfs = $project->media()->where('type','pdf')->get(); @endphp
                @if($existingPdfs->count())
                <div class="mb-3" id="pdf-list">
                    @foreach($existingPdfs as $pdf)
                    <div class="d-flex align-items-center gap-2 py-2 border-bottom" id="media-{{ $pdf->id }}">
                        <i class="fas fa-file-pdf fa-lg text-danger"></i>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-semibold text-truncate">{{ $pdf->original_name ?: basename($pdf->path) }}</div>
                            <small class="text-muted">{{ $pdf->getFileSizeFormatted() }}</small>
                        </div>
                        <button type="button" onclick="deleteMedia({{ $pdf->id }})"
                                class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="pdf-upload-zone" id="pdfUploadZone">
                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                    <p class="mb-1">اسحب ملفات PDF هنا أو <span class="text-primary" style="cursor:pointer" onclick="document.getElementById('pdfInput').click()">انقر للاختيار</span></p>
                    <small class="text-muted">PDF فقط — الحد الأقصى 20MB</small>
                    <input type="file" id="pdfInput" accept=".pdf" multiple class="d-none">
                </div>
                <div id="pdf-upload-status" class="mt-2"></div>
            </div>

            {{-- ===== VIDEO FILES ===== --}}
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-video text-primary"></i> ملفات الفيديو</div>

                @php $existingVideos = $project->media()->where('type','video')->get(); @endphp
                @if($existingVideos->count())
                <div class="mb-3" id="video-list">
                    @foreach($existingVideos as $vid)
                    <div class="d-flex align-items-center gap-2 py-2 border-bottom" id="media-{{ $vid->id }}">
                        <i class="fas fa-video fa-lg text-primary"></i>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-semibold text-truncate">{{ $vid->original_name ?: basename($vid->path) }}</div>
                            <small class="text-muted">{{ $vid->getFileSizeFormatted() }}</small>
                        </div>
                        <button type="button" onclick="deleteMedia({{ $vid->id }})"
                                class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($project->video_url)
                <div class="alert alert-info py-2 mb-3">
                    <i class="fas fa-link me-1"></i>
                    رابط YouTube/Vimeo موجود أيضاً — يمكن استخدام كليهما
                </div>
                @endif

                <div class="video-upload-zone" id="videoUploadZone">
                    <i class="fas fa-film fa-2x text-muted mb-2"></i>
                    <p class="mb-1">اسحب ملف الفيديو هنا أو <span class="text-primary" style="cursor:pointer" onclick="document.getElementById('videoInput').click()">انقر للاختيار</span></p>
                    <small class="text-muted">MP4, MOV, AVI, WebM — الحد الأقصى 200MB</small>
                    <input type="file" id="videoInput" accept=".mp4,.mov,.avi,.webm,video/*" class="d-none">
                </div>
                <div id="video-upload-status" class="mt-2"></div>
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
<style>
.pdf-upload-zone, .video-upload-zone {
    border: 2px dashed #dee2e6;
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}
.pdf-upload-zone:hover   { border-color: #dc3545; background: #fff5f5; }
.video-upload-zone:hover { border-color: #0d6efd; background: #f0f5ff; }
</style>
@endpush

@push('scripts')
<script>
// Country → City select filter
(function() {
    var countrySelect = document.getElementById('countrySelect');
    var citySelect    = document.getElementById('citySelect');
    var allOptions    = Array.from(citySelect.querySelectorAll('option[data-country]'));

    function filterCities() {
        var country = countrySelect.value;
        var current = citySelect.value;
        citySelect.innerHTML = '<option value="">-- اختر المدينة --</option>';
        allOptions.forEach(function(opt) {
            if (!country || opt.dataset.country === country) {
                var clone = opt.cloneNode(true);
                if (clone.value === current) clone.selected = true;
                citySelect.appendChild(clone);
            }
        });
    }
    countrySelect.addEventListener('change', filterCities);
    filterCities();
})();

// PDF upload
(function() {
    var zone   = document.getElementById('pdfUploadZone');
    var input  = document.getElementById('pdfInput');
    var status = document.getElementById('pdf-upload-status');
    var csrf   = document.querySelector('meta[name="csrf-token"]').content;

    zone.addEventListener('dragover', function(e) { e.preventDefault(); zone.style.borderColor='#c8a96e'; });
    zone.addEventListener('dragleave', function()  { zone.style.borderColor=''; });
    zone.addEventListener('drop', function(e) {
        e.preventDefault(); zone.style.borderColor='';
        uploadFiles(e.dataTransfer.files, '/admin/projects/{{ $project->id }}/pdfs', status);
    });
    input.addEventListener('change', function() {
        uploadFiles(this.files, '/admin/projects/{{ $project->id }}/pdfs', status);
    });

    function uploadFiles(files, url, statusEl) {
        Array.from(files).forEach(function(file) {
            var fd = new FormData();
            fd.append('pdfs[]', file);
            fd.append('_token', csrf);
            statusEl.innerHTML = '<div class="alert alert-info py-2"><i class="fas fa-spinner fa-spin me-2"></i>جاري الرفع: ' + file.name + '</div>';
            fetch(url, { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success) {
                        statusEl.innerHTML = '<div class="alert alert-success py-2"><i class="fas fa-check me-2"></i>تم رفع ' + file.name + ' بنجاح</div>';
                        setTimeout(function() { location.reload(); }, 1200);
                    } else {
                        statusEl.innerHTML = '<div class="alert alert-danger py-2">خطأ: ' + (data.message || 'فشل الرفع') + '</div>';
                    }
                })
                .catch(function() {
                    statusEl.innerHTML = '<div class="alert alert-danger py-2">خطأ في الاتصال</div>';
                });
        });
    }
})();

// Video upload
(function() {
    var zone   = document.getElementById('videoUploadZone');
    var input  = document.getElementById('videoInput');
    var status = document.getElementById('video-upload-status');
    var csrf   = document.querySelector('meta[name="csrf-token"]').content;

    zone.addEventListener('dragover', function(e) { e.preventDefault(); zone.style.borderColor='#0d6efd'; });
    zone.addEventListener('dragleave', function()  { zone.style.borderColor=''; });
    zone.addEventListener('drop', function(e) {
        e.preventDefault(); zone.style.borderColor='';
        uploadVideo(e.dataTransfer.files[0], status);
    });
    input.addEventListener('change', function() {
        if (this.files[0]) uploadVideo(this.files[0], status);
    });

    function uploadVideo(file, statusEl) {
        var fd = new FormData();
        fd.append('videos[]', file);
        fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        statusEl.innerHTML = '<div class="alert alert-info py-2"><i class="fas fa-spinner fa-spin me-2"></i>جاري رفع الفيديو... قد يستغرق بعض الوقت</div>';
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/projects/{{ $project->id }}/videos');
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var pct = Math.round(e.loaded / e.total * 100);
                statusEl.innerHTML = '<div class="alert alert-info py-2"><div class="progress mt-1" style="height:6px"><div class="progress-bar bg-primary" style="width:' + pct + '%"></div></div><small>' + pct + '% — ' + file.name + '</small></div>';
            }
        };
        xhr.onload = function() {
            var data = JSON.parse(xhr.responseText);
            if (data.success) {
                statusEl.innerHTML = '<div class="alert alert-success py-2"><i class="fas fa-check me-2"></i>تم رفع الفيديو بنجاح</div>';
                setTimeout(function() { location.reload(); }, 1200);
            } else {
                statusEl.innerHTML = '<div class="alert alert-danger py-2">خطأ: ' + (data.message || 'فشل الرفع') + '</div>';
            }
        };
        xhr.send(fd);
    }
})();

// Delete media
function deleteMedia(id) {
    if (!confirm('حذف هذا الملف نهائياً؟')) return;
    fetch('/admin/projects/{{ $project->id }}/media/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
    }).then(r => r.json()).then(function(data) {
        if (data.success) document.getElementById('media-' + id)?.remove();
    });
}
</script>
@endpush
