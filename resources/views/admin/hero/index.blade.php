@extends('admin.layout')

@section('title', 'إدارة البانر الرئيسي')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0"><i class="fas fa-images me-2 text-primary"></i> إدارة البانر الرئيسي</h2>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- نوع البانر --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-bold"><i class="fas fa-toggle-on me-2"></i> نوع البانر</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.hero.type') }}" class="d-flex align-items-center gap-3">
                @csrf
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="type_static" value="static" {{ $heroType === 'static' ? 'checked' : '' }}>
                    <label class="form-check-label" for="type_static">
                        <i class="fas fa-image me-1"></i> بانر ثابت (صورة واحدة)
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="type_slider" value="slider" {{ $heroType === 'slider' ? 'checked' : '' }}>
                    <label class="form-check-label" for="type_slider">
                        <i class="fas fa-film me-1"></i> سلايدر (شرائح متعددة)
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">حفظ</button>
            </form>
            @if($heroType === 'static')
            <div class="mt-2 text-muted small"><i class="fas fa-info-circle me-1"></i> في وضع البانر الثابت، سيُعرض الشريحة الأولى فقط كصورة خلفية.</div>
            @endif
        </div>
    </div>

    {{-- إضافة شريحة جديدة --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-bold"><i class="fas fa-plus-circle me-2"></i> إضافة شريحة جديدة</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.hero.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">صورة الشريحة *</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">1920×900 أو أكبر، JPG/PNG/WebP</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">العنوان (عربي)</label>
                        <input type="text" name="title_ar" class="form-control" placeholder="مثال: عقارات فاخرة في إسطنبول">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">العنوان (English)</label>
                        <input type="text" name="title_en" class="form-control" placeholder="Luxury Real Estate in Istanbul">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">النص التوضيحي (عربي)</label>
                        <input type="text" name="subtitle_ar" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">نص الزر (عربي)</label>
                        <input type="text" name="btn_label_ar" class="form-control" placeholder="اكتشف المشاريع">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">رابط الزر</label>
                        <input type="text" name="btn_url" class="form-control" placeholder="/projects">
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">
                    <i class="fas fa-plus me-1"></i> إضافة الشريحة
                </button>
            </form>
        </div>
    </div>

    {{-- قائمة الشرائح --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold d-flex align-items-center justify-content-between">
            <span><i class="fas fa-list me-2"></i> الشرائح ({{ $slides->count() }})</span>
            <small class="text-muted">اسحب لإعادة الترتيب</small>
        </div>
        <div class="card-body p-0">
            <div id="slides-list">
                @forelse($slides as $slide)
                <div class="slide-item d-flex align-items-start gap-3 p-3 border-bottom" data-id="{{ $slide->id }}">
                    <div class="drag-handle text-muted" style="cursor:grab; padding-top:8px;"><i class="fas fa-grip-vertical fa-lg"></i></div>
                    <img src="{{ $slide->getImageUrl() }}" alt="" style="width:120px;height:68px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $slide->title_ar ?: $slide->title_en ?: 'بدون عنوان' }}</div>
                        <div class="text-muted small">{{ $slide->subtitle_ar }}</div>
                        @if($slide->btn_url)
                        <span class="badge bg-light text-dark border small">{{ $slide->btn_url }}</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge {{ $slide->active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $slide->active ? 'مفعّل' : 'مخفي' }}
                        </span>
                        <button class="btn btn-sm btn-outline-primary" onclick="editSlide({{ $slide->id }}, {{ json_encode($slide) }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.hero.destroy', $slide) }}" onsubmit="return confirm('حذف هذه الشريحة؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">لا توجد شرائح بعد. أضف الشريحة الأولى أعلاه.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editSlideModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل الشريحة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSlideForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">صورة جديدة (اختياري)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input type="hidden" name="active" value="0">
                                <input class="form-check-input" type="checkbox" name="active" value="1" id="editActive">
                                <label class="form-check-label" for="editActive">مفعّل</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">العنوان (عربي)</label>
                            <input type="text" name="title_ar" id="edit_title_ar" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">العنوان (English)</label>
                            <input type="text" name="title_en" id="edit_title_en" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">العنوان (Türkçe)</label>
                            <input type="text" name="title_tr" id="edit_title_tr" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">النص التوضيحي (عربي)</label>
                            <input type="text" name="subtitle_ar" id="edit_subtitle_ar" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">نص الزر (عربي)</label>
                            <input type="text" name="btn_label_ar" id="edit_btn_label_ar" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">رابط الزر</label>
                            <input type="text" name="btn_url" id="edit_btn_url" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// Drag & drop reorder
const list = document.getElementById('slides-list');
if (list) {
    Sortable.create(list, {
        handle: '.drag-handle',
        animation: 150,
        onEnd: function() {
            const order = [...list.querySelectorAll('.slide-item')].map(el => el.dataset.id);
            fetch('{{ route('admin.hero.reorder') }}', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body: JSON.stringify({order})
            });
        }
    });
}

function editSlide(id, slide) {
    document.getElementById('editSlideForm').action = '/admin/hero/' + id;
    document.getElementById('edit_title_ar').value    = slide.title_ar || '';
    document.getElementById('edit_title_en').value    = slide.title_en || '';
    document.getElementById('edit_title_tr').value    = slide.title_tr || '';
    document.getElementById('edit_subtitle_ar').value = slide.subtitle_ar || '';
    document.getElementById('edit_btn_label_ar').value= slide.btn_label_ar || '';
    document.getElementById('edit_btn_url').value     = slide.btn_url || '';
    document.getElementById('editActive').checked     = slide.active == 1;
    new bootstrap.Modal(document.getElementById('editSlideModal')).show();
}
</script>
@endpush
