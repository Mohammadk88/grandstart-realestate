<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'لوحة التحكم'); ?> - Grand Start Real Estate</title>

    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-PJsj/BTMqILvmcej7ulplguok8ag4xFTPryRq8xevL7eBYSmpXKcbNVuy+P0RMgq" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha384-iw3OoTErCYJJB9mCa8LNS2hbsQ7M3C0EpIsO/H5+EGAkPGc6rk+V8i04oW/K5xq0" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #d4b05a;
            --dark: #0D0D0D;
            --dark2: #161616;
            --dark3: #1e1e1e;
            --dark4: #252525;
            --sidebar-width: 260px;
            --topbar-height: 64px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f0f2f5;
            margin: 0;
        }

        /* ===== SIDEBAR ===== */
        .admin-sidebar {
            position: fixed;
            right: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--dark2);
            border-left: 1px solid rgba(201,168,76,0.15);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(201,168,76,0.15);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar-logo img { height: 40px; }
        .sidebar-logo-text { color: var(--gold); font-weight: 700; font-size: 0.9rem; line-height: 1.2; }

        .sidebar-nav { padding: 1rem 0; flex: 1; }

        .nav-section-title {
            color: #555;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.75rem 1.5rem 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            color: #aaa;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.9rem;
            border-right: 3px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            color: var(--gold);
            background: rgba(201,168,76,0.08);
            border-right-color: var(--gold);
        }
        .sidebar-link i { width: 18px; text-align: center; }

        .sidebar-badge {
            margin-right: auto;
            background: var(--gold);
            color: #000;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(201,168,76,0.15);
        }

        /* ===== MAIN CONTENT ===== */
        .admin-main {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .admin-topbar {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .topbar-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
        }

        .topbar-actions { display: flex; align-items: center; gap: 1rem; }

        .admin-avatar {
            width: 36px;
            height: 36px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
        }

        /* ===== CONTENT ===== */
        .admin-content {
            padding: 1.5rem;
            flex: 1;
        }

        /* ===== CARDS ===== */
        .stat-card-admin {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .stat-icon-admin {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .stat-icon-gold { background: rgba(201,168,76,0.15); color: var(--gold); }
        .stat-icon-blue { background: rgba(59,130,246,0.15); color: #3b82f6; }
        .stat-icon-green { background: rgba(16,185,129,0.15); color: #10b981; }
        .stat-icon-red { background: rgba(239,68,68,0.15); color: #ef4444; }
        .stat-icon-purple { background: rgba(139,92,246,0.15); color: #8b5cf6; }
        .stat-icon-orange { background: rgba(245,158,11,0.15); color: #f59e0b; }

        .stat-info { flex: 1; }
        .stat-number-admin { font-size: 1.6rem; font-weight: 800; color: #1a1a1a; line-height: 1; }
        .stat-label-admin { font-size: 0.8rem; color: #888; margin-top: 2px; }

        /* ===== TABLE ===== */
        .admin-table {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            overflow: hidden;
        }
        .admin-table-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-table-title { font-weight: 700; color: #333; font-size: 1rem; }
        .table { margin-bottom: 0; }
        .table th { color: #888; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none; background: #fafafa; }
        .table td { vertical-align: middle; border-color: #f5f5f5; }
        .table tbody tr:hover { background: #fafafa; }

        /* ===== BUTTONS ===== */
        .btn-gold { background: var(--gold); color: #000; border: none; font-weight: 600; }
        .btn-gold:hover { background: var(--gold-light); color: #000; }
        .btn-outline-gold { border: 1px solid var(--gold); color: var(--gold); background: transparent; font-weight: 600; }
        .btn-outline-gold:hover { background: var(--gold); color: #000; }

        /* ===== FORM ===== */
        .form-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .form-card-title {
            font-weight: 700;
            color: #333;
            font-size: 1rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-card-title i { color: var(--gold); }
        .form-label { font-weight: 600; color: #555; font-size: 0.875rem; }

        /* ===== ALERTS ===== */
        .alert-success-admin {
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.3);
            color: #065f46;
            border-radius: 8px;
        }
        .alert-danger-admin {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #991b1b;
            border-radius: 8px;
        }

        /* ===== BADGES ===== */
        .badge-available { background: rgba(16,185,129,0.15); color: #059669; }
        .badge-sold { background: rgba(239,68,68,0.15); color: #dc2626; }
        .badge-construction { background: rgba(245,158,11,0.15); color: #d97706; }
        .badge-soon { background: rgba(139,92,246,0.15); color: #7c3aed; }

        /* ===== PAGINATION ===== */
        .page-link { color: var(--gold); border-color: #e9ecef; }
        .page-item.active .page-link { background: var(--gold); border-color: var(--gold); color: #000; }

        /* ===== MOBILE ===== */
        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-main { margin-right: 0; }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-logo">
            <img src="<?php echo e(asset('images/logo-transparent.png')); ?>" alt="Grand Start">
            <div class="sidebar-logo-text">
                Grand Start<br>
                <small style="color:#888; font-weight:400;">لوحة التحكم</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">الرئيسية</div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-chart-line"></i> الداشبورد
            </a>

            <?php if(isset($currentAdmin) && $currentAdmin->hasPermission('contacts.view')): ?>
            <div class="nav-section-title mt-2">CRM</div>
            <a href="<?php echo e(route('admin.contacts.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.contacts.*') ? 'active' : ''); ?>">
                <i class="fas fa-headset"></i> العملاء والاستفسارات
                <?php $unread = \App\Models\Contact::where('is_read', false)->count(); ?>
                <?php if($unread > 0): ?>
                <span class="sidebar-badge"><?php echo e($unread); ?></span>
                <?php endif; ?>
            </a>
            <?php if($currentAdmin->hasPermission('contacts.view')): ?>
            <?php $dueCrm = \App\Models\Contact::dueFollowUp()->count(); ?>
            <?php if($dueCrm > 0): ?>
            <a href="<?php echo e(route('admin.contacts.index', ['follow_up' => 1])); ?>" class="sidebar-link" style="color:#ef4444 !important; border-right-color:#ef4444;">
                <i class="fas fa-bell"></i> متابعة متأخرة
                <span class="sidebar-badge" style="background:#ef4444;"><?php echo e($dueCrm); ?></span>
            </a>
            <?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>

            <?php if(isset($currentAdmin) && $currentAdmin->hasPermission('projects.view')): ?>
            <div class="nav-section-title mt-2">إدارة المحتوى</div>
            <a href="<?php echo e(route('admin.projects.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.projects.*') ? 'active' : ''); ?>">
                <i class="fas fa-building"></i> المشاريع
            </a>
            <?php endif; ?>
            <?php if(isset($currentAdmin) && $currentAdmin->hasPermission('pages.manage')): ?>
            <a href="<?php echo e(route('admin.pages.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.pages.*') ? 'active' : ''); ?>">
                <i class="fas fa-file-alt"></i> الصفحات
            </a>
            <?php endif; ?>
            <?php if(isset($currentAdmin) && $currentAdmin->hasPermission('hero.manage')): ?>
            <a href="<?php echo e(route('admin.hero.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.hero.*') ? 'active' : ''); ?>">
                <i class="fas fa-images"></i> البانر الرئيسي
            </a>
            <?php endif; ?>
            <?php if(isset($currentAdmin) && $currentAdmin->hasPermission('page_builder.manage')): ?>
            <a href="<?php echo e(route('admin.page-builder.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.page-builder.*') ? 'active' : ''); ?>">
                <i class="fas fa-th-large"></i> ترتيب الأقسام
            </a>
            <?php endif; ?>

            <?php if(isset($currentAdmin) && ($currentAdmin->hasPermission('settings.manage') || $currentAdmin->hasPermission('languages.manage') || $currentAdmin->hasPermission('countries.manage') || $currentAdmin->hasPermission('users.manage'))): ?>
            <div class="nav-section-title mt-2">الإعدادات</div>
            <?php if($currentAdmin->hasPermission('users.manage')): ?>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                <i class="fas fa-users-cog"></i> المستخدمون والصلاحيات
            </a>
            <?php endif; ?>
            <?php if($currentAdmin->hasPermission('settings.manage')): ?>
            <a href="<?php echo e(route('admin.settings.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
                <i class="fas fa-cog"></i> الإعدادات العامة
            </a>
            <?php endif; ?>
            <?php if($currentAdmin->hasPermission('languages.manage')): ?>
            <a href="<?php echo e(route('admin.languages.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.languages.*') ? 'active' : ''); ?>">
                <i class="fas fa-language"></i> اللغات
            </a>
            <?php endif; ?>
            <?php if($currentAdmin->hasPermission('countries.manage')): ?>
            <a href="<?php echo e(route('admin.countries.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.countries.*') ? 'active' : ''); ?>">
                <i class="fas fa-globe"></i> دول التواصل
            </a>
            <?php endif; ?>
            <?php endif; ?>

            <div class="nav-section-title mt-2">الموقع</div>
            <a href="<?php echo e(route('home')); ?>" target="_blank" class="sidebar-link">
                <i class="fas fa-external-link-alt"></i> عرض الموقع
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2 mb-2">
                <?php if(isset($currentAdmin)): ?>
                <div class="admin-avatar" style="background:<?php echo e($currentAdmin->getRoleColor()); ?>; color:#000;">
                    <?php echo e(mb_substr($currentAdmin->name, 0, 1)); ?>

                </div>
                <div>
                    <div style="color:#ccc; font-size:0.85rem; font-weight:600;"><?php echo e($currentAdmin->name); ?></div>
                    <div style="color:#888; font-size:0.72rem;">
                        <span style="color:<?php echo e($currentAdmin->getRoleColor()); ?>;"><?php echo e($currentAdmin->getRoleLabel()); ?></span>
                    </div>
                </div>
                <?php else: ?>
                <div class="admin-avatar"><?php echo e(substr(session('admin_name', 'A'), 0, 1)); ?></div>
                <div>
                    <div style="color:#ccc; font-size:0.85rem; font-weight:600;"><?php echo e(session('admin_name')); ?></div>
                    <div style="color:#666; font-size:0.75rem;"><?php echo e(session('admin_email')); ?></div>
                </div>
                <?php endif; ?>
            </div>
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                    <i class="fas fa-sign-out-alt me-1"></i> تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Topbar -->
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-title"><?php echo $__env->yieldContent('page-title', 'لوحة التحكم'); ?></div>
            </div>
            <div class="topbar-actions">
                <?php if(session('success')): ?>
                <div class="alert alert-success-admin py-1 px-3 mb-0 small d-none d-md-block">
                    <i class="fas fa-check-circle me-1"></i><?php echo e(session('success')); ?>

                </div>
                <?php endif; ?>
                <a href="<?php echo e(route('home')); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-external-link-alt me-1"></i> الموقع
                </a>
                <div class="admin-avatar"><?php echo e(substr(session('admin_name', 'A'), 0, 1)); ?></div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="admin-content">
            <?php if(session('success')): ?>
            <div class="alert alert-success-admin mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="alert alert-danger-admin mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>
        // Sidebar toggle on mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('adminSidebar').classList.toggle('show');
        });

        // Auto-hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 4000);

        // CSRF for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/layout.blade.php ENDPATH**/ ?>