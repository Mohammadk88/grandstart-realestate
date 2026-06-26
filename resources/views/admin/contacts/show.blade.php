@extends('admin.layout')

@section('title', 'تفاصيل الرسالة')
@section('page-title', 'تفاصيل الرسالة')

@section('content')

<div class="d-flex gap-2 mb-4">
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-envelope"></i> محتوى الرسالة</div>
            <div class="p-3 bg-light rounded" style="line-height: 1.8; font-size: 1rem;">
                {{ $contact->message }}
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-user"></i> معلومات المُرسِل</div>
            <table class="table table-sm table-borderless">
                <tr>
                    <td class="text-muted">الاسم:</td>
                    <td class="fw-bold">{{ $contact->name }}</td>
                </tr>
                <tr>
                    <td class="text-muted">الهاتف:</td>
                    <td>
                        <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                    </td>
                </tr>
                @if($contact->email)
                <tr>
                    <td class="text-muted">البريد:</td>
                    <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                </tr>
                @endif
                <tr>
                    <td class="text-muted">الدولة:</td>
                    <td>{{ $contact->country_code ?: 'غير محدد' }}</td>
                </tr>
                <tr>
                    <td class="text-muted">المصدر:</td>
                    <td>{{ $contact->source ?: '-' }}</td>
                </tr>
                @if($contact->project)
                <tr>
                    <td class="text-muted">المشروع:</td>
                    <td>
                        <a href="{{ route('projects.show', $contact->project->slug) }}" target="_blank">
                            {{ $contact->project->getTitle() }}
                        </a>
                    </td>
                </tr>
                @endif
                <tr>
                    <td class="text-muted">التاريخ:</td>
                    <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>

            <div class="d-grid gap-2 mt-3">
                @if($contact->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}?text={{ urlencode('مرحباً ' . $contact->name . '، شكراً لتواصلك مع جراند ستار للعقارات') }}"
                   target="_blank" class="btn btn-success">
                    <i class="fab fa-whatsapp me-2"></i>رد عبر واتساب
                </a>
                @endif
                @if($contact->email)
                <a href="mailto:{{ $contact->email }}" class="btn btn-outline-primary">
                    <i class="fas fa-envelope me-2"></i>رد عبر البريد
                </a>
                @endif
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                      onsubmit="return confirm('حذف هذه الرسالة؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-trash me-2"></i>حذف الرسالة
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
