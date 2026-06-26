# Grand Start Real Estate Website

موقع عقاري فاخر مبني بـ Laravel PHP مع لوحة تحكم كاملة.

## التقنيات المستخدمة

- **Laravel 10** - PHP Framework
- **MySQL** - قاعدة البيانات
- **Bootstrap 5 RTL** - واجهة المستخدم مع دعم RTL
- **Custom CSS** - ثيم أسود وذهبي فاخر
- **Swiper.js** - معرض الصور
- **AOS** - تأثيرات التمرير

## المتطلبات

- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Node.js (اختياري)

## التثبيت

```bash
# 1. استنساخ المشروع
git clone <repo-url>
cd grand-start

# 2. تثبيت التبعيات
composer install

# 3. إعداد ملف البيئة
cp .env.example .env
php artisan key:generate

# 4. إعداد قاعدة البيانات
# أنشئ قاعدة بيانات MySQL باسم: grand_start
php artisan migrate
php artisan db:seed

# 5. إنشاء رابط التخزين
php artisan storage:link

# 6. تشغيل السيرفر
php artisan serve
```

## بيانات الدخول للوحة التحكم

- **الرابط:** `/admin`
- **البريد:** `admin@grandstartrealestate.com`
- **كلمة المرور:** `admin@2024`

## الصفحات

| الصفحة | الرابط |
|--------|--------|
| الرئيسية | `/` |
| المشاريع | `/projects` |
| مشروع محدد | `/projects/{slug}` |
| من نحن | `/about` |
| اتصل بنا | `/contact` |
| لوحة التحكم | `/admin` |

## المميزات

- ✅ متعدد اللغات (عربي، إنجليزي، كردي)
- ✅ دعم RTL كامل
- ✅ استهداف جغرافي (محتوى خاص للعراق)
- ✅ زر واتساب عائم في كل الصفحات
- ✅ لوحة تحكم كاملة
- ✅ إدارة المشاريع مع معرض الصور
- ✅ إدارة الرسائل والاستفسارات
- ✅ إعدادات قابلة للتخصيص
- ✅ تصميم متجاوب (Responsive)
- ✅ ثيم ذهبي وأسود فاخر
- ✅ تحسين SEO

## الاستهداف الجغرافي للعراق

الزوار من العراق يرون:
- أسعار بالدينار العراقي
- رقم هاتف العراق
- عنوان مكتب العراق
- رقم واتساب العراق

## هيكل المشروع

```
grand-start/
├── app/
│   ├── Http/Controllers/
│   │   ├── Frontend/     # كونترولرز الموقع
│   │   └── Admin/        # كونترولرز لوحة التحكم
│   ├── Models/           # نماذج البيانات
│   └── Http/Middleware/  # Middleware
├── database/
│   ├── migrations/       # هجرات قاعدة البيانات
│   └── seeders/          # بيانات أولية
├── public/
│   ├── css/app.css       # ملف CSS الرئيسي
│   ├── js/app.js         # ملف JS الرئيسي
│   └── images/           # الصور
├── resources/
│   ├── views/            # قوالب Blade
│   └── lang/             # ملفات الترجمة
└── routes/web.php        # المسارات
```
