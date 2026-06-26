@extends('admin.layout')

@section('title', 'الصفحات')
@section('page-title', 'إدارة الصفحات')

@section('content')

<div class="row g-3">
    @foreach($pages as $page)
    @php
    $icons = ['home' => 'fas fa-home', 'about' => 'fas fa-users', 'contact' => 'fas fa-envelope', 'projects' => 'fas fa-building'];
    $labels = ['home' => 'الصفحة الرئيسية', 'about' => 'من نحن', 'contact' => 'اتصل بنا', 'projects' => 'المشاريع'];
    @endphp
    <div class="col-md-6">
        <div class="form-card d-flex align-items-center gap-3 p-3">
            <div class="stat-icon-admin stat-icon-gold" style="flex-shrink:0;">
                <i class="{{ $icons[$page] ?? 'fas fa-file' }}"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold">{{ $labels[$page] ?? $page }}</div>
                <small class="text-muted">/{{ $page }}</small>
            </div>
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-edit me-1"></i>تعديل
            </a>
        </div>
    </div>
    @endforeach
</div>

@endsection
