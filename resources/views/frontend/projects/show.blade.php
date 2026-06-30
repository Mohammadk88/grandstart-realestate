@extends('layouts.app')

@section('title', $project->getTitle() . ' - ' . \App\Models\Setting::get('company_name_' . app()->getLocale()))
@section('description', Str::limit(strip_tags($project->getDescription()), 160))
@section('og_type', 'article')
@section('og_image', $project->getMainImageUrl())

@push('schema')
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Product',
        '@id'      => route('projects.show', $project->slug),
        'name'     => $project->getTitle(),
        'description' => Str::limit(strip_tags($project->getDescription()), 300),
        'image'    => $project->getMainImageUrl(),
        'url'      => route('projects.show', $project->slug),
        'brand'    => ['@type' => 'Brand', 'name' => \App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Start Real Estate')],
        'additionalProperty' => array_filter([
            $project->area   ? ['@type' => 'PropertyValue', 'name' => 'Area',   'value' => $project->area]   : null,
            $project->floors ? ['@type' => 'PropertyValue', 'name' => 'Floors', 'value' => $project->floors] : null,
            ['@type' => 'PropertyValue', 'name' => 'Status', 'value' => $project->status],
            ['@type' => 'PropertyValue', 'name' => 'Type',   'value' => $project->type],
        ]),
    ];
    if ($project->price_usd) {
        $schema['offers'] = [
            '@type'        => 'Offer',
            'priceCurrency'=> 'USD',
            'price'        => (string) $project->price_usd,
            'availability' => $project->status === 'available' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content text-center">
            <h1 class="page-header-title" data-aos="fade-down">{{ $project->getTitle() }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('app.projects') }}</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($project->getTitle(), 40) }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Project Detail Section -->
<section class="project-detail py-6">
    <div class="container">
        <div class="row g-5">

            <!-- Left: Gallery + Description -->
            <div class="col-lg-8">

                <!-- Main Image / Gallery -->
                @php
                    $allGalleryImages = collect();
                    // Always add main image first
                    $allGalleryImages->push(['url' => $project->getMainImageUrl(), 'thumb' => $project->getMainImageThumbUrl()]);
                    foreach($project->images as $img) {
                        $allGalleryImages->push(['url' => $img->getUrl(), 'thumb' => $img->getThumbUrl()]);
                    }
                    foreach($project->mediaImages as $img) {
                        $allGalleryImages->push(['url' => $img->getUrl(), 'thumb' => $img->getThumbUrl()]);
                    }
                    $hasGallery = $allGalleryImages->count() > 1;
                @endphp

                <div class="project-gallery" data-aos="fade-up">
                    @if($hasGallery)
                    <div class="swiper gallery-swiper mb-3">
                        <div class="swiper-wrapper">
                            @foreach($allGalleryImages as $i => $img)
                            <div class="swiper-slide">
                                <a href="{{ $img['url'] }}" class="glightbox" data-gallery="project-gallery"
                                   data-glightbox="slide-effect: zoom">
                                    <img src="{{ $img['url'] }}" alt="{{ $project->getTitle() }}" class="gallery-main-img">
                                    <div class="gallery-zoom-btn"><i class="fas fa-expand-alt"></i></div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-pagination"></div>
                        <div class="gallery-count-badge">
                            <i class="fas fa-images me-1"></i>{{ $allGalleryImages->count() }}
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="swiper gallery-thumbs">
                        <div class="swiper-wrapper">
                            @foreach($allGalleryImages as $img)
                            <div class="swiper-slide">
                                <img src="{{ $img['thumb'] }}" alt="" class="gallery-thumb-img">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="single-project-image mb-4">
                        <a href="{{ $project->getMainImageUrl() }}" class="glightbox">
                            <img src="{{ $project->getMainImageUrl() }}" alt="{{ $project->getTitle() }}" class="img-fluid rounded">
                            <div class="gallery-zoom-btn"><i class="fas fa-expand-alt"></i></div>
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Project Info Badges -->
                <div class="project-info-row mt-4 mb-4" data-aos="fade-up">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-tag"></i>
                                <span class="info-badge-label">{{ __('app.filter_type') }}</span>
                                <span class="info-badge-value">{{ $project->getTypeLabel() }}</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-circle-check"></i>
                                <span class="info-badge-label">{{ __('app.filter_status') }}</span>
                                <span class="info-badge-value">{{ $project->getStatusLabel() }}</span>
                            </div>
                        </div>
                        @if($project->area)
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-vector-square"></i>
                                <span class="info-badge-label">{{ __('app.area') }}</span>
                                <span class="info-badge-value">{{ $project->area }}</span>
                            </div>
                        </div>
                        @endif
                        @if($project->floors)
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-layer-group"></i>
                                <span class="info-badge-label">{{ __('app.floors') }}</span>
                                <span class="info-badge-value">{{ $project->floors }}</span>
                            </div>
                        </div>
                        @endif
                        @if($project->units)
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-door-open"></i>
                                <span class="info-badge-label">{{ __('app.units') }}</span>
                                <span class="info-badge-value">{{ $project->units }}</span>
                            </div>
                        </div>
                        @endif
                        @if($project->delivery_date)
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="info-badge-label">{{ __('app.delivery_date') }}</span>
                                <span class="info-badge-value">{{ $project->delivery_date->format('Y') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="project-description" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        {{ app()->getLocale() === 'en' ? 'Project Description' : 'وصف المشروع' }}
                    </h3>
                    <div class="description-content">
                        {!! nl2br(e($project->getDescription())) !!}
                    </div>
                </div>

                <!-- Features -->
                @if($project->features->count())
                <div class="project-features-section mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">{{ __('app.project_features') }}</h3>
                    <div class="row g-3">
                        @foreach($project->features as $feature)
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="{{ $feature->icon ?? 'fas fa-check' }}"></i>
                                </div>
                                <span class="feature-text">{{ $feature->getLabel() }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Videos -->
                @php $projectVideos = $project->media()->where('type','video')->get(); @endphp
                @if($projectVideos->count() || $project->video_url)
                <div class="project-video mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        <i class="fas fa-video me-2"></i>{{ __('app.project_video') }}
                    </h3>
                    @if($projectVideos->count() === 1)
                    {{-- Single video: inline player --}}
                    <div class="video-player-wrap">
                        <video controls class="w-100" poster="{{ $project->getMainImageThumbUrl() }}">
                            <source src="{{ $projectVideos->first()->getUrl() }}" type="video/mp4">
                        </video>
                    </div>
                    @elseif($projectVideos->count() > 1)
                    {{-- Multiple videos: tabs --}}
                    <div class="video-tabs">
                        @foreach($projectVideos as $i => $vid)
                        <button class="video-tab-btn {{ $i===0?'active':'' }}"
                                onclick="switchVideo(this, '{{ $vid->getUrl() }}', '{{ $vid->original_name ?: 'فيديو '.($i+1) }}')">
                            <i class="fas fa-play-circle me-1"></i>
                            {{ $vid->original_name ? \Illuminate\Support\Str::limit($vid->original_name, 25) : 'فيديو '.($i+1) }}
                        </button>
                        @endforeach
                    </div>
                    <div class="video-player-wrap mt-3">
                        <video id="mainVideoPlayer" controls class="w-100" poster="{{ $project->getMainImageThumbUrl() }}">
                            <source src="{{ $projectVideos->first()->getUrl() }}" type="video/mp4">
                        </video>
                    </div>
                    @elseif($project->video_url)
                    <div class="ratio ratio-16x9 rounded overflow-hidden">
                        <iframe src="{{ $project->video_url }}" allowfullscreen loading="lazy"></iframe>
                    </div>
                    @endif
                </div>
                @endif

                <!-- PDFs -->
                @php $projectPdfs = $project->media()->where('type','pdf')->get(); @endphp
                @if($projectPdfs->count())
                <div class="project-pdfs mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        <i class="fas fa-file-pdf me-2"></i>{{ __('app.downloads') }}
                    </h3>
                    <div class="pdf-cards-grid">
                        @foreach($projectPdfs as $pdf)
                        <a href="{{ $pdf->getUrl() }}" target="_blank" class="pdf-card" download>
                            <div class="pdf-card-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="pdf-card-body">
                                <div class="pdf-card-name">{{ $pdf->original_name ?: basename($pdf->path) }}</div>
                                <div class="pdf-card-meta">
                                    <span class="pdf-card-size">{{ $pdf->getFileSizeFormatted() }}</span>
                                </div>
                            </div>
                            <div class="pdf-card-action">
                                <i class="fas fa-download"></i>
                                <span>{{ app()->getLocale() === 'ar' ? 'تحميل' : (app()->getLocale() === 'tr' ? 'İndir' : 'Download') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Location (city/district) -->
                @if($project->country || $project->city || $project->district)
                <div class="project-location-detail mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ app()->getLocale() === 'en' ? 'Location' : 'الموقع' }}
                    </h3>
                    <div class="location-tags d-flex flex-wrap gap-2 mb-2">
                        @if($project->country)
                        <span class="location-tag">
                            <i class="fas fa-globe me-1"></i>{{ $project->getCountryName() }}
                        </span>
                        @endif
                        @if($project->city)
                        <span class="location-tag">
                            <i class="fas fa-city me-1"></i>{{ $project->getProvinceName() }}
                        </span>
                        @endif
                        @if($project->district)
                        <span class="location-tag">
                            <i class="fas fa-map-pin me-1"></i>{{ $project->getDistrictName() }}
                        </span>
                        @endif
                    </div>
                    @if($project->getAddressDetail())
                    <p class="mt-2 mb-0 text-muted small">
                        <i class="fas fa-location-dot me-1"></i>{{ $project->getAddressDetail() }}
                    </p>
                    @endif
                </div>
                @endif

            </div>

            <!-- Right: Sidebar -->
            <div class="col-lg-4">
                <div class="project-sidebar sticky-top" style="top: 90px;">

                    <!-- Price Card -->
                    <div class="price-card" data-aos="fade-left">
                        <div class="price-card-header">
                            <h4>{{ __('app.project_details') }}</h4>
                        </div>
                        <div class="price-card-body">
                            <div class="price-display">
                                @php
                                    $priceField = $countryContact?->price_field ?? 'price_usd';
                                    $priceValue = $project->$priceField ?? null;
                                    $symbol     = $countryContact?->currency_symbol ?? '$';
                                    $currency   = $countryContact?->currency_code ?? 'USD';
                                @endphp
                                @if($priceValue)
                                <div class="price-main">
                                    {{ $symbol }}{{ number_format($priceValue, 0) }}
                                    <span class="price-currency">{{ $currency }}</span>
                                </div>
                                @if($priceField !== 'price_usd' && $project->price_usd)
                                <div class="price-alt">${{ number_format($project->price_usd, 0) }} USD</div>
                                @endif
                                @elseif($project->price_usd)
                                <div class="price-main">
                                    ${{ number_format($project->price_usd, 0) }}
                                    <span class="price-currency">USD</span>
                                </div>
                                @else
                                <div class="price-main">{{ __('app.price_on_request') }}</div>
                                @endif
                            </div>

                            <div class="price-location mt-3">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $project->getLocation() }}
                            </div>

                            <hr class="divider-gold">

                            <!-- Contact Form in Sidebar -->
                            <form action="{{ route('contact.store') }}" method="POST" class="sidebar-contact-form">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                <input type="hidden" name="source" value="project_page">

                                <h5 class="form-title mb-3">{{ __('app.request_info') }}</h5>

                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control dark-input"
                                           placeholder="{{ __('app.your_name') }}" required>
                                </div>
                                <div class="mb-3">
                                    <input type="tel" name="phone" class="form-control dark-input"
                                           placeholder="{{ __('app.your_phone') }}" required>
                                </div>
                                <div class="mb-3">
                                    <textarea name="message" class="form-control dark-input" rows="3"
                                              placeholder="{{ __('app.your_message') }}">{{ app()->getLocale() === 'en' ? 'I am interested in ' . $project->getTitle() : 'أنا مهتم بـ ' . $project->getTitle() }}</textarea>
                                </div>

                                @if(session('success'))
                                <div class="alert alert-success mb-3">{{ session('success') }}</div>
                                @endif

                                <button type="submit" class="btn btn-gold w-100">
                                    <i class="fas fa-paper-plane me-2"></i>{{ __('app.send_message') }}
                                </button>
                            </form>

                            <!-- WhatsApp Button -->
                            @if(isset($whatsapp))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}?text={{ urlencode((app()->getLocale() === 'en' ? 'I am interested in: ' : 'أنا مهتم بـ: ') . $project->getTitle()) }}"
                               target="_blank" class="btn btn-whatsapp w-100 mt-2">
                                <i class="fab fa-whatsapp me-2"></i>{{ __('app.chat_whatsapp') }}
                            </a>
                            @endif

                            <!-- Phone -->
                            @if(isset($phone) && $phone)
                            <a href="tel:{{ $phone }}" class="btn btn-outline-light w-100 mt-2">
                                <i class="fas fa-phone-alt me-2"></i>{{ $phone }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Projects -->
        @if($relatedProjects->count())
        <div class="related-projects mt-6" data-aos="fade-up">
            <h3 class="section-title mb-4">{{ __('app.related_projects') }}</h3>
            <div class="row g-4">
                @foreach($relatedProjects as $related)
                <div class="col-lg-4 col-md-6">
                    <div class="project-card">
                        <div class="project-image-wrap">
                            <img src="{{ $related->getMainImageThumbUrl() }}" alt="{{ $related->getTitle() }}" class="project-img" loading="lazy">
                            <div class="project-overlay">
                                <a href="{{ route('projects.show', $related->slug) }}" class="btn btn-gold btn-sm">
                                    {{ __('app.view_project') }}
                                </a>
                            </div>
                        </div>
                        <div class="project-body">
                            <h3 class="project-title">
                                <a href="{{ route('projects.show', $related->slug) }}">{{ $related->getTitle() }}</a>
                            </h3>
                            <p class="project-location"><i class="fas fa-map-marker-alt"></i> {{ $related->getLocation() }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection

@push('head_scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/css/glightbox.min.css"
      integrity="sha384-GPAzSuZc0kFvdIev6wm9zg8gnafE8tLso7rsAYQfc9hAdWCpOcpcNI5W9lWkYcsd"
      crossorigin="anonymous">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/js/glightbox.min.js"
        integrity="sha384-/+Fc1LD6ksHYZ+2MChiSfjEXBcl4q2axUWhs6/CdnfqY5aLmrPwtysVzyeP0s60b"
        crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── GLightbox ─────────────────────────────────────────
    GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });

    // ── Gallery Swiper ─────────────────────────────────────
    @if($hasGallery)
    const galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 8,
        slidesPerView: 'auto',
        freeMode: true,
        watchSlidesProgress: true,
    });
    new Swiper('.gallery-swiper', {
        spaceBetween: 10,
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        pagination: { el: '.swiper-pagination', clickable: true },
        thumbs: { swiper: galleryThumbs },
    });
    @endif

    @if($project->latitude && $project->longitude)
    const mapEl = document.getElementById('projectMap');
    if (mapEl && typeof L !== 'undefined') {
        const map = L.map('projectMap').setView([{{ $project->latitude }}, {{ $project->longitude }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([{{ $project->latitude }}, {{ $project->longitude }}]).addTo(map)
            .bindPopup('{{ $project->getTitle() }}').openPopup();
    }
    @endif
});

// ── Multi-video tab switch ────────────────────────────────
function switchVideo(btn, url, name) {
    document.querySelectorAll('.video-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const player = document.getElementById('mainVideoPlayer');
    if (player) {
        player.pause();
        player.querySelector('source').src = url;
        player.load();
    }
}
</script>

@push('styles')
<style>
/* ── Gallery zoom button ── */
.gallery-main-img { display:block; }
.swiper-slide > a { position:relative; display:block; }
.gallery-zoom-btn {
    position: absolute;
    bottom: 12px; right: 12px;
    background: rgba(0,0,0,.5);
    color: #fff;
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items:center; justify-content:center;
    font-size: .85rem;
    opacity: 0;
    transition: opacity .2s;
    backdrop-filter: blur(4px);
}
.swiper-slide:hover .gallery-zoom-btn,
.single-project-image:hover .gallery-zoom-btn { opacity: 1; }
.single-project-image { position: relative; }
.single-project-image > a { display:block; position:relative; }

/* ── Gallery count badge ── */
.gallery-count-badge {
    position: absolute;
    bottom: 12px; left: 12px;
    background: rgba(0,0,0,.55);
    color: #fff;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: .78rem;
    z-index: 10;
    backdrop-filter: blur(4px);
}
.gallery-swiper { position: relative; }

/* ── Video player ── */
.video-player-wrap {
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,.15);
}
.video-player-wrap video { display:block; max-height: 420px; }
.video-tabs { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:8px; }
.video-tab-btn {
    padding: 6px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    background: #f9fafb;
    font-size: .82rem;
    cursor: pointer;
    transition: all .2s;
    color: #555;
}
.video-tab-btn.active,
.video-tab-btn:hover {
    background: var(--gold);
    border-color: var(--gold);
    color: #fff;
}

/* ── PDF cards grid ── */
.pdf-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 14px;
}
.pdf-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem 1rem 1rem;
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    text-decoration: none;
    color: #333;
    transition: all .25s;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.pdf-card:hover {
    border-color: #dc3545;
    box-shadow: 0 6px 20px rgba(220,53,69,.12);
    transform: translateY(-3px);
    color: #dc3545;
}
.pdf-card-icon {
    font-size: 3rem;
    color: #dc3545;
    margin-bottom: .75rem;
    line-height: 1;
}
.pdf-card-body { flex: 1; }
.pdf-card-name {
    font-weight: 700;
    font-size: .85rem;
    line-height: 1.3;
    margin-bottom: .25rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.pdf-card-meta { font-size: .72rem; color: #aaa; margin-bottom: .75rem; }
.pdf-card-action {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #dc3545;
    color: #fff;
    padding: 6px 18px;
    border-radius: 20px;
    font-size: .8rem;
    font-weight: 600;
    margin-top: .5rem;
    transition: background .2s;
}
.pdf-card:hover .pdf-card-action { background: #b91c1c; }
</style>
@endpush
@endpush
