@extends('layouts.app')

@section('title', \App\Models\Setting::get('meta_title_' . app()->getLocale()))

@section('content')

{{-- ====== HERO SECTION ====== --}}
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-particles" id="particles"></div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                @if($countryCode === 'IQ')
                <div class="iraq-badge mb-3">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ app()->getLocale() === 'ar' ? 'محتوى خاص للعراق' : (app()->getLocale() === 'tr' ? 'Irak\'a Özel İçerik' : 'Iraq Special Content') }}
                </div>
                @endif
                <h1 class="hero-title">
                    {!! strip_tags(\App\Models\Setting::get('hero_title_' . app()->getLocale(), \App\Models\Setting::get('hero_title_ar', '')), '<br><strong><em><span>') !!}
                </h1>
                <p class="hero-subtitle">
                    {{ \App\Models\Setting::get('hero_subtitle_' . app()->getLocale(), \App\Models\Setting::get('hero_subtitle_ar')) }}
                </p>
                <div class="hero-actions mt-4">
                    <a href="{{ route('projects.index') }}" class="btn btn-gold btn-lg me-3">
                        <i class="fas fa-building me-2"></i>{{ __('app.hero_cta') }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone-alt me-2"></i>{{ __('app.hero_contact') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Stats Bar -->
    <div class="hero-stats-bar">
        <div class="container">
            <div class="row g-0 text-center">
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="hero-stat">
                        <span class="stat-num" data-count="{{ $stats['projects'] }}">0</span>
                        <span class="stat-label">{{ __('app.completed_projects') }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="hero-stat">
                        <span class="stat-num" data-count="{{ $stats['years'] }}">0</span>
                        <span class="stat-label">{{ __('app.years_experience') }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="hero-stat">
                        <span class="stat-num" data-count="{{ $stats['clients'] }}">0</span>
                        <span class="stat-label">{{ __('app.happy_clients') }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="500">
                    <div class="hero-stat">
                        <span class="stat-num" data-count="{{ $stats['countries'] }}">0</span>
                        <span class="stat-label">{{ __('app.countries') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====== FEATURED PROJECTS ====== --}}
@if($featuredProjects->count())
<section class="section-projects py-6">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label">{{ __('app.featured_projects') }}</span>
            <h2 class="section-title">{{ __('app.featured_projects') }}</h2>
            <div class="title-divider"><span></span></div>
        </div>

        <div class="row g-4">
            @foreach($featuredProjects as $i => $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                <div class="project-card">
                    <div class="project-image-wrap">
                        <img src="{{ $project->getMainImageThumbUrl() }}"
                             alt="{{ $project->getTitle() }}"
                             class="project-img"
                             loading="lazy">
                        <div class="project-overlay">
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-gold btn-sm">
                                {{ __('app.view_project') }}
                            </a>
                        </div>
                        <div class="project-badges">
                            <span class="badge-status status-{{ $project->status }}">
                                {{ $project->getStatusLabel() }}
                            </span>
                            @if($project->featured)
                            <span class="badge-featured">
                                <i class="fas fa-star"></i>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-type">
                            <i class="fas fa-tag"></i> {{ $project->getTypeLabel() }}
                        </div>
                        <h3 class="project-title">
                            <a href="{{ route('projects.show', $project->slug) }}">
                                {{ $project->getTitle() }}
                            </a>
                        </h3>
                        <p class="project-location">
                            <i class="fas fa-map-marker-alt"></i> {{ $project->getLocation() }}
                        </p>
                        <div class="project-footer">
                            <div class="project-price">
                                @if($countryCode === 'IQ' && $project->price_iqd)
                                    {{ number_format($project->price_iqd, 0) }} د.ع
                                @elseif($countryCode === 'TR' && $project->price_try)
                                    ₺{{ number_format($project->price_try, 0) }}
                                @elseif($project->price_usd)
                                    ${{ number_format($project->price_usd, 0) }}
                                @else
                                    {{ __('app.price_on_request') }}
                                @endif
                            </div>
                            <div class="project-meta">
                                @if($project->area)
                                <span><i class="fas fa-vector-square"></i> {{ $project->area }}</span>
                                @endif
                                @if($project->units)
                                <span><i class="fas fa-door-open"></i> {{ $project->units }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-gold btn-lg">
                {{ __('app.all_projects') }} <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ====== WHY CHOOSE US ====== --}}
<section class="section-why bg-dark-section py-6">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label">{{ __('app.why_us') }}</span>
            <h2 class="section-title">{{ __('app.why_us') }}</h2>
            <div class="title-divider"><span></span></div>
        </div>

        <div class="row g-4">
            @php
            $whyItems = [
                ['icon' => 'fas fa-award', 'title_ar' => 'خبرة 15 عاماً', 'title_en' => '15 Years Experience', 'desc_ar' => 'نمتلك خبرة واسعة في مجال التطوير العقاري تمتد لأكثر من 15 عاماً', 'desc_en' => 'We have extensive experience in real estate development spanning over 15 years'],
                ['icon' => 'fas fa-handshake', 'title_ar' => 'موثوقية عالية', 'title_en' => 'High Reliability', 'desc_ar' => 'نلتزم بتسليم مشاريعنا في الوقت المحدد وبأعلى مستويات الجودة', 'desc_en' => 'We are committed to delivering our projects on time with the highest quality standards'],
                ['icon' => 'fas fa-globe', 'title_ar' => 'انتشار عالمي', 'title_en' => 'Global Presence', 'desc_ar' => 'نمتلك مشاريع في أكثر من 8 دول حول العالم', 'desc_en' => 'We have projects in more than 8 countries around the world'],
                ['icon' => 'fas fa-headset', 'title_ar' => 'دعم مستمر', 'title_en' => 'Continuous Support', 'desc_ar' => 'فريق متخصص على استعداد لمساعدتك في كل خطوة', 'desc_en' => 'Specialized team ready to help you every step of the way'],
            ];
            @endphp

            @foreach($whyItems as $i => $item)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="why-card">
                    <div class="why-icon">
                        <i class="{{ $item['icon'] }}"></i>
                    </div>
                    <h3 class="why-title">
                        {{ app()->getLocale() === 'en' ? $item['title_en'] : $item['title_ar'] }}
                    </h3>
                    <p class="why-desc">
                        {{ app()->getLocale() === 'en' ? $item['desc_en'] : $item['desc_ar'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ====== ABOUT SECTION ====== --}}
<section class="section-about py-6">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image-grid">
                    <div class="about-img-main">
                        <img src="{{ asset('images/about-main.jpg') }}" alt="About Grand Start" onerror="this.src='https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=80'">
                    </div>
                    <div class="about-img-secondary">
                        <img src="{{ asset('images/about-sec.jpg') }}" alt="Grand Start Office" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=300&q=80'">
                    </div>
                    <div class="about-years-badge">
                        <span class="years-number">{{ $stats['years'] }}+</span>
                        <span class="years-label">{{ __('app.years_experience') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-label">{{ __('app.our_story') }}</span>
                    <h2 class="section-title mb-4">
                        {{ \App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Start Real Estate') }}
                    </h2>
                    <p class="about-text">
                        {{ \App\Models\Setting::get('about_text_' . app()->getLocale(), \App\Models\Setting::get('about_text_ar')) }}
                    </p>
                    <div class="about-stats row mt-4">
                        <div class="col-4 text-center">
                            <div class="mini-stat">
                                <span class="mini-stat-num">{{ $stats['projects'] }}+</span>
                                <span class="mini-stat-label">{{ __('app.completed_projects') }}</span>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="mini-stat">
                                <span class="mini-stat-num">{{ $stats['clients'] }}+</span>
                                <span class="mini-stat-label">{{ __('app.happy_clients') }}</span>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="mini-stat">
                                <span class="mini-stat-num">{{ $stats['countries'] }}</span>
                                <span class="mini-stat-label">{{ __('app.countries') }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('about') }}" class="btn btn-gold mt-4">
                        {{ __('app.our_story') }} <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====== LATEST PROJECTS ====== --}}
@if($latestProjects->count())
<section class="section-latest bg-dark-section py-6">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label">{{ __('app.all_projects') }}</span>
            <h2 class="section-title">{{ app()->getLocale() === 'en' ? 'Latest Projects' : 'أحدث المشاريع' }}</h2>
            <div class="title-divider"><span></span></div>
        </div>

        <div class="row g-4">
            @foreach($latestProjects as $i => $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 150 }}">
                <div class="project-card project-card-dark">
                    <div class="project-image-wrap">
                        <img src="{{ $project->getMainImageThumbUrl() }}" alt="{{ $project->getTitle() }}" class="project-img" loading="lazy">
                        <div class="project-overlay">
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-gold btn-sm">
                                {{ __('app.view_project') }}
                            </a>
                        </div>
                        <span class="badge-status status-{{ $project->status }}">{{ $project->getStatusLabel() }}</span>
                    </div>
                    <div class="project-body">
                        <div class="project-type"><i class="fas fa-tag"></i> {{ $project->getTypeLabel() }}</div>
                        <h3 class="project-title">
                            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->getTitle() }}</a>
                        </h3>
                        <p class="project-location"><i class="fas fa-map-marker-alt"></i> {{ $project->getLocation() }}</p>
                        <div class="project-footer">
                            <div class="project-price">
                                @if($countryCode === 'IQ' && $project->price_iqd)
                                    {{ number_format($project->price_iqd, 0) }} د.ع
                                @elseif($countryCode === 'TR' && $project->price_try)
                                    ₺{{ number_format($project->price_try, 0) }}
                                @elseif($project->price_usd)
                                    ${{ number_format($project->price_usd, 0) }}
                                @else
                                    {{ __('app.price_on_request') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====== CTA SECTION ====== --}}
<section class="section-cta py-6">
    <div class="container">
        <div class="cta-box text-center" data-aos="zoom-in">
            <h2 class="cta-title">
                {{ app()->getLocale() === 'en' ? 'Ready to Find Your Dream Property?' : 'هل أنت مستعد للعثور على عقار أحلامك؟' }}
            </h2>
            <p class="cta-text">
                {{ app()->getLocale() === 'en' ? 'Contact our team of experts and let us help you find the perfect property.' : 'تواصل مع فريق الخبراء لدينا ودعنا نساعدك في إيجاد العقار المثالي.' }}
            </p>
            <div class="cta-actions mt-4">
                <a href="{{ route('contact') }}" class="btn btn-gold btn-lg me-3">
                    <i class="fas fa-envelope me-2"></i>{{ __('app.contact_us') }}
                </a>
                @if(isset($whatsapp))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}"
                   target="_blank" class="btn btn-whatsapp btn-lg">
                    <i class="fab fa-whatsapp me-2"></i>{{ __('app.whatsapp') }}
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
