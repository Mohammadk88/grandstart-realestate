@extends('admin.layout')

@section('title', 'دول التواصل')
@section('page-title', 'إدارة دول التواصل')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.countries.create') }}" class="btn btn-gold">
        <i class="fas fa-plus me-2"></i> إضافة دولة
    </a>
</div>

<div class="admin-table">
    <div class="admin-table-header">
        <div class="admin-table-title"><i class="fas fa-globe me-2" style="color:var(--gold)"></i> الدول وبيانات التواصل</div>
        <span class="badge bg-secondary">{{ $countries->count() }} دولة</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>الدولة</th>
                    <th>كود الدولة</th>
                    <th>الهاتف / واتساب</th>
                    <th>العملة</th>
                    <th>الحقل السعري</th>
                    <th>الافتراضية</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($countries as $country)
                <tr>
                    <td>
                        <span class="me-1">{{ $country->flag_emoji }}</span>
                        <strong>{{ $country->country_name_ar }}</strong>
                        <div class="text-muted small">{{ $country->country_name_en }}</div>
                    </td>
                    <td>
                        @if($country->country_code)
                        <span class="badge bg-dark" style="color:var(--gold)">{{ $country->country_code }}</span>
                        @else
                        <span class="text-muted small">افتراضي عام</span>
                        @endif
                    </td>
                    <td>
                        <div class="small">{{ $country->phone }}</div>
                        <div class="small text-success">{{ $country->whatsapp }}</div>
                    </td>
                    <td>
                        <span class="fw-bold">{{ $country->currency_symbol }}</span>
                        <span class="text-muted small">({{ $country->currency_code }})</span>
                    </td>
                    <td><span class="badge bg-light text-dark">{{ $country->price_field }}</span></td>
                    <td>
                        @if($country->is_default)
                        <span class="badge" style="background:var(--gold);color:#000;"><i class="fas fa-star me-1"></i> افتراضية</span>
                        @else
                        <form action="{{ route('admin.countries.set-default', $country) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary">تعيين افتراضي</button>
                        </form>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.countries.toggle-active', $country) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $country->active ? 'btn-success' : 'btn-secondary' }}">
                                {{ $country->active ? 'مفعّل' : 'معطّل' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$country->is_default)
                            <form action="{{ route('admin.countries.destroy', $country) }}" method="POST"
                                onsubmit="return confirm('حذف بيانات هذه الدولة؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">لا توجد دول مضافة</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="alert mt-3" style="background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.3);border-radius:8px;">
    <i class="fas fa-info-circle me-2" style="color:var(--gold)"></i>
    <strong>كيف يعمل النظام؟</strong> عند زيارة المستخدم للموقع، يُكتشف بلده تلقائياً، وتُعرض له بيانات التواصل الخاصة بدولته.
    إذا لم تكن دولته مضافة، يرى بيانات الدولة <strong>الافتراضية</strong>.
</div>
@endsection
