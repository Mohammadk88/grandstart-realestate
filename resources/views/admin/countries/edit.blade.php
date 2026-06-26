@extends('admin.layout')

@section('title', 'تعديل دولة')
@section('page-title', 'تعديل: ' . $country->flag_emoji . ' ' . $country->country_name_ar)

@section('content')
<form action="{{ route('admin.countries.update', $country) }}" method="POST">
    @csrf @method('PUT')

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-globe"></i> معلومات الدولة</div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">الاسم بالعربية <span class="text-danger">*</span></label>
                        <input type="text" name="country_name_ar" class="form-control" value="{{ old('country_name_ar', $country->country_name_ar) }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">الاسم بالإنجليزية <span class="text-danger">*</span></label>
                        <input type="text" name="country_name_en" class="form-control" value="{{ old('country_name_en', $country->country_name_en) }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">كود الدولة ISO</label>
                        <input type="text" name="country_code" class="form-control" value="{{ old('country_code', $country->country_code) }}" maxlength="10">
                    </div>
                    <div class="col-6">
                        <label class="form-label">إيموجي العلم</label>
                        <input type="text" name="flag_emoji" class="form-control" value="{{ old('flag_emoji', $country->flag_emoji) }}" maxlength="10">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-coins"></i> العملة والأسعار</div>
                <div class="row g-3">
                    <div class="col-4">
                        <label class="form-label">كود العملة</label>
                        <input type="text" name="currency_code" class="form-control" value="{{ old('currency_code', $country->currency_code) }}" required maxlength="10">
                    </div>
                    <div class="col-4">
                        <label class="form-label">رمز العملة</label>
                        <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $country->currency_symbol) }}" required maxlength="10">
                    </div>
                    <div class="col-4">
                        <label class="form-label">حقل السعر</label>
                        <select name="price_field" class="form-select" required>
                            <option value="price_usd" {{ old('price_field', $country->price_field) === 'price_usd' ? 'selected' : '' }}>USD ($)</option>
                            <option value="price_try" {{ old('price_field', $country->price_field) === 'price_try' ? 'selected' : '' }}>TRY (₺)</option>
                            <option value="price_iqd" {{ old('price_field', $country->price_field) === 'price_iqd' ? 'selected' : '' }}>IQD (د.ع)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-phone"></i> بيانات التواصل</div>
                <div class="mb-3">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $country->phone) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">رقم واتساب</label>
                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $country->whatsapp) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $country->email) }}">
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-map-marker-alt"></i> العناوين حسب اللغة</div>
                @foreach($languages as $lang)
                @php $addr = $country->addresses->firstWhere('locale', $lang->code); @endphp
                <div class="mb-3">
                    <label class="form-label">
                        العنوان بـ {{ $lang->name_native }}
                        <span class="badge bg-secondary ms-1">{{ $lang->code }}</span>
                    </label>
                    <textarea name="addresses[{{ $lang->code }}]" class="form-control" rows="2"
                        @if($lang->direction === 'rtl') dir="rtl" @endif>{{ old("addresses.{$lang->code}", $addr?->address) }}</textarea>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mt-2">
        <button type="submit" class="btn btn-gold px-4"><i class="fas fa-save me-2"></i> حفظ التغييرات</button>
        <a href="{{ route('admin.countries.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
    </div>
</form>
@endsection
