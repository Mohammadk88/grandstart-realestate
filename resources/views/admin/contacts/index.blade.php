@extends('admin.layout')

@section('title', 'الرسائل')
@section('page-title', 'إدارة الرسائل')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-0">الرسائل
            @if($unreadCount > 0)
            <span class="badge bg-danger ms-2">{{ $unreadCount }} غير مقروء</span>
            @endif
        </h5>
    </div>
</div>

<!-- Filters -->
<div class="form-card mb-4">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="بحث بالاسم أو الهاتف..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">جميع الرسائل</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>غير مقروءة</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>مقروءة</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="country" class="form-select form-select-sm">
                <option value="">جميع الدول</option>
                <option value="IQ" {{ request('country') === 'IQ' ? 'selected' : '' }}>العراق 🇮🇶</option>
                <option value="AE" {{ request('country') === 'AE' ? 'selected' : '' }}>الإمارات 🇦🇪</option>
                <option value="SA" {{ request('country') === 'SA' ? 'selected' : '' }}>السعودية 🇸🇦</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-sm btn-gold w-100">تصفية</button>
        </div>
    </form>
</div>

<div class="admin-table">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>البريد</th>
                    <th>المشروع</th>
                    <th>الدولة</th>
                    <th>التاريخ</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr class="{{ !$contact->is_read ? 'fw-bold' : '' }}">
                    <td class="text-muted small">{{ $contact->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if(!$contact->is_read)
                            <span class="bg-danger rounded-circle" style="width:8px;height:8px;display:inline-block;flex-shrink:0;"></span>
                            @endif
                            {{ $contact->name }}
                        </div>
                    </td>
                    <td><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></td>
                    <td>
                        @if($contact->email)
                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($contact->project)
                        <a href="{{ route('projects.show', $contact->project->slug) }}" target="_blank" class="text-decoration-none">
                            <small>{{ Str::limit($contact->project->getTitle(), 20) }}</small>
                        </a>
                        @else
                        <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td><span class="badge bg-light text-dark">{{ $contact->country_code ?: '-' }}</span></td>
                    <td><small class="text-muted">{{ $contact->created_at->format('d/m/Y') }}<br>{{ $contact->created_at->format('H:i') }}</small></td>
                    <td>
                        @if($contact->is_read)
                        <span class="badge bg-light text-success">مقروء</span>
                        @else
                        <span class="badge bg-danger">جديد</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-xs btn-outline-primary py-1 px-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($contact->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}"
                               target="_blank" class="btn btn-xs btn-outline-success py-1 px-2">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            @endif
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                                  onsubmit="return confirm('حذف هذه الرسالة؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-outline-danger py-1 px-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-envelope-open fa-2x mb-2 d-block"></i>
                        لا توجد رسائل
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
    <div class="d-flex justify-content-center p-3">
        {{ $contacts->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection
