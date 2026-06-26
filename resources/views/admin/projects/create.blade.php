@extends('admin.layout')

@section('title', 'إضافة مشروع')
@section('page-title', 'إضافة مشروع جديد')

@push('styles')
<style>
.nav-tabs .nav-link { color: #666; }
.nav-tabs .nav-link.active { color: var(--gold); border-bottom-color: var(--gold); font-weight: 600; }
</style>
@endpush

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع
    </a>
</div>

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

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
                    <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="tab-{{ $lang->code }}"
                        @if($lang->direction === 'rtl') dir="rtl" @endif>
                        <div class="mb-3">
                            <label class="form-label">اسم المشروع بـ {{ $lang->name_native }}
                                @if($lang->is_default)<span class="text-danger">*</span>@endif
                            </label>
                            <input type="text" name="translations[{{ $lang->code }}][title]"
                                class="form-control" {{ $lang->is_default ? 'required' : '' }}
                                placeholder="أدخل اسم المشروع...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الموقع بـ {{ $lang->name_native }}</label>
                            <input type="text" name="translations[{{ $lang->code }}][location]" class="form-control"
                                placeholder="المدينة، المنطقة...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف بـ {{ $lang->name_native }}</label>
                            <textarea name="translations[{{ $lang->code }}][description]" class="form-control" rows="5"
                                placeholder="وصف تفصيلي للمشروع..."></textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-info-circle"></i> تفاصيل المشروع</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">النوع <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="residential">سكني</option>
                            <option value="commercial">تجاري</option>
                            <option value="villa">فيلا</option>
                            <option value="apartment">شقة</option>
                            <option value="compound">مجمع سكني</option>
                            <option value="tower">برج</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="available">متاح</option>
                            <option value="under_construction">قيد الإنشاء</option>
                            <option value="coming_soon">قريباً</option>
                            <option value="sold_out">مباع بالكامل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ التسليم</label>
                        <input type="date" name="delivery_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المساحة</label>
                        <input type="text" name="area" class="form-control" placeholder="2500 م²">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">عدد الطوابق</label>
                        <input type="number" name="floors" class="form-control" min="1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">عدد الوحدات</label>
                        <input type="number" name="units" class="form-control" min="1">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-dollar-sign"></i> الأسعار</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">USD ($)</label>
                        <input type="number" name="price_usd" class="form-control" step="0.01" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">TRY (₺)</label>
                        <input type="number" name="price_try" class="form-control" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">IQD (د.ع)</label>
                        <input type="number" name="price_iqd" class="form-control" min="0">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-map-marker-alt"></i> الموقع الجغرافي</div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">خط العرض (Latitude)</label>
                        <input type="number" name="latitude" class="form-control" step="any" placeholder="41.0082">
                    </div>
                    <div class="col-6">
                        <label class="form-label">خط الطول (Longitude)</label>
                        <input type="number" name="longitude" class="form-control" step="any" placeholder="28.9784">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-list-check"></i> مميزات المشروع</div>
                <div class="row g-2 mb-2">
                    @foreach($languages as $lang)
                    <div class="col"><small class="text-muted fw-bold">{{ $lang->name_native }}</small></div>
                    @endforeach
                    <div class="col-auto"><small class="text-muted fw-bold">أيقونة</small></div>
                    <div class="col-auto" style="width:40px;"></div>
                </div>
                <div id="featuresContainer"></div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addFeatureBtn">
                    <i class="fas fa-plus me-1"></i> إضافة ميزة
                </button>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-video"></i> رابط الفيديو</div>
                <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/embed/...">
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-image"></i> الصورة الرئيسية</div>
                <input type="file" name="main_image" class="form-control" accept="image/*" id="mainImageInput">
                <div class="mt-2" id="imagePreview"></div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-toggle-on"></i> الخيارات</div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="active" value="1" checked>
                    <label class="form-check-label">مشروع نشط</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="featured" value="1">
                    <label class="form-check-label">مشروع مميز</label>
                </div>
                <div class="mt-3">
                    <label class="form-label">ترتيب العرض</label>
                    <input type="number" name="sort_order" class="form-control" value="0" min="0">
                </div>
            </div>

            <button type="submit" class="btn btn-gold w-100 py-3 fw-bold">
                <i class="fas fa-save me-2"></i> حفظ المشروع
            </button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary w-100 mt-2">إلغاء</a>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('mainImageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imagePreview').innerHTML =
                `<img src="${e.target.result}" class="img-fluid rounded mt-2" style="max-height:200px;">`;
        };
        reader.readAsDataURL(file);
    }
});

const languages = @json($languages->map(fn($l) => ['code' => $l->code, 'name' => $l->name_native, 'direction' => $l->direction]));
let featureCount = 0;

function buildFeatureRow(index) {
    let cols = languages.map(lang =>
        `<div class="col">
            <input type="text" name="features[${index}][${lang.code}]" class="form-control form-control-sm"
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

for (let i = 0; i < 3; i++) {
    document.getElementById('featuresContainer').insertAdjacentHTML('beforeend', buildFeatureRow(featureCount++));
}
</script>
@endpush
