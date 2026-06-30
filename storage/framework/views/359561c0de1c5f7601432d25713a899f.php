<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php
        $seoTitle       = trim(strip_tags(View::yieldContent('title') ?: \App\Models\Setting::get('meta_title_' . app()->getLocale(), 'Grand Start Real Estate')));
        $seoDescription = trim(strip_tags(View::yieldContent('description') ?: \App\Models\Setting::get('meta_description_' . app()->getLocale(), '')));
        $seoImage       = View::yieldContent('og_image') ?: asset('images/og-default.jpg');
        $seoUrl         = url()->current();
        $seoLocale      = app()->getLocale() === 'ar' ? 'ar_AE' : 'en_US';
        $siteName       = \App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Start Real Estate');
    ?>

    <title><?php echo e($seoTitle); ?></title>
    <meta name="description" content="<?php echo e($seoDescription); ?>">
    <meta name="robots" content="<?php echo $__env->yieldContent('robots', 'index, follow'); ?>">
    <link rel="canonical" href="<?php echo e($seoUrl); ?>">

    <!-- Open Graph -->
    <meta property="og:type"        content="<?php echo $__env->yieldContent('og_type', 'website'); ?>">
    <meta property="og:title"       content="<?php echo e($seoTitle); ?>">
    <meta property="og:description" content="<?php echo e($seoDescription); ?>">
    <meta property="og:image"       content="<?php echo e($seoImage); ?>">
    <meta property="og:url"         content="<?php echo e($seoUrl); ?>">
    <meta property="og:site_name"   content="<?php echo e($siteName); ?>">
    <meta property="og:locale"      content="<?php echo e($seoLocale); ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?php echo e($seoTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($seoDescription); ?>">
    <meta name="twitter:image"       content="<?php echo e($seoImage); ?>">

    <!-- JSON-LD Organization (GEO/AEO) -->
    <?php
    $orgSchema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'RealEstateAgent',
        'name'        => $siteName,
        'url'         => url('/'),
        'logo'        => asset('images/logo.png'),
        'image'       => $seoImage,
        'description' => $seoDescription,
        '@id'         => url('/') . '/#organization',
        'sameAs'      => [],
    ];
    ?>
    <script type="application/ld+json"><?php echo json_encode($orgSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>

    <?php echo $__env->yieldPushContent('schema'); ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Tajawal:wght@300;400;500;700&family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 RTL/LTR -->
    <?php if(app()->getLocale() === 'ar'): ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-PJsj/BTMqILvmcej7ulplguok8ag4xFTPryRq8xevL7eBYSmpXKcbNVuy+P0RMgq" crossorigin="anonymous">
    <?php else: ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <?php endif; ?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha384-iw3OoTErCYJJB9mCa8LNS2hbsQ7M3C0EpIsO/H5+EGAkPGc6rk+V8i04oW/K5xq0" crossorigin="anonymous">

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
          integrity="sha384-WDy11dc+3v52BOTt9WHuWenX6bjqGVBwYrU4XtgPIrneMtg1bXhpmWEZECSNrasO" crossorigin="anonymous">

    <!-- Leaflet (lazy-loaded only on pages that use map) -->
    <?php echo $__env->yieldPushContent('map_css'); ?>

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"
          integrity="sha384-/rJKQnzOkEo+daG0jMjU1IwwY9unxt1NBw3Ef2fmOJ3PW/TfAg2KXVoWwMZQZtw9" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="<?php echo e(app()->getLocale() === 'ar' ? 'rtl-body' : 'ltr-body'); ?>">

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-2">
                
                <div class="top-contact d-none d-md-flex gap-3 align-items-center">
                    <?php
                        $topContact = \App\Services\CountryContactService::getContact(
                            request()->get('visitor_country', 'AE')
                        );
                        $topPhone = $topContact['phone'];
                        $topEmail = $topContact['email'];
                    ?>
                    <?php if($topPhone): ?>
                    <a href="tel:<?php echo e($topPhone); ?>" class="top-link">
                        <i class="fas fa-phone-alt"></i> <?php echo e($topPhone); ?>

                    </a>
                    <?php endif; ?>
                    <?php if($topEmail): ?>
                    <a href="mailto:<?php echo e($topEmail); ?>" class="top-link">
                        <i class="fas fa-envelope"></i> <?php echo e($topEmail); ?>

                    </a>
                    <?php endif; ?>
                </div>

                
                <div class="d-flex align-items-center gap-3">
                    
                    <?php
                        $socials = [
                            'facebook_url'  => ['icon' => 'fab fa-facebook-f',  'label' => 'Facebook'],
                            'instagram_url' => ['icon' => 'fab fa-instagram',    'label' => 'Instagram'],
                            'twitter_url'   => ['icon' => 'fab fa-x-twitter',    'label' => 'X'],
                            'youtube_url'   => ['icon' => 'fab fa-youtube',      'label' => 'YouTube'],
                            'tiktok_url'    => ['icon' => 'fab fa-tiktok',       'label' => 'TikTok'],
                            'linkedin_url'  => ['icon' => 'fab fa-linkedin-in',  'label' => 'LinkedIn'],
                            'whatsapp_url'  => ['icon' => 'fab fa-whatsapp',     'label' => 'WhatsApp'],
                        ];
                        $hasSocial = false;
                        foreach ($socials as $key => $_) {
                            if (\App\Models\Setting::get($key)) { $hasSocial = true; break; }
                        }
                    ?>
                    <?php if($hasSocial): ?>
                    <div class="top-social d-none d-md-flex align-items-center gap-1">
                        <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $url = \App\Models\Setting::get($key); ?>
                        <?php if($url): ?>
                        <a href="<?php echo e($url); ?>" target="_blank" rel="noopener" class="top-social-link" title="<?php echo e($s['label']); ?>">
                            <i class="<?php echo e($s['icon']); ?>"></i>
                        </a>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="top-bar-divider d-none d-md-block"></div>
                    <?php endif; ?>

                    
                    <div class="lang-switcher d-flex gap-2 align-items-center">
                        <?php $__currentLoopData = \App\Models\Language::allActive(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('lang.switch', $lang->code)); ?>"
                           class="lang-btn <?php echo e(app()->getLocale() === $lang->code ? 'active' : ''); ?>">
                            <?php echo e($lang->name_native); ?>

                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg main-navbar sticky-top" id="mainNav">
        <div class="container">
            <!-- Logo + Company Name -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(asset('images/logo-transparent.png')); ?>"
                     alt="<?php echo e(\App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Star')); ?>"
                     class="navbar-logo">
                <div class="navbar-brand-text">
                    <span class="navbar-brand-name">
                        <?php echo e(\App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Star')); ?>

                    </span>
                    <?php $tagline = \App\Models\Setting::get('company_tagline_' . app()->getLocale()); ?>
                    <?php if($tagline): ?>
                    <span class="navbar-brand-tagline d-none d-lg-block"><?php echo e($tagline); ?></span>
                    <?php endif; ?>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav <?php echo e(app()->getLocale() === 'ar' ? 'me-auto' : 'ms-auto'); ?> align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                            <?php echo e(__('app.home')); ?>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('projects.*') ? 'active' : ''); ?>" href="<?php echo e(route('projects.index')); ?>">
                            <?php echo e(__('app.projects')); ?>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">
                            <?php echo e(__('app.about')); ?>

                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-gold" href="<?php echo e(route('contact')); ?>">
                            <i class="fas fa-phone-alt me-1"></i> <?php echo e(__('app.contact')); ?>

                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-top">
            <div class="container">
                <div class="row g-4">
                    <!-- Brand -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand">
                            <img src="<?php echo e(asset('images/logo-transparent.png')); ?>" alt="Grand Start" class="footer-logo mb-3">
                            <p class="footer-desc">
                                <?php echo e(\App\Models\Setting::get('company_tagline_' . app()->getLocale(), \App\Models\Setting::get('company_tagline_ar'))); ?>

                            </p>
                            <div class="social-links mt-3">
                                <?php if(\App\Models\Setting::get('facebook_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('facebook_url')); ?>" target="_blank" class="social-link"><i class="fab fa-facebook-f"></i></a>
                                <?php endif; ?>
                                <?php if(\App\Models\Setting::get('instagram_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('instagram_url')); ?>" target="_blank" class="social-link"><i class="fab fa-instagram"></i></a>
                                <?php endif; ?>
                                <?php if(\App\Models\Setting::get('twitter_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('twitter_url')); ?>" target="_blank" class="social-link"><i class="fab fa-twitter"></i></a>
                                <?php endif; ?>
                                <?php if(\App\Models\Setting::get('youtube_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('youtube_url')); ?>" target="_blank" class="social-link"><i class="fab fa-youtube"></i></a>
                                <?php endif; ?>
                                <?php if(\App\Models\Setting::get('tiktok_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('tiktok_url')); ?>" target="_blank" class="social-link"><i class="fab fa-tiktok"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6 col-6">
                        <h5 class="footer-title"><?php echo e(__('app.quick_links')); ?></h5>
                        <ul class="footer-links">
                            <li><a href="<?php echo e(route('home')); ?>"><?php echo e(__('app.home')); ?></a></li>
                            <li><a href="<?php echo e(route('projects.index')); ?>"><?php echo e(__('app.projects')); ?></a></li>
                            <li><a href="<?php echo e(route('about')); ?>"><?php echo e(__('app.about')); ?></a></li>
                            <li><a href="<?php echo e(route('contact')); ?>"><?php echo e(__('app.contact')); ?></a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-3 col-md-6">
                        <h5 class="footer-title"><?php echo e(__('app.contact_us')); ?></h5>
                        <ul class="footer-contact-list">
                            <?php
                                $footerContact = \App\Services\CountryContactService::getContact(
                                    request()->get('visitor_country', 'AE')
                                );
                                $footerPhone   = $footerContact['phone'];
                                $footerEmail   = $footerContact['email'];
                                $footerAddress = $footerContact['address'];
                            ?>
                            <?php if($footerPhone): ?>
                            <li><i class="fas fa-phone-alt"></i> <a href="tel:<?php echo e($footerPhone); ?>"><?php echo e($footerPhone); ?></a></li>
                            <?php endif; ?>
                            <?php if($footerEmail): ?>
                            <li><i class="fas fa-envelope"></i> <a href="mailto:<?php echo e($footerEmail); ?>"><?php echo e($footerEmail); ?></a></li>
                            <?php endif; ?>
                            <?php if($footerAddress): ?>
                            <li><i class="fas fa-map-marker-alt"></i> <?php echo e($footerAddress); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div class="col-lg-3 col-md-6">
                        <h5 class="footer-title"><?php echo e(__('app.newsletter')); ?></h5>
                        <p class="footer-desc small"><?php echo e(__('app.newsletter_text')); ?></p>
                        <form class="newsletter-form" onsubmit="return false;">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="<?php echo e(__('app.your_email')); ?>">
                                <button class="btn btn-gold" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <p class="mb-0">
                        &copy; <?php echo e(date('Y')); ?>

                        <?php echo e(\App\Models\Setting::get('company_name_' . app()->getLocale(), 'Grand Start Real Estate')); ?> -
                        <?php echo e(__('app.all_rights')); ?>

                    </p>
                    <a href="<?php echo e(route('admin.login')); ?>" class="footer-admin-link">
                        <i class="fas fa-lock"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <?php
        $waContact = \App\Services\CountryContactService::getContact(
            request()->get('visitor_country', 'AE')
        );
        $waNumber = preg_replace('/[^0-9]/', '', $waContact['whatsapp'] ?? '');
    ?>
    <?php if($waNumber): ?>
    <a href="https://wa.me/<?php echo e($waNumber); ?>?text=<?php echo e(urlencode(__('app.chat_whatsapp'))); ?>"
       class="whatsapp-float"
       target="_blank"
       title="<?php echo e(__('app.whatsapp')); ?>">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-pulse"></span>
    </a>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"
            integrity="sha384-UpSTlZpLDzenAXs6CRRa5gU7uk1xaEJy+7uIz+c0niFDR3yuAlqzV7w0SgZhmEX3" crossorigin="anonymous"></script>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"
            integrity="sha384-wziAfh6b/qT+3LrqebF9WeK4+J5sehS6FA10J1t3a866kJ/fvU5UwofWnQyzLtwu" crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo $__env->yieldPushContent('map_js'); ?>
</body>
</html>
<?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/layouts/app.blade.php ENDPATH**/ ?>