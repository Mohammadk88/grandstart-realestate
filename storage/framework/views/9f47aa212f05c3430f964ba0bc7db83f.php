<?php $__env->startSection('title', __('app.all_projects') . ' - ' . \App\Models\Setting::get('company_name_' . app()->getLocale())); ?>

<?php $__env->startSection('content'); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content text-center">
            <h1 class="page-header-title" data-aos="fade-down"><?php echo e(__('app.all_projects')); ?></h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('app.home')); ?></a></li>
                    <li class="breadcrumb-item active"><?php echo e(__('app.projects')); ?></li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="projects-section py-6">
    <div class="container">

        <!-- Filters -->
        <div class="projects-filter mb-5" data-aos="fade-up">
            <form method="GET" action="<?php echo e(route('projects.index')); ?>" class="filter-form">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="form-control search-input"
                                   placeholder="<?php echo e(__('app.search_projects')); ?>"
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select filter-select">
                            <option value=""><?php echo e(__('app.all_types')); ?></option>
                            <?php $__currentLoopData = ['residential', 'commercial', 'villa', 'apartment', 'compound', 'tower']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type); ?>" <?php echo e(request('type') === $type ? 'selected' : ''); ?>>
                                <?php echo e(__('app.' . $type)); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select filter-select">
                            <option value=""><?php echo e(__('app.all_statuses')); ?></option>
                            <?php $__currentLoopData = ['available', 'under_construction', 'coming_soon', 'sold_out']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status); ?>" <?php echo e(request('status') === $status ? 'selected' : ''); ?>>
                                <?php echo e(__('app.' . $status)); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-gold w-100">
                            <i class="fas fa-filter me-2"></i><?php echo e(app()->getLocale() === 'en' ? 'Filter' : 'تصفية'); ?>

                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <p class="results-count mb-0">
                <?php echo e($projects->total()); ?>

                <?php echo e(app()->getLocale() === 'en' ? 'project(s) found' : 'مشروع'); ?>

            </p>
            <?php if(request()->hasAny(['search', 'type', 'status'])): ?>
            <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-times me-1"></i>
                <?php echo e(app()->getLocale() === 'en' ? 'Clear Filters' : 'مسح الفلاتر'); ?>

            </a>
            <?php endif; ?>
        </div>

        <!-- Projects Grid -->
        <?php if($projects->isEmpty()): ?>
        <div class="text-center py-5" data-aos="fade-up">
            <div class="empty-state">
                <i class="fas fa-building empty-icon"></i>
                <h3><?php echo e(__('app.no_projects')); ?></h3>
                <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-gold mt-3">
                    <?php echo e(app()->getLocale() === 'en' ? 'View All' : 'عرض الكل'); ?>

                </a>
            </div>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo e(($i % 3) * 100); ?>">
                <div class="project-card">
                    <div class="project-image-wrap">
                        <img src="<?php echo e($project->getMainImageThumbUrl()); ?>"
                             alt="<?php echo e($project->getTitle()); ?>"
                             class="project-img"
                             loading="lazy">
                        <div class="project-overlay">
                            <a href="<?php echo e(route('projects.show', $project->slug)); ?>" class="btn btn-gold btn-sm">
                                <?php echo e(__('app.view_project')); ?>

                            </a>
                        </div>
                        <div class="project-badges">
                            <span class="badge-status status-<?php echo e($project->status); ?>">
                                <?php echo e($project->getStatusLabel()); ?>

                            </span>
                            <?php if($project->featured): ?>
                            <span class="badge-featured"><i class="fas fa-star"></i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-type">
                            <i class="fas fa-tag"></i> <?php echo e($project->getTypeLabel()); ?>

                        </div>
                        <h3 class="project-title">
                            <a href="<?php echo e(route('projects.show', $project->slug)); ?>"><?php echo e($project->getTitle()); ?></a>
                        </h3>
                        <p class="project-location">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($project->getLocation()); ?>

                        </p>
                        <p class="project-excerpt">
                            <?php echo e(Str::limit($project->getDescription(), 100)); ?>

                        </p>
                        <div class="project-footer">
                            <div class="project-price">
                                <?php if($countryCode === 'IQ' && $project->price_iqd): ?>
                                    <?php echo e(number_format($project->price_iqd, 0)); ?> <small>د.ع</small>
                                <?php elseif($countryCode === 'TR' && $project->price_try): ?>
                                    <small>₺</small><?php echo e(number_format($project->price_try, 0)); ?>

                                <?php elseif($project->price_usd): ?>
                                    <small>$</small><?php echo e(number_format($project->price_usd, 0)); ?>

                                <?php else: ?>
                                    <?php echo e(__('app.price_on_request')); ?>

                                <?php endif; ?>
                            </div>
                            <div class="project-meta">
                                <?php if($project->area): ?>
                                <span title="<?php echo e(__('app.area')); ?>"><i class="fas fa-vector-square"></i> <?php echo e($project->area); ?></span>
                                <?php endif; ?>
                                <?php if($project->floors): ?>
                                <span title="<?php echo e(__('app.floors')); ?>"><i class="fas fa-layer-group"></i> <?php echo e($project->floors); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <?php if($projects->hasPages()): ?>
        <div class="pagination-wrap mt-5 d-flex justify-content-center" data-aos="fade-up">
            <?php echo e($projects->withQueryString()->links('vendor.pagination.custom')); ?>

        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/frontend/projects/index.blade.php ENDPATH**/ ?>