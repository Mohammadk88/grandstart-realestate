@extends('admin.layout')

@section('title', 'إضافة دولة')
@section('page-title', 'إضافة دولة جديدة')

@section('content')
<form action="{{ route('admin.countries.store') }}" method="POST">
    @csrf

    <div class="row g-4">
        <!-- Basic Info -->
        <div class="col-lg-6">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-globe"></i> معلومات الدولة</div>

                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">الاسم بالعربية <span class="text-danger">*</span></label>
                        <input type="text" name="country_name_ar" class="form-control" value="{{ old('country_name_ar') }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">الاسم بالإنجليزية <span class="text-danger">*</span></label>
                        <input type="text" name="country_name_en" class="form-control" value="{{ old('country_name_en') }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">كود الدولة ISO <small class="text-muted">(اختياري)</small></label>
                        <input type="text" name="country_code" class="form-control" value="{{ old('country_code') }}"
                            placeholder="IQ, SA, AE..." maxlength="10">
                        <div class="form-text">اتركه فارغاً إذا كانت هذه الدولة الافتراضية العامة</div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">إيموجي العلم</label>
                        <input type="text" name="flag_emoji" class="form-control" value="{{ old('flag_emoji') }}" placeholder="🇹🇷" maxlength="10">
                    </div>
                </div>
            </div>

            <!-- Currency -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-coins"></i> العملة والأسعار</div>
                <div class="row g-3">
                    <div class="col-4">
                        <label class="form-label">كود العملة</label>
                        <input type="text" name="currency_code" class="form-control" value="{{ old('currency_code', 'USD') }}" required maxlength="10">
                    </div>
                    <div class="col-4">
                        <label class="form-label">رمز العملة</label>
                        <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', '$') }}" required maxlength="10">
                    </div>
                    <div class="col-4">
                        <label class="form-label">حقل السعر</label>
                        <select name="price_field" class="form-select" required>
                            <option value="price_usd" {{ old('price_field') === 'price_usd' ? 'selected' : '' }}>USD ($)</option>
                            <option value="price_try" {{ old('price_field') === 'price_try' ? 'selected' : '' }}>TRY (₺)</option>
                            <option value="price_iqd" {{ old('price_field') === 'price_iqd' ? 'selected' : '' }}>IQD (د.ع)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="col-lg-6">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-phone"></i> بيانات التواصل</div>
                <div class="mb-3">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+90 212 123 4567">
                </div>
                <div class="mb-3">
                    <label class="form-label">رقم واتساب</label>
                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}" placeholder="+905551234567">
                </div>
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="info@grandstart.com">
                </div>
            </div>

            <!-- Addresses per language -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-map-marker-alt"></i> العناوين حسب اللغة</div>
                @foreach($languages as $lang)
                <div class="mb-3">
                    <label class="form-label">
                        العنوان بـ {{ $lang->name_native }}
                        <span class="badge bg-secondary ms-1">{{ $lang->code }}</span>
                    </label>
                    <textarea name="addresses[{{ $lang->code }}]" class="form-control" rows="2"
                        @if($lang->direction === 'rtl') dir="rtl" @endif>{{ old("addresses.{$lang->code}") }}</textarea>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mt-2">
        <button type="submit" class="btn btn-gold px-4"><i class="fas fa-save me-2"></i> حفظ</button>
        <a href="{{ route('admin.countries.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
    </div>
</form>
@endsection
