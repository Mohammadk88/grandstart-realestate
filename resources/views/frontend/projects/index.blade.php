@extends('layouts.app')

@section('title', __('app.all_projects') . ' - ' . \App\Models\Setting::get('company_name_' . app()->getLocale()))

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content text-center">
            <h1 class="page-header-title" data-aos="fade-down">{{ __('app.all_projects') }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('app.projects') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="projects-section py-6">
    <div class="container">

        <!-- Filters -->
        <div class="projects-filter mb-5" data-aos="fade-up">
            <form method="GET" action="{{ route('projects.index') }}" class="filter-form">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="form-control search-input"
                                   placeholder="{{ __('app.search_projects') }}"
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select filter-select">
                            <option value="">{{ __('app.all_types') }}</option>
                            @foreach(['residential', 'commercial', 'villa', 'apartment', 'compound', 'tower'] as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                {{ __('app.' . $type) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select filter-select">
                            <option value="">{{ __('app.all_statuses') }}</option>
                            @foreach(['available', 'under_construction', 'coming_soon', 'sold_out'] as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ __('app.' . $status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-gold w-100">
                            <i class="fas fa-filter me-2"></i>{{ app()->getLocale() === 'en' ? 'Filter' : 'تصفية' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <p class="results-count mb-0">
                {{ $projects->total() }}
                {{ app()->getLocale() === 'en' ? 'project(s) found' : 'مشروع' }}
            </p>
            @if(request()->hasAny(['search', 'type', 'status']))
            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-times me-1"></i>
                {{ app()->getLocale() === 'en' ? 'Clear Filters' : 'مسح الفلاتر' }}
            </a>
            @endif
        </div>

        <!-- Projects Grid -->
        @if($projects->isEmpty())
        <div class="text-center py-5" data-aos="fade-up">
            <div class="empty-state">
                <i class="fas fa-building empty-icon"></i>
                <h3>{{ __('app.no_projects') }}</h3>
                <a href="{{ route('projects.index') }}" class="btn btn-gold mt-3">
                    {{ app()->getLocale() === 'en' ? 'View All' : 'عرض الكل' }}
                </a>
            </div>
        </div>
        @else
        <div class="row g-4">
            @foreach($projects as $i => $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                <div class="project-card">
                    <div class="project-image-wrap">
                        <img src="{{ $project->getMainImageUrl() }}"
                             alt="{{ $project->getTitle() }}"
                             class="project-img"
                             loading="lazy">
                        <div class="project-overlay">
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-gold btn-sm">
                                {{ __('app.view_project') }}
                            </a>
                        </div>
                        <div class="project-badges">
                            <span class="badge-status status-{{ $project->status }}">
                                {{ $project->getStatusLabel() }}
                            </span>
                            @if($project->featured)
                            <span class="badge-featured"><i class="fas fa-star"></i></span>
                            @endif
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-type">
                            <i class="fas fa-tag"></i> {{ $project->getTypeLabel() }}
                        </div>
                        <h3 class="project-title">
                            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->getTitle() }}</a>
                        </h3>
                        <p class="project-location">
                            <i class="fas fa-map-marker-alt"></i> {{ $project->getLocation() }}
                        </p>
                        <p class="project-excerpt">
                            {{ Str::limit($project->getDescription(), 100) }}
                        </p>
                        <div class="project-footer">
                            <div class="project-price">
                                @if($countryCode === 'IQ' && $project->price_iqd)
                                    {{ number_format($project->price_iqd, 0) }} <small>د.ع</small>
                                @elseif($countryCode === 'TR' && $project->price_try)
                                    <small>₺</small>{{ number_format($project->price_try, 0) }}
                                @elseif($project->price_usd)
                                    <small>$</small>{{ number_format($project->price_usd, 0) }}
                                @else
                                    {{ __('app.price_on_request') }}
                                @endif
                            </div>
                            <div class="project-meta">
                                @if($project->area)
                                <span title="{{ __('app.area') }}"><i class="fas fa-vector-square"></i> {{ $project->area }}</span>
                                @endif
                                @if($project->floors)
                                <span title="{{ __('app.floors') }}"><i class="fas fa-layer-group"></i> {{ $project->floors }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="pagination-wrap mt-5 d-flex justify-content-center" data-aos="fade-up">
            {{ $projects->withQueryString()->links('vendor.pagination.custom') }}
        </div>
        @endif
        @endif
    </div>
</section>

@endsection
