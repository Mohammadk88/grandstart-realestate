@extends('admin.layout')

@section('title', 'الداشبورد')
@section('page-title', 'الداشبورد')

@section('content')

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-gold"><i class="fas fa-building"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $stats['total_projects'] }}</div>
                <div class="stat-label-admin">إجمالي المشاريع</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $stats['active_projects'] }}</div>
                <div class="stat-label-admin">مشاريع نشطة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-orange"><i class="fas fa-star"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $stats['featured_projects'] }}</div>
                <div class="stat-label-admin">مشاريع مميزة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-blue"><i class="fas fa-envelope"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $stats['total_contacts'] }}</div>
                <div class="stat-label-admin">إجمالي الرسائل</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-red"><i class="fas fa-envelope-open"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $stats['unread_contacts'] }}</div>
                <div class="stat-label-admin">رسائل غير مقروءة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card-admin">
            <div class="stat-icon-admin stat-icon-purple"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-info">
                <div class="stat-number-admin">{{ $stats['today_contacts'] }}</div>
                <div class="stat-label-admin">رسائل اليوم</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="form-card p-3">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.projects.create') }}" class="btn btn-gold">
                    <i class="fas fa-plus me-1"></i> إضافة مشروع
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-envelope me-1"></i> الرسائل
                    @if($stats['unread_contacts'] > 0)
                    <span class="badge bg-danger">{{ $stats['unread_contacts'] }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-cog me-1"></i> الإعدادات
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-dark">
                    <i class="fas fa-external-link-alt me-1"></i> عرض الموقع
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Contacts -->
    <div class="col-lg-7">
        <div class="admin-table">
            <div class="admin-table-header">
                <div class="admin-table-title">
                    <i class="fas fa-envelope text-warning me-2"></i>آخر الرسائل
                </div>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-secondary">عرض الكل</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>الدولة</th>
                            <th>التاريخ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentContacts as $contact)
                        <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if(!$contact->is_read)
                                    <span class="badge bg-danger rounded-pill" style="width:8px;height:8px;padding:0;"></span>
                                    @endif
                                    {{ $contact->name }}
                                </div>
                            </td>
                            <td>{{ $contact->phone }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $contact->country_code }}</span>
                            </td>
                            <td><small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small></td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-xs btn-outline-primary py-0 px-2">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">لا توجد رسائل</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="col-lg-5">
        <div class="admin-table">
            <div class="admin-table-header">
                <div class="admin-table-title">
                    <i class="fas fa-building text-warning me-2"></i>آخر المشاريع
                </div>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-secondary">عرض الكل</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>المشروع</th>
                            <th>الحالة</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProjects as $project)
                        <tr>
                            <td>
                                <div style="font-weight:600; font-size:0.875rem;">{{ Str::limit($project->getTitle(), 25) }}</div>
                                <small class="text-muted">{{ $project->getLocation() }}</small>
                            </td>
                            <td>
                                @php
                                $statusClass = match($project->status) {
                                    'available' => 'badge-available',
                                    'sold_out' => 'badge-sold',
                                    'under_construction' => 'badge-construction',
                                    'coming_soon' => 'badge-soon',
                                    default => 'bg-secondary'
                                };
                                $statusLabel = match($project->status) {
                                    'available' => 'متاح',
                                    'sold_out' => 'مباع',
                                    'under_construction' => 'إنشاء',
                                    'coming_soon' => 'قريباً',
                                    default => $project->status
                                };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-xs btn-outline-warning py-0 px-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">لا توجد مشاريع</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Contacts by Country -->
        @if($contactsByCountry->count())
        <div class="form-card mt-4">
            <div class="form-card-title"><i class="fas fa-globe"></i> الرسائل حسب الدولة</div>
            @foreach($contactsByCountry as $item)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-light text-dark">{{ $item->country_code ?: 'غير معروف' }}</span>
                <div class="progress flex-grow-1 mx-2" style="height:6px;">
                    <div class="progress-bar bg-warning" style="width: {{ ($item->count / max(1, $contactsByCountry->max('count'))) * 100 }}%"></div>
                </div>
                <span class="fw-bold text-muted small">{{ $item->count }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection
