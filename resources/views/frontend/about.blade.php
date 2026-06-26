@extends('layouts.app')

@section('title', __('app.about') . ' - ' . \App\Models\Setting::get('company_name_' . app()->getLocale()))

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content text-center">
            <h1 class="page-header-title" data-aos="fade-down">{{ __('app.about') }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('app.about') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- About Main Section -->
<section class="about-main-section py-6">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image-grid">
                    <div class="about-img-main">
                        <img src="{{ asset('images/about-main.jpg') }}" alt="Grand Start Real Estate"
                             onerror="this.src='https://images.unsplash.com/photo-1486325212027-8081e485255e?w=700&q=80'">
                    </div>
                    <div class="about-img-secondary">
                        <img src="{{ asset('images/about-sec.jpg') }}" alt="Our Team"
                             onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=350&q=80'">
                    </div>
                    <div class="about-years-badge">
                        <span class="years-number">{{ $stats['years'] }}+</span>
                        <span class="years-label">{{ __('app.years_experience') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="section-label">{{ __('app.our_story') }}</span>
                <h2 class="section-title mb-4">
                    {{ \App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Start Real Estate') }}
                </h2>
                <p class="about-text lead">
                    {{ \App\Models\Setting::get('about_text_' . app()->getLocale(), \App\Models\Setting::get('about_text_ar')) }}
                </p>
                <div class="row mt-4 g-3">
                    <div class="col-6">
                        <div class="about-feature">
                            <i class="fas fa-check-circle text-gold"></i>
                            {{ app()->getLocale() === 'en' ? 'ISO Certified' : 'معتمد ISO' }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-feature">
                            <i class="fas fa-check-circle text-gold"></i>
                            {{ app()->getLocale() === 'en' ? 'Award Winning' : 'حائز على جوائز' }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-feature">
                            <i class="fas fa-check-circle text-gold"></i>
                            {{ app()->getLocale() === 'en' ? 'Licensed & Regulated' : 'مرخص ومنظم' }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-feature">
                            <i class="fas fa-check-circle text-gold"></i>
                            {{ app()->getLocale() === 'en' ? 'Transparent Pricing' : 'أسعار شفافة' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-5 bg-dark-section">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-building"></i></div>
                    <div class="stat-number counter" data-target="{{ $stats['projects'] }}">0</div>
                    <div class="stat-label">{{ __('app.completed_projects') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="stat-number counter" data-target="{{ $stats['years'] }}">0</div>
                    <div class="stat-label">{{ __('app.years_experience') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number counter" data-target="{{ $stats['clients'] }}">0</div>
                    <div class="stat-label">{{ __('app.happy_clients') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-globe"></i></div>
                    <div class="stat-number counter" data-target="{{ $stats['countries'] }}">0</div>
                    <div class="stat-label">{{ __('app.countries') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="vision-section py-6">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="vm-title">{{ __('app.our_vision') }}</h3>
                    <p class="vm-text">
                        {{ app()->getLocale() === 'en'
                            ? 'To be the leading real estate developer in the Middle East, known for innovation, quality, and trust.'
                            : 'أن نكون الشركة العقارية الرائدة في الشرق الأوسط، المعروفة بالابتكار والجودة والثقة.' }}
                    </p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="vm-card vm-card-featured">
                    <div class="vm-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="vm-title">{{ __('app.our_mission') }}</h3>
                    <p class="vm-text">
                        {{ app()->getLocale() === 'en'
                            ? 'To deliver exceptional real estate experiences by combining world-class design with sustainable development practices.'
                            : 'تقديم تجارب عقارية استثنائية من خلال الجمع بين التصميم العالمي الرفيع وممارسات التطوير المستدام.' }}
                    </p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="vm-title">{{ __('app.our_values') }}</h3>
                    <p class="vm-text">
                        {{ app()->getLocale() === 'en'
                            ? 'Integrity, Excellence, Innovation, Sustainability, and Client-First approach in everything we do.'
                            : 'النزاهة والتميز والابتكار والاستدامة ومنهج يضع العميل في المقام الأول في كل ما نقوم به.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-section py-6 bg-dark-section">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label">{{ __('app.why_us') }}</span>
            <h2 class="section-title">{{ __('app.why_us') }}</h2>
            <div class="title-divider"><span></span></div>
        </div>

        <div class="row g-4">
            @php
            $whyItems = [
                ['icon' => 'fas fa-trophy', 'num' => '01', 'title_ar' => 'خبرة واسعة', 'title_en' => 'Extensive Experience', 'desc_ar' => 'أكثر من 15 عاماً من الخبرة في التطوير العقاري', 'desc_en' => 'More than 15 years of experience in real estate development'],
                ['icon' => 'fas fa-gem', 'num' => '02', 'title_ar' => 'جودة استثنائية', 'title_en' => 'Exceptional Quality', 'desc_ar' => 'نلتزم بأعلى معايير الجودة في كل مشاريعنا', 'desc_en' => 'We are committed to the highest quality standards in all our projects'],
                ['icon' => 'fas fa-shield-alt', 'num' => '03', 'title_ar' => 'ضمان موثوق', 'title_en' => 'Reliable Guarantee', 'desc_ar' => 'نضمن حقوق عملائنا بالكامل وفق القوانين المعمول بها', 'desc_en' => 'We fully guarantee our clients\' rights in accordance with applicable laws'],
                ['icon' => 'fas fa-headset', 'num' => '04', 'title_ar' => 'دعم متكامل', 'title_en' => 'Comprehensive Support', 'desc_ar' => 'فريق دعم متخصص على مدار الساعة', 'desc_en' => 'Dedicated support team around the clock'],
                ['icon' => 'fas fa-hand-holding-usd', 'num' => '05', 'title_ar' => 'أسعار تنافسية', 'title_en' => 'Competitive Prices', 'desc_ar' => 'نقدم أفضل الأسعار مع أعلى مستويات الجودة', 'desc_en' => 'We offer the best prices with the highest quality levels'],
                ['icon' => 'fas fa-map-marked-alt', 'num' => '06', 'title_ar' => 'مواقع استراتيجية', 'title_en' => 'Strategic Locations', 'desc_ar' => 'مشاريعنا في أفضل المواقع الاستراتيجية', 'desc_en' => 'Our projects are in the best strategic locations'],
            ];
            @endphp

            @foreach($whyItems as $i => $item)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                <div class="why-item">
                    <div class="why-num">{{ $item['num'] }}</div>
                    <div class="why-icon-small">
                        <i class="{{ $item['icon'] }}"></i>
                    </div>
                    <h4 class="why-item-title">
                        {{ app()->getLocale() === 'en' ? $item['title_en'] : $item['title_ar'] }}
                    </h4>
                    <p class="why-item-desc">
                        {{ app()->getLocale() === 'en' ? $item['desc_en'] : $item['desc_ar'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-cta py-6">
    <div class="container">
        <div class="cta-box text-center" data-aos="zoom-in">
            <h2 class="cta-title">
                {{ app()->getLocale() === 'en' ? 'Start Your Real Estate Journey Today' : 'ابدأ رحلتك العقارية اليوم' }}
            </h2>
            <p class="cta-text">
                {{ app()->getLocale() === 'en'
                    ? 'Contact us and let us guide you to the perfect property investment.'
                    : 'تواصل معنا ودعنا نرشدك إلى الاستثمار العقاري المثالي.' }}
            </p>
            <div class="cta-actions mt-4">
                <a href="{{ route('contact') }}" class="btn btn-gold btn-lg me-3">
                    <i class="fas fa-envelope me-2"></i>{{ __('app.contact_us') }}
                </a>
                <a href="{{ route('projects.index') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-building me-2"></i>{{ __('app.all_projects') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
