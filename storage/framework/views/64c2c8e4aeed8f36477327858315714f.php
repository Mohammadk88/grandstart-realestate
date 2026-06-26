<?php $__env->startSection('title', 'تفاصيل العميل'); ?>
<?php $__env->startSection('page-title', 'ملف العميل'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.crm-status-badge { display:inline-flex; align-items:center; gap:5px; padding:5px 14px; border-radius:20px; font-size:0.82rem; font-weight:600; }
.info-row { display:flex; gap:1rem; padding:0.5rem 0; border-bottom:1px solid #f5f5f5; font-size:0.9rem; }
.info-label { color:#888; min-width:120px; font-weight:600; flex-shrink:0; }
.crm-panel { position:sticky; top:80px; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex gap-2 mb-4">
    <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع للقائمة
    </a>
    <?php if($currentAdmin->hasPermission('contacts.delete')): ?>
    <form method="POST" action="<?php echo e(route('admin.contacts.destroy', $contact)); ?>"
          onsubmit="return confirm('حذف هذا الاستفسار نهائياً؟')" class="ms-auto">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash me-1"></i> حذف
        </button>
    </form>
    <?php endif; ?>
</div>

<div class="row g-4">
    
    <div class="col-lg-7">

        <div class="form-card">
            <div class="form-card-title">
                <i class="fas fa-user"></i> بيانات العميل
                <?php if(!$contact->is_read): ?>
                <span class="badge ms-2" style="background:#3b82f620; color:#3b82f6; font-size:0.7rem;">جديد</span>
                <?php endif; ?>
            </div>

            <?php if($contact->contact_number): ?>
            <div class="info-row">
                <span class="info-label">رقم العميل</span>
                <span class="badge" style="background:var(--gold)20; color:var(--gold); border:1px solid var(--gold)40; font-size:0.85rem; font-weight:700; letter-spacing:1px;"><?php echo e($contact->contact_number); ?></span>
            </div>
            <?php endif; ?>
            <div class="info-row"><span class="info-label">الاسم</span> <?php echo e($contact->name); ?></div>
            <?php if($contact->email): ?>
            <div class="info-row">
                <span class="info-label">البريد</span>
                <a href="mailto:<?php echo e($contact->email); ?>"><?php echo e($contact->email); ?></a>
            </div>
            <?php endif; ?>
            <?php if($contact->phone): ?>
            <div class="info-row">
                <span class="info-label">الهاتف</span>
                <a href="tel:<?php echo e($contact->phone); ?>"><?php echo e($contact->phone); ?></a>
                &nbsp;
                <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $contact->phone)); ?>" target="_blank"
                   class="btn btn-sm" style="background:#25D366; color:#fff; padding:2px 8px; border-radius:6px; font-size:0.75rem;">
                    <i class="fab fa-whatsapp me-1"></i>واتساب
                </a>
            </div>
            <?php endif; ?>
            <?php if($contact->country_code): ?>
            <div class="info-row"><span class="info-label">الدولة</span> 🌍 <?php echo e($contact->country_code); ?></div>
            <?php endif; ?>
            <?php if($contact->source): ?>
            <div class="info-row"><span class="info-label">المصدر</span> <?php echo e($contact->source); ?></div>
            <?php endif; ?>
            <?php if($contact->project): ?>
            <div class="info-row">
                <span class="info-label">المشروع</span>
                <a href="<?php echo e(route('admin.projects.show', $contact->project)); ?>">
                    <?php echo e($contact->project->getTitle()); ?>

                </a>
            </div>
            <?php endif; ?>
            <?php if($contact->budget_range): ?>
            <div class="info-row"><span class="info-label">الميزانية</span> <?php echo e(\App\Models\Contact::BUDGET_RANGES[$contact->budget_range] ?? $contact->budget_range); ?></div>
            <?php endif; ?>
            <?php if($contact->preferred_contact && $contact->preferred_contact !== 'any'): ?>
            <div class="info-row"><span class="info-label">وسيلة التواصل</span> <?php echo e(\App\Models\Contact::PREFERRED_CONTACT[$contact->preferred_contact] ?? $contact->preferred_contact); ?></div>
            <?php endif; ?>
            <?php if($contact->language): ?>
            <div class="info-row"><span class="info-label">لغة العميل</span> <?php echo e(strtoupper($contact->language)); ?></div>
            <?php endif; ?>
            <div class="info-row"><span class="info-label">تاريخ التواصل</span> <?php echo e($contact->created_at->format('Y/m/d H:i')); ?> (<?php echo e($contact->created_at->diffForHumans()); ?>)</div>
        </div>

        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-comment-dots"></i> الرسالة</div>
            <p style="white-space:pre-wrap; line-height:1.8; color:#333; margin:0;"><?php echo e($contact->message); ?></p>
        </div>

        <?php if($contact->crm_notes): ?>
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-sticky-note"></i> ملاحظات CRM</div>
            <p style="white-space:pre-wrap; line-height:1.8; color:#555; margin:0;"><?php echo e($contact->crm_notes); ?></p>
            <?php if($contact->lastActionAdmin): ?>
            <div class="text-muted small mt-2">
                آخر تحديث: <?php echo e($contact->lastActionAdmin->name); ?> — <?php echo e($contact->last_action_at?->format('Y/m/d H:i')); ?>

            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>

    
    <div class="col-lg-5">
        <div class="crm-panel">

            
            <div class="form-card text-center">
                <span class="crm-status-badge d-inline-flex"
                      style="background:<?php echo e($contact->getStatusBg()); ?>; color:<?php echo e($contact->getStatusColor()); ?>; font-size:1rem;">
                    <?php echo e($contact->getStatusLabel()); ?>

                </span>
                <div class="mt-2" style="font-size:0.82rem; color:<?php echo e($contact->getPriorityColor()); ?>; font-weight:600;">
                    <i class="fas <?php echo e($contact->getPriorityIcon()); ?> me-1"></i>أولوية: <?php echo e($contact->getPriorityLabel()); ?>

                </div>
                <?php if($contact->assignedAdmin): ?>
                <div class="mt-1 text-muted small">
                    <i class="fas fa-user-tie me-1"></i>مسؤول: <?php echo e($contact->assignedAdmin->name); ?>

                </div>
                <?php endif; ?>
                <?php if($contact->follow_up_at): ?>
                <div class="mt-1 <?php echo e($contact->isFollowUpDue() ? 'text-danger fw-bold' : 'text-muted'); ?> small">
                    <i class="fas fa-calendar-alt me-1"></i>
                    متابعة: <?php echo e($contact->follow_up_at->format('Y/m/d H:i')); ?>

                    <?php if($contact->isFollowUpDue()): ?> (متأخر!) <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            
            <?php if($currentAdmin->hasPermission('contacts.edit')): ?>
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-edit"></i> تحديث CRM</div>
                <form method="POST" action="<?php echo e(route('admin.contacts.crm', $contact)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">الحالة</label>
                        <div class="row g-1">
                            <?php $__currentLoopData = \App\Models\Contact::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sk => $sv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6">
                                <label class="d-flex align-items-center gap-2 p-2 rounded border small"
                                       style="cursor:pointer; <?php echo e($contact->status === $sk ? 'border-color:'.$sv['color'].'; background:'.$sv['bg'].'; font-weight:700;' : ''); ?>">
                                    <input type="radio" name="status" value="<?php echo e($sk); ?>" <?php echo e($contact->status === $sk ? 'checked' : ''); ?>>
                                    <span style="color:<?php echo e($sv['color']); ?>;"><?php echo e($sv['label']); ?></span>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">الأولوية</label>
                        <div class="row g-1">
                            <?php $__currentLoopData = \App\Models\Contact::PRIORITIES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pk => $pv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6">
                                <label class="d-flex align-items-center gap-2 p-2 rounded border small"
                                       style="cursor:pointer; <?php echo e($contact->priority === $pk ? 'border-color:'.$pv['color'].'; background:'.$pv['color'].'18; font-weight:700;' : ''); ?>">
                                    <input type="radio" name="priority" value="<?php echo e($pk); ?>" <?php echo e($contact->priority === $pk ? 'checked' : ''); ?>>
                                    <i class="fas <?php echo e($pv['icon']); ?> fa-xs" style="color:<?php echo e($pv['color']); ?>;"></i>
                                    <span style="color:<?php echo e($pv['color']); ?>;"><?php echo e($pv['label']); ?></span>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">تعيين إلى</label>
                        <select name="assigned_to" class="form-select form-select-sm">
                            <option value="">— بدون تعيين —</option>
                            <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($agent->id); ?>" <?php echo e($contact->assigned_to == $agent->id ? 'selected' : ''); ?>>
                                <?php echo e($agent->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">موعد المتابعة</label>
                        <input type="datetime-local" name="follow_up_at" class="form-control form-control-sm"
                               value="<?php echo e($contact->follow_up_at ? $contact->follow_up_at->format('Y-m-d\TH:i') : ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">ملاحظات CRM</label>
                        <textarea name="crm_notes" class="form-control form-control-sm" rows="4"
                                  placeholder="سجّل ملاحظات المتابعة..."><?php echo e($contact->crm_notes); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-gold w-100 fw-bold">
                        <i class="fas fa-save me-2"></i> حفظ التحديث
                    </button>
                </form>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/contacts/show.blade.php ENDPATH**/ ?>