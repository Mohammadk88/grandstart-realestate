<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #C9A84C;
            --dark: #0D0D0D;
            --dark2: #1a1a1a;
            --dark3: #252525;
        }
        * { box-sizing: border-box; }
        body {
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cairo', 'Tajawal', sans-serif;
        }
        .login-card {
            background: var(--dark2);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo img { height: 80px; }
        .login-title {
            color: var(--gold);
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .login-subtitle {
            color: #888;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-label { color: #ccc; font-size: 0.9rem; }
        .form-control {
            background: var(--dark3);
            border: 1px solid rgba(201,168,76,0.2);
            color: #fff;
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }
        .form-control:focus {
            background: var(--dark3);
            border-color: var(--gold);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
        }
        .btn-login {
            background: linear-gradient(135deg, var(--gold), #8B6914);
            border: none;
            color: #000;
            font-weight: 700;
            padding: 0.75rem;
            border-radius: 8px;
            width: 100%;
            font-size: 1rem;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #d4b05a, #a07820);
            transform: translateY(-2px);
        }
        .alert-danger-custom {
            background: rgba(220,53,69,0.15);
            border: 1px solid rgba(220,53,69,0.3);
            color: #f87171;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        .back-link {
            display: block;
            text-align: center;
            color: var(--gold);
            text-decoration: none;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        .back-link:hover { opacity: 1; color: var(--gold); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <img src="<?php echo e(asset('images/logo-transparent.png')); ?>" alt="Grand Start Real Estate">
        </div>
        <h1 class="login-title">لوحة التحكم</h1>
        <p class="login-subtitle">أدخل بياناتك للدخول</p>

        <?php if($errors->any()): ?>
        <div class="alert-danger-custom mb-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="alert-danger-custom mb-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.login.post')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-envelope me-1"></i> البريد الإلكتروني
                </label>
                <input type="email" name="email" class="form-control"
                       value="<?php echo e(old('email')); ?>"
                       placeholder="admin@grandstartrealestate.com"
                       required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-lock me-1"></i> كلمة المرور
                </label>
                <input type="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> تسجيل الدخول
            </button>
        </form>

        <a href="<?php echo e(route('home')); ?>" class="back-link">
            <i class="fas fa-arrow-right me-1"></i> العودة إلى الموقع
        </a>
    </div>
</body>
</html>
<?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>