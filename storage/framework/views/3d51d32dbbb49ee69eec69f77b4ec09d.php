<?php $__env->startSection('title', 'إضافة مستخدم'); ?>
<?php $__env->startSection('page-title', 'إضافة مستخدم جديد'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع
    </a>
</div>

<div class="row justify-content-center">
<div class="col-lg-7">
<form action="<?php echo e(route('admin.users.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <div class="form-card">
        <div class="form-card-title"><i class="fas fa-user"></i> بيانات المستخدم</div>

        <?php if($errors->any()): ?>
        <div class="alert alert-danger-admin mb-3">
            <i class="fas fa-exclamation-circle me-1"></i>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($e); ?><br> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>" placeholder="+90...">
            </div>
            <div class="col-12">
                <label class="form-label">الدور / الصلاحية <span class="text-danger">*</span></label>
                <div class="row g-2 mt-1" id="roleCards">
                    <?php $__currentLoopData = \App\Models\Admin::ROLES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk => $rl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <label class="role-card <?php echo e(old('role') === $rk ? 'selected' : ''); ?>" data-color="<?php echo e(\App\Models\Admin::ROLE_COLORS[$rk]); ?>" style="cursor:pointer; display:block; border:2px solid #e9ecef; border-radius:10px; padding:1rem; transition:all 0.2s;">
                            <div class="d-flex align-items-center gap-2">
                                <input type="radio" name="role" value="<?php echo e($rk); ?>" <?php echo e(old('role') === $rk ? 'checked' : ''); ?> style="display:none;">
                                <div class="role-dot" style="width:12px; height:12px; border-radius:50%; background:<?php echo e(\App\Models\Admin::ROLE_COLORS[$rk]); ?>;"></div>
                                <span class="fw-bold" style="color:<?php echo e(\App\Models\Admin::ROLE_COLORS[$rk]); ?>;"><?php echo e($rl); ?></span>
                            </div>
                            <div class="mt-2" style="font-size:0.78rem; color:#888; line-height:1.5;">
                                <?php if($rk === 'super_admin'): ?> كل الصلاحيات بدون قيود
                                <?php elseif($rk === 'manager'): ?> إدارة المشاريع والعملاء والمحتوى
                                <?php elseif($rk === 'data_entry'): ?> إدخال وتعديل المشاريع والمحتوى فقط
                                <?php elseif($rk === 'call_center'): ?> متابعة العملاء والاستفسارات فقط
                                <?php endif; ?>
                            </div>
                        </label>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required minlength="8">
                <div class="form-text">8 أحرف على الأقل</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="active" value="1" checked>
                    <label class="form-check-label fw-semibold">حساب نشط</label>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-gold flex-fill py-2 fw-bold">
            <i class="fas fa-save me-2"></i> إضافة المستخدم
        </button>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary px-4">إلغاء</a>
    </div>
</form>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.querySelectorAll('.role-card').forEach(function(card) {
    card.addEventListener('click', function() {
        document.querySelectorAll('.role-card').forEach(c => {
            c.style.borderColor = '#e9ecef';
            c.style.background  = '';
            c.classList.remove('selected');
        });
        var color = this.dataset.color;
        this.style.borderColor = color;
        this.style.background  = color + '12';
        this.classList.add('selected');
        this.querySelector('input[type=radio]').checked = true;
    });
    // Init selected state
    if (card.classList.contains('selected')) {
        var color = card.dataset.color;
        card.style.borderColor = color;
        card.style.background  = color + '12';
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/users/create.blade.php ENDPATH**/ ?>