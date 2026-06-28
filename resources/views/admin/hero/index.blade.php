@extends('admin.layout')
@section('title', 'إدارة البانر الرئيسي')
@section('page-title', 'إدارة البانر الرئيسي')

@push('styles')
<style>
.slide-item { transition: background 0.15s; }
.slide-item:hover { background: #fafafa; }
.drag-handle { cursor: grab; color: #ccc; }
.lang-section { border-right: 3px solid var(--gold); padding-right: 0.75rem; }
</style>
@endpush

@section('content')

{{-- نوع البانر --}}
<div class="form-card mb-4">
    <div class="form-card-title"><i class="fas fa-toggle-on"></i> نوع البانر</div>
    <form method="POST" action="{{ route('admin.hero.type') }}" class="d-flex align-items-center gap-3 flex-wrap">
        @csrf
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="type_static" value="static" {{ $heroType === 'static' ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="type_static">
                <i class="fas fa-image me-1"></i> بانر ثابت (صورة واحدة)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type" id="type_slider" value="slider" {{ $heroType === 'slider' ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="type_slider">
                <i class="fas fa-film me-1"></i> سلايدر (شرائح متعددة)
            </label>
        </div>
        <button type="submit" class="btn btn-gold btn-sm px-4">حفظ</button>
        @if($heroType === 'static')
        <span class="text-muted small"><i class="fas fa-info-circle me-1"></i>تُعرض الشريحة الأولى فقط في وضع الثابت.</span>
        @endif
    </form>
</div>

{{-- إضافة شريحة جديدة --}}
<div class="form-card mb-4">
    <div class="form-card-title"><i class="fas fa-plus-circle"></i> إضافة شريحة جديدة</div>
    <form method="POST" action="{{ route('admin.hero.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- صورة --}}
        <div class="row g-3 mb-4">
            <div class="col-md-5">
                <label class="form-label fw-semibold">صورة الشريحة <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control" accept="image/*" required id="newImageInput">
                <div class="form-text">1920×900 أو أكبر — JPG / PNG / WebP</div>
                <div id="newImagePreview" class="mt-2"></div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">رابط الزر</label>
                <input type="text" name="btn_url" class="form-control" placeholder="/projects">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="active" value="1" checked>
                    <label class="form-check-label fw-semibold">مفعّل</label>
                </div>
            </div>
        </div>

        {{-- حقول اللغات --}}
        <div class="row g-3">
            @foreach($languages as $lang)
            <div class="col-12">
                <div class="lang-section mb-1">
                    <span class="fw-bold" style="color:var(--gold);">
                        {{ $lang->name_native }}
                        <span class="text-muted fw-normal small">({{ strtoupper($lang->code) }})</span>
                        @if($lang->is_default)<span class="badge ms-1" style="background:var(--gold);color:#000;font-size:0.65em;">افتراضي</span>@endif
                    </span>
                </div>
                <div class="row g-2" @if($lang->direction === 'rtl') dir="rtl" @endif>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">العنوان</label>
                        <input type="text" name="title_{{ $lang->code }}"
                               class="form-control" dir="{{ $lang->direction }}"
                               placeholder="{{ $lang->direction === 'rtl' ? 'عقارات فاخرة في إسطنبول' : 'Luxury Real Estate in Istanbul' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">النص التوضيحي</label>
                        <input type="text" name="subtitle_{{ $lang->code }}"
                               class="form-control" dir="{{ $lang->direction }}"
                               placeholder="{{ $lang->direction === 'rtl' ? 'استثمار عقاري مميز...' : 'Premium real estate investment...' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">نص الزر</label>
                        <input type="text" name="btn_label_{{ $lang->code }}"
                               class="form-control" dir="{{ $lang->direction }}"
                               placeholder="{{ $lang->direction === 'rtl' ? 'اكتشف المشاريع' : 'View Projects' }}">
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-gold px-5 fw-bold">
                <i class="fas fa-plus me-2"></i> إضافة الشريحة
            </button>
        </div>
    </form>
</div>

{{-- قائمة الشرائح --}}
<div class="admin-table">
    <div class="admin-table-header">
        <div class="admin-table-title"><i class="fas fa-images text-warning me-2"></i> الشرائح ({{ $slides->count() }})</div>
        <span class="text-muted small"><i class="fas fa-grip-vertical me-1"></i>اسحب لإعادة الترتيب</span>
    </div>
    <div id="slides-list">
        @forelse($slides as $slide)
        <div class="slide-item d-flex align-items-center gap-3 p-3 border-bottom" data-id="{{ $slide->id }}">
            <div class="drag-handle"><i class="fas fa-grip-vertical fa-lg"></i></div>
            <img src="{{ $slide->getImageUrl() }}" alt=""
                 style="width:110px; height:62px; object-fit:cover; border-radius:6px; border:1px solid #eee; flex-shrink:0;">
            <div class="flex-grow-1" style="min-width:0;">
                <div class="fw-semibold" style="font-size:0.9rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $slide->title_ar ?: $slide->title_en ?: 'بدون عنوان' }}
                </div>
                <div class="text-muted small" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $slide->subtitle_ar }}
                </div>
                <div class="d-flex gap-1 mt-1 flex-wrap">
                    @foreach($languages as $lang)
                    @php $t = $slide->{'title_'.$lang->code}; @endphp
                    @if($t)
                    <span class="badge" style="background:#f0f0f0; color:#555; font-size:0.65rem;">{{ strtoupper($lang->code) }}</span>
                    @endif
                    @endforeach
                    @if($slide->btn_url)
                    <span class="badge" style="background:#e8f4fd; color:#1d72b8; font-size:0.65rem;">{{ $slide->btn_url }}</span>
                    @endif
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                <span class="badge {{ $slide->active ? 'bg-success' : 'bg-secondary' }}">
                    {{ $slide->active ? 'مفعّل' : 'مخفي' }}
                </span>
                <button class="btn btn-sm btn-outline-secondary"
                        onclick="openEdit({{ $slide->id }}, {{ json_encode($slide->toArray()) }})">
                    <i class="fas fa-edit"></i>
                </button>
                <form method="POST" action="{{ route('admin.hero.destroy', $slide) }}"
                      onsubmit="return confirm('حذف هذه الشريحة؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
        @empty
        <div class="p-5 text-center text-muted">
            <i class="fas fa-images fa-2x mb-2 d-block"></i>
            لا توجد شرائح بعد. أضف الشريحة الأولى أعلاه.
        </div>
        @endforelse
    </div>
</div>

{{-- ══════ Modal التعديل ══════ --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--dark2); color:#fff;">
                <h5 class="modal-title"><i class="fas fa-edit me-2" style="color:var(--gold);"></i>تعديل الشريحة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">

                    {{-- صورة + إعدادات --}}
                    <div class="row g-3 mb-4 pb-3" style="border-bottom:1px solid #f0f0f0;">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">صورة جديدة (اختياري)</label>
                            <input type="file" name="image" class="form-control" accept="image/*" id="editImageInput">
                            <div id="editImagePreview" class="mt-2"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">رابط الزر</label>
                            <input type="text" name="btn_url" id="edit_btn_url" class="form-control" placeholder="/projects">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input type="hidden" name="active" value="0">
                                <input class="form-check-input" type="checkbox" name="active" value="1" id="edit_active">
                                <label class="form-check-label fw-semibold" for="edit_active">مفعّل</label>
                            </div>
                        </div>
                    </div>

                    {{-- حقول اللغات ديناميكياً --}}
                    @foreach($languages as $lang)
                    <div class="mb-4">
                        <div class="lang-section mb-2">
                            <span class="fw-bold" style="color:var(--gold);">
                                {{ $lang->name_native }}
                                <span class="text-muted fw-normal small">({{ strtoupper($lang->code) }})</span>
                                @if($lang->is_default)<span class="badge ms-1" style="background:var(--gold);color:#000;font-size:0.65em;">افتراضي</span>@endif
                            </span>
                        </div>
                        <div class="row g-2" @if($lang->direction === 'rtl') dir="rtl" @endif>
                            <div class="col-md-4">
                                <label class="form-label small text-muted mb-1">العنوان</label>
                                <input type="text"
                                       name="title_{{ $lang->code }}"
                                       id="edit_title_{{ $lang->code }}"
                                       class="form-control"
                                       dir="{{ $lang->direction }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted mb-1">النص التوضيحي</label>
                                <input type="text"
                                       name="subtitle_{{ $lang->code }}"
                                       id="edit_subtitle_{{ $lang->code }}"
                                       class="form-control"
                                       dir="{{ $lang->direction }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted mb-1">نص الزر</label>
                                <input type="text"
                                       name="btn_label_{{ $lang->code }}"
                                       id="edit_btn_label_{{ $lang->code }}"
                                       class="form-control"
                                       dir="{{ $lang->direction }}">
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-gold fw-bold px-5">
                        <i class="fas fa-save me-2"></i>حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// ── Drag & drop reorder ─────────────────────────────────────
Sortable.create(document.getElementById('slides-list'), {
    handle: '.drag-handle',
    animation: 150,
    onEnd: function() {
        const order = [...document.querySelectorAll('.slide-item')].map(el => el.dataset.id);
        fetch('{{ route('admin.hero.reorder') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ order })
        });
    }
});

// ── Image preview (new slide) ───────────────────────────────
document.getElementById('newImageInput').addEventListener('change', function() {
    const f = this.files[0];
    if (!f) return;
    const r = new FileReader();
    r.onload = e => {
        document.getElementById('newImagePreview').innerHTML =
            `<img src="${e.target.result}" style="max-height:100px;border-radius:6px;border:1px solid #eee;">`;
    };
    r.readAsDataURL(f);
});

// ── Image preview (edit) ────────────────────────────────────
document.getElementById('editImageInput').addEventListener('change', function() {
    const f = this.files[0];
    if (!f) return;
    const r = new FileReader();
    r.onload = e => {
        document.getElementById('editImagePreview').innerHTML =
            `<img src="${e.target.result}" style="max-height:80px;border-radius:6px;border:1px solid #eee;">`;
    };
    r.readAsDataURL(f);
});

// ── Open edit modal ─────────────────────────────────────────
@php $langCodes = $languages->pluck('code')->toArray(); @endphp
const langCodes = @json($langCodes);

function openEdit(id, slide) {
    document.getElementById('editForm').action = '/admin/hero/' + id;

    // Reset image preview
    document.getElementById('editImagePreview').innerHTML = '';
    document.getElementById('editImageInput').value = '';

    // Common fields
    document.getElementById('edit_btn_url').value = slide.btn_url || '';
    document.getElementById('edit_active').checked = slide.active == 1;

    // Per-language fields
    langCodes.forEach(function(code) {
        const titleEl    = document.getElementById('edit_title_'     + code);
        const subtitleEl = document.getElementById('edit_subtitle_'  + code);
        const btnEl      = document.getElementById('edit_btn_label_' + code);

        if (titleEl)    titleEl.value    = slide['title_'     + code] || '';
        if (subtitleEl) subtitleEl.value = slide['subtitle_'  + code] || '';
        if (btnEl)      btnEl.value      = slide['btn_label_' + code] || '';
    });

    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
