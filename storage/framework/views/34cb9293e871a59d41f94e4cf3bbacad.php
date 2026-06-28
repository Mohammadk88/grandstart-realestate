<?php $__env->startSection('title', \App\Models\Setting::get('meta_title_' . app()->getLocale())); ?>

<?php $__env->startSection('content'); ?>

<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(!$section->active): ?> <?php continue; ?> <?php endif; ?>


<?php if($section->key === 'hero'): ?>

<?php if($heroType === 'slider' && $heroSlides->count()): ?>

<section class="hero-section hero-slider-section p-0" style="min-height:100vh;position:relative;">
    <div class="swiper hero-swiper" style="height:100vh;">
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="swiper-slide" style="background:url('<?php echo e($slide->getImageUrl()); ?>') center/cover no-repeat;position:relative;">
                <div class="hero-overlay" style="position:absolute;inset:0;background:rgba(0,0,0,0.5);z-index:1;"></div>
                <div class="container h-100 d-flex align-items-center" style="position:relative;z-index:2;">
                    <div class="col-lg-8" data-aos="fade-up">
                        <?php if($countryCode === 'IQ'): ?>
                        <div class="iraq-badge mb-3"><i class="fas fa-map-marker-alt"></i> <?php echo e(app()->getLocale() === 'ar' ? 'محتوى خاص للعراق' : 'Iraq Special Content'); ?></div>
                        <?php endif; ?>
                        <?php if($slide->getTitle()): ?>
                        <h1 class="hero-title text-white"><?php echo e($slide->getTitle()); ?></h1>
                        <?php endif; ?>
                        <?php if($slide->getSubtitle()): ?>
                        <p class="hero-subtitle text-white-50"><?php echo e($slide->getSubtitle()); ?></p>
                        <?php endif; ?>
                        <div class="hero-actions mt-4">
                            <?php if($slide->getBtnLabel() && $slide->btn_url): ?>
                            <a href="<?php echo e($slide->btn_url); ?>" class="btn btn-gold btn-lg me-3"><?php echo e($slide->getBtnLabel()); ?></a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('contact')); ?>" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-phone-alt me-2"></i><?php echo e(__('app.hero_contact')); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="swiper-button-prev" style="color:#fff;"></div>
        <div class="swiper-button-next" style="color:#fff;"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Hero Stats Bar -->
    <div class="hero-stats-bar" style="position:absolute;bottom:0;left:0;right:0;z-index:10;">
        <div class="container">
            <div class="row g-0 text-center">
                <div class="col-6 col-md-3"><div class="hero-stat"><span class="stat-num" data-count="<?php echo e($stats['projects']); ?>">0</span><span class="stat-label"><?php echo e(__('app.completed_projects')); ?></span></div></div>
                <div class="col-6 col-md-3"><div class="hero-stat"><span class="stat-num" data-count="<?php echo e($stats['years']); ?>">0</span><span class="stat-label"><?php echo e(__('app.years_experience')); ?></span></div></div>
                <div class="col-6 col-md-3"><div class="hero-stat"><span class="stat-num" data-count="<?php echo e($stats['clients']); ?>">0</span><span class="stat-label"><?php echo e(__('app.happy_clients')); ?></span></div></div>
                <div class="col-6 col-md-3"><div class="hero-stat"><span class="stat-num" data-count="<?php echo e($stats['countries']); ?>">0</span><span class="stat-label"><?php echo e(__('app.countries')); ?></span></div></div>
            </div>
        </div>
    </div>
</section>

<?php else: ?>

<section class="hero-section" <?php if($heroSlides->count()): ?> style="background-image:url('<?php echo e($heroSlides->first()->getImageUrl()); ?>');background-size:cover;background-position:center;" <?php endif; ?>>
    <div class="hero-overlay"></div>
    <div class="hero-particles" id="particles"></div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <?php if($countryCode === 'IQ'): ?>
                <div class="iraq-badge mb-3">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php echo e(app()->getLocale() === 'ar' ? 'محتوى خاص للعراق' : 'Iraq Special Content'); ?>

                </div>
                <?php endif; ?>
                <?php if($heroSlides->count()): ?>
                <h1 class="hero-title"><?php echo e($heroSlides->first()->getTitle() ?: strip_tags(\App\Models\Setting::get('hero_title_' . app()->getLocale(), ''), '<br><strong><em><span>')); ?></h1>
                <p class="hero-subtitle"><?php echo e($heroSlides->first()->getSubtitle() ?: \App\Models\Setting::get('hero_subtitle_' . app()->getLocale())); ?></p>
                <?php else: ?>
                <h1 class="hero-title">
                    <?php echo strip_tags(\App\Models\Setting::get('hero_title_' . app()->getLocale(), \App\Models\Setting::get('hero_title_ar', '')), '<br><strong><em><span>'); ?>

                </h1>
                <p class="hero-subtitle"><?php echo e(\App\Models\Setting::get('hero_subtitle_' . app()->getLocale(), \App\Models\Setting::get('hero_subtitle_ar'))); ?></p>
                <?php endif; ?>
                <div class="hero-actions mt-4">
                    <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-gold btn-lg me-3">
                        <i class="fas fa-building me-2"></i><?php echo e(__('app.hero_cta')); ?>

                    </a>
                    <a href="<?php echo e(route('contact')); ?>" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone-alt me-2"></i><?php echo e(__('app.hero_contact')); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-stats-bar">
        <div class="container">
            <div class="row g-0 text-center">
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200"><div class="hero-stat"><span class="stat-num" data-count="<?php echo e($stats['projects']); ?>">0</span><span class="stat-label"><?php echo e(__('app.completed_projects')); ?></span></div></div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300"><div class="hero-stat"><span class="stat-num" data-count="<?php echo e($stats['years']); ?>">0</span><span class="stat-label"><?php echo e(__('app.years_experience')); ?></span></div></div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400"><div class="hero-stat"><span class="stat-num" data-count="<?php echo e($stats['clients']); ?>">0</span><span class="stat-label"><?php echo e(__('app.happy_clients')); ?></span></div></div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="500"><div class="hero-stat"><span class="stat-num" data-count="<?php echo e($stats['countries']); ?>">0</span><span class="stat-label"><?php echo e(__('app.countries')); ?></span></div></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<?php elseif($section->key === 'featured' && $featuredProjects->count()): ?>
<section class="section-projects py-6">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label"><?php echo e(__('app.featured_projects')); ?></span>
            <h2 class="section-title"><?php echo e(__('app.featured_projects')); ?></h2>
            <div class="title-divider"><span></span></div>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $featuredProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo e(($i % 3) * 100); ?>">
                <div class="project-card">
                    <div class="project-image-wrap">
                        <img src="<?php echo e($project->getMainImageThumbUrl()); ?>" alt="<?php echo e($project->getTitle()); ?>" class="project-img" loading="lazy">
                        <div class="project-overlay">
                            <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="btn btn-gold btn-sm"><?php echo e(__('app.view_project')); ?></a>
                        </div>
                        <div class="project-badges">
                            <span class="badge-status status-<?php echo e($project->status); ?>"><?php echo e($project->getStatusLabel()); ?></span>
                            <?php if($project->featured): ?><span class="badge-featured"><i class="fas fa-star"></i></span><?php endif; ?>
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-type"><i class="fas fa-tag"></i> <?php echo e($project->getTypeLabel()); ?></div>
                        <h3 class="project-title"><a href="<?php echo e(route('projects.show', $project->slug)); ?>"><?php echo e($project->getTitle()); ?></a></h3>
                        <p class="project-location"><i class="fas fa-map-marker-alt"></i> <?php echo e($project->getLocation()); ?></p>
                        <div class="project-footer">
                            <div class="project-price">
                                <?php if($countryCode === 'IQ' && $project->price_iqd): ?> <?php echo e(number_format($project->price_iqd, 0)); ?> د.ع
                                <?php elseif($countryCode === 'TR' && $project->price_try): ?> ₺<?php echo e(number_format($project->price_try, 0)); ?>

                                <?php elseif($project->price_usd): ?> $<?php echo e(number_format($project->price_usd, 0)); ?>

                                <?php else: ?> <?php echo e(__('app.price_on_request')); ?> <?php endif; ?>
                            </div>
                            <div class="project-meta">
                                <?php if($project->area): ?><span><i class="fas fa-vector-square"></i> <?php echo e($project->area); ?></span><?php endif; ?>
                                <?php if($project->units): ?><span><i class="fas fa-door-open"></i> <?php echo e($project->units); ?></span><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-outline-gold btn-lg">
                <?php echo e(__('app.all_projects')); ?> <i class="fas fa-arrow-<?php echo e(app()->getLocale() === 'ar' ? 'left' : 'right'); ?> ms-2"></i>
            </a>
        </div>
    </div>
</section>


<?php elseif($section->key === 'search_area'): ?>
<section class="section-search-area py-6">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label"><?php echo e(app()->getLocale() === 'en' ? 'Browse by Area' : 'تصفح حسب المنطقة'); ?></span>
            <h2 class="section-title"><?php echo e(app()->getLocale() === 'en' ? 'Find Your Property by Location' : 'اعثر على عقارك حسب الموقع'); ?></h2>
            <div class="title-divider"><span></span></div>
            <p class="section-subtitle mt-3"><?php echo e(app()->getLocale() === 'en' ? 'Explore our projects distributed across the most prominent investment cities' : 'استكشف مشاريعنا الموزعة في أبرز المدن الاستثمارية'); ?></p>
        </div>

        
        <div class="type-filter-bar mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="<?php echo e(route('projects.index')); ?>" class="type-filter-btn <?php echo e(!request('type') ? 'active' : ''); ?>">
                    <i class="fas fa-th me-2"></i><?php echo e(app()->getLocale() === 'en' ? 'All' : 'الكل'); ?>

                </a>
                <?php $__currentLoopData = [
                    'tower'       => ['icon' => 'fas fa-building',    'ar' => 'أبراج',        'en' => 'Towers'],
                    'villa'       => ['icon' => 'fas fa-home',         'ar' => 'فلل',          'en' => 'Villas'],
                    'apartment'   => ['icon' => 'fas fa-city',         'ar' => 'شقق',          'en' => 'Apartments'],
                    'commercial'  => ['icon' => 'fas fa-store',        'ar' => 'تجاري',        'en' => 'Commercial'],
                    'compound'    => ['icon' => 'fas fa-tree',         'ar' => 'مجمعات',       'en' => 'Compounds'],
                    'residential' => ['icon' => 'fas fa-house-user',   'ar' => 'سكني',         'en' => 'Residential'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $typeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('projects.index', ['type' => $typeKey])); ?>"
                   class="type-filter-btn <?php echo e(request('type') === $typeKey ? 'active' : ''); ?>">
                    <i class="<?php echo e($typeData['icon']); ?> me-2"></i><?php echo e(app()->getLocale() === 'en' ? $typeData['en'] : $typeData['ar']); ?>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <?php if($areaProjects->count()): ?>
        <div class="row g-4" id="area-cards-row">
            <?php $__currentLoopData = $areaProjects->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city => $cityProjects): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $firstProject = $cityProjects->first(); ?>
            <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="<?php echo e(($loop->index % 4) * 80); ?>">
                <a href="<?php echo e(route('projects.index', ['search' => $city])); ?>" class="area-card">
                    <div class="area-card-img-wrap">
                        <img src="<?php echo e($firstProject->getMainImageThumbUrl()); ?>"
                             alt="<?php echo e($city); ?>"
                             class="area-card-img"
                             loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1486325212027-8081e485255e?w=400&q=70'">
                        <div class="area-card-overlay"></div>
                    </div>
                    <div class="area-card-body">
                        <h3 class="area-card-city"><?php echo e($city); ?></h3>
                        <span class="area-card-count">
                            <?php echo e($cityProjects->count()); ?>

                            <?php echo e(app()->getLocale() === 'en' ? ($cityProjects->count() === 1 ? 'project' : 'projects') : 'مشروع'); ?>

                        </span>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($areaProjects->count() > 8): ?>
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-outline-gold">
                <?php echo e(app()->getLocale() === 'en' ? 'View All Cities' : 'عرض كل المدن'); ?>

                <i class="fas fa-arrow-<?php echo e(app()->getLocale() === 'ar' ? 'left' : 'right'); ?> ms-2"></i>
            </a>
        </div>
        <?php endif; ?>
        <?php else: ?>
        
        <div class="row g-3 justify-content-center">
            <?php $__currentLoopData = [
                ['name_ar' => 'إسطنبول',  'name_en' => 'Istanbul',  'icon' => 'fas fa-mosque',        'img' => 'https://images.unsplash.com/photo-1527838832700-5059252407fa?w=400&q=70'],
                ['name_ar' => 'أنطاليا',  'name_en' => 'Antalya',   'icon' => 'fas fa-umbrella-beach', 'img' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400&q=70'],
                ['name_ar' => 'أنقرة',    'name_en' => 'Ankara',    'icon' => 'fas fa-landmark',       'img' => 'https://images.unsplash.com/photo-1601979031925-424e53b6caaa?w=400&q=70'],
                ['name_ar' => 'بغداد',    'name_en' => 'Baghdad',   'icon' => 'fas fa-archway',        'img' => 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?w=400&q=70'],
                ['name_ar' => 'دبي',      'name_en' => 'Dubai',     'icon' => 'fas fa-star',           'img' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&q=70'],
                ['name_ar' => 'عمّان',    'name_en' => 'Amman',     'icon' => 'fas fa-city',           'img' => 'https://images.unsplash.com/photo-1539650116574-8efeb43e2750?w=400&q=70'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="<?php echo e($i * 60); ?>">
                <a href="<?php echo e(route('projects.index', ['search' => app()->getLocale() === 'en' ? $c['name_en'] : $c['name_ar']])); ?>" class="area-card">
                    <div class="area-card-img-wrap">
                        <img src="<?php echo e($c['img']); ?>" alt="<?php echo e(app()->getLocale() === 'en' ? $c['name_en'] : $c['name_ar']); ?>" class="area-card-img" loading="lazy">
                        <div class="area-card-overlay"></div>
                    </div>
                    <div class="area-card-body">
                        <h3 class="area-card-city"><?php echo e(app()->getLocale() === 'en' ? $c['name_en'] : $c['name_ar']); ?></h3>
                        <span class="area-card-count"><i class="<?php echo e($c['icon']); ?>"></i></span>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>


<?php elseif($section->key === 'why_us'): ?>
<section class="section-why bg-dark-section py-6">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label"><?php echo e(__('app.why_us')); ?></span>
            <h2 class="section-title"><?php echo e(__('app.why_us')); ?></h2>
            <div class="title-divider"><span></span></div>
        </div>
        <div class="row g-4">
            <?php
            $whyItems = [
                ['icon'=>'fas fa-award',   'title_ar'=>\App\Models\Setting::get('why_1_title_ar','خبرة 15 عاماً'),    'title_en'=>\App\Models\Setting::get('why_1_title_en','15 Years Experience'),   'desc_ar'=>\App\Models\Setting::get('why_1_desc_ar',''),  'desc_en'=>\App\Models\Setting::get('why_1_desc_en','')],
                ['icon'=>'fas fa-handshake','title_ar'=>\App\Models\Setting::get('why_2_title_ar','موثوقية عالية'),    'title_en'=>\App\Models\Setting::get('why_2_title_en','High Reliability'),      'desc_ar'=>\App\Models\Setting::get('why_2_desc_ar',''),  'desc_en'=>\App\Models\Setting::get('why_2_desc_en','')],
                ['icon'=>'fas fa-globe',   'title_ar'=>\App\Models\Setting::get('why_3_title_ar','انتشار عالمي'),     'title_en'=>\App\Models\Setting::get('why_3_title_en','Global Presence'),       'desc_ar'=>\App\Models\Setting::get('why_3_desc_ar',''),  'desc_en'=>\App\Models\Setting::get('why_3_desc_en','')],
                ['icon'=>'fas fa-headset', 'title_ar'=>\App\Models\Setting::get('why_4_title_ar','دعم مستمر'),        'title_en'=>\App\Models\Setting::get('why_4_title_en','Continuous Support'),     'desc_ar'=>\App\Models\Setting::get('why_4_desc_ar',''),  'desc_en'=>\App\Models\Setting::get('why_4_desc_en','')],
            ];
            ?>
            <?php $__currentLoopData = $whyItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo e($i * 100); ?>">
                <div class="why-card">
                    <div class="why-icon"><i class="<?php echo e($item['icon']); ?>"></i></div>
                    <h3 class="why-title"><?php echo e(app()->getLocale() === 'en' ? $item['title_en'] : $item['title_ar']); ?></h3>
                    <p class="why-desc"><?php echo e(app()->getLocale() === 'en' ? $item['desc_en'] : $item['desc_ar']); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<?php elseif($section->key === 'about'): ?>
<section class="section-about py-6">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-image-grid">
                    <div class="about-img-main">
                        <img src="<?php echo e(asset('images/about-main.jpg')); ?>" alt="About Grand Start" onerror="this.src='https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=80'">
                    </div>
                    <div class="about-img-secondary">
                        <img src="<?php echo e(asset('images/about-sec.jpg')); ?>" alt="Grand Start Office" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=300&q=80'">
                    </div>
                    <div class="about-years-badge">
                        <span class="years-number"><?php echo e($stats['years']); ?>+</span>
                        <span class="years-label"><?php echo e(__('app.years_experience')); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <span class="section-label"><?php echo e(__('app.our_story')); ?></span>
                    <h2 class="section-title mb-4"><?php echo e(\App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Start Real Estate')); ?></h2>
                    <p class="about-text"><?php echo e(\App\Models\Setting::get('about_text_' . app()->getLocale(), \App\Models\Setting::get('about_text_ar'))); ?></p>
                    <div class="about-stats row mt-4">
                        <div class="col-4 text-center"><div class="mini-stat"><span class="mini-stat-num"><?php echo e($stats['projects']); ?>+</span><span class="mini-stat-label"><?php echo e(__('app.completed_projects')); ?></span></div></div>
                        <div class="col-4 text-center"><div class="mini-stat"><span class="mini-stat-num"><?php echo e($stats['clients']); ?>+</span><span class="mini-stat-label"><?php echo e(__('app.happy_clients')); ?></span></div></div>
                        <div class="col-4 text-center"><div class="mini-stat"><span class="mini-stat-num"><?php echo e($stats['countries']); ?></span><span class="mini-stat-label"><?php echo e(__('app.countries')); ?></span></div></div>
                    </div>
                    <a href="<?php echo e(route('about')); ?>" class="btn btn-gold mt-4">
                        <?php echo e(__('app.our_story')); ?> <i class="fas fa-arrow-<?php echo e(app()->getLocale() === 'ar' ? 'left' : 'right'); ?> ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<?php elseif($section->key === 'map'): ?>
<?php
$allProjectsForMap = \App\Models\Project::active()->with(['translations','images'])->orderBy('sort_order')->get();
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
?>
<section class="section-map py-6 bg-dark-section">
    <div class="container-fluid px-0">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <span class="section-label"><?php echo e(app()->getLocale() === 'en' ? 'Our Projects on the Map' : 'مشاريعنا على الخريطة'); ?></span>
                <h2 class="section-title"><?php echo e(app()->getLocale() === 'en' ? 'Explore Properties Geographically' : 'استكشف العقارات جغرافياً'); ?></h2>
                <div class="title-divider"><span></span></div>
            </div>
        </div>

        <?php if($mapProjects->isNotEmpty()): ?>
        
        <div class="map-split-layout">
            <div class="map-split-map" data-aos="fade-right">
                <div id="projects-map"></div>
            </div>
            <div class="map-split-list" data-aos="fade-left">
                <div class="map-project-list">
                    <?php $__currentLoopData = $mapProjects->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('projects.show', $p->slug)); ?>" class="map-project-item" data-lat="<?php echo e($p->latitude); ?>" data-lng="<?php echo e($p->longitude); ?>">
                        <img src="<?php echo e($p->getMainImageThumbUrl()); ?>" alt="<?php echo e($p->getTitle()); ?>" class="map-project-thumb"
                             onerror="this.src='https://images.unsplash.com/photo-1486325212027-8081e485255e?w=120&q=60'">
                        <div class="map-project-info">
                            <div class="map-project-name"><?php echo e($p->getTitle()); ?></div>
                            <div class="map-project-loc"><i class="fas fa-map-marker-alt"></i> <?php echo e($p->getLocation()); ?></div>
                            <?php if($p->price_usd): ?><div class="map-project-price">$<?php echo e(number_format($p->price_usd, 0)); ?></div><?php endif; ?>
                        </div>
                        <i class="fas fa-chevron-<?php echo e(app()->getLocale() === 'ar' ? 'left' : 'right'); ?> map-project-arrow"></i>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($mapProjects->count() > 6): ?>
                    <a href="<?php echo e(route('projects.index')); ?>" class="map-view-all">
                        <?php echo e(app()->getLocale() === 'en' ? 'View all ' . $mapProjects->count() . ' projects' : 'عرض كل ' . $mapProjects->count() . ' مشروع'); ?>

                        <i class="fas fa-arrow-<?php echo e(app()->getLocale() === 'ar' ? 'left' : 'right'); ?>"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script id="map-projects-data" type="application/json"><?php echo json_encode($mapData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>

        <?php else: ?>
        
        <div class="container">
            <div class="map-fallback-wrapper" data-aos="fade-up">
                <div class="map-fallback-bg" style="background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);">

                    <div class="map-fallback-overlay">
                        <div class="map-fallback-content text-center">
                            <div class="map-globe-icon mb-3">
                                <i class="fas fa-globe-asia"></i>
                            </div>
                            <h3 class="text-white mb-2"><?php echo e(app()->getLocale() === 'en' ? 'Projects Across the Region' : 'مشاريع في جميع أنحاء المنطقة'); ?></h3>
                            <p class="text-white-50 mb-4"><?php echo e(app()->getLocale() === 'en' ? 'Our projects span Turkey, Iraq, and the Gulf' : 'مشاريعنا تمتد في تركيا والعراق ودول الخليج'); ?></p>
                            
                            <div class="map-location-pins d-flex flex-wrap justify-content-center gap-3">
                                <?php $__currentLoopData = $allProjectsForMap->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('projects.show', $p->slug)); ?>" class="map-location-pin">
                                    <span class="pin-dot"></span>
                                    <span class="pin-label"><?php echo e($p->getLocation()); ?></span>
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-gold mt-4">
                                <i class="fas fa-building me-2"></i><?php echo e(app()->getLocale() === 'en' ? 'Browse All Projects' : 'تصفح جميع المشاريع'); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center text-muted small mt-3">
                <i class="fas fa-info-circle me-1"></i>
                <?php echo e(app()->getLocale() === 'en' ? 'Add GPS coordinates to projects from the admin panel to enable the interactive map.' : 'أضف إحداثيات GPS للمشاريع من لوحة التحكم لتفعيل الخريطة التفاعلية.'); ?>

            </p>
        </div>
        <?php endif; ?>
    </div>
</section>


<?php elseif($section->key === 'latest' && $latestProjects->count()): ?>
<section class="section-latest bg-dark-section py-6">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-label"><?php echo e(__('app.all_projects')); ?></span>
            <h2 class="section-title"><?php echo e(app()->getLocale() === 'en' ? 'Latest Projects' : 'أحدث المشاريع'); ?></h2>
            <div class="title-divider"><span></span></div>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $latestProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo e($i * 150); ?>">
                <div class="project-card project-card-dark">
                    <div class="project-image-wrap">
                        <img src="<?php echo e($project->getMainImageThumbUrl()); ?>" alt="<?php echo e($project->getTitle()); ?>" class="project-img" loading="lazy">
                        <div class="project-overlay">
                            <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="btn btn-gold btn-sm"><?php echo e(__('app.view_project')); ?></a>
                        </div>
                        <span class="badge-status status-<?php echo e($project->status); ?>"><?php echo e($project->getStatusLabel()); ?></span>
                    </div>
                    <div class="project-body">
                        <div class="project-type"><i class="fas fa-tag"></i> <?php echo e($project->getTypeLabel()); ?></div>
                        <h3 class="project-title"><a href="<?php echo e(route('projects.show', $project->slug)); ?>"><?php echo e($project->getTitle()); ?></a></h3>
                        <p class="project-location"><i class="fas fa-map-marker-alt"></i> <?php echo e($project->getLocation()); ?></p>
                        <div class="project-footer">
                            <div class="project-price">
                                <?php if($countryCode === 'IQ' && $project->price_iqd): ?> <?php echo e(number_format($project->price_iqd, 0)); ?> د.ع
                                <?php elseif($countryCode === 'TR' && $project->price_try): ?> ₺<?php echo e(number_format($project->price_try, 0)); ?>

                                <?php elseif($project->price_usd): ?> $<?php echo e(number_format($project->price_usd, 0)); ?>

                                <?php else: ?> <?php echo e(__('app.price_on_request')); ?> <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<?php elseif($section->key === 'cta'): ?>
<section class="section-cta py-6">
    <div class="container">
        <div class="cta-box text-center" data-aos="zoom-in">
            <h2 class="cta-title"><?php echo e(app()->getLocale() === 'en' ? 'Ready to Find Your Dream Property?' : 'هل أنت مستعد للعثور على عقار أحلامك؟'); ?></h2>
            <p class="cta-text"><?php echo e(app()->getLocale() === 'en' ? 'Contact our team of experts and let us help you find the perfect property.' : 'تواصل مع فريق الخبراء لدينا ودعنا نساعدك في إيجاد العقار المثالي.'); ?></p>
            <div class="cta-actions mt-4">
                <a href="<?php echo e(route('contact')); ?>" class="btn btn-gold btn-lg me-3">
                    <i class="fas fa-envelope me-2"></i><?php echo e(__('app.contact_us')); ?>

                </a>
                <?php if(isset($whatsapp)): ?>
                <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" class="btn btn-whatsapp btn-lg">
                    <i class="fab fa-whatsapp me-2"></i><?php echo e(__('app.whatsapp')); ?>

                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('map_css'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('map_js'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV/XN/WLcE=" crossorigin="anonymous"></script>
<script>
(function() {
    var el      = document.getElementById('projects-map');
    var dataEl  = document.getElementById('map-projects-data');
    if (!el || !dataEl) return;

    var projects     = JSON.parse(dataEl.textContent || '[]');
    var validProjects = projects.filter(function(p) { return p.lat && p.lng; });
    if (!validProjects.length) return;

    // Dark tile layer
    var map = L.map('projects-map', { scrollWheelZoom: false, zoomControl: true });
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://carto.com/">CARTO</a>',
        maxZoom: 19
    }).addTo(map);

    var goldIcon = L.divIcon({
        html: '<div style="width:14px;height:14px;background:#c8a96e;border-radius:50%;border:2px solid #fff;box-shadow:0 0 0 4px rgba(200,169,110,0.35);"></div>',
        iconSize: [14, 14],
        iconAnchor: [7, 7],
        popupAnchor: [0, -12],
        className: ''
    });
    var goldIconActive = L.divIcon({
        html: '<div style="width:18px;height:18px;background:#e6c27a;border-radius:50%;border:3px solid #fff;box-shadow:0 0 0 6px rgba(200,169,110,0.5);"></div>',
        iconSize: [18, 18],
        iconAnchor: [9, 9],
        popupAnchor: [0, -14],
        className: ''
    });

    var markers = {};
    var bounds  = [];

    validProjects.forEach(function(p, i) {
        bounds.push([p.lat, p.lng]);
        var imgHtml   = p.img   ? '<img src="' + p.img + '" style="width:100%;height:90px;object-fit:cover;border-radius:6px;margin-bottom:6px;" onerror="this.style.display=\'none\'">' : '';
        var priceHtml = p.price ? '<div style="color:#c8a96e;font-weight:600;font-size:0.85rem;">' + p.price + '</div>' : '';
        var popup = L.popup({ maxWidth: 200, className: 'map-custom-popup' }).setContent(
            '<div>' + imgHtml
            + '<div style="font-weight:700;font-size:0.9rem;margin-bottom:3px;">' + p.title + '</div>'
            + '<div style="font-size:0.75rem;color:#888;margin-bottom:4px;"><i class="fas fa-map-marker-alt" style="color:#c8a96e;"></i> ' + p.loc + '</div>'
            + priceHtml
            + '<a href="' + p.url + '" style="display:inline-block;margin-top:8px;padding:4px 14px;background:#c8a96e;color:#fff;border-radius:20px;font-size:0.8rem;text-decoration:none;">عرض المشروع</a>'
            + '</div>'
        );
        var marker = L.marker([p.lat, p.lng], { icon: goldIcon }).addTo(map).bindPopup(popup);
        markers[i] = marker;
    });

    bounds.length === 1 ? map.setView(bounds[0], 13) : map.fitBounds(bounds, { padding: [50, 50] });

    // Sidebar list interaction
    document.querySelectorAll('.map-project-item').forEach(function(item, i) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            var lat = parseFloat(item.dataset.lat);
            var lng = parseFloat(item.dataset.lng);
            if (!lat || !lng) return;
            document.querySelectorAll('.map-project-item').forEach(function(el) { el.classList.remove('active'); });
            item.classList.add('active');
            map.setView([lat, lng], 14, { animate: true });
            if (markers[i]) { markers[i].setIcon(goldIconActive); markers[i].openPopup(); }
            setTimeout(function() { if (markers[i]) markers[i].setIcon(goldIcon); }, 3000);
        });
    });
})();
</script>
<?php $__env->stopPush(); ?>

<?php if($heroType === 'slider' && $heroSlides->count()): ?>
<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/frontend/home.blade.php ENDPATH**/ ?>