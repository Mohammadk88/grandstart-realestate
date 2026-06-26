@extends('admin.layout')
@section('title', 'إدارة المستخدمين')
@section('page-title', 'إدارة المستخدمين والصلاحيات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0 small">إجمالي {{ $users->count() }} مستخدم في النظام</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-gold">
        <i class="fas fa-user-plus me-2"></i> إضافة مستخدم
    </a>
</div>

@php
$roleGroups = $users->groupBy('role');
$roleOrder  = ['super_admin','manager','data_entry','call_center'];
@endphp

@foreach($roleOrder as $roleKey)
@php $group = $roleGroups->get($roleKey, collect()); @endphp
@if($group->isEmpty()) @continue @endif

<div class="admin-table mb-4">
    <div class="admin-table-header">
        <div class="admin-table-title d-flex align-items-center gap-2">
            <span class="role-badge-lg" style="background: {{ \App\Models\Admin::ROLE_COLORS[$roleKey] }}20; color: {{ \App\Models\Admin::ROLE_COLORS[$roleKey] }}; border: 1px solid {{ \App\Models\Admin::ROLE_COLORS[$roleKey] }}40; padding: 4px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">
                {{ \App\Models\Admin::ROLES[$roleKey] }}
            </span>
            <span class="text-muted small">{{ $group->count() }} مستخدم</span>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>المستخدم</th>
                <th>البريد / الهاتف</th>
                <th>الصلاحيات</th>
                <th>آخر دخول</th>
                <th>الحالة</th>
                <th class="text-center">إجراءات</th>
            </tr>
        </thead>
        <tbody>
        @foreach($group as $user)
        <tr>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="admin-avatar-sm" style="background: {{ $user->getRoleColor() }}22; color: {{ $user->getRoleColor() }}; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem; flex-shrink:0;">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.9rem;">{{ $user->name }}</div>
                        @if($user->id === $currentAdmin->id)
                        <span class="badge" style="background:#e8f4fd; color:#1d72b8; font-size:0.65rem;">أنت</span>
                        @endif
                    </div>
                </div>
            </td>
            <td>
                <div style="font-size:0.85rem;">{{ $user->email }}</div>
                @if($user->phone)
                <div class="text-muted small">{{ $user->phone }}</div>
                @endif
            </td>
            <td>
                @php $perms = \App\Models\Admin::ROLE_PERMISSIONS[$user->role] ?? []; @endphp
                @if(in_array('*', $perms))
                <span class="badge" style="background:rgba(201,168,76,0.15); color:#C9A84C;">كل الصلاحيات</span>
                @else
                <div class="d-flex flex-wrap gap-1">
                    @foreach($perms as $p)
                    <span class="badge" style="background:#f0f0f0; color:#555; font-size:0.65rem; font-weight:500;">{{ $p }}</span>
                    @endforeach
                </div>
                @endif
            </td>
            <td>
                <span style="font-size:0.8rem; color:#888;">
                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'لم يسجل دخول بعد' }}
                </span>
            </td>
            <td>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input toggle-active"
                           type="checkbox"
                           {{ $user->active ? 'checked' : '' }}
                           {{ $user->id === $currentAdmin->id ? 'disabled' : '' }}
                           data-id="{{ $user->id }}"
                           data-url="{{ route('admin.users.toggle-active', $user) }}">
                </div>
            </td>
            <td class="text-center">
                <div class="d-flex gap-1 justify-content-center">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>
                    @if($user->id !== $currentAdmin->id)
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('هل تريد حذف هذا المستخدم؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endforeach

{{-- Permissions Reference --}}
<div class="form-card">
    <div class="form-card-title"><i class="fas fa-shield-alt"></i> مرجع الصلاحيات</div>
    <div class="table-responsive">
        <table class="table table-sm" style="font-size:0.82rem;">
            <thead>
                <tr>
                    <th>الصلاحية</th>
                    @foreach(\App\Models\Admin::ROLES as $rk => $rl)
                    <th class="text-center">{{ $rl }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                $allPerms = [
                    'projects.view'      => 'عرض المشاريع',
                    'projects.create'    => 'إضافة مشاريع',
                    'projects.edit'      => 'تعديل مشاريع',
                    'projects.delete'    => 'حذف مشاريع',
                    'contacts.view'      => 'عرض العملاء',
                    'contacts.edit'      => 'تعديل / متابعة العملاء',
                    'contacts.delete'    => 'حذف العملاء',
                    'pages.manage'       => 'إدارة الصفحات',
                    'hero.manage'        => 'إدارة البانر',
                    'page_builder.manage'=> 'ترتيب الأقسام',
                    'countries.manage'   => 'إدارة الدول',
                    'settings.manage'    => 'الإعدادات العامة',
                    'languages.manage'   => 'إدارة اللغات',
                    'users.manage'       => 'إدارة المستخدمين',
                ];
                @endphp
                @foreach($allPerms as $perm => $label)
                <tr>
                    <td class="fw-semibold">{{ $label }}</td>
                    @foreach(\App\Models\Admin::ROLES as $rk => $rl)
                    @php $rolePerms = \App\Models\Admin::ROLE_PERMISSIONS[$rk] ?? []; @endphp
                    <td class="text-center">
                        @if(in_array('*', $rolePerms) || in_array($perm, $rolePerms))
                        <i class="fas fa-check-circle text-success"></i>
                        @else
                        <i class="fas fa-times-circle text-muted" style="opacity:0.3;"></i>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.toggle-active').forEach(function(el) {
    el.addEventListener('change', function() {
        fetch(this.dataset.url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.error) { alert(data.error); this.checked = !this.checked; }
        });
    });
});
</script>
@endpush
