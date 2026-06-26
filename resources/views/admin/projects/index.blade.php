@extends('admin.layout')

@section('title', 'إدارة المشاريع')
@section('page-title', 'إدارة المشاريع')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-0">المشاريع <span class="badge bg-secondary ms-2">{{ $projects->total() }}</span></h5>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-gold">
        <i class="fas fa-plus me-1"></i> إضافة مشروع
    </a>
</div>

<!-- Filters -->
<div class="form-card mb-4">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="بحث..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="type" class="form-select form-select-sm">
                <option value="">جميع الأنواع</option>
                @foreach(['residential' => 'سكني', 'commercial' => 'تجاري', 'villa' => 'فيلا', 'apartment' => 'شقة', 'compound' => 'مجمع', 'tower' => 'برج'] as $val => $label)
                <option value="{{ $val }}" {{ request('type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">جميع الحالات</option>
                @foreach(['available' => 'متاح', 'under_construction' => 'قيد الإنشاء', 'coming_soon' => 'قريباً', 'sold_out' => 'مباع'] as $val => $label)
                <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-sm btn-gold w-100">تصفية</button>
        </div>
    </form>
</div>

<!-- Table -->
<div class="admin-table">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المشروع</th>
                    <th>النوع</th>
                    <th>الحالة</th>
                    <th>السعر</th>
                    <th>نشط</th>
                    <th>مميز</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td class="text-muted small">{{ $project->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($project->main_image)
                            <img src="{{ asset('uploads/' . $project->main_image) }}"
                                 alt="" width="40" height="40" style="border-radius:6px; object-fit:cover;">
                            @else
                            <div style="width:40px;height:40px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-building text-muted"></i>
                            </div>
                            @endif
                            <div>
                                <div class="fw-bold" style="font-size:0.875rem;">{{ Str::limit($project->getTitle(), 30) }}</div>
                                <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $project->getLocation() }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">
                            {{ match($project->type) {
                                'residential' => 'سكني', 'commercial' => 'تجاري',
                                'villa' => 'فيلا', 'apartment' => 'شقة',
                                'compound' => 'مجمع', 'tower' => 'برج', default => $project->type
                            } }}
                        </span>
                    </td>
                    <td>
                        @php
                        $sc = match($project->status) {
                            'available' => 'badge-available', 'sold_out' => 'badge-sold',
                            'under_construction' => 'badge-construction', 'coming_soon' => 'badge-soon',
                            default => 'bg-secondary'
                        };
                        $sl = match($project->status) {
                            'available' => 'متاح', 'sold_out' => 'مباع',
                            'under_construction' => 'قيد الإنشاء', 'coming_soon' => 'قريباً', default => $project->status
                        };
                        @endphp
                        <span class="badge {{ $sc }}">{{ $sl }}</span>
                    </td>
                    <td class="small">
                        @if($project->price_usd)
                        <div>${{ number_format($project->price_usd, 0) }}</div>
                        @endif
                        @if($project->price_iqd)
                        <div class="text-muted">{{ number_format($project->price_iqd, 0) }} د.ع</div>
                        @endif
                        @if(!$project->price_usd && !$project->price_iqd)
                        <span class="text-muted">عند الطلب</span>
                        @endif
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input toggle-active"
                                   data-id="{{ $project->id }}"
                                   {{ $project->active ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-xs toggle-featured p-0 border-0 bg-transparent"
                                data-id="{{ $project->id }}"
                                title="{{ $project->featured ? 'إلغاء التمييز' : 'تمييز' }}">
                            <i class="fas fa-star {{ $project->featured ? 'text-warning' : 'text-muted' }}" style="font-size:1.2rem;"></i>
                        </button>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('projects.show', $project->slug) }}" target="_blank"
                               class="btn btn-xs btn-outline-secondary py-1 px-2" title="عرض">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}"
                               class="btn btn-xs btn-outline-warning py-1 px-2" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المشروع؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-outline-danger py-1 px-2" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-building fa-2x mb-2 d-block"></i>
                        لا توجد مشاريع
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($projects->hasPages())
    <div class="d-flex justify-content-center p-3">
        {{ $projects->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
// Toggle Featured
document.querySelectorAll('.toggle-featured').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        fetch(`/admin/projects/${id}/toggle-featured`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            const icon = this.querySelector('i');
            icon.classList.toggle('text-warning', data.featured);
            icon.classList.toggle('text-muted', !data.featured);
        });
    });
});
</script>
@endpush
