<?php $__env->startSection('title', 'الصفحات'); ?>
<?php $__env->startSection('page-title', 'إدارة الصفحات'); ?>

<?php $__env->startSection('content'); ?>

<div class="row g-3">
    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $icons = ['home' => 'fas fa-home', 'about' => 'fas fa-users', 'contact' => 'fas fa-envelope', 'projects' => 'fas fa-building'];
    $labels = ['home' => 'الصفحة الرئيسية', 'about' => 'من نحن', 'contact' => 'اتصل بنا', 'projects' => 'المشاريع'];
    ?>
    <div class="col-md-6">
        <div class="form-card d-flex align-items-center gap-3 p-3">
            <div class="stat-icon-admin stat-icon-gold" style="flex-shrink:0;">
                <i class="<?php echo e($icons[$page] ?? 'fas fa-file'); ?>"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold"><?php echo e($labels[$page] ?? $page); ?></div>
                <small class="text-muted">/<?php echo e($page); ?></small>
            </div>
            <a href="<?php echo e(route('admin.pages.edit', $page)); ?>" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-edit me-1"></i>تعديل
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/pages/index.blade.php ENDPATH**/ ?>