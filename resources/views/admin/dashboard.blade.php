@extends('admin.layout')
@section('title', 'الداشبورد')
@section('page-title', 'الداشبورد')

@push('styles')
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
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════════
     TOP KPI ROW
═══════════════════════════════════════════════════════════ --}}
<div class="row g-3 mb-4">

    @if($currentAdmin->hasPermission('contacts.view'))
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-blue"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $crmStats['total'] }}</div>
                <div class="stat-label-admin">إجمالي العملاء</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin" style="{{ $crmStats['unread'] > 0 ? 'border:1px solid #ef444440;' : '' }}">
            <div class="stat-icon-admin stat-icon-red"><i class="fas fa-envelope"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin" style="{{ $crmStats['unread'] > 0 ? 'color:#ef4444;' : '' }}">{{ $crmStats['unread'] }}</div>
                <div class="stat-label-admin">غير مقروء</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-orange"><i class="fas fa-spinner"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $crmStats['in_progress'] }}</div>
                <div class="stat-label-admin">قيد المتابعة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-green"><i class="fas fa-handshake"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $crmStats['converted'] }}</div>
                <div class="stat-label-admin">تحويل ناجح</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-purple"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $crmStats['today'] }}</div>
                <div class="stat-label-admin">اليوم</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin" style="background:rgba(201,168,76,0.15); color:var(--gold);"><i class="fas fa-percentage"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $crmStats['conversion_rate'] }}%</div>
                <div class="stat-label-admin">نسبة التحويل</div>
            </div>
        </div>
    </div>
    @endif

    @if($currentAdmin->hasPermission('projects.view'))
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-gold"><i class="fas fa-building"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $projectStats['total'] }}</div>
                <div class="stat-label-admin">المشاريع</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $projectStats['available'] }}</div>
                <div class="stat-label-admin">متاح للبيع</div>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ══════════════════════════════════════════════════════
     ALERTS ROW — Urgent + Due Follow-ups
═══════════════════════════════════════════════════════════ --}}
@if($currentAdmin->hasPermission('contacts.view') && ($crmStats['urgent'] > 0 || $crmStats['due_followup'] > 0))
<div class="row g-3 mb-4">
    @if($crmStats['urgent'] > 0)
    <div class="col-md-6">
        <div class="form-card" style="border-right:4px solid #ef4444;">
            <div class="form-card-title" style="color:#ef4444;">
                <i class="fas fa-fire"></i> عملاء عاجلون ({{ $crmStats['urgent'] }})
                <a href="{{ route('admin.contacts.index', ['priority' => 'urgent']) }}" class="btn btn-sm btn-outline-danger ms-auto" style="font-size:0.75rem; padding:2px 10px;">عرض الكل</a>
            </div>
            @foreach($urgentContacts as $u)
            <div class="urgent-row">
                <div style="flex:1; min-width:0;">
                    <div class="fw-semibold" style="font-size:0.88rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $u->name }}</div>
                    <div class="text-muted" style="font-size:0.75rem;">
                        @if($u->phone) <i class="fas fa-phone fa-xs me-1"></i>{{ $u->phone }} @endif
                        @if($u->project) · {{ Str::limit($u->project->getTitle(), 20) }} @endif
                    </div>
                </div>
                <span class="status-pill" style="background:{{ $u->getStatusBg() }}; color:{{ $u->getStatusColor() }}; font-size:0.72rem; padding:3px 10px;">{{ $u->getStatusLabel() }}</span>
                <a href="{{ route('admin.contacts.show', $u) }}" class="btn btn-sm" style="background:#ef444415; color:#ef4444; padding:3px 8px; border-radius:6px;"><i class="fas fa-arrow-left"></i></a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($crmStats['due_followup'] > 0)
    <div class="col-md-6">
        <div class="form-card" style="border-right:4px solid #f59e0b;">
            <div class="form-card-title" style="color:#d97706;">
                <i class="fas fa-bell"></i> متابعة متأخرة ({{ $crmStats['due_followup'] }})
                <a href="{{ route('admin.contacts.index', ['follow_up' => 1]) }}" class="btn btn-sm btn-outline-warning ms-auto" style="font-size:0.75rem; padding:2px 10px;">عرض الكل</a>
            </div>
            @foreach($dueFollowUps as $fu)
            <div class="fu-row">
                <div style="flex:1; min-width:0;">
                    <div class="fw-semibold" style="font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $fu->name }}</div>
                    @if($fu->assignedAdmin)
                    <div class="text-muted" style="font-size:0.72rem;"><i class="fas fa-user fa-xs me-1"></i>{{ $fu->assignedAdmin->name }}</div>
                    @endif
                </div>
                <div class="fu-time"><i class="fas fa-clock fa-xs me-1"></i>{{ $fu->follow_up_at->format('m/d H:i') }}</div>
                <a href="{{ route('admin.contacts.show', $fu) }}" class="btn btn-sm" style="background:#f59e0b18; color:#d97706; padding:3px 8px; border-radius:6px;"><i class="fas fa-arrow-left"></i></a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     CHARTS ROW
═══════════════════════════════════════════════════════════ --}}
@if($currentAdmin->hasPermission('contacts.view'))
<div class="row g-4 mb-4">

    {{-- Weekly Bar Chart --}}
    <div class="col-md-4">
        <div class="form-card h-100">
            <div class="form-card-title"><i class="fas fa-chart-bar"></i> الاستفسارات (7 أيام)</div>
            @php $maxW = max(1, max(array_column($weeklyContacts, 'count'))); @endphp
            <div class="bar-chart-wrap">
                @foreach($weeklyContacts as $day)
                <div style="flex:1; display:flex; flex-direction:column; align-items:center;">
                    <div class="bar-chart-bar"
                         style="height:{{ max(4, ($day['count']/$maxW)*72) }}px; background:var(--gold); opacity:{{ $day['count'] > 0 ? 1 : 0.2 }};"
                         data-val="{{ $day['count'] }}">
                    </div>
                    <div class="bar-label">{{ $day['label'] }}</div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-2 text-muted" style="font-size:0.78rem;">
                هذا الأسبوع: <strong class="text-dark">{{ $crmStats['this_week'] }}</strong> استفسار
            </div>
        </div>
    </div>

    {{-- Monthly Bar Chart --}}
    <div class="col-md-4">
        <div class="form-card h-100">
            <div class="form-card-title"><i class="fas fa-chart-line"></i> الاستفسارات (6 أشهر)</div>
            @php $maxM = max(1, max(array_column($monthlyContacts, 'total'))); @endphp
            <div class="bar-chart-wrap">
                @foreach($monthlyContacts as $m)
                @php
                    $mTotal     = $m['total'];
                    $mConverted = $m['converted'];
                    $mRest      = $mTotal - $mConverted;
                    $hConv = max(3, ($mConverted / max(1, $mTotal)) * max(4, ($mTotal / $maxM) * 68));
                    $hRest = max(3, ($mRest / $maxM) * 68);
                @endphp
                <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:2px;">
                    <div style="flex:1; width:100%; display:flex; flex-direction:column; justify-content:flex-end; gap:2px;">
                        <div class="bar-chart-bar"
                             style="height:{{ $hConv }}px; background:#10b981; border-radius:3px 3px 0 0; opacity:0.9;"
                             data-val="تحويل: {{ $mConverted }}"></div>
                        <div class="bar-chart-bar"
                             style="height:{{ $hRest }}px; background:var(--gold); border-radius:3px 3px 0 0;"
                             data-val="إجمالي: {{ $mTotal }}"></div>
                    </div>
                    <div class="bar-label">{{ $m['label'] }}</div>
                </div>
                @endforeach
            </div>
            <div class="d-flex gap-3 justify-content-center mt-2" style="font-size:0.72rem; color:#888;">
                <span><span style="display:inline-block; width:10px; height:10px; border-radius:2px; background:var(--gold); margin-left:4px;"></span>إجمالي</span>
                <span><span style="display:inline-block; width:10px; height:10px; border-radius:2px; background:#10b981; margin-left:4px;"></span>محوّل</span>
            </div>
        </div>
    </div>

    {{-- Status Donut + Priority --}}
    <div class="col-md-4">
        <div class="form-card h-100">
            <div class="form-card-title"><i class="fas fa-chart-pie"></i> توزيع الحالات</div>
            @php
            $statusColors = ['new'=>'#3b82f6','in_progress'=>'#f59e0b','converted'=>'#10b981','closed'=>'#6b7280','spam'=>'#ef4444'];
            $total = array_sum($statusBreakdown) ?: 1;
            @endphp
            <div class="d-flex flex-column gap-2">
                @foreach(\App\Models\Contact::STATUSES as $sk => $sv)
                @php $cnt = $statusBreakdown[$sk] ?? 0; $pct = round($cnt/$total*100); @endphp
                <div>
                    <div class="d-flex justify-content-between mb-1" style="font-size:0.8rem;">
                        <span style="color:{{ $sv['color'] }}; font-weight:600;">{{ $sv['label'] }}</span>
                        <span class="text-muted">{{ $cnt }} ({{ $pct }}%)</span>
                    </div>
                    <div class="progress" style="height:7px; border-radius:4px;">
                        <div class="progress-bar" style="width:{{ $pct }}%; background:{{ $sv['color'] }}; border-radius:4px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
            <hr class="my-3">
            <div class="form-card-title" style="border:none; padding:0; margin-bottom:0.75rem; font-size:0.88rem;"><i class="fas fa-exclamation-triangle"></i> الأولوية (نشط)</div>
            @php $priorityColors = ['low'=>'#6b7280','medium'=>'#f59e0b','high'=>'#ef4444','urgent'=>'#dc2626']; $prTotal = max(1,array_sum($priorityBreakdown)); @endphp
            <div class="d-flex gap-2 flex-wrap">
                @foreach(\App\Models\Contact::PRIORITIES as $pk => $pv)
                @php $c = $priorityBreakdown[$pk] ?? 0; @endphp
                <div class="text-center" style="flex:1; min-width:50px; background:{{ $pv['color'] }}14; border-radius:8px; padding:8px 4px;">
                    <div style="font-size:1.1rem; font-weight:800; color:{{ $pv['color'] }};">{{ $c }}</div>
                    <div style="font-size:0.65rem; color:#888;">{{ $pv['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endif

{{-- ══════════════════════════════════════════════════════
     MAIN DATA ROW
═══════════════════════════════════════════════════════════ --}}
<div class="row g-4 mb-4">

    {{-- Recent Contacts --}}
    @if($currentAdmin->hasPermission('contacts.view'))
    <div class="col-lg-7">
        <div class="admin-table">
            <div class="admin-table-header">
                <div class="admin-table-title"><i class="fas fa-headset text-warning me-2"></i>آخر الاستفسارات</div>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-secondary">عرض الكل</a>
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
                @forelse($recentContacts as $contact)
                <tr style="{{ !$contact->is_read ? 'background:#fffbf0;' : '' }}">
                    <td>
                        <div class="fw-semibold" style="font-size:0.85rem;">
                            @if(!$contact->is_read)<span style="display:inline-block; width:7px; height:7px; border-radius:50%; background:#3b82f6; margin-left:5px; vertical-align:middle;"></span>@endif
                            {{ $contact->name }}
                        </div>
                        @if($contact->phone)
                        <div class="text-muted" style="font-size:0.72rem;"><i class="fas fa-phone fa-xs me-1"></i>{{ $contact->phone }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="small text-muted">{{ $contact->project ? Str::limit($contact->project->getTitle(), 18) : '—' }}</span>
                    </td>
                    <td>
                        <span style="display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:12px; font-size:0.72rem; font-weight:600; background:{{ $contact->getStatusBg() }}; color:{{ $contact->getStatusColor() }};">
                            {{ $contact->getStatusLabel() }}
                        </span>
                    </td>
                    <td>
                        <span class="text-muted small">{{ $contact->assignedAdmin?->name ?? '—' }}</span>
                    </td>
                    <td><span class="text-muted" style="font-size:0.75rem;">{{ $contact->created_at->diffForHumans() }}</span></td>
                    <td>
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-secondary" style="padding:2px 8px;">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">لا توجد استفسارات</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Right Column --}}
    <div class="col-lg-5">

        {{-- Countries --}}
        @if($currentAdmin->hasPermission('contacts.view') && $contactsByCountry->count())
        <div class="form-card mb-4">
            <div class="form-card-title"><i class="fas fa-globe-asia"></i> الاستفسارات حسب الدولة</div>
            @php $maxC = max(1, $contactsByCountry->max('count')); @endphp
            @foreach($contactsByCountry as $item)
            <div class="country-row">
                <span style="min-width:36px; font-size:0.82rem; font-weight:600; color:#555;">{{ $item->country_code ?: '—' }}</span>
                <div class="country-bar">
                    <div class="country-bar-fill" style="width:{{ ($item->count/$maxC)*100 }}%;"></div>
                </div>
                <span style="min-width:28px; text-align:left; font-size:0.82rem; font-weight:700; color:#333;">{{ $item->count }}</span>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Sources --}}
        @if($currentAdmin->hasPermission('contacts.view') && $contactsBySource->count())
        <div class="form-card mb-4">
            <div class="form-card-title"><i class="fas fa-filter"></i> مصادر الاستفسارات</div>
            @php $maxSrc = max(1, $contactsBySource->max('cnt')); @endphp
            @foreach($contactsBySource as $src)
            <div class="country-row">
                @php
                $srcIcon = match($src->source) {
                    'whatsapp'     => '💬',
                    'phone'        => '📞',
                    'contact_form' => '📝',
                    'email'        => '📧',
                    'social'       => '📱',
                    default        => '🌐',
                };
                @endphp
                <span style="min-width:90px; font-size:0.78rem; color:#555;">{{ $srcIcon }} {{ $src->source }}</span>
                <div class="country-bar">
                    <div class="country-bar-fill" style="width:{{ ($src->cnt/$maxSrc)*100 }}%; background:#3b82f6;"></div>
                </div>
                <span style="min-width:24px; text-align:left; font-size:0.82rem; font-weight:700;">{{ $src->cnt }}</span>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     AGENT PERFORMANCE + TOP PROJECTS
═══════════════════════════════════════════════════════════ --}}
<div class="row g-4 mb-4">

    {{-- Agent Performance --}}
    @if($currentAdmin->hasPermission('users.manage') && $agentPerformance->count())
    <div class="col-lg-6">
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-trophy"></i> أداء الفريق</div>
            @foreach($agentPerformance as $agent)
            @php
            $convRate = $agent->total_assigned > 0
                ? round(($agent->converted / $agent->total_assigned) * 100)
                : 0;
            @endphp
            <div class="agent-row">
                <div class="agent-avatar" style="background:{{ $agent->getRoleColor() }}20; color:{{ $agent->getRoleColor() }};">
                    {{ mb_substr($agent->name, 0, 1) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold" style="font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:130px;">{{ $agent->name }}</span>
                        <span style="font-size:0.72rem; color:#888;">{{ $agent->getRoleLabel() }}</span>
                    </div>
                    <div class="d-flex gap-2 mt-1 align-items-center">
                        <div class="progress flex-grow-1 progress-sm">
                            <div class="progress-bar" style="width:{{ $convRate }}%; background:#10b981;"></div>
                        </div>
                        <span style="font-size:0.72rem; color:#10b981; font-weight:700; white-space:nowrap;">{{ $convRate }}%</span>
                    </div>
                </div>
                <div class="text-center" style="min-width:60px;">
                    <div style="font-size:1rem; font-weight:800; color:var(--gold);">{{ $agent->total_assigned }}</div>
                    <div style="font-size:0.65rem; color:#aaa;">عميل</div>
                </div>
                <div class="text-center" style="min-width:50px;">
                    <div style="font-size:1rem; font-weight:800; color:#10b981;">{{ $agent->converted }}</div>
                    <div style="font-size:0.65rem; color:#aaa;">محوّل</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Top Projects by Inquiries --}}
    @if($currentAdmin->hasPermission('projects.view') && $topProjects->count())
    <div class="col-lg-6">
        <div class="form-card">
            <div class="form-card-title"><i class="fas fa-fire-alt"></i> المشاريع الأكثر استفسارات</div>
            @php $maxPrj = max(1, $topProjects->max('contacts_count')); @endphp
            @foreach($topProjects as $i => $prj)
            <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px solid #f5f5f5;">
                <div style="font-size:1.1rem; font-weight:800; color:{{ ['var(--gold)','#3b82f6','#10b981','#f59e0b','#8b5cf6'][$i] ?? '#aaa' }}; min-width:24px; text-align:center;">
                    {{ $i + 1 }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div class="fw-semibold" style="font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $prj->getTitle() }}
                    </div>
                    <div class="progress mt-1 progress-sm">
                        <div class="progress-bar" style="width:{{ ($prj->contacts_count/$maxPrj)*100 }}%; background:{{ ['var(--gold)','#3b82f6','#10b981','#f59e0b','#8b5cf6'][$i] ?? '#aaa' }};"></div>
                    </div>
                </div>
                <div class="text-center" style="min-width:40px;">
                    <div style="font-size:1rem; font-weight:800;">{{ $prj->contacts_count }}</div>
                    <div style="font-size:0.65rem; color:#aaa;">استفسار</div>
                </div>
                @if($currentAdmin->hasPermission('projects.edit'))
                <a href="{{ route('admin.projects.edit', $prj) }}" class="btn btn-sm btn-outline-secondary" style="padding:2px 8px; flex-shrink:0;">
                    <i class="fas fa-edit fa-xs"></i>
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- ══════════════════════════════════════════════════════
     QUICK ACTIONS
═══════════════════════════════════════════════════════════ --}}
<div class="form-card">
    <div class="form-card-title"><i class="fas fa-bolt"></i> إجراءات سريعة</div>
    <div class="d-flex gap-2 flex-wrap">
        @if($currentAdmin->hasPermission('projects.create'))
        <a href="{{ route('admin.projects.create') }}" class="btn btn-gold">
            <i class="fas fa-plus me-1"></i> إضافة مشروع
        </a>
        @endif
        @if($currentAdmin->hasPermission('contacts.view'))
        <a href="{{ route('admin.contacts.index', ['status' => 'new']) }}" class="btn btn-outline-primary">
            <i class="fas fa-inbox me-1"></i> الجديد
            @if($crmStats['new'] > 0) <span class="badge bg-primary ms-1">{{ $crmStats['new'] }}</span> @endif
        </a>
        <a href="{{ route('admin.contacts.index', ['follow_up' => 1]) }}" class="btn btn-outline-warning">
            <i class="fas fa-bell me-1"></i> المتابعات المتأخرة
            @if($crmStats['due_followup'] > 0) <span class="badge bg-warning text-dark ms-1">{{ $crmStats['due_followup'] }}</span> @endif
        </a>
        @endif
        @if($currentAdmin->hasPermission('settings.manage'))
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-cog me-1"></i> الإعدادات
        </a>
        @endif
        @if($currentAdmin->hasPermission('users.manage'))
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark">
            <i class="fas fa-users-cog me-1"></i> المستخدمون
        </a>
        @endif
        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-dark ms-auto">
            <i class="fas fa-external-link-alt me-1"></i> عرض الموقع
        </a>
    </div>
</div>

@endsection
