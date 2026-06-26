@extends('admin.layout')
@section('title', 'تفاصيل العميل')
@section('page-title', 'ملف العميل')

@push('styles')
<style>
.crm-status-badge { display:inline-flex; align-items:center; gap:5px; padding:5px 14px; border-radius:20px; font-size:0.82rem; font-weight:600; }
.info-row { display:flex; gap:1rem; padding:0.5rem 0; border-bottom:1px solid #f5f5f5; font-size:0.9rem; }
.info-label { color:#888; min-width:120px; font-weight:600; flex-shrink:0; }
.crm-panel { position:sticky; top:80px; }
</style>
@endpush

@section('content')
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع للقائمة
    </a>
    @if($currentAdmin->hasPermission('contacts.delete'))
    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}"
          onsubmit="return confirm('حذف هذا الاستفسار نهائياً؟')" class="ms-auto">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash me-1"></i> حذف
        </button>
    </form>
    @endif
</div>

<div class="row g-4">
    {{-- Left: Contact Info + Message --}}
    <div class="col-lg-7">

        <div class="form-card">
            <div class="form-card-title">
                <i class="fas fa-user"></i> بيانات العميل
                @if(!$contact->is_read)
                <span class="badge ms-2" style="background:#3b82f620; color:#3b82f6; font-size:0.7rem;">جديد</span>
                @endif
            </div>

            @if($contact->contact_number)
            <div class="info-row">
                <span class="info-label">رقم العميل</span>
                <span class="badge" style="background:var(--gold)20; color:var(--gold); border:1px solid var(--gold)40; font-size:0.85rem; font-weight:700; letter-spacing:1px;">{{ $contact->contact_number }}</span>
            </div>
            @endif
            <div class="info-row"><span class="info-label">الاسم</span> {{ $contact->name }}</div>
            @if($contact->email)
            <div class="info-row">
                <span class="info-label">البريد</span>
                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
            </div>
            @endif
            @if($contact->phone)
            <div class="info-row">
                <span class="info-label">الهاتف</span>
                <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                &nbsp;
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" target="_blank"
                   class="btn btn-sm" style="background:#25D366; color:#fff; padding:2px 8px; border-radius:6px; font-size:0.75rem;">
                    <i class="fab fa-whatsapp me-1"></i>واتساب
                </a>
            </div>
            @endif
            @if($contact->country_code)
            <div class="info-row"><span class="info-label">الدولة</span> 🌍 {{ $contact->country_code }}</div>
            @endif
            @if($contact->source)
            <div class="info-row"><span class="info-label">المصدر</span> {{ $contact->source }}</div>
            @endif
            @if($contact->project)
            <div class="info-row">
                <span class="info-label">المشروع</span>
                <a href="{{ route('admin.projects.show', $contact->project) }}">
                    {{ $contact->project->getTitle() }}
                </a>
            </div>
            @endif
            @if($contact->budget_range)
            <div class="info-row"><span class="info-label">الميزانية</span> {{ \App\Models\Contact::BUDGET_RANGES[$contact->budget_range] ?? $contact->budget_range }}</div>
            @endif
            @if($contact->preferred_contact && $contact->preferred_contact !== 'any')
            <div class="info-row"><span class="info-label">وسيلة التواصل</span> {{ \App\Models\Contact::PREFERRED_CONTACT[$contact->preferred_contact] ?? $contact->preferred_contact }}</div>
            @endif
            @if($contact->language)
            <div class="info-row"><span class="info-label">لغة العميل</span> {{ strtoupper($contact->language) }}</div>
            @endif
            <div class="info-row"><span class="info-label">تاريخ التواصل</span> {{ $contact->created_at->format('Y/m/d H:i') }} ({{ $contact->created_at->diffForHumans() }})</div>
        </div>

        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-comment-dots"></i> الرسالة</div>
            <p style="white-space:pre-wrap; line-height:1.8; color:#333; margin:0;">{{ $contact->message }}</p>
        </div>

        @if($contact->crm_notes)
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-sticky-note"></i> ملاحظات CRM</div>
            <p style="white-space:pre-wrap; line-height:1.8; color:#555; margin:0;">{{ $contact->crm_notes }}</p>
            @if($contact->lastActionAdmin)
            <div class="text-muted small mt-2">
                آخر تحديث: {{ $contact->lastActionAdmin->name }} — {{ $contact->last_action_at?->format('Y/m/d H:i') }}
            </div>
            @endif
        </div>
        @endif

    </div>

    {{-- Right: CRM Panel --}}
    <div class="col-lg-5">
        <div class="crm-panel">

            {{-- Status Badge --}}
            <div class="form-card text-center">
                <span class="crm-status-badge d-inline-flex"
                      style="background:{{ $contact->getStatusBg() }}; color:{{ $contact->getStatusColor() }}; font-size:1rem;">
                    {{ $contact->getStatusLabel() }}
                </span>
                <div class="mt-2" style="font-size:0.82rem; color:{{ $contact->getPriorityColor() }}; font-weight:600;">
                    <i class="fas {{ $contact->getPriorityIcon() }} me-1"></i>أولوية: {{ $contact->getPriorityLabel() }}
                </div>
                @if($contact->assignedAdmin)
                <div class="mt-1 text-muted small">
                    <i class="fas fa-user-tie me-1"></i>مسؤول: {{ $contact->assignedAdmin->name }}
                </div>
                @endif
                @if($contact->follow_up_at)
                <div class="mt-1 {{ $contact->isFollowUpDue() ? 'text-danger fw-bold' : 'text-muted' }} small">
                    <i class="fas fa-calendar-alt me-1"></i>
                    متابعة: {{ $contact->follow_up_at->format('Y/m/d H:i') }}
                    @if($contact->isFollowUpDue()) (متأخر!) @endif
                </div>
                @endif
            </div>

            {{-- CRM Update Form --}}
            @if($currentAdmin->hasPermission('contacts.edit'))
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-edit"></i> تحديث CRM</div>
                <form method="POST" action="{{ route('admin.contacts.crm', $contact) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">الحالة</label>
                        <div class="row g-1">
                            @foreach(\App\Models\Contact::STATUSES as $sk => $sv)
                            <div class="col-6">
                                <label class="d-flex align-items-center gap-2 p-2 rounded border small"
                                       style="cursor:pointer; {{ $contact->status === $sk ? 'border-color:'.$sv['color'].'; background:'.$sv['bg'].'; font-weight:700;' : '' }}">
                                    <input type="radio" name="status" value="{{ $sk }}" {{ $contact->status === $sk ? 'checked' : '' }}>
                                    <span style="color:{{ $sv['color'] }};">{{ $sv['label'] }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">الأولوية</label>
                        <div class="row g-1">
                            @foreach(\App\Models\Contact::PRIORITIES as $pk => $pv)
                            <div class="col-6">
                                <label class="d-flex align-items-center gap-2 p-2 rounded border small"
                                       style="cursor:pointer; {{ $contact->priority === $pk ? 'border-color:'.$pv['color'].'; background:'.$pv['color'].'18; font-weight:700;' : '' }}">
                                    <input type="radio" name="priority" value="{{ $pk }}" {{ $contact->priority === $pk ? 'checked' : '' }}>
                                    <i class="fas {{ $pv['icon'] }} fa-xs" style="color:{{ $pv['color'] }};"></i>
                                    <span style="color:{{ $pv['color'] }};">{{ $pv['label'] }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">تعيين إلى</label>
                        <select name="assigned_to" class="form-select form-select-sm">
                            <option value="">— بدون تعيين —</option>
                            @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ $contact->assigned_to == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">موعد المتابعة</label>
                        <input type="datetime-local" name="follow_up_at" class="form-control form-control-sm"
                               value="{{ $contact->follow_up_at ? $contact->follow_up_at->format('Y-m-d\TH:i') : '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">ملاحظات CRM</label>
                        <textarea name="crm_notes" class="form-control form-control-sm" rows="4"
                                  placeholder="سجّل ملاحظات المتابعة...">{{ $contact->crm_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gold w-100 fw-bold">
                        <i class="fas fa-save me-2"></i> حفظ التحديث
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
