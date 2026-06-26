@extends('admin.layout')
@section('title', 'تعديل مستخدم')
@section('page-title', 'تعديل بيانات: ' . $user->name)

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع
    </a>
</div>

<div class="row justify-content-center">
<div class="col-lg-7">
<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf @method('PUT')

    <div class="form-card">
        <div class="form-card-title"><i class="fas fa-user-edit"></i> بيانات المستخدم</div>

        @if($errors->any())
        <div class="alert alert-danger-admin mb-3">
            <i class="fas fa-exclamation-circle me-1"></i>
            @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
        @endif

        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+90...">
            </div>
            <div class="col-12">
                <label class="form-label">الدور / الصلاحية <span class="text-danger">*</span></label>
                <div class="row g-2 mt-1">
                    @foreach(\App\Models\Admin::ROLES as $rk => $rl)
                    @php $isSelected = old('role', $user->role) === $rk; @endphp
                    <div class="col-md-6">
                        <label class="role-card {{ $isSelected ? 'selected' : '' }}"
                               data-color="{{ \App\Models\Admin::ROLE_COLORS[$rk] }}"
                               style="cursor:pointer; display:block; border:2px solid {{ $isSelected ? \App\Models\Admin::ROLE_COLORS[$rk] : '#e9ecef' }}; background:{{ $isSelected ? \App\Models\Admin::ROLE_COLORS[$rk].'12' : '' }}; border-radius:10px; padding:1rem; transition:all 0.2s;">
                            <div class="d-flex align-items-center gap-2">
                                <input type="radio" name="role" value="{{ $rk }}" {{ $isSelected ? 'checked' : '' }} style="display:none;">
                                <div style="width:12px; height:12px; border-radius:50%; background:{{ \App\Models\Admin::ROLE_COLORS[$rk] }};"></div>
                                <span class="fw-bold" style="color:{{ \App\Models\Admin::ROLE_COLORS[$rk] }};">{{ $rl }}</span>
                            </div>
                            <div class="mt-2" style="font-size:0.78rem; color:#888; line-height:1.5;">
                                @if($rk === 'super_admin') كل الصلاحيات بدون قيود
                                @elseif($rk === 'manager') إدارة المشاريع والعملاء والمحتوى
                                @elseif($rk === 'data_entry') إدخال وتعديل المشاريع والمحتوى فقط
                                @elseif($rk === 'call_center') متابعة العملاء والاستفسارات فقط
                                @endif
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                <hr class="my-1">
                <label class="form-label">كلمة المرور الجديدة <span class="text-muted fw-normal">(اتركها فارغة إن لم تريد التغيير)</span></label>
            </div>
            <div class="col-md-6">
                <input type="password" name="password" class="form-control" minlength="8" placeholder="••••••••">
            </div>
            <div class="col-md-6">
                <input type="password" name="password_confirmation" class="form-control" placeholder="تأكيد كلمة المرور">
            </div>
            @if($user->id !== $currentAdmin->id)
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="active" value="1" {{ $user->active ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">حساب نشط</label>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-gold flex-fill py-2 fw-bold">
            <i class="fas fa-save me-2"></i> حفظ التعديلات
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
    </div>
</form>
</div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.role-card').forEach(function(card) {
    card.addEventListener('click', function() {
        document.querySelectorAll('.role-card').forEach(c => {
            c.style.borderColor = '#e9ecef';
            c.style.background  = '';
        });
        var color = this.dataset.color;
        this.style.borderColor = color;
        this.style.background  = color + '12';
        this.querySelector('input[type=radio]').checked = true;
    });
});
</script>
@endpush
