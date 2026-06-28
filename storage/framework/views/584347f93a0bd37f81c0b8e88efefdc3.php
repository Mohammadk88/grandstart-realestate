<?php $__env->startSection('title', 'الداشبورد'); ?>
<?php $__env->startSection('page-title', 'الداشبورد'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ── Mini charts / progress ──────────────────────────────── */
.bar-chart-wrap { display:flex; align-items:flex-end; gap:6px; height:80px; }
.bar-chart-bar  { flex:1; border-radius:4px 4px 0 0; min-height:4px; transition:height 0.4s ease; position:relative; cursor:default; }
.bar-chart-bar:hover::after {
    content: attr(data-val);
    position:absolute; bottom:calc(100% + 4px); left:50%; transform:translateX(-50%);
    background:#333; color:#fff; font-size:11px; padding:2px 6px; border-radius:4px; white-space:nowrap;
}
.bar-label { font-size:0.65rem; color:#aaa; text-align:center; margin-top:4px; }

/* ── Donut chart ─────────────────────────────────────────── */
.donut-wrap { position:relative; width:120px; height:120px; }
.donut-label { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; font-size:1.4rem; font-weight:800; line-height:1; }
.donut-sub { font-size:0.65rem; color:#aaa; font-weight:400; }

/* ── Agent row ───────────────────────────────────────────── */
.agent-row { display:flex; align-items:center; gap:12px; padding:0.6rem 0; border-bottom:1px solid #f5f5f5; }
.agent-avatar { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem; flex-shrink:0; }
.progress-sm { height:6px; border-radius:4px; }

/* ── Country list ────────────────────────────────────────── */
.country-row { display:flex; align-items:center; gap:8px; margin-bottom:8px; font-size:0.82rem; }
.country-bar { flex:1; height:6px; border-radius:4px; background:#f0f0f0; overflow:hidden; }
.country-bar-fill { height:100%; background:var(--gold); border-radius:4px; }

/* ── Status pills ─────────────────────────────────────────── */
.status-pill { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:0.8rem; font-weight:600; }

/* ── Urgent badge ─────────────────────────────────────────── */
.urgent-row { display:flex; align-items:center; gap:10px; padding:0.5rem 0; border-bottom:1px solid #f5f5f5; }

/* ── Follow-up row ────────────────────────────────────────── */
.fu-row { display:flex; align-items:center; gap:10px; padding:0.5rem 0; border-bottom:1px solid #f5f5f5; font-size:0.82rem; }
.fu-time { font-size:0.75rem; font-weight:600; color:#ef4444; white-space:nowrap; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-3 mb-4">

    <?php if($currentAdmin->hasPermission('contacts.view')): ?>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-blue"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($crmStats['total']); ?></div>
                <div class="stat-label-admin">إجمالي العملاء</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin" style="<?php echo e($crmStats['unread'] > 0 ? 'border:1px solid #ef444440;' : ''); ?>">
            <div class="stat-icon-admin stat-icon-red"><i class="fas fa-envelope"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin" style="<?php echo e($crmStats['unread'] > 0 ? 'color:#ef4444;' : ''); ?>"><?php echo e($crmStats['unread']); ?></div>
                <div class="stat-label-admin">غير مقروء</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-orange"><i class="fas fa-spinner"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($crmStats['in_progress']); ?></div>
                <div class="stat-label-admin">قيد المتابعة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-green"><i class="fas fa-handshake"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($crmStats['converted']); ?></div>
                <div class="stat-label-admin">تحويل ناجح</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-purple"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($crmStats['today']); ?></div>
                <div class="stat-label-admin">اليوم</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin" style="background:rgba(201,168,76,0.15); color:var(--gold);"><i class="fas fa-percentage"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($crmStats['conversion_rate']); ?>%</div>
                <div class="stat-label-admin">نسبة التحويل</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($currentAdmin->hasPermission('projects.view')): ?>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-gold"><i class="fas fa-building"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($projectStats['total']); ?></div>
                <div class="stat-label-admin">المشاريع</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin"><?php echo e($projectStats['available']); ?></div>
                <div class="stat-label-admin">متاح للبيع</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>


<?php if($currentAdmin->hasPermission('contacts.view') && ($crmStats['urgent'] > 0 || $crmStats['due_followup'] > 0)): ?>
<div class="row g-3 mb-4">
    <?php if($crmStats['urgent'] > 0): ?>
    <div class="col-md-6">
        <div class="form-card" style="border-right:4px solid #ef4444;">
            <div class="form-card-title" style="color:#ef4444;">
                <i class="fas fa-fire"></i> عملاء عاجلون (<?php echo e($crmStats['urgent']); ?>)
                <a href="<?php echo e(route('admin.contacts.index', ['priority' => 'urgent'])); ?>" class="btn btn-sm btn-outline-danger ms-auto" style="font-size:0.75rem; padding:2px 10px;">عرض الكل</a>
            </div>
            <?php $__currentLoopData = $urgentContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="urgent-row">
                <div style="flex:1; min-width:0;">
                    <div class="fw-semibold" style="font-size:0.88rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo e($u->name); ?></div>
                    <div class="text-muted" style="font-size:0.75rem;">
                        <?php if($u->phone): ?> <i class="fas fa-phone fa-xs me-1"></i><?php echo e($u->phone); ?> <?php endif; ?>
                        <?php if($u->project): ?> · <?php echo e(Str::limit($u->project->getTitle(), 20)); ?> <?php endif; ?>
                    </div>
                </div>
                <span class="status-pill" style="background:<?php echo e($u->getStatusBg()); ?>; color:<?php echo e($u->getStatusColor()); ?>; font-size:0.72rem; padding:3px 10px;"><?php echo e($u->getStatusLabel()); ?></span>
                <a href="<?php echo e(route('admin.contacts.show', $u)); ?>" class="btn btn-sm" style="background:#ef444415; color:#ef4444; padding:3px 8px; border-radius:6px;"><i class="fas fa-arrow-left"></i></a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if($crmStats['due_followup'] > 0): ?>
    <div class="col-md-6">
        <div class="form-card" style="border-right:4px solid #f59e0b;">
            <div class="form-card-title" style="color:#d97706;">
                <i class="fas fa-bell"></i> متابعة متأخرة (<?php echo e($crmStats['due_followup']); ?>)
                <a href="<?php echo e(route('admin.contacts.index', ['follow_up' => 1])); ?>" class="btn btn-sm btn-outline-warning ms-auto" style="font-size:0.75rem; padding:2px 10px;">عرض الكل</a>
            </div>
            <?php $__currentLoopData = $dueFollowUps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="fu-row">
                <div style="flex:1; min-width:0;">
                    <div class="fw-semibold" style="font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo e($fu->name); ?></div>
                    <?php if($fu->assignedAdmin): ?>
                    <div class="text-muted" style="font-size:0.72rem;"><i class="fas fa-user fa-xs me-1"></i><?php echo e($fu->assignedAdmin->name); ?></div>
                    <?php endif; ?>
                </div>
                <div class="fu-time"><i class="fas fa-clock fa-xs me-1"></i><?php echo e($fu->follow_up_at->format('m/d H:i')); ?></div>
                <a href="<?php echo e(route('admin.contacts.show', $fu)); ?>" class="btn btn-sm" style="background:#f59e0b18; color:#d97706; padding:3px 8px; border-radius:6px;"><i class="fas fa-arrow-left"></i></a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>


<?php if($currentAdmin->hasPermission('contacts.view')): ?>
<div class="row g-4 mb-4">

    
    <div class="col-md-4">
        <div class="form-card h-100">
            <div class="form-card-title"><i class="fas fa-chart-bar"></i> الاستفسارات (7 أيام)</div>
            <?php $maxW = max(1, max(array_column($weeklyContacts, 'count'))); ?>
            <div class="bar-chart-wrap">
                <?php $__currentLoopData = $weeklyContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="flex:1; display:flex; flex-direction:column; align-items:center;">
                    <div class="bar-chart-bar"
                         style="height:<?php echo e(max(4, ($day['count']/$maxW)*72)); ?>px; background:var(--gold); opacity:<?php echo e($day['count'] > 0 ? 1 : 0.2); ?>;"
                         data-val="<?php echo e($day['count']); ?>">
                    </div>
                    <div class="bar-label"><?php echo e($day['label']); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="text-center mt-2 text-muted" style="font-size:0.78rem;">
                هذا الأسبوع: <strong class="text-dark"><?php echo e($crmStats['this_week']); ?></strong> استفسار
            </div>
        </div>
    </div>

    
    <div class="col-md-4">
        <div class="form-card h-100">
            <div class="form-card-title"><i class="fas fa-chart-line"></i> الاستفسارات (6 أشهر)</div>
            <?php $maxM = max(1, max(array_column($monthlyContacts, 'total'))); ?>
            <div class="bar-chart-wrap">
                <?php $__currentLoopData = $monthlyContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $mTotal     = $m['total'];
                    $mConverted = $m['converted'];
                    $mRest      = $mTotal - $mConverted;
                    $hConv = max(3, ($mConverted / max(1, $mTotal)) * max(4, ($mTotal / $maxM) * 68));
                    $hRest = max(3, ($mRest / $maxM) * 68);
                ?>
                <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:2px;">
                    <div style="flex:1; width:100%; display:flex; flex-direction:column; justify-content:flex-end; gap:2px;">
                        <div class="bar-chart-bar"
                             style="height:<?php echo e($hConv); ?>px; background:#10b981; border-radius:3px 3px 0 0; opacity:0.9;"
                             data-val="تحويل: <?php echo e($mConverted); ?>"></div>
                        <div class="bar-chart-bar"
                             style="height:<?php echo e($hRest); ?>px; background:var(--gold); border-radius:3px 3px 0 0;"
                             data-val="إجمالي: <?php echo e($mTotal); ?>"></div>
                    </div>
                    <div class="bar-label"><?php echo e($m['label']); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="d-flex gap-3 justify-content-center mt-2" style="font-size:0.72rem; color:#888;">
                <span><span style="display:inline-block; width:10px; height:10px; border-radius:2px; background:var(--gold); margin-left:4px;"></span>إجمالي</span>
                <span><span style="display:inline-block; width:10px; height:10px; border-radius:2px; background:#10b981; margin-left:4px;"></span>محوّل</span>
            </div>
        </div>
    </div>

    
    <div class="col-md-4">
        <div class="form-card h-100">
            <div class="form-card-title"><i class="fas fa-chart-pie"></i> توزيع الحالات</div>
            <?php
            $statusColors = ['new'=>'#3b82f6','in_progress'=>'#f59e0b','converted'=>'#10b981','closed'=>'#6b7280','spam'=>'#ef4444'];
            $total = array_sum($statusBreakdown) ?: 1;
            ?>
            <div class="d-flex flex-column gap-2">
                <?php $__currentLoopData = \App\Models\Contact::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sk => $sv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $cnt = $statusBreakdown[$sk] ?? 0; $pct = round($cnt/$total*100); ?>
                <div>
                    <div class="d-flex justify-content-between mb-1" style="font-size:0.8rem;">
                        <span style="color:<?php echo e($sv['color']); ?>; font-weight:600;"><?php echo e($sv['label']); ?></span>
                        <span class="text-muted"><?php echo e($cnt); ?> (<?php echo e($pct); ?>%)</span>
                    </div>
                    <div class="progress" style="height:7px; border-radius:4px;">
                        <div class="progress-bar" style="width:<?php echo e($pct); ?>%; background:<?php echo e($sv['color']); ?>; border-radius:4px;"></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <hr class="my-3">
            <div class="form-card-title" style="border:none; padding:0; margin-bottom:0.75rem; font-size:0.88rem;"><i class="fas fa-exclamation-triangle"></i> الأولوية (نشط)</div>
            <?php $priorityColors = ['low'=>'#6b7280','medium'=>'#f59e0b','high'=>'#ef4444','urgent'=>'#dc2626']; $prTotal = max(1,array_sum($priorityBreakdown)); ?>
            <div class="d-flex gap-2 flex-wrap">
                <?php $__currentLoopData = \App\Models\Contact::PRIORITIES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pk => $pv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $c = $priorityBreakdown[$pk] ?? 0; ?>
                <div class="text-center" style="flex:1; min-width:50px; background:<?php echo e($pv['color']); ?>14; border-radius:8px; padding:8px 4px;">
                    <div style="font-size:1.1rem; font-weight:800; color:<?php echo e($pv['color']); ?>;"><?php echo e($c); ?></div>
                    <div style="font-size:0.65rem; color:#888;"><?php echo e($pv['label']); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

</div>
<?php endif; ?>


<div class="row g-4 mb-4">

    
    <?php if($currentAdmin->hasPermission('contacts.view')): ?>
    <div class="col-lg-7">
        <div class="admin-table">
            <div class="admin-table-header">
                <div class="admin-table-title"><i class="fas fa-headset text-warning me-2"></i>آخر الاستفسارات</div>
                <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-sm btn-outline-secondary">عرض الكل</a>
            </div>
            <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>العميل</th>
                        <th>المشروع</th>
                        <th>الحالة</th>
                        <th>المسؤول</th>
                        <th>التاريخ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $recentContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="<?php echo e(!$contact->is_read ? 'background:#fffbf0;' : ''); ?>">
                    <td>
                        <div class="fw-semibold" style="font-size:0.85rem;">
                            <?php if(!$contact->is_read): ?><span style="display:inline-block; width:7px; height:7px; border-radius:50%; background:#3b82f6; margin-left:5px; vertical-align:middle;"></span><?php endif; ?>
                            <?php echo e($contact->name); ?>

                        </div>
                        <?php if($contact->phone): ?>
                        <div class="text-muted" style="font-size:0.72rem;"><i class="fas fa-phone fa-xs me-1"></i><?php echo e($contact->phone); ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="small text-muted"><?php echo e($contact->project ? Str::limit($contact->project->getTitle(), 18) : '—'); ?></span>
                    </td>
                    <td>
                        <span style="display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:12px; font-size:0.72rem; font-weight:600; background:<?php echo e($contact->getStatusBg()); ?>; color:<?php echo e($contact->getStatusColor()); ?>;">
                            <?php echo e($contact->getStatusLabel()); ?>

                        </span>
                    </td>
                    <td>
                        <span class="text-muted small"><?php echo e($contact->assignedAdmin?->name ?? '—'); ?></span>
                    </td>
                    <td><span class="text-muted" style="font-size:0.75rem;"><?php echo e($contact->created_at->diffForHumans()); ?></span></td>
                    <td>
                        <a href="<?php echo e(route('admin.contacts.show', $contact)); ?>" class="btn btn-sm btn-outline-secondary" style="padding:2px 8px;">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">لا توجد استفسارات</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="col-lg-5">

        
        <?php if($currentAdmin->hasPermission('contacts.view') && $contactsByCountry->count()): ?>
        <div class="form-card mb-4">
            <div class="form-card-title"><i class="fas fa-globe-asia"></i> الاستفسارات حسب الدولة</div>
            <?php $maxC = max(1, $contactsByCountry->max('count')); ?>
            <?php $__currentLoopData = $contactsByCountry; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="country-row">
                <span style="min-width:36px; font-size:0.82rem; font-weight:600; color:#555;"><?php echo e($item->country_code ?: '—'); ?></span>
                <div class="country-bar">
                    <div class="country-bar-fill" style="width:<?php echo e(($item->count/$maxC)*100); ?>%;"></div>
                </div>
                <span style="min-width:28px; text-align:left; font-size:0.82rem; font-weight:700; color:#333;"><?php echo e($item->count); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        
        <?php if($currentAdmin->hasPermission('contacts.view') && $contactsBySource->count()): ?>
        <div class="form-card mb-4">
            <div class="form-card-title"><i class="fas fa-filter"></i> مصادر الاستفسارات</div>
            <?php $maxSrc = max(1, $contactsBySource->max('cnt')); ?>
            <?php $__currentLoopData = $contactsBySource; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $src): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="country-row">
                <?php
                $srcIcon = match($src->source) {
                    'whatsapp'     => '💬',
                    'phone'        => '📞',
                    'contact_form' => '📝',
                    'email'        => '📧',
                    'social'       => '📱',
                    default        => '🌐',
                };
                ?>
                <span style="min-width:90px; font-size:0.78rem; color:#555;"><?php echo e($srcIcon); ?> <?php echo e($src->source); ?></span>
                <div class="country-bar">
                    <div class="country-bar-fill" style="width:<?php echo e(($src->cnt/$maxSrc)*100); ?>%; background:#3b82f6;"></div>
                </div>
                <span style="min-width:24px; text-align:left; font-size:0.82rem; font-weight:700;"><?php echo e($src->cnt); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

    </div>
</div>


<div class="row g-4 mb-4">

    
    <?php if($currentAdmin->hasPermission('users.manage') && $agentPerformance->count()): ?>
    <div class="col-lg-6">
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-trophy"></i> أداء الفريق</div>
            <?php $__currentLoopData = $agentPerformance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $convRate = $agent->total_assigned > 0
                ? round(($agent->converted / $agent->total_assigned) * 100)
                : 0;
            ?>
            <div class="agent-row">
                <div class="agent-avatar" style="background:<?php echo e($agent->getRoleColor()); ?>20; color:<?php echo e($agent->getRoleColor()); ?>;">
                    <?php echo e(mb_substr($agent->name, 0, 1)); ?>

                </div>
                <div style="flex:1; min-width:0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold" style="font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:130px;"><?php echo e($agent->name); ?></span>
                        <span style="font-size:0.72rem; color:#888;"><?php echo e($agent->getRoleLabel()); ?></span>
                    </div>
                    <div class="d-flex gap-2 mt-1 align-items-center">
                        <div class="progress flex-grow-1 progress-sm">
                            <div class="progress-bar" style="width:<?php echo e($convRate); ?>%; background:#10b981;"></div>
                        </div>
                        <span style="font-size:0.72rem; color:#10b981; font-weight:700; white-space:nowrap;"><?php echo e($convRate); ?>%</span>
                    </div>
                </div>
                <div class="text-center" style="min-width:60px;">
                    <div style="font-size:1rem; font-weight:800; color:var(--gold);"><?php echo e($agent->total_assigned); ?></div>
                    <div style="font-size:0.65rem; color:#aaa;">عميل</div>
                </div>
                <div class="text-center" style="min-width:50px;">
                    <div style="font-size:1rem; font-weight:800; color:#10b981;"><?php echo e($agent->converted); ?></div>
                    <div style="font-size:0.65rem; color:#aaa;">محوّل</div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if($currentAdmin->hasPermission('projects.view') && $topProjects->count()): ?>
    <div class="col-lg-6">
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-fire-alt"></i> المشاريع الأكثر استفسارات</div>
            <?php $maxPrj = max(1, $topProjects->max('contacts_count')); ?>
            <?php $__currentLoopData = $topProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $prj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px solid #f5f5f5;">
                <div style="font-size:1.1rem; font-weight:800; color:<?php echo e(['var(--gold)','#3b82f6','#10b981','#f59e0b','#8b5cf6'][$i] ?? '#aaa'); ?>; min-width:24px; text-align:center;">
                    <?php echo e($i + 1); ?>

                </div>
                <div style="flex:1; min-width:0;">
                    <div class="fw-semibold" style="font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <?php echo e($prj->getTitle()); ?>

                    </div>
                    <div class="progress mt-1 progress-sm">
                        <div class="progress-bar" style="width:<?php echo e(($prj->contacts_count/$maxPrj)*100); ?>%; background:<?php echo e(['var(--gold)','#3b82f6','#10b981','#f59e0b','#8b5cf6'][$i] ?? '#aaa'); ?>;"></div>
                    </div>
                </div>
                <div class="text-center" style="min-width:40px;">
                    <div style="font-size:1rem; font-weight:800;"><?php echo e($prj->contacts_count); ?></div>
                    <div style="font-size:0.65rem; color:#aaa;">استفسار</div>
                </div>
                <?php if($currentAdmin->hasPermission('projects.edit')): ?>
                <a href="<?php echo e(route('admin.projects.edit', $prj)); ?>" class="btn btn-sm btn-outline-secondary" style="padding:2px 8px; flex-shrink:0;">
                    <i class="fas fa-edit fa-xs"></i>
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

</div>


<div class="form-card">
    <div class="form-card-title"><i class="fas fa-bolt"></i> إجراءات سريعة</div>
    <div class="d-flex gap-2 flex-wrap">
        <?php if($currentAdmin->hasPermission('projects.create')): ?>
        <a href="<?php echo e(route('admin.projects.create')); ?>" class="btn btn-gold">
            <i class="fas fa-plus me-1"></i> إضافة مشروع
        </a>
        <?php endif; ?>
        <?php if($currentAdmin->hasPermission('contacts.view')): ?>
        <a href="<?php echo e(route('admin.contacts.index', ['status' => 'new'])); ?>" class="btn btn-outline-primary">
            <i class="fas fa-inbox me-1"></i> الجديد
            <?php if($crmStats['new'] > 0): ?> <span class="badge bg-primary ms-1"><?php echo e($crmStats['new']); ?></span> <?php endif; ?>
        </a>
        <a href="<?php echo e(route('admin.contacts.index', ['follow_up' => 1])); ?>" class="btn btn-outline-warning">
            <i class="fas fa-bell me-1"></i> المتابعات المتأخرة
            <?php if($crmStats['due_followup'] > 0): ?> <span class="badge bg-warning text-dark ms-1"><?php echo e($crmStats['due_followup']); ?></span> <?php endif; ?>
        </a>
        <?php endif; ?>
        <?php if($currentAdmin->hasPermission('settings.manage')): ?>
        <a href="<?php echo e(route('admin.settings.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-cog me-1"></i> الإعدادات
        </a>
        <?php endif; ?>
        <?php if($currentAdmin->hasPermission('users.manage')): ?>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-dark">
            <i class="fas fa-users-cog me-1"></i> المستخدمون
        </a>
        <?php endif; ?>
        <a href="<?php echo e(route('home')); ?>" target="_blank" class="btn btn-outline-dark ms-auto">
            <i class="fas fa-external-link-alt me-1"></i> عرض الموقع
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>