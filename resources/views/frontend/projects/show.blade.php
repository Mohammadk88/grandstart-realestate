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
                <div class="project-gallery" data-aos="fade-up">
                    @if($project->images->count() > 0)
                    <div class="swiper gallery-swiper mb-3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ $project->getMainImageUrl() }}" alt="{{ $project->getTitle() }}" class="gallery-main-img">
                            </div>
                            @foreach($project->images as $image)
                            <div class="swiper-slide">
                                <img src="{{ $image->getUrl() }}" alt="{{ $project->getTitle() }}" class="gallery-main-img">
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="swiper gallery-thumbs">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ $project->getMainImageThumbUrl() }}" alt="" class="gallery-thumb-img">
                            </div>
                            @foreach($project->images as $image)
                            <div class="swiper-slide">
                                <img src="{{ $image->getThumbUrl() }}" alt="" class="gallery-thumb-img">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="single-project-image mb-4">
                        <img src="{{ $project->getMainImageUrl() }}" alt="{{ $project->getTitle() }}" class="img-fluid rounded">
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

                <!-- Video -->
                @if($project->video_url)
                <div class="project-video mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        {{ app()->getLocale() === 'en' ? 'Project Video' : 'فيديو المشروع' }}
                    </h3>
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ $project->video_url }}" allowfullscreen></iframe>
                    </div>
                </div>
                @endif

                <!-- Map -->
                @if($project->latitude && $project->longitude)
                <div class="project-map mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        {{ app()->getLocale() === 'en' ? 'Location' : 'الموقع' }}
                    </h3>
                    <div id="projectMap" style="height: 350px; border-radius: 12px;"></div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery Swiper
    const galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });

    new Swiper('.gallery-swiper', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        thumbs: {
            swiper: galleryThumbs,
        },
    });

    @if($project->latitude && $project->longitude)
    // Map placeholder (integrates with Leaflet if loaded)
    const mapEl = document.getElementById('projectMap');
    if (mapEl && typeof L !== 'undefined') {
        const map = L.map('projectMap').setView([{{ $project->latitude }}, {{ $project->longitude }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([{{ $project->latitude }}, {{ $project->longitude }}]).addTo(map)
            .bindPopup('{{ $project->getTitle() }}').openPopup();
    }
    @endif
});
</script>
@endpush
