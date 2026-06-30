<?php $__env->startSection('title', 'منشئ الصفحات'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0"><i class="fas fa-th-large me-2 text-primary"></i> ترتيب أقسام الصفحة الرئيسية</h2>
        <a href="<?php echo e(route('home')); ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-eye me-1"></i> معاينة الصفحة
        </a>
    </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        اسحب الأقسام لإعادة ترتيبها، وانقر على مفتاح التفعيل لإخفاء أو إظهار قسم.
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">
            <i class="fas fa-grip-vertical me-2"></i> أقسام الصفحة الرئيسية
        </div>
        <div class="card-body p-0">
            <ul id="sections-list" class="list-group list-group-flush">
                <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item d-flex align-items-center gap-3 py-3" data-id="<?php echo e($section->id); ?>">
                    <span class="drag-handle text-muted" style="cursor:grab">
                        <i class="fas fa-grip-vertical fa-lg"></i>
                    </span>
                    <span class="badge bg-secondary" style="min-width:28px"><?php echo e($loop->iteration); ?></span>
                    <div class="flex-grow-1">
                        <span class="fw-semibold"><?php echo e($section->label); ?></span>
                        <small class="text-muted ms-2">(<?php echo e($section->key); ?>)</small>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input section-toggle" type="checkbox"
                               data-id="<?php echo e($section->id); ?>"
                               <?php echo e($section->active ? 'checked' : ''); ?>

                               style="cursor:pointer; width:2.5em; height:1.3em;">
                    </div>
                    <span class="badge <?php echo e($section->active ? 'bg-success' : 'bg-secondary'); ?> section-badge" id="badge-<?php echo e($section->id); ?>">
                        <?php echo e($section->active ? 'ظاهر' : 'مخفي'); ?>

                    </span>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

    <div class="mt-3 text-muted small">
        <i class="fas fa-lightbulb me-1 text-warning"></i>
        لتعديل محتوى الأقسام (النصوص والصور) اذهب إلى <a href="<?php echo e(route('admin.settings.index')); ?>">الإعدادات</a>.
        لإدارة البانر الرئيسي اذهب إلى <a href="<?php echo e(route('admin.hero.index')); ?>">إدارة البانر</a>.
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" integrity="sha384-eeLEhtwdMwD3X9y+8P3Cn7Idl/M+w8H4uZqkgD/2eJVkWIN1yKzEj6XegJ9dL3q0" crossorigin="anonymous"></script>
<script>
const list = document.getElementById('sections-list');
Sortable.create(list, {
    handle: '.drag-handle',
    animation: 150,
    onEnd: function() {
        const order = [...list.querySelectorAll('li')].map(el => el.dataset.id);
        // Update badge numbers
        list.querySelectorAll('li').forEach((li, i) => {
            li.querySelector('.badge.bg-secondary').textContent = i + 1;
        });
        fetch('<?php echo e(route('admin.page-builder.reorder')); ?>', {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},
            body: JSON.stringify({order})
        });
    }
});

document.querySelectorAll('.section-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const id = this.dataset.id;
        const badge = document.getElementById('badge-' + id);
        fetch(`/admin/page-builder/${id}/toggle`, {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},
        })
        .then(r => r.json())
        .then(data => {
            badge.textContent = data.active ? 'ظاهر' : 'مخفي';
            badge.className   = 'badge section-badge ' + (data.active ? 'bg-success' : 'bg-secondary');
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/page-builder/index.blade.php ENDPATH**/ ?>