<?php $__env->startSection('title', 'إدارة اللغات'); ?>
<?php $__env->startSection('page-title', 'إدارة اللغات'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">

    <!-- Add Language -->
    <div class="col-lg-4">
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-plus"></i> إضافة لغة جديدة</div>
            <form action="<?php echo e(route('admin.languages.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">كود اللغة <small class="text-muted">(مثال: fr, de, es)</small></label>
                    <input type="text" name="code" class="form-control" placeholder="ar" maxlength="10" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الاسم بالإنجليزية</label>
                    <input type="text" name="name_en" class="form-control" placeholder="Arabic" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الاسم بلغته الأصلية</label>
                    <input type="text" name="name_native" class="form-control" placeholder="العربية" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">اتجاه الكتابة</label>
                    <select name="direction" class="form-select" required>
                        <option value="ltr">LTR - من اليسار لليمين</option>
                        <option value="rtl">RTL - من اليمين لليسار</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">ترتيب العرض</label>
                    <input type="number" name="sort_order" class="form-control" value="0" min="0">
                </div>
                <button type="submit" class="btn btn-gold w-100">
                    <i class="fas fa-plus me-2"></i> إضافة اللغة
                </button>
            </form>
        </div>
    </div>

    <!-- Languages List -->
    <div class="col-lg-8">
        <div class="admin-table">
            <div class="admin-table-header">
                <div class="admin-table-title"><i class="fas fa-language me-2" style="color:var(--gold)"></i> اللغات المتاحة</div>
                <span class="badge bg-secondary"><?php echo e($languages->count()); ?> لغة</span>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>الكود</th>
                            <th>الاسم</th>
                            <th>الاتجاه</th>
                            <th>الحالة</th>
                            <th>الافتراضية</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <span class="badge bg-dark text-gold fw-bold" style="font-size:0.95em;color:var(--gold) !important;">
                                    <?php echo e(strtoupper($lang->code)); ?>

                                </span>
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo e($lang->name_native); ?></div>
                                <small class="text-muted"><?php echo e($lang->name_en); ?></small>
                            </td>
                            <td>
                                <span class="badge <?php echo e($lang->direction === 'rtl' ? 'bg-warning text-dark' : 'bg-info text-dark'); ?>">
                                    <?php echo e(strtoupper($lang->direction)); ?>

                                </span>
                            </td>
                            <td>
                                <form action="<?php echo e(route('admin.languages.toggle-active', $lang)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm <?php echo e($lang->active ? 'btn-success' : 'btn-secondary'); ?>">
                                        <?php echo e($lang->active ? 'مفعّلة' : 'معطّلة'); ?>

                                    </button>
                                </form>
                            </td>
                            <td>
                                <?php if($lang->is_default): ?>
                                <span class="badge" style="background:var(--gold);color:#000;">
                                    <i class="fas fa-star me-1"></i> افتراضية
                                </span>
                                <?php else: ?>
                                <form action="<?php echo e(route('admin.languages.set-default', $lang)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        تعيين افتراضي
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($lang->id); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if(!$lang->is_default): ?>
                                    <form action="<?php echo e(route('admin.languages.destroy', $lang)); ?>" method="POST"
                                        onsubmit="return confirm('حذف اللغة؟')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo e($lang->id); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل: <?php echo e($lang->name_native); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?php echo e(route('admin.languages.update', $lang)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">الاسم بالإنجليزية</label>
                                                <input type="text" name="name_en" class="form-control" value="<?php echo e($lang->name_en); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">الاسم الأصلي</label>
                                                <input type="text" name="name_native" class="form-control" value="<?php echo e($lang->name_native); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">الاتجاه</label>
                                                <select name="direction" class="form-select">
                                                    <option value="ltr" <?php echo e($lang->direction === 'ltr' ? 'selected' : ''); ?>>LTR</option>
                                                    <option value="rtl" <?php echo e($lang->direction === 'rtl' ? 'selected' : ''); ?>>RTL</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">ترتيب العرض</label>
                                                <input type="number" name="sort_order" class="form-control" value="<?php echo e($lang->sort_order); ?>" min="0">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-gold">حفظ التغييرات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">لا توجد لغات مضافة</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="alert mt-3" style="background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.3);border-radius:8px;">
            <i class="fas fa-info-circle me-2" style="color:var(--gold)"></i>
            <strong>ملاحظة:</strong> عند إضافة لغة جديدة، ستظهر تلقائياً في محرر المشاريع وبدّال اللغة في الموقع.
            يجب إضافة ملف ترجمة <code>resources/lang/{code}/app.php</code> للغة الجديدة.
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/languages/index.blade.php ENDPATH**/ ?>