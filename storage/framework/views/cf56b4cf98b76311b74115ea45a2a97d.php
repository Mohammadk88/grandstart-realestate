<?php $__env->startSection('title', 'إدارة المستخدمين'); ?>
<?php $__env->startSection('page-title', 'إدارة المستخدمين والصلاحيات'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0 small">إجمالي <?php echo e($users->count()); ?> مستخدم في النظام</p>
    </div>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-gold">
        <i class="fas fa-user-plus me-2"></i> إضافة مستخدم
    </a>
</div>

<?php
$roleGroups = $users->groupBy('role');
$roleOrder  = ['super_admin','manager','data_entry','call_center'];
?>

<?php $__currentLoopData = $roleOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $group = $roleGroups->get($roleKey, collect()); ?>
<?php if($group->isEmpty()): ?> <?php continue; ?> <?php endif; ?>

<div class="admin-table mb-4">
    <div class="admin-table-header">
        <div class="admin-table-title d-flex align-items-center gap-2">
            <span class="role-badge-lg" style="background: <?php echo e(\App\Models\Admin::ROLE_COLORS[$roleKey]); ?>20; color: <?php echo e(\App\Models\Admin::ROLE_COLORS[$roleKey]); ?>; border: 1px solid <?php echo e(\App\Models\Admin::ROLE_COLORS[$roleKey]); ?>40; padding: 4px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">
                <?php echo e(\App\Models\Admin::ROLES[$roleKey]); ?>

            </span>
            <span class="text-muted small"><?php echo e($group->count()); ?> مستخدم</span>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>المستخدم</th>
                <th>البريد / الهاتف</th>
                <th>الصلاحيات</th>
                <th>آخر دخول</th>
                <th>الحالة</th>
                <th class="text-center">إجراءات</th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="admin-avatar-sm" style="background: <?php echo e($user->getRoleColor()); ?>22; color: <?php echo e($user->getRoleColor()); ?>; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem; flex-shrink:0;">
                        <?php echo e(mb_substr($user->name, 0, 1)); ?>

                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.9rem;"><?php echo e($user->name); ?></div>
                        <?php if($user->id === $currentAdmin->id): ?>
                        <span class="badge" style="background:#e8f4fd; color:#1d72b8; font-size:0.65rem;">أنت</span>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
            <td>
                <div style="font-size:0.85rem;"><?php echo e($user->email); ?></div>
                <?php if($user->phone): ?>
                <div class="text-muted small"><?php echo e($user->phone); ?></div>
                <?php endif; ?>
            </td>
            <td>
                <?php $perms = \App\Models\Admin::ROLE_PERMISSIONS[$user->role] ?? []; ?>
                <?php if(in_array('*', $perms)): ?>
                <span class="badge" style="background:rgba(201,168,76,0.15); color:#C9A84C;">كل الصلاحيات</span>
                <?php else: ?>
                <div class="d-flex flex-wrap gap-1">
                    <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge" style="background:#f0f0f0; color:#555; font-size:0.65rem; font-weight:500;"><?php echo e($p); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </td>
            <td>
                <span style="font-size:0.8rem; color:#888;">
                    <?php echo e($user->last_login_at ? $user->last_login_at->diffForHumans() : 'لم يسجل دخول بعد'); ?>

                </span>
            </td>
            <td>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input toggle-active"
                           type="checkbox"
                           <?php echo e($user->active ? 'checked' : ''); ?>

                           <?php echo e($user->id === $currentAdmin->id ? 'disabled' : ''); ?>

                           data-id="<?php echo e($user->id); ?>"
                           data-url="<?php echo e(route('admin.users.toggle-active', $user)); ?>">
                </div>
            </td>
            <td class="text-center">
                <div class="d-flex gap-1 justify-content-center">
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-outline-secondary" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>
                    <?php if($user->id !== $currentAdmin->id): ?>
                    <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>"
                          onsubmit="return confirm('هل تريد حذف هذا المستخدم؟')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<div class="form-card">
    <div class="form-card-title"><i class="fas fa-shield-alt"></i> مرجع الصلاحيات</div>
    <div class="table-responsive">
        <table class="table table-sm" style="font-size:0.82rem;">
            <thead>
                <tr>
                    <th>الصلاحية</th>
                    <?php $__currentLoopData = \App\Models\Admin::ROLES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk => $rl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th class="text-center"><?php echo e($rl); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $allPerms = [
                    'projects.view'      => 'عرض المشاريع',
                    'projects.create'    => 'إضافة مشاريع',
                    'projects.edit'      => 'تعديل مشاريع',
                    'projects.delete'    => 'حذف مشاريع',
                    'contacts.view'      => 'عرض العملاء',
                    'contacts.edit'      => 'تعديل / متابعة العملاء',
                    'contacts.delete'    => 'حذف العملاء',
                    'pages.manage'       => 'إدارة الصفحات',
                    'hero.manage'        => 'إدارة البانر',
                    'page_builder.manage'=> 'ترتيب الأقسام',
                    'countries.manage'   => 'إدارة الدول',
                    'settings.manage'    => 'الإعدادات العامة',
                    'languages.manage'   => 'إدارة اللغات',
                    'users.manage'       => 'إدارة المستخدمين',
                ];
                ?>
                <?php $__currentLoopData = $allPerms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="fw-semibold"><?php echo e($label); ?></td>
                    <?php $__currentLoopData = \App\Models\Admin::ROLES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk => $rl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $rolePerms = \App\Models\Admin::ROLE_PERMISSIONS[$rk] ?? []; ?>
                    <td class="text-center">
                        <?php if(in_array('*', $rolePerms) || in_array($perm, $rolePerms)): ?>
                        <i class="fas fa-check-circle text-success"></i>
                        <?php else: ?>
                        <i class="fas fa-times-circle text-muted" style="opacity:0.3;"></i>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.querySelectorAll('.toggle-active').forEach(function(el) {
    el.addEventListener('change', function() {
        fetch(this.dataset.url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.error) { alert(data.error); this.checked = !this.checked; }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/users/index.blade.php ENDPATH**/ ?>