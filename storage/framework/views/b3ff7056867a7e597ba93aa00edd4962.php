<?php $__env->startSection('title', 'CRM - العملاء والاستفسارات'); ?>
<?php $__env->startSection('page-title', 'CRM — العملاء والاستفسارات'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.crm-status-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:600; }
.quick-assign { min-width:150px; font-size:0.8rem; padding:3px 8px; }
.crm-filter-bar { background:#fff; border-radius:12px; padding:1rem 1.25rem; margin-bottom:1.25rem; box-shadow:0 1px 3px rgba(0,0,0,.06); }
.bulk-toolbar { background:#fff8e1; border:1px solid #ffe082; border-radius:8px; padding:0.6rem 1rem; margin-bottom:1rem; display:none; align-items:center; gap:1rem; flex-wrap:wrap; }
.bulk-toolbar.show { display:flex; }
.follow-up-due { color:#ef4444; font-weight:600; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-blue"><i class="fas fa-inbox"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($statusCounts->get('new', 0)); ?></div>
                <div class="stat-label-admin">جديد</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-orange"><i class="fas fa-spinner"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($statusCounts->get('in_progress', 0)); ?></div>
                <div class="stat-label-admin">قيد المتابعة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-green"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($statusCounts->get('converted', 0)); ?></div>
                <div class="stat-label-admin">تم التحويل</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-admin" style="<?php echo e($dueCount > 0 ? 'border:1px solid #ef444440;' : ''); ?>">
            <div class="stat-icon-admin" style="background:rgba(239,68,68,.12); color:#ef4444;"><i class="fas fa-bell"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin" style="<?php echo e($dueCount > 0 ? 'color:#ef4444;' : ''); ?>"><?php echo e($dueCount); ?></div>
                <div class="stat-label-admin">متابعة متأخرة</div>
            </div>
        </div>
    </div>
</div>


<div class="crm-filter-bar">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">الحالة</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">الكل</option>
                <?php $__currentLoopData = \App\Models\Contact::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sk => $sv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($sk); ?>" <?php echo e(request('status') === $sk ? 'selected' : ''); ?>><?php echo e($sv['label']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <option value="spam" <?php echo e(request('status') === 'spam' ? 'selected' : ''); ?>>سبام</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">الأولوية</label>
            <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">الكل</option>
                <?php $__currentLoopData = \App\Models\Contact::PRIORITIES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pk => $pv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($pk); ?>" <?php echo e(request('priority') === $pk ? 'selected' : ''); ?>><?php echo e($pv['label']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php if(!$currentAdmin->role === 'call_center'): ?>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">المسؤول</label>
            <select name="assigned" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">الكل</option>
                <option value="unassigned" <?php echo e(request('assigned') === 'unassigned' ? 'selected' : ''); ?>>غير معين</option>
                <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($agent->id); ?>" <?php echo e(request('assigned') == $agent->id ? 'selected' : ''); ?>><?php echo e($agent->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php endif; ?>
        <div class="col-6 col-md-2">
            <label class="form-label small fw-semibold mb-1">المتابعة</label>
            <select name="follow_up" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">الكل</option>
                <option value="1" <?php echo e(request('follow_up') ? 'selected' : ''); ?>>متأخرة فقط</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold mb-1">بحث</label>
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control" value="<?php echo e(request('search')); ?>" placeholder="اسم، هاتف، بريد...">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-1">
            <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-sm btn-outline-danger w-100" title="مسح الفلاتر">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </form>
</div>


<?php if($currentAdmin->hasPermission('contacts.edit')): ?>
<form id="bulkForm" method="POST" action="<?php echo e(route('admin.contacts.bulk')); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="action"     id="bulkAction">
    <input type="hidden" name="assign_to"  id="bulkAssignTo">
    <input type="hidden" name="new_status" id="bulkNewStatus">
    <div class="bulk-toolbar" id="bulkToolbar">
        <span id="bulkCount" class="fw-bold small text-dark"></span>
        <button type="button" class="btn btn-sm btn-outline-dark" onclick="doBulk('mark_read')">
            <i class="fas fa-check me-1"></i>تحديد كمقروء
        </button>
        <div class="d-flex gap-1 align-items-center">
            <select id="bulkStatusSel" class="form-select form-select-sm" style="width:auto;">
                <?php $__currentLoopData = \App\Models\Contact::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sk => $sv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($sk); ?>"><?php echo e($sv['label']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="doBulk('status')">تغيير الحالة</button>
        </div>
        <?php if($agents->isNotEmpty()): ?>
        <div class="d-flex gap-1 align-items-center">
            <select id="bulkAssignSel" class="form-select form-select-sm" style="width:auto;">
                <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($agent->id); ?>"><?php echo e($agent->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="doBulk('assign')">تعيين</button>
        </div>
        <?php endif; ?>
        <?php if($currentAdmin->hasPermission('contacts.delete')): ?>
        <button type="button" class="btn btn-sm btn-outline-danger me-auto" onclick="doBulk('delete')">
            <i class="fas fa-trash me-1"></i>حذف
        </button>
        <?php endif; ?>
    </div>
</form>
<?php endif; ?>


<div class="admin-table">
    <div class="admin-table-header">
        <div class="admin-table-title">
            <?php echo e($contacts->total()); ?> استفسار
            <?php if($unreadCount > 0): ?>
            <span class="sidebar-badge ms-2"><?php echo e($unreadCount); ?> غير مقروء</span>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span class="text-muted small">صفحة <?php echo e($contacts->currentPage()); ?> / <?php echo e($contacts->lastPage()); ?></span>
            <a href="<?php echo e(route('admin.contacts.export', request()->query())); ?>" class="btn btn-sm btn-outline-success">
                <i class="fas fa-file-csv me-1"></i> تصدير CSV
            </a>
        </div>
    </div>
    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <?php if($currentAdmin->hasPermission('contacts.edit')): ?>
                <th style="width:36px;"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                <?php endif; ?>
                <th>العميل</th>
                <th>المشروع</th>
                <th>الحالة</th>
                <th>الأولوية</th>
                <th>المسؤول</th>
                <th>موعد المتابعة</th>
                <th>التاريخ</th>
                <th class="text-center">إجراءات</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr style="<?php echo e(!$contact->is_read ? 'background:#fffbf0; font-weight:600;' : ''); ?>">
            <?php if($currentAdmin->hasPermission('contacts.edit')): ?>
            <td>
                <input type="checkbox" class="form-check-input row-check" value="<?php echo e($contact->id); ?>" name="ids[]" form="bulkForm">
            </td>
            <?php endif; ?>
            <td>
                <div style="font-size:0.88rem;">
                    <?php if(!$contact->is_read): ?><span style="display:inline-block; width:7px; height:7px; border-radius:50%; background:#3b82f6; margin-left:5px; vertical-align:middle;"></span><?php endif; ?>
                    <?php echo e($contact->name); ?>

                </div>
                <?php if($contact->contact_number): ?>
                <div style="font-size:0.7rem; color:var(--gold); font-weight:600; letter-spacing:0.5px;"><?php echo e($contact->contact_number); ?></div>
                <?php endif; ?>
                <div class="text-muted" style="font-size:0.78rem;">
                    <?php if($contact->phone): ?><i class="fas fa-phone fa-xs me-1"></i><?php echo e($contact->phone); ?> <?php endif; ?>
                    <?php if($contact->country_code): ?> &nbsp;🌍 <?php echo e($contact->country_code); ?> <?php endif; ?>
                </div>
            </td>
            <td>
                <?php if($contact->project): ?>
                <span class="small" style="color:#555;"><?php echo e($contact->project->getTitle()); ?></span>
                <?php else: ?>
                <span class="text-muted small">—</span>
                <?php endif; ?>
            </td>
            <td>
                <span class="crm-status-badge"
                      style="background:<?php echo e($contact->getStatusBg()); ?>; color:<?php echo e($contact->getStatusColor()); ?>;">
                    <?php echo e($contact->getStatusLabel()); ?>

                </span>
            </td>
            <td>
                <span style="font-size:0.8rem; color:<?php echo e($contact->getPriorityColor()); ?>; font-weight:600;">
                    <i class="fas <?php echo e($contact->getPriorityIcon()); ?> fa-xs me-1"></i><?php echo e($contact->getPriorityLabel()); ?>

                </span>
            </td>
            <td>
                <?php if($contact->assignedAdmin): ?>
                <span class="small"><?php echo e($contact->assignedAdmin->name); ?></span>
                <?php elseif($currentAdmin->hasPermission('contacts.edit')): ?>
                <form method="POST" action="<?php echo e(route('admin.contacts.crm', $contact)); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="status"   value="<?php echo e($contact->status); ?>">
                    <input type="hidden" name="priority" value="<?php echo e($contact->priority); ?>">
                    <select name="assigned_to" class="form-select form-select-sm quick-assign" onchange="this.form.submit()">
                        <option value="">— تعيين —</option>
                        <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($agent->id); ?>"><?php echo e($agent->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </form>
                <?php else: ?>
                <span class="text-muted small">—</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($contact->follow_up_at): ?>
                <span class="<?php echo e($contact->isFollowUpDue() ? 'follow-up-due' : 'text-muted'); ?>" style="font-size:0.8rem;">
                    <?php if($contact->isFollowUpDue()): ?><i class="fas fa-bell fa-xs me-1"></i><?php endif; ?>
                    <?php echo e($contact->follow_up_at->format('m/d H:i')); ?>

                </span>
                <?php else: ?>
                <span class="text-muted small">—</span>
                <?php endif; ?>
            </td>
            <td><span class="text-muted small"><?php echo e($contact->created_at->format('Y/m/d')); ?></span></td>
            <td class="text-center">
                <div class="d-flex gap-1 justify-content-center">
                    <a href="<?php echo e(route('admin.contacts.show', $contact)); ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye"></i>
                    </a>
                    <?php if($currentAdmin->hasPermission('contacts.delete')): ?>
                    <form method="POST" action="<?php echo e(route('admin.contacts.destroy', $contact)); ?>"
                          onsubmit="return confirm('حذف هذا الاستفسار؟')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="9" class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i> لا توجد استفسارات
            </td>
        </tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
    <?php if($contacts->hasPages()): ?>
    <div class="px-4 py-3"><?php echo e($contacts->links()); ?></div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
var selectAll = document.getElementById('selectAll');
var toolbar   = document.getElementById('bulkToolbar');
var bulkCount = document.getElementById('bulkCount');

if (selectAll) {
    selectAll.addEventListener('change', function() {
        document.querySelectorAll('.row-check').forEach(c => c.checked = this.checked);
        updateToolbar();
    });
    document.querySelectorAll('.row-check').forEach(c => c.addEventListener('change', updateToolbar));
}

function updateToolbar() {
    var checked = document.querySelectorAll('.row-check:checked');
    if (toolbar) {
        if (checked.length > 0) {
            toolbar.classList.add('show');
            bulkCount.textContent = 'محدد: ' + checked.length;
        } else {
            toolbar.classList.remove('show');
        }
    }
}

function doBulk(action) {
    var checked = document.querySelectorAll('.row-check:checked');
    if (!checked.length) { alert('اختر سجلاً واحداً على الأقل'); return; }
    if (action === 'delete' && !confirm('حذف ' + checked.length + ' سجل؟')) return;

    document.getElementById('bulkAction').value = action;
    if (action === 'assign') document.getElementById('bulkAssignTo').value = document.getElementById('bulkAssignSel').value;
    if (action === 'status') document.getElementById('bulkNewStatus').value = document.getElementById('bulkStatusSel').value;

    var form = document.getElementById('bulkForm');
    // Remove old hidden ids
    form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
    checked.forEach(function(c) {
        var inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = c.value;
        form.appendChild(inp);
    });
    form.submit();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/contacts/index.blade.php ENDPATH**/ ?>