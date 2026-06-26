@extends('admin.layout')
@section('title', 'CRM - العملاء والاستفسارات')
@section('page-title', 'CRM — العملاء والاستفسارات')

@push('styles')
<style>
.crm-status-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:600; }
.quick-assign { min-width:150px; font-size:0.8rem; padding:3px 8px; }
.crm-filter-bar { background:#fff; border-radius:12px; padding:1rem 1.25rem; margin-bottom:1.25rem; box-shadow:0 1px 3px rgba(0,0,0,.06); }
.bulk-toolbar { background:#fff8e1; border:1px solid #ffe082; border-radius:8px; padding:0.6rem 1rem; margin-bottom:1rem; display:none; align-items:center; gap:1rem; flex-wrap:wrap; }
.bulk-toolbar.show { display:flex; }
.follow-up-due { color:#ef4444; font-weight:600; }
</style>
@endpush

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-blue"><i class="fas fa-inbox"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $statusCounts->get('new', 0) }}</div>
                <div class="stat-label-admin">جديد</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-orange"><i class="fas fa-spinner"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $statusCounts->get('in_progress', 0) }}</div>
                <div class="stat-label-admin">قيد المتابعة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-green"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $statusCounts->get('converted', 0) }}</div>
                <div class="stat-label-admin">تم التحويل</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-admin" style="{{ $dueCount > 0 ? 'border:1px solid #ef444440;' : '' }}">
            <div class="stat-icon-admin" style="background:rgba(239,68,68,.12); color:#ef4444;"><i class="fas fa-bell"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin" style="{{ $dueCount > 0 ? 'color:#ef4444;' : '' }}">{{ $dueCount }}</div>
                <div class="stat-label-admin">متابعة متأخرة</div>
            </div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="crm-filter-bar">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">الحالة</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">الكل</option>
                @foreach(\App\Models\Contact::STATUSES as $sk => $sv)
                <option value="{{ $sk }}" {{ request('status') === $sk ? 'selected' : '' }}>{{ $sv['label'] }}</option>
                @endforeach
                <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>سبام</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">الأولوية</label>
            <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">الكل</option>
                @foreach(\App\Models\Contact::PRIORITIES as $pk => $pv)
                <option value="{{ $pk }}" {{ request('priority') === $pk ? 'selected' : '' }}>{{ $pv['label'] }}</option>
                @endforeach
            </select>
        </div>
        @if(!$currentAdmin->role === 'call_center')
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">المسؤول</label>
            <select name="assigned" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">الكل</option>
                <option value="unassigned" {{ request('assigned') === 'unassigned' ? 'selected' : '' }}>غير معين</option>
                @foreach($agents as $agent)
                <option value="{{ $agent->id }}" {{ request('assigned') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">المتابعة</label>
            <select name="follow_up" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">الكل</option>
                <option value="1" {{ request('follow_up') ? 'selected' : '' }}>متأخرة فقط</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold mb-1">بحث</label>
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="اسم، هاتف، بريد...">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-1">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-danger w-100" title="مسح الفلاتر">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </form>
</div>

{{-- Bulk Actions --}}
@if($currentAdmin->hasPermission('contacts.edit'))
<form id="bulkForm" method="POST" action="{{ route('admin.contacts.bulk') }}">
    @csrf
    <input type="hidden" name="action"     id="bulkAction">
    <input type="hidden" name="assign_to"  id="bulkAssignTo">
    <input type="hidden" name="new_status" id="bulkNewStatus">
    <div class="bulk-toolbar" id="bulkToolbar">
        <span id="bulkCount" class="fw-bold small text-dark"></span>
        <button type="button" class="btn btn-sm btn-outline-dark" onclick="doBulk('mark_read')">
            <i class="fas fa-check me-1"></i>تحديد كمقروء
        </button>
        <div class="d-flex gap-1 align-items-center">
            <select id="bulkStatusSel" class="form-select form-select-sm" style="width:auto;">
                @foreach(\App\Models\Contact::STATUSES as $sk => $sv)
                <option value="{{ $sk }}">{{ $sv['label'] }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="doBulk('status')">تغيير الحالة</button>
        </div>
        @if($agents->isNotEmpty())
        <div class="d-flex gap-1 align-items-center">
            <select id="bulkAssignSel" class="form-select form-select-sm" style="width:auto;">
                @foreach($agents as $agent)
                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="doBulk('assign')">تعيين</button>
        </div>
        @endif
        @if($currentAdmin->hasPermission('contacts.delete'))
        <button type="button" class="btn btn-sm btn-outline-danger me-auto" onclick="doBulk('delete')">
            <i class="fas fa-trash me-1"></i>حذف
        </button>
        @endif
    </div>
</form>
@endif

{{-- Table --}}
<div class="admin-table">
    <div class="admin-table-header">
        <div class="admin-table-title">
            {{ $contacts->total() }} استفسار
            @if($unreadCount > 0)
            <span class="sidebar-badge ms-2">{{ $unreadCount }} غير مقروء</span>
            @endif
        </div>
        <span class="text-muted small">صفحة {{ $contacts->currentPage() }} / {{ $contacts->lastPage() }}</span>
    </div>
    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                @if($currentAdmin->hasPermission('contacts.edit'))
                <th style="width:36px;"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                @endif
                <th>العميل</th>
                <th>المشروع</th>
                <th>الحالة</th>
                <th>الأولوية</th>
                <th>المسؤول</th>
                <th>موعد المتابعة</th>
                <th>التاريخ</th>
                <th class="text-center">إجراءات</th>
            </tr>
        </thead>
        <tbody>
        @forelse($contacts as $contact)
        <tr style="{{ !$contact->is_read ? 'background:#fffbf0; font-weight:600;' : '' }}">
            @if($currentAdmin->hasPermission('contacts.edit'))
            <td>
                <input type="checkbox" class="form-check-input row-check" value="{{ $contact->id }}" name="ids[]" form="bulkForm">
            </td>
            @endif
            <td>
                <div style="font-size:0.88rem;">
                    {{ $contact->name }}
                    @if(!$contact->is_read)
                    <span class="badge ms-1" style="background:#3b82f620; color:#3b82f6; font-size:0.65rem;">جديد</span>
                    @endif
                </div>
                <div class="text-muted" style="font-size:0.78rem;">
                    @if($contact->phone)<i class="fas fa-phone fa-xs me-1"></i>{{ $contact->phone }} @endif
                    @if($contact->country_code) &nbsp;🌍 {{ $contact->country_code }} @endif
                </div>
            </td>
            <td>
                @if($contact->project)
                <span class="small" style="color:#555;">{{ $contact->project->getTitle() }}</span>
                @else
                <span class="text-muted small">—</span>
                @endif
            </td>
            <td>
                <span class="crm-status-badge"
                      style="background:{{ $contact->getStatusBg() }}; color:{{ $contact->getStatusColor() }};">
                    {{ $contact->getStatusLabel() }}
                </span>
            </td>
            <td>
                <span style="font-size:0.8rem; color:{{ $contact->getPriorityColor() }}; font-weight:600;">
                    <i class="fas {{ $contact->getPriorityIcon() }} fa-xs me-1"></i>{{ $contact->getPriorityLabel() }}
                </span>
            </td>
            <td>
                @if($contact->assignedAdmin)
                <span class="small">{{ $contact->assignedAdmin->name }}</span>
                @elseif($currentAdmin->hasPermission('contacts.edit'))
                <form method="POST" action="{{ route('admin.contacts.crm', $contact) }}">
                    @csrf
                    <input type="hidden" name="status"   value="{{ $contact->status }}">
                    <input type="hidden" name="priority" value="{{ $contact->priority }}">
                    <select name="assigned_to" class="form-select form-select-sm quick-assign" onchange="this.form.submit()">
                        <option value="">— تعيين —</option>
                        @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach
                    </select>
                </form>
                @else
                <span class="text-muted small">—</span>
                @endif
            </td>
            <td>
                @if($contact->follow_up_at)
                <span class="{{ $contact->isFollowUpDue() ? 'follow-up-due' : 'text-muted' }}" style="font-size:0.8rem;">
                    @if($contact->isFollowUpDue())<i class="fas fa-bell fa-xs me-1"></i>@endif
                    {{ $contact->follow_up_at->format('m/d H:i') }}
                </span>
                @else
                <span class="text-muted small">—</span>
                @endif
            </td>
            <td><span class="text-muted small">{{ $contact->created_at->format('Y/m/d') }}</span></td>
            <td class="text-center">
                <div class="d-flex gap-1 justify-content-center">
                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye"></i>
                    </a>
                    @if($currentAdmin->hasPermission('contacts.delete'))
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}"
                          onsubmit="return confirm('حذف هذا الاستفسار؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i> لا توجد استفسارات
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    </div>
    @if($contacts->hasPages())
    <div class="px-4 py-3">{{ $contacts->links() }}</div>
    @endif
</div>

@endsection

@push('scripts')
<script>
var selectAll = document.getElementById('selectAll');
var toolbar   = document.getElementById('bulkToolbar');
var bulkCount = document.getElementById('bulkCount');

if (selectAll) {
    selectAll.addEventListener('change', function() {
        document.querySelectorAll('.row-check').forEach(c => c.checked = this.checked);
        updateToolbar();
    });
    document.querySelectorAll('.row-check').forEach(c => c.addEventListener('change', updateToolbar));
}

function updateToolbar() {
    var checked = document.querySelectorAll('.row-check:checked');
    if (toolbar) {
        if (checked.length > 0) {
            toolbar.classList.add('show');
            bulkCount.textContent = 'محدد: ' + checked.length;
        } else {
            toolbar.classList.remove('show');
        }
    }
}

function doBulk(action) {
    var checked = document.querySelectorAll('.row-check:checked');
    if (!checked.length) { alert('اختر سجلاً واحداً على الأقل'); return; }
    if (action === 'delete' && !confirm('حذف ' + checked.length + ' سجل؟')) return;

    document.getElementById('bulkAction').value = action;
    if (action === 'assign') document.getElementById('bulkAssignTo').value = document.getElementById('bulkAssignSel').value;
    if (action === 'status') document.getElementById('bulkNewStatus').value = document.getElementById('bulkStatusSel').value;

    var form = document.getElementById('bulkForm');
    // Remove old hidden ids
    form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
    checked.forEach(function(c) {
        var inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = c.value;
        form.appendChild(inp);
    });
    form.submit();
}
</script>
@endpush
