<?php $__env->startSection('title', 'دول التواصل'); ?>
<?php $__env->startSection('page-title', 'إدارة دول التواصل'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="<?php echo e(route('admin.countries.create')); ?>" class="btn btn-gold">
        <i class="fas fa-plus me-2"></i> إضافة دولة
    </a>
</div>

<div class="admin-table">
    <div class="admin-table-header">
        <div class="admin-table-title"><i class="fas fa-globe me-2" style="color:var(--gold)"></i> الدول وبيانات التواصل</div>
        <span class="badge bg-secondary"><?php echo e($countries->count()); ?> دولة</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>الدولة</th>
                    <th>كود الدولة</th>
                    <th>الهاتف / واتساب</th>
                    <th>العملة</th>
                    <th>الحقل السعري</th>
                    <th>الافتراضية</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <span class="me-1"><?php echo e($country->flag_emoji); ?></span>
                        <strong><?php echo e($country->country_name_ar); ?></strong>
                        <div class="text-muted small"><?php echo e($country->country_name_en); ?></div>
                    </td>
                    <td>
                        <?php if($country->country_code): ?>
                        <span class="badge bg-dark" style="color:var(--gold)"><?php echo e($country->country_code); ?></span>
                        <?php else: ?>
                        <span class="text-muted small">افتراضي عام</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="small"><?php echo e($country->phone); ?></div>
                        <div class="small text-success"><?php echo e($country->whatsapp); ?></div>
                    </td>
                    <td>
                        <span class="fw-bold"><?php echo e($country->currency_symbol); ?></span>
                        <span class="text-muted small">(<?php echo e($country->currency_code); ?>)</span>
                    </td>
                    <td><span class="badge bg-light text-dark"><?php echo e($country->price_field); ?></span></td>
                    <td>
                        <?php if($country->is_default): ?>
                        <span class="badge" style="background:var(--gold);color:#000;"><i class="fas fa-star me-1"></i> افتراضية</span>
                        <?php else: ?>
                        <form action="<?php echo e(route('admin.countries.set-default', $country)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-secondary">تعيين افتراضي</button>
                        </form>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="<?php echo e(route('admin.countries.toggle-active', $country)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm <?php echo e($country->active ? 'btn-success' : 'btn-secondary'); ?>">
                                <?php echo e($country->active ? 'مفعّل' : 'معطّل'); ?>

                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="<?php echo e(route('admin.countries.edit', $country)); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if(!$country->is_default): ?>
                            <form action="<?php echo e(route('admin.countries.destroy', $country)); ?>" method="POST"
                                onsubmit="return confirm('حذف بيانات هذه الدولة؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">لا توجد دول مضافة</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="alert mt-3" style="background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.3);border-radius:8px;">
    <i class="fas fa-info-circle me-2" style="color:var(--gold)"></i>
    <strong>كيف يعمل النظام؟</strong> عند زيارة المستخدم للموقع، يُكتشف بلده تلقائياً، وتُعرض له بيانات التواصل الخاصة بدولته.
    إذا لم تكن دولته مضافة، يرى بيانات الدولة <strong>الافتراضية</strong>.
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/countries/index.blade.php ENDPATH**/ ?>