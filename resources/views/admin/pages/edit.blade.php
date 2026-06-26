@extends('admin.layout')

@section('title', 'تعديل الصفحة')
@section('page-title', 'تعديل محتوى الصفحة')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع
    </a>
</div>

<p class="text-muted mb-4">يمكنك تعديل إعدادات الصفحة هنا. للمحتوى المتقدم، استخدم <a href="{{ route('admin.settings.index') }}">الإعدادات العامة</a>.</p>

<div class="form-card">
    <div class="form-card-title"><i class="fas fa-info-circle"></i>محتوى الصفحة: {{ $page }}</div>
    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
        @csrf @method('PUT')
        @foreach($settings as $key => $value)
        <div class="mb-3">
            <label class="form-label">{{ $key }}</label>
            @if(strlen($value ?? '') > 100)
            <textarea name="{{ $key }}" class="form-control" rows="4">{{ $value }}</textarea>
            @else
            <input type="text" name="{{ $key }}" class="form-control" value="{{ $value }}">
            @endif
        </div>
        @endforeach
        <button type="submit" class="btn btn-gold">حفظ</button>
    </form>
</div>

@endsection
