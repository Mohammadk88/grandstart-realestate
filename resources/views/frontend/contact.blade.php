@extends('layouts.app')

@section('title', __('app.contact') . ' - ' . \App\Models\Setting::get('company_name_' . app()->getLocale()))

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content text-center">
            <h1 class="page-header-title" data-aos="fade-down">{{ __('app.contact_us') }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('app.contact') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-6">
    <div class="container">
        <div class="row g-5">

            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="contact-form-card">
                    <div class="contact-form-header">
                        <span class="section-label">{{ __('app.contact_us') }}</span>
                        <h2 class="contact-form-title">
                            {{ app()->getLocale() === 'en' ? 'Send Us a Message' : 'أرسل لنا رسالة' }}
                        </h2>
                        <p class="contact-form-subtitle">
                            {{ app()->getLocale() === 'en'
                                ? 'Fill out the form below and our team will get back to you within 24 hours.'
                                : 'املأ النموذج أدناه وسيتواصل فريقنا معك في غضون 24 ساعة.' }}
                        </p>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success-custom mb-4">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label>{{ __('app.your_name') }} <span class="required">*</span></label>
                                    <input type="text" name="name" class="form-control dark-input @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="{{ __('app.your_name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-custom">
                                    <label>{{ __('app.your_phone') }} <span class="required">*</span></label>
                                    <input type="tel" name="phone" class="form-control dark-input @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           placeholder="{{ __('app.your_phone') }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating-custom">
                                    <label>{{ __('app.your_email') }}</label>
                                    <input type="email" name="email" class="form-control dark-input @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="{{ __('app.your_email') }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating-custom">
                                    <label>{{ __('app.your_message') }} <span class="required">*</span></label>
                                    <textarea name="message" class="form-control dark-input @error('message') is-invalid @enderror"
                                              rows="5"
                                              placeholder="{{ __('app.your_message') }}" required>{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-gold btn-lg w-100">
                                    <i class="fas fa-paper-plane me-2"></i>{{ __('app.send_message') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="contact-info-section">
                    <span class="section-label">{{ __('app.contact') }}</span>
                    <h3 class="contact-info-title">
                        {{ app()->getLocale() === 'en' ? 'Get In Touch' : 'تواصل معنا' }}
                    </h3>

                    @if($hasCustom)
                    <div class="iraq-notice">
                        <i class="fas fa-map-marker-alt"></i>
                        @if($countryCode === 'IQ')
                            {{ app()->getLocale() === 'en' ? 'Iraq Office Contact' : (app()->getLocale() === 'tr' ? 'Irak Ofisi İletişim' : 'معلومات مكتب العراق') }}
                        @else
                            {{ app()->getLocale() === 'en' ? 'Local Office Contact' : (app()->getLocale() === 'tr' ? 'Yerel Ofis İletişim' : 'معلومات المكتب المحلي') }}
                        @endif
                    </div>
                    @endif

                    <div class="contact-info-cards mt-4">
                        @if($phone)
                        <div class="contact-info-card" data-aos="fade-left" data-aos-delay="100">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>{{ __('app.phone') }}</h5>
                                <a href="tel:{{ $phone }}">{{ $phone }}</a>
                            </div>
                        </div>
                        @endif

                        @if($email)
                        <div class="contact-info-card" data-aos="fade-left" data-aos-delay="200">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>{{ __('app.email') }}</h5>
                                <a href="mailto:{{ $email }}">{{ $email }}</a>
                            </div>
                        </div>
                        @endif

                        @if($address)
                        <div class="contact-info-card" data-aos="fade-left" data-aos-delay="300">
                            <div class="contact-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>{{ __('app.address') }}</h5>
                                <p class="mb-0">{{ $address }}</p>
                            </div>
                        </div>
                        @endif

                        @if($whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}"
                           target="_blank"
                           class="contact-info-card contact-info-wa" data-aos="fade-left" data-aos-delay="400">
                            <div class="contact-info-icon wa-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="contact-info-content">
                                <h5>{{ __('app.whatsapp') }}</h5>
                                <p class="mb-0">{{ __('app.chat_whatsapp') }}</p>
                            </div>
                        </a>
                        @endif
                    </div>

                    <!-- Social Media -->
                    <div class="contact-social mt-4" data-aos="fade-up">
                        <h5 class="social-title">{{ __('app.follow_us') }}</h5>
                        <div class="social-links">
                            @if(\App\Models\Setting::get('facebook_url'))
                            <a href="{{ \App\Models\Setting::get('facebook_url') }}" target="_blank" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            @if(\App\Models\Setting::get('instagram_url'))
                            <a href="{{ \App\Models\Setting::get('instagram_url') }}" target="_blank" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if(\App\Models\Setting::get('twitter_url'))
                            <a href="{{ \App\Models\Setting::get('twitter_url') }}" target="_blank" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                            @endif
                            @if(\App\Models\Setting::get('youtube_url'))
                            <a href="{{ \App\Models\Setting::get('youtube_url') }}" target="_blank" class="social-link">
                                <i class="fab fa-youtube"></i>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="working-hours mt-4" data-aos="fade-up" data-aos-delay="100">
                        <h5 class="working-hours-title">
                            <i class="fas fa-clock me-2"></i>
                            {{ app()->getLocale() === 'en' ? 'Working Hours' : 'ساعات العمل' }}
                        </h5>
                        <table class="hours-table">
                            <tr>
                                <td>{{ app()->getLocale() === 'en' ? 'Saturday - Thursday' : 'السبت - الخميس' }}</td>
                                <td>9:00 AM - 6:00 PM</td>
                            </tr>
                            <tr>
                                <td>{{ app()->getLocale() === 'en' ? 'Friday' : 'الجمعة' }}</td>
                                <td>{{ app()->getLocale() === 'en' ? 'Closed' : 'مغلق' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
