<?php $__env->startSection('title', $project->getTitle() . ' - ' . \App\Models\Setting::get('company_name_' . app()->getLocale())); ?>
<?php $__env->startSection('description', Str::limit(strip_tags($project->getDescription()), 160)); ?>
<?php $__env->startSection('og_type', 'article'); ?>
<?php $__env->startSection('og_image', $project->getMainImageUrl()); ?>

<?php $__env->startPush('schema'); ?>
<?php
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
?>
<script type="application/ld+json"><?php echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content text-center">
            <h1 class="page-header-title" data-aos="fade-down"><?php echo e($project->getTitle()); ?></h1>
            <nav aria-label="breadcrumb" data-aos="fade-up">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('app.home')); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('projects.index')); ?>"><?php echo e(__('app.projects')); ?></a></li>
                    <li class="breadcrumb-item active"><?php echo e(Str::limit($project->getTitle(), 40)); ?></li>
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
                <?php
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
                ?>

                <div class="project-gallery" data-aos="fade-up">
                    <?php if($hasGallery): ?>
                    <div class="swiper gallery-swiper mb-3">
                        <div class="swiper-wrapper">
                            <?php $__currentLoopData = $allGalleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <a href="<?php echo e($img['url']); ?>" class="glightbox" data-gallery="project-gallery"
                                   data-glightbox="slide-effect: zoom">
                                    <img src="<?php echo e($img['url']); ?>" alt="<?php echo e($project->getTitle()); ?>" class="gallery-main-img">
                                    <div class="gallery-zoom-btn"><i class="fas fa-expand-alt"></i></div>
                                </a>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-pagination"></div>
                        <div class="gallery-count-badge">
                            <i class="fas fa-images me-1"></i><?php echo e($allGalleryImages->count()); ?>

                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="swiper gallery-thumbs">
                        <div class="swiper-wrapper">
                            <?php $__currentLoopData = $allGalleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <img src="<?php echo e($img['thumb']); ?>" alt="" class="gallery-thumb-img">
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="single-project-image mb-4">
                        <a href="<?php echo e($project->getMainImageUrl()); ?>" class="glightbox">
                            <img src="<?php echo e($project->getMainImageUrl()); ?>" alt="<?php echo e($project->getTitle()); ?>" class="img-fluid rounded">
                            <div class="gallery-zoom-btn"><i class="fas fa-expand-alt"></i></div>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Project Info Badges -->
                <div class="project-info-row mt-4 mb-4" data-aos="fade-up">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-tag"></i>
                                <span class="info-badge-label"><?php echo e(__('app.filter_type')); ?></span>
                                <span class="info-badge-value"><?php echo e($project->getTypeLabel()); ?></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-circle-check"></i>
                                <span class="info-badge-label"><?php echo e(__('app.filter_status')); ?></span>
                                <span class="info-badge-value"><?php echo e($project->getStatusLabel()); ?></span>
                            </div>
                        </div>
                        <?php if($project->area): ?>
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-vector-square"></i>
                                <span class="info-badge-label"><?php echo e(__('app.area')); ?></span>
                                <span class="info-badge-value"><?php echo e($project->area); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($project->floors): ?>
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-layer-group"></i>
                                <span class="info-badge-label"><?php echo e(__('app.floors')); ?></span>
                                <span class="info-badge-value"><?php echo e($project->floors); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($project->units): ?>
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-door-open"></i>
                                <span class="info-badge-label"><?php echo e(__('app.units')); ?></span>
                                <span class="info-badge-value"><?php echo e($project->units); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($project->delivery_date): ?>
                        <div class="col-6 col-md-3">
                            <div class="info-badge">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="info-badge-label"><?php echo e(__('app.delivery_date')); ?></span>
                                <span class="info-badge-value"><?php echo e($project->delivery_date->format('Y')); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Description -->
                <div class="project-description" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        <?php echo e(app()->getLocale() === 'en' ? 'Project Description' : 'وصف المشروع'); ?>

                    </h3>
                    <div class="description-content">
                        <?php echo nl2br(e($project->getDescription())); ?>

                    </div>
                </div>

                <!-- Features -->
                <?php if($project->features->count()): ?>
                <div class="project-features-section mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title"><?php echo e(__('app.project_features')); ?></h3>
                    <div class="row g-3">
                        <?php $__currentLoopData = $project->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="<?php echo e($feature->icon ?? 'fas fa-check'); ?>"></i>
                                </div>
                                <span class="feature-text"><?php echo e($feature->getLabel()); ?></span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Videos -->
                <?php $projectVideos = $project->media()->where('type','video')->get(); ?>
                <?php if($projectVideos->count() || $project->video_url): ?>
                <div class="project-video mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        <i class="fas fa-video me-2"></i><?php echo e(__('app.project_video')); ?>

                    </h3>
                    <?php if($projectVideos->count() === 1): ?>
                    
                    <div class="video-player-wrap">
                        <video controls class="w-100" poster="<?php echo e($project->getMainImageThumbUrl()); ?>">
                            <source src="<?php echo e($projectVideos->first()->getUrl()); ?>" type="video/mp4">
                        </video>
                    </div>
                    <?php elseif($projectVideos->count() > 1): ?>
                    
                    <div class="video-tabs">
                        <?php $__currentLoopData = $projectVideos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $vid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button class="video-tab-btn <?php echo e($i===0?'active':''); ?>"
                                onclick="switchVideo(this, '<?php echo e($vid->getUrl()); ?>', '<?php echo e($vid->original_name ?: 'فيديو '.($i+1)); ?>')">
                            <i class="fas fa-play-circle me-1"></i>
                            <?php echo e($vid->original_name ? \Illuminate\Support\Str::limit($vid->original_name, 25) : 'فيديو '.($i+1)); ?>

                        </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="video-player-wrap mt-3">
                        <video id="mainVideoPlayer" controls class="w-100" poster="<?php echo e($project->getMainImageThumbUrl()); ?>">
                            <source src="<?php echo e($projectVideos->first()->getUrl()); ?>" type="video/mp4">
                        </video>
                    </div>
                    <?php elseif($project->video_url): ?>
                    <div class="ratio ratio-16x9 rounded overflow-hidden">
                        <iframe src="<?php echo e($project->video_url); ?>" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- PDFs -->
                <?php $projectPdfs = $project->media()->where('type','pdf')->get(); ?>
                <?php if($projectPdfs->count()): ?>
                <div class="project-pdfs mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        <i class="fas fa-file-pdf me-2"></i><?php echo e(__('app.downloads')); ?>

                    </h3>
                    <div class="pdf-cards-grid">
                        <?php $__currentLoopData = $projectPdfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($pdf->getUrl()); ?>" target="_blank" class="pdf-card" download>
                            <div class="pdf-card-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="pdf-card-body">
                                <div class="pdf-card-name"><?php echo e($pdf->original_name ?: basename($pdf->path)); ?></div>
                                <div class="pdf-card-meta">
                                    <span class="pdf-card-size"><?php echo e($pdf->getFileSizeFormatted()); ?></span>
                                </div>
                            </div>
                            <div class="pdf-card-action">
                                <i class="fas fa-download"></i>
                                <span><?php echo e(app()->getLocale() === 'ar' ? 'تحميل' : (app()->getLocale() === 'tr' ? 'İndir' : 'Download')); ?></span>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Location (city/district) -->
                <?php if($project->country || $project->city || $project->district): ?>
                <div class="project-location-detail mt-5" data-aos="fade-up">
                    <h3 class="detail-section-title">
                        <i class="fas fa-map-marker-alt me-2"></i><?php echo e(app()->getLocale() === 'en' ? 'Location' : 'الموقع'); ?>

                    </h3>
                    <div class="location-tags d-flex flex-wrap gap-2 mb-2">
                        <?php if($project->country): ?>
                        <span class="location-tag">
                            <i class="fas fa-globe me-1"></i><?php echo e($project->getCountryName()); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($project->city): ?>
                        <span class="location-tag">
                            <i class="fas fa-city me-1"></i><?php echo e($project->getProvinceName()); ?>

                        </span>
                        <?php endif; ?>
                        <?php if($project->district): ?>
                        <span class="location-tag">
                            <i class="fas fa-map-pin me-1"></i><?php echo e($project->getDistrictName()); ?>

                        </span>
                        <?php endif; ?>
                    </div>
                    <?php if($project->getAddressDetail()): ?>
                    <p class="mt-2 mb-0 text-muted small">
                        <i class="fas fa-location-dot me-1"></i><?php echo e($project->getAddressDetail()); ?>

                    </p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right: Sidebar -->
            <div class="col-lg-4">
                <div class="project-sidebar sticky-top" style="top: 90px;">

                    <!-- Price Card -->
                    <div class="price-card" data-aos="fade-left">
                        <div class="price-card-header">
                            <h4><?php echo e(__('app.project_details')); ?></h4>
                        </div>
                        <div class="price-card-body">
                            <div class="price-display">
                                <?php
                                    $priceField = $countryContact?->price_field ?? 'price_usd';
                                    $priceValue = $project->$priceField ?? null;
                                    $symbol     = $countryContact?->currency_symbol ?? '$';
                                    $currency   = $countryContact?->currency_code ?? 'USD';
                                ?>
                                <?php if($priceValue): ?>
                                <div class="price-main">
                                    <?php echo e($symbol); ?><?php echo e(number_format($priceValue, 0)); ?>

                                    <span class="price-currency"><?php echo e($currency); ?></span>
                                </div>
                                <?php if($priceField !== 'price_usd' && $project->price_usd): ?>
                                <div class="price-alt">$<?php echo e(number_format($project->price_usd, 0)); ?> USD</div>
                                <?php endif; ?>
                                <?php elseif($project->price_usd): ?>
                                <div class="price-main">
                                    $<?php echo e(number_format($project->price_usd, 0)); ?>

                                    <span class="price-currency">USD</span>
                                </div>
                                <?php else: ?>
                                <div class="price-main"><?php echo e(__('app.price_on_request')); ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="price-location mt-3">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo e($project->getLocation()); ?>

                            </div>

                            <hr class="divider-gold">

                            <!-- Contact Form in Sidebar -->
                            <form action="<?php echo e(route('contact.store')); ?>" method="POST" class="sidebar-contact-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="project_id" value="<?php echo e($project->id); ?>">
                                <input type="hidden" name="source" value="project_page">

                                <h5 class="form-title mb-3"><?php echo e(__('app.request_info')); ?></h5>

                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control dark-input"
                                           placeholder="<?php echo e(__('app.your_name')); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <input type="tel" name="phone" class="form-control dark-input"
                                           placeholder="<?php echo e(__('app.your_phone')); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <textarea name="message" class="form-control dark-input" rows="3"
                                              placeholder="<?php echo e(__('app.your_message')); ?>"><?php echo e(app()->getLocale() === 'en' ? 'I am interested in ' . $project->getTitle() : 'أنا مهتم بـ ' . $project->getTitle()); ?></textarea>
                                </div>

                                <?php if(session('success')): ?>
                                <div class="alert alert-success mb-3"><?php echo e(session('success')); ?></div>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-gold w-100">
                                    <i class="fas fa-paper-plane me-2"></i><?php echo e(__('app.send_message')); ?>

                                </button>
                            </form>

                            <!-- WhatsApp Button -->
                            <?php if(isset($whatsapp)): ?>
                            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $whatsapp)); ?>?text=<?php echo e(urlencode((app()->getLocale() === 'en' ? 'I am interested in: ' : 'أنا مهتم بـ: ') . $project->getTitle())); ?>"
                               target="_blank" class="btn btn-whatsapp w-100 mt-2">
                                <i class="fab fa-whatsapp me-2"></i><?php echo e(__('app.chat_whatsapp')); ?>

                            </a>
                            <?php endif; ?>

                            <!-- Phone -->
                            <?php if(isset($phone) && $phone): ?>
                            <a href="tel:<?php echo e($phone); ?>" class="btn btn-outline-light w-100 mt-2">
                                <i class="fas fa-phone-alt me-2"></i><?php echo e($phone); ?>

                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Projects -->
        <?php if($relatedProjects->count()): ?>
        <div class="related-projects mt-6" data-aos="fade-up">
            <h3 class="section-title mb-4"><?php echo e(__('app.related_projects')); ?></h3>
            <div class="row g-4">
                <?php $__currentLoopData = $relatedProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="project-card">
                        <div class="project-image-wrap">
                            <img src="<?php echo e($related->getMainImageThumbUrl()); ?>" alt="<?php echo e($related->getTitle()); ?>" class="project-img" loading="lazy">
                            <div class="project-overlay">
                                <a href="<?php echo e(route('projects.show', $related->slug)); ?>" class="btn btn-gold btn-sm">
                                    <?php echo e(__('app.view_project')); ?>

                                </a>
                            </div>
                        </div>
                        <div class="project-body">
                            <h3 class="project-title">
                                <a href="<?php echo e(route('projects.show', $related->slug)); ?>"><?php echo e($related->getTitle()); ?></a>
                            </h3>
                            <p class="project-location"><i class="fas fa-map-marker-alt"></i> <?php echo e($related->getLocation()); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('head_scripts'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/css/glightbox.min.css"
      integrity="sha384-GPAzSuZc0kFvdIev6wm9zg8gnafE8tLso7rsAYQfc9hAdWCpOcpcNI5W9lWkYcsd"
      crossorigin="anonymous">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/js/glightbox.min.js"
        integrity="sha384-/+Fc1LD6ksHYZ+2MChiSfjEXBcl4q2axUWhs6/CdnfqY5aLmrPwtysVzyeP0s60b"
        crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── GLightbox ─────────────────────────────────────────
    GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });

    // ── Gallery Swiper ─────────────────────────────────────
    <?php if($hasGallery): ?>
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
    <?php endif; ?>

    <?php if($project->latitude && $project->longitude): ?>
    const mapEl = document.getElementById('projectMap');
    if (mapEl && typeof L !== 'undefined') {
        const map = L.map('projectMap').setView([<?php echo e($project->latitude); ?>, <?php echo e($project->longitude); ?>], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([<?php echo e($project->latitude); ?>, <?php echo e($project->longitude); ?>]).addTo(map)
            .bindPopup('<?php echo e($project->getTitle()); ?>').openPopup();
    }
    <?php endif; ?>
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

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/frontend/projects/show.blade.php ENDPATH**/ ?>