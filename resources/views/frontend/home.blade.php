@extends('layouts.app')

@section('title', \App\Models\Setting::get('meta_title_' . app()->getLocale()))

@section('content')

@foreach($sections as $section)
@if(!$section->active) @continue @endif

{{-- ====== HERO ====== --}}
@if($section->key === 'hero')

@if($heroType === 'slider' && $heroSlides->count())
{{-- SLIDER MODE --}}
<section class="hero-section hero-slider-section p-0" style="min-height:100vh;position:relative;">
    <div class="swiper hero-swiper" style="height:100vh;">
        <div class="swiper-wrapper">
            @foreach($heroSlides as $slide)
            <div class="swiper-slide" style="background:url('{{ $slide->getImageUrl() }}') center/cover no-repeat;position:relative;">
                <div class="hero-overlay" style="position:absolute;inset:0;background:rgba(0,0,0,0.5);z-index:1;"></div>
                <div class="container h-100 d-flex align-items-center" style="position:relative;z-index:2;">
                    <div class="col-lg-8" data-aos="fade-up">
                        @if($countryCode === 'IQ')
                        <div class="iraq-badge mb-3"><i class="fas fa-map-marker-alt"></i> {{ app()->getLocale() === 'ar' ? 'محتوى خاص للعراق' : 'Iraq Special Content' }}</div>
                        @endif
                        @if($slide->getTitle())
                        <h1 class="hero-title text-white">{{ $slide->getTitle() }}</h1>
                        @endif
                        @if($slide->getSubtitle())
                        <p class="hero-subtitle text-white-50">{{ $slide->getSubtitle() }}</p>
                        @endif
                        <div class="hero-actions mt-4">
                            @if($slide->getBtnLabel() && $slide->btn_url)
                            <a href="{{ $slide->btn_url }}" class="btn btn-gold btn-lg me-3">{{ $slide->getBtnLabel() }}</a>
                            @endif
                            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-phone-alt me-2"></i>{{ __('app.hero_contact') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-button-prev" style="color:#fff;"></div>
        <div class="swiper-button-next" style="color:#fff;"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Hero Stats Bar -->
    <div class="hero-stats-bar" style="position:absolute;bottom:0;left:0;right:0;z-index:10;">
        <div class="container">
            <div class="row g-0 text-center">
                <div class="col-6 col-md-3"><div class="hero-stat"><span class="stat-num" data-count="{{ $stats['projects'] }}">0</span><span class="stat-label">{{ __('app.completed_projects') }}</span></div></div>
                <div class="col-6 col-md-3"><div class="hero-stat"><span class="stat-num" data-count="{{ $stats['years'] }}">0</span><span class="stat-label">{{ __('app.years_experience') }}</span></div></div>
                <div class="col-6 col-md-3"><div class="hero-stat"><span class="stat-num" data-count="{{ $stats['clients'] }}">0</span><span class="stat-label">{{ __('app.happy_clients') }}</span></div></div>
                <div class="col-6 col-md-3"><div class="hero-stat"><span class="stat-num" data-count="{{ $stats['countries'] }}">0</span><span class="stat-label">{{ __('app.countries') }}</span></div></div>
            </div>
        </div>
    </div>
</section>

@else
{{-- STATIC MODE --}}
<section class="hero-section" @if($heroSlides->count()) style="background-image:url('{{ $heroSlides->first()->getImageUrl() }}');background-size:cover;background-position:center;" @endif>
    <div class="hero-overlay"></div>
    <div class="hero-particles" id="particles"></div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                @if($countryCode === 'IQ')
                <div class="iraq-badge mb-3">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ app()->getLocale() === 'ar' ? 'محتوى خاص للعراق' : 'Iraq Special Content' }}
                </div>
                @endif
                @if($heroSlides->count())
                <h1 class="hero-title">{{ $heroSlides->first()->getTitle() ?: strip_tags(\App\Models\Setting::get('hero_title_' . app()->getLocale(), ''), '<br><strong><em><span>') }}</h1>
                <p class="hero-subtitle">{{ $heroSlides->first()->getSubtitle() ?: \App\Models\Setting::get('hero_subtitle_' . app()->getLocale()) }}</p>
                @else
                <h1 class="hero-title">
                    {!! strip_tags(\App\Models\Setting::get('hero_title_' . app()->getLocale(), \App\Models\Setting::get('hero_title_ar', '')), '<br><strong><em><span>') !!}
                </h1>
                <p class="hero-subtitle">{{ \App\Models\Setting::get('hero_subtitle_' . app()->getLocale(), \App\Models\Setting::get('hero_subtitle_ar')) }}</p>
                @endif
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
    <div class="hero-stats-bar">
        <div class="container">
            <div class="row g-0 text-center">
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200"><div class="hero-stat"><span class="stat-num" data-count="{{ $stats['projects'] }}">0</span><span class="stat-label">{{ __('app.completed_projects') }}</span></div></div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300"><div class="hero-stat"><span class="stat-num" data-count="{{ $stats['years'] }}">0</span><span class="stat-label">{{ __('app.years_experience') }}</span></div></div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400"><div class="hero-stat"><span class="stat-num" data-count="{{ $stats['clients'] }}">0</span><span class="stat-label">{{ __('app.happy_clients') }}</span></div></div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="500"><div class="hero-stat"><span class="stat-num" data-count="{{ $stats['countries'] }}">0</span><span class="stat-label">{{ __('app.countries') }}</span></div></div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ====== FEATURED PROJECTS ====== --}}
@elseif($section->key === 'featured' && $featuredProjects->count())
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
                        <img src="{{ $project->getMainImageThumbUrl() }}" alt="{{ $project->getTitle() }}" class="project-img" loading="lazy">
                        <div class="project-overlay">
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-gold btn-sm">{{ __('app.view_project') }}</a>
                        </div>
                        <div class="project-badges">
                            <span class="badge-status status-{{ $project->status }}">{{ $project->getStatusLabel() }}</span>
                            @if($project->featured)<span class="badge-featured"><i class="fas fa-star"></i></span>@endif
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-type"><i class="fas fa-tag"></i> {{ $project->getTypeLabel() }}</div>
                        <h3 class="project-title"><a href="{{ route('projects.show', $project->slug) }}">{{ $project->getTitle() }}</a></h3>
                        <p class="project-location"><i class="fas fa-map-marker-alt"></i> {{ $project->getLocation() }}</p>
                        <div class="project-footer">
                            <div class="project-price">
                                @if($countryCode === 'IQ' && $project->price_iqd) {{ number_format($project->price_iqd, 0) }} د.ع
                                @elseif($countryCode === 'TR' && $project->price_try) ₺{{ number_format($project->price_try, 0) }}
                                @elseif($project->price_usd) ${{ number_format($project->price_usd, 0) }}
                                @else {{ __('app.price_on_request') }} @endif
                            </div>
                            <div class="project-meta">
                                @if($project->area)<span><i class="fas fa-vector-square"></i> {{ $project->area }}</span>@endif
                                @if($project->units)<span><i class="fas fa-door-open"></i> {{ $project->units }}</span>@endif
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

{{-- ====== SEARCH BY AREA ====== --}}
@elseif($section->key === 'search_area')
<section class="section-search-area py-6">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label">{{ app()->getLocale() === 'en' ? 'Browse by Area' : 'تصفح حسب المنطقة' }}</span>
            <h2 class="section-title">{{ app()->getLocale() === 'en' ? 'Find Your Property by Location' : 'اعثر على عقارك حسب الموقع' }}</h2>
            <div class="title-divider"><span></span></div>
            <p class="section-subtitle mt-3">{{ app()->getLocale() === 'en' ? 'Explore our projects distributed across the most prominent investment cities' : 'استكشف مشاريعنا الموزعة في أبرز المدن الاستثمارية' }}</p>
        </div>

        {{-- Quick Type Filter Bar --}}
        <div class="type-filter-bar mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="{{ route('projects.index') }}" class="type-filter-btn {{ !request('type') ? 'active' : '' }}">
                    <i class="fas fa-th me-2"></i>{{ app()->getLocale() === 'en' ? 'All' : 'الكل' }}
                </a>
                @foreach([
                    'tower'       => ['icon' => 'fas fa-building',    'ar' => 'أبراج',        'en' => 'Towers'],
                    'villa'       => ['icon' => 'fas fa-home',         'ar' => 'فلل',          'en' => 'Villas'],
                    'apartment'   => ['icon' => 'fas fa-city',         'ar' => 'شقق',          'en' => 'Apartments'],
                    'commercial'  => ['icon' => 'fas fa-store',        'ar' => 'تجاري',        'en' => 'Commercial'],
                    'compound'    => ['icon' => 'fas fa-tree',         'ar' => 'مجمعات',       'en' => 'Compounds'],
                    'residential' => ['icon' => 'fas fa-house-user',   'ar' => 'سكني',         'en' => 'Residential'],
                ] as $typeKey => $typeData)
                <a href="{{ route('projects.index', ['type' => $typeKey]) }}"
                   class="type-filter-btn {{ request('type') === $typeKey ? 'active' : '' }}">
                    <i class="{{ $typeData['icon'] }} me-2"></i>{{ app()->getLocale() === 'en' ? $typeData['en'] : $typeData['ar'] }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- City Cards --}}
        @if($areaProjects->count())
        <div class="row g-4" id="area-cards-row">
            @foreach($areaProjects->take(8) as $city => $cityProjects)
            @php $firstProject = $cityProjects->first(); @endphp
            <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                <a href="{{ route('projects.index', ['search' => $city]) }}" class="area-card">
                    <div class="area-card-img-wrap">
                        <img src="{{ $firstProject->getMainImageThumbUrl() }}"
                             alt="{{ $city }}"
                             class="area-card-img"
                             loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1486325212027-8081e485255e?w=400&q=70'">
                        <div class="area-card-overlay"></div>
                    </div>
                    <div class="area-card-body">
                        <h3 class="area-card-city">{{ $city }}</h3>
                        <span class="area-card-count">
                            {{ $cityProjects->count() }}
                            {{ app()->getLocale() === 'en' ? ($cityProjects->count() === 1 ? 'project' : 'projects') : 'مشروع' }}
                        </span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        @if($areaProjects->count() > 8)
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-gold">
                {{ app()->getLocale() === 'en' ? 'View All Cities' : 'عرض كل المدن' }}
                <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} ms-2"></i>
            </a>
        </div>
        @endif
        @else
        {{-- Fallback: show static city buttons when no projects yet --}}
        <div class="row g-3 justify-content-center">
            @foreach([
                ['name_ar' => 'إسطنبول',  'name_en' => 'Istanbul',  'icon' => 'fas fa-mosque',        'img' => 'https://images.unsplash.com/photo-1527838832700-5059252407fa?w=400&q=70'],
                ['name_ar' => 'أنطاليا',  'name_en' => 'Antalya',   'icon' => 'fas fa-umbrella-beach', 'img' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400&q=70'],
                ['name_ar' => 'أنقرة',    'name_en' => 'Ankara',    'icon' => 'fas fa-landmark',       'img' => 'https://images.unsplash.com/photo-1601979031925-424e53b6caaa?w=400&q=70'],
                ['name_ar' => 'بغداد',    'name_en' => 'Baghdad',   'icon' => 'fas fa-archway',        'img' => 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?w=400&q=70'],
                ['name_ar' => 'دبي',      'name_en' => 'Dubai',     'icon' => 'fas fa-star',           'img' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&q=70'],
                ['name_ar' => 'عمّان',    'name_en' => 'Amman',     'icon' => 'fas fa-city',           'img' => 'https://images.unsplash.com/photo-1539650116574-8efeb43e2750?w=400&q=70'],
            ] as $i => $c)
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                <a href="{{ route('projects.index', ['search' => app()->getLocale() === 'en' ? $c['name_en'] : $c['name_ar']]) }}" class="area-card">
                    <div class="area-card-img-wrap">
                        <img src="{{ $c['img'] }}" alt="{{ app()->getLocale() === 'en' ? $c['name_en'] : $c['name_ar'] }}" class="area-card-img" loading="lazy">
                        <div class="area-card-overlay"></div>
                    </div>
                    <div class="area-card-body">
                        <h3 class="area-card-city">{{ app()->getLocale() === 'en' ? $c['name_en'] : $c['name_ar'] }}</h3>
                        <span class="area-card-count"><i class="{{ $c['icon'] }}"></i></span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- ====== WHY US ====== --}}
@elseif($section->key === 'why_us')
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
                ['icon'=>'fas fa-award',   'title_ar'=>\App\Models\Setting::get('why_1_title_ar','خبرة 15 عاماً'),    'title_en'=>\App\Models\Setting::get('why_1_title_en','15 Years Experience'),   'desc_ar'=>\App\Models\Setting::get('why_1_desc_ar',''),  'desc_en'=>\App\Models\Setting::get('why_1_desc_en','')],
                ['icon'=>'fas fa-handshake','title_ar'=>\App\Models\Setting::get('why_2_title_ar','موثوقية عالية'),    'title_en'=>\App\Models\Setting::get('why_2_title_en','High Reliability'),      'desc_ar'=>\App\Models\Setting::get('why_2_desc_ar',''),  'desc_en'=>\App\Models\Setting::get('why_2_desc_en','')],
                ['icon'=>'fas fa-globe',   'title_ar'=>\App\Models\Setting::get('why_3_title_ar','انتشار عالمي'),     'title_en'=>\App\Models\Setting::get('why_3_title_en','Global Presence'),       'desc_ar'=>\App\Models\Setting::get('why_3_desc_ar',''),  'desc_en'=>\App\Models\Setting::get('why_3_desc_en','')],
                ['icon'=>'fas fa-headset', 'title_ar'=>\App\Models\Setting::get('why_4_title_ar','دعم مستمر'),        'title_en'=>\App\Models\Setting::get('why_4_title_en','Continuous Support'),     'desc_ar'=>\App\Models\Setting::get('why_4_desc_ar',''),  'desc_en'=>\App\Models\Setting::get('why_4_desc_en','')],
            ];
            @endphp
            @foreach($whyItems as $i => $item)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="why-card">
                    <div class="why-icon"><i class="{{ $item['icon'] }}"></i></div>
                    <h3 class="why-title">{{ app()->getLocale() === 'en' ? $item['title_en'] : $item['title_ar'] }}</h3>
                    <p class="why-desc">{{ app()->getLocale() === 'en' ? $item['desc_en'] : $item['desc_ar'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ====== ABOUT ====== --}}
@elseif($section->key === 'about')
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
                    <h2 class="section-title mb-4">{{ \App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Start Real Estate') }}</h2>
                    <p class="about-text">{{ \App\Models\Setting::get('about_text_' . app()->getLocale(), \App\Models\Setting::get('about_text_ar')) }}</p>
                    <div class="about-stats row mt-4">
                        <div class="col-4 text-center"><div class="mini-stat"><span class="mini-stat-num">{{ $stats['projects'] }}+</span><span class="mini-stat-label">{{ __('app.completed_projects') }}</span></div></div>
                        <div class="col-4 text-center"><div class="mini-stat"><span class="mini-stat-num">{{ $stats['clients'] }}+</span><span class="mini-stat-label">{{ __('app.happy_clients') }}</span></div></div>
                        <div class="col-4 text-center"><div class="mini-stat"><span class="mini-stat-num">{{ $stats['countries'] }}</span><span class="mini-stat-label">{{ __('app.countries') }}</span></div></div>
                    </div>
                    <a href="{{ route('about') }}" class="btn btn-gold mt-4">
                        {{ __('app.our_story') }} <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====== MAP ====== --}}
@elseif($section->key === 'map')
<section class="section-map py-6 bg-dark-section">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label">{{ app()->getLocale() === 'en' ? 'Our Projects on the Map' : 'مشاريعنا على الخريطة' }}</span>
            <h2 class="section-title">{{ app()->getLocale() === 'en' ? 'Explore Properties Geographically' : 'استكشف العقارات جغرافياً' }}</h2>
            <div class="title-divider"><span></span></div>
        </div>

        <div class="map-wrapper" data-aos="fade-up" data-aos-delay="100">
            <div id="projects-map" style="height:520px;border-radius:16px;overflow:hidden;"></div>
        </div>

        @if($mapProjects->isEmpty())
        <div class="text-center mt-4">
            <p class="text-muted">
                <i class="fas fa-map-marker-alt me-2"></i>
                {{ app()->getLocale() === 'en' ? 'Add coordinates to your projects from the admin panel to display them on the map.' : 'أضف إحداثيات لمشاريعك من لوحة التحكم لعرضها على الخريطة.' }}
            </p>
            <a href="{{ route('projects.index') }}" class="btn btn-outline-gold mt-2">
                {{ app()->getLocale() === 'en' ? 'Browse All Projects' : 'تصفح جميع المشاريع' }}
            </a>
        </div>
        @endif

        @php
        $mapData = $mapProjects->map(fn($p) => [
            'lat'   => (float) $p->latitude,
            'lng'   => (float) $p->longitude,
            'title' => $p->getTitle(),
            'loc'   => $p->getLocation(),
            'img'   => $p->getMainImageThumbUrl(),
            'url'   => route('projects.show', $p->slug),
            'price' => $p->price_usd ? '$' . number_format($p->price_usd, 0) : null,
            'type'  => $p->type,
        ])->values();
        @endphp
        <script id="map-projects-data" type="application/json">{!! json_encode($mapData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    </div>
</section>

{{-- ====== LATEST PROJECTS ====== --}}
@elseif($section->key === 'latest' && $latestProjects->count())
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
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-gold btn-sm">{{ __('app.view_project') }}</a>
                        </div>
                        <span class="badge-status status-{{ $project->status }}">{{ $project->getStatusLabel() }}</span>
                    </div>
                    <div class="project-body">
                        <div class="project-type"><i class="fas fa-tag"></i> {{ $project->getTypeLabel() }}</div>
                        <h3 class="project-title"><a href="{{ route('projects.show', $project->slug) }}">{{ $project->getTitle() }}</a></h3>
                        <p class="project-location"><i class="fas fa-map-marker-alt"></i> {{ $project->getLocation() }}</p>
                        <div class="project-footer">
                            <div class="project-price">
                                @if($countryCode === 'IQ' && $project->price_iqd) {{ number_format($project->price_iqd, 0) }} د.ع
                                @elseif($countryCode === 'TR' && $project->price_try) ₺{{ number_format($project->price_try, 0) }}
                                @elseif($project->price_usd) ${{ number_format($project->price_usd, 0) }}
                                @else {{ __('app.price_on_request') }} @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ====== CTA ====== --}}
@elseif($section->key === 'cta')
<section class="section-cta py-6">
    <div class="container">
        <div class="cta-box text-center" data-aos="zoom-in">
            <h2 class="cta-title">{{ app()->getLocale() === 'en' ? 'Ready to Find Your Dream Property?' : 'هل أنت مستعد للعثور على عقار أحلامك؟' }}</h2>
            <p class="cta-text">{{ app()->getLocale() === 'en' ? 'Contact our team of experts and let us help you find the perfect property.' : 'تواصل مع فريق الخبراء لدينا ودعنا نساعدك في إيجاد العقار المثالي.' }}</p>
            <div class="cta-actions mt-4">
                <a href="{{ route('contact') }}" class="btn btn-gold btn-lg me-3">
                    <i class="fas fa-envelope me-2"></i>{{ __('app.contact_us') }}
                </a>
                @if(isset($whatsapp))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" class="btn btn-whatsapp btn-lg">
                    <i class="fab fa-whatsapp me-2"></i>{{ __('app.whatsapp') }}
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

@endforeach

@endsection

@push('map_css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
@endpush

@push('map_js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV/XN/WLcE=" crossorigin=""></script>
<script>
(function() {
    var el = document.getElementById('projects-map');
    var dataEl = document.getElementById('map-projects-data');
    if (!el || !dataEl) return;

    var projects = JSON.parse(dataEl.textContent || '[]');
    if (!projects.length) return;

    var validProjects = projects.filter(function(p) { return p.lat && p.lng; });
    if (!validProjects.length) return;

    var map = L.map('projects-map', { scrollWheelZoom: false, zoomControl: true });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18
    }).addTo(map);

    var goldIcon = L.divIcon({
        html: '<div style="background:#c8a96e;width:32px;height:32px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -35],
        className: ''
    });

    var bounds = [];
    validProjects.forEach(function(p) {
        bounds.push([p.lat, p.lng]);
        var imgHtml = p.img ? '<img src="' + p.img + '" class="map-popup-img" alt="' + p.title + '" onerror="this.style.display=\'none\'">' : '';
        var priceHtml = p.price ? '<div class="map-popup-price">' + p.price + '</div>' : '';
        var popup = '<div style="min-width:160px;">'
            + imgHtml
            + '<div class="map-popup-title">' + p.title + '</div>'
            + '<div class="map-popup-loc"><i class="fas fa-map-marker-alt" style="color:#c8a96e;margin-left:3px;margin-right:3px;"></i>' + p.loc + '</div>'
            + priceHtml
            + '<a href="' + p.url + '" class="map-popup-link">عرض المشروع</a>'
            + '</div>';
        L.marker([p.lat, p.lng], { icon: goldIcon }).addTo(map).bindPopup(popup);
    });

    if (bounds.length === 1) {
        map.setView(bounds[0], 13);
    } else {
        map.fitBounds(bounds, { padding: [40, 40] });
    }
})();
</script>
@endpush

@if($heroType === 'slider' && $heroSlides->count())
@push('scripts')
<script>
if (document.querySelector('.hero-swiper')) {
    new Swiper('.hero-swiper', {
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        effect: 'fade',
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        pagination: { el: '.swiper-pagination', clickable: true },
    });
}
</script>
@endpush
@endif
