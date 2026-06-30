<?php $__env->startSection('title', 'الإعدادات'); ?>
<?php $__env->startSection('page-title', 'الإعدادات العامة'); ?>

<?php $__env->startSection('content'); ?>

<form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="row g-4">
        <div class="col-lg-8">

            <!-- Company Info -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-building"></i> معلومات الشركة</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">اسم الشركة (عربي)</label>
                        <input type="text" name="company_name_ar" class="form-control" value="<?php echo e($settings['company_name_ar'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Company Name (English)</label>
                        <input type="text" name="company_name_en" class="form-control" value="<?php echo e($settings['company_name_en'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Şirket Adı (Türkçe)</label>
                        <input type="text" name="company_name_tr" class="form-control" value="<?php echo e($settings['company_name_tr'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">شعار الشركة (عربي)</label>
                        <input type="text" name="company_tagline_ar" class="form-control" value="<?php echo e($settings['company_tagline_ar'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tagline (English)</label>
                        <input type="text" name="company_tagline_en" class="form-control" value="<?php echo e($settings['company_tagline_en'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Slogan (Türkçe)</label>
                        <input type="text" name="company_tagline_tr" class="form-control" value="<?php echo e($settings['company_tagline_tr'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">سنوات الخبرة</label>
                        <input type="number" name="company_years" class="form-control" value="<?php echo e($settings['company_years'] ?? '15'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">عدد العملاء</label>
                        <input type="number" name="total_clients" class="form-control" value="<?php echo e($settings['total_clients'] ?? '1200'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">عدد الدول</label>
                        <input type="number" name="countries_count" class="form-control" value="<?php echo e($settings['countries_count'] ?? '8'); ?>">
                    </div>
                </div>
            </div>

            <!-- Contact - Default (Turkey Main Office) -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-phone"></i> معلومات التواصل الرئيسية 🇹🇷 (مكتب تركيا)</div>
                <p class="text-muted small mb-3">تظهر هذه المعلومات لجميع الزوار الذين لا تتوفر لبلدهم معلومات خاصة</p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone_default" class="form-control" value="<?php echo e($settings['phone_default'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">واتساب</label>
                        <input type="text" name="whatsapp_default" class="form-control" value="<?php echo e($settings['whatsapp_default'] ?? ''); ?>" placeholder="+902121234567">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email_default" class="form-control" value="<?php echo e($settings['email_default'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">العنوان (عربي)</label>
                        <input type="text" name="address_default_ar" class="form-control" value="<?php echo e($settings['address_default_ar'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Address (English)</label>
                        <input type="text" name="address_default_en" class="form-control" value="<?php echo e($settings['address_default_en'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Adres (Türkçe)</label>
                        <input type="text" name="address_default_tr" class="form-control" value="<?php echo e($settings['address_default_tr'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <!-- Contact - Iraq -->
            <div class="form-card border-warning">
                <div class="form-card-title" style="color:#d97706;"><i class="fas fa-map-marker-alt"></i> معلومات التواصل - العراق 🇮🇶</div>
                <p class="text-muted small mb-3">ستظهر هذه المعلومات للزوار من العراق تلقائياً</p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">رقم الهاتف (العراق)</label>
                        <input type="text" name="phone_iraq" class="form-control" value="<?php echo e($settings['phone_iraq'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">واتساب (العراق)</label>
                        <input type="text" name="whatsapp_iraq" class="form-control" value="<?php echo e($settings['whatsapp_iraq'] ?? ''); ?>" placeholder="+9647501234567">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">البريد (العراق)</label>
                        <input type="email" name="email_iraq" class="form-control" value="<?php echo e($settings['email_iraq'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">العنوان في العراق (عربي)</label>
                        <input type="text" name="address_iraq_ar" class="form-control" value="<?php echo e($settings['address_iraq_ar'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Iraq Address (English)</label>
                        <input type="text" name="address_iraq_en" class="form-control" value="<?php echo e($settings['address_iraq_en'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Irak Adresi (Türkçe)</label>
                        <input type="text" name="address_iraq_tr" class="form-control" value="<?php echo e($settings['address_iraq_tr'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <!-- About Text -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-file-text"></i> نص صفحة من نحن</div>
                <div class="mb-3">
                    <label class="form-label">النص (عربي)</label>
                    <textarea name="about_text_ar" class="form-control" rows="4"><?php echo e($settings['about_text_ar'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Text (English)</label>
                    <textarea name="about_text_en" class="form-control" rows="4"><?php echo e($settings['about_text_en'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Metin (Türkçe)</label>
                    <textarea name="about_text_tr" class="form-control" rows="4"><?php echo e($settings['about_text_tr'] ?? ''); ?></textarea>
                </div>
            </div>

            <!-- Hero Section -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-star"></i> قسم الهيرو (الرئيسية)</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">العنوان الرئيسي (عربي)</label>
                        <input type="text" name="hero_title_ar" class="form-control" value="<?php echo e($settings['hero_title_ar'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Hero Title (English)</label>
                        <input type="text" name="hero_title_en" class="form-control" value="<?php echo e($settings['hero_title_en'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ana Başlık (Türkçe)</label>
                        <input type="text" name="hero_title_tr" class="form-control" value="<?php echo e($settings['hero_title_tr'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">العنوان الفرعي (عربي)</label>
                        <textarea name="hero_subtitle_ar" class="form-control" rows="2"><?php echo e($settings['hero_subtitle_ar'] ?? ''); ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Hero Subtitle (English)</label>
                        <textarea name="hero_subtitle_en" class="form-control" rows="2"><?php echo e($settings['hero_subtitle_en'] ?? ''); ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alt Başlık (Türkçe)</label>
                        <textarea name="hero_subtitle_tr" class="form-control" rows="2"><?php echo e($settings['hero_subtitle_tr'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <!-- Social Media -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-share-alt"></i> وسائل التواصل الاجتماعي</div>
                <div class="mb-3">
                    <label class="form-label"><i class="fab fa-facebook text-primary me-1"></i>Facebook</label>
                    <input type="url" name="facebook_url" class="form-control form-control-sm" value="<?php echo e($settings['facebook_url'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fab fa-instagram text-danger me-1"></i>Instagram</label>
                    <input type="url" name="instagram_url" class="form-control form-control-sm" value="<?php echo e($settings['instagram_url'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fab fa-twitter text-info me-1"></i>Twitter / X</label>
                    <input type="url" name="twitter_url" class="form-control form-control-sm" value="<?php echo e($settings['twitter_url'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fab fa-youtube text-danger me-1"></i>YouTube</label>
                    <input type="url" name="youtube_url" class="form-control form-control-sm" value="<?php echo e($settings['youtube_url'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fab fa-linkedin text-primary me-1"></i>LinkedIn</label>
                    <input type="url" name="linkedin_url" class="form-control form-control-sm" value="<?php echo e($settings['linkedin_url'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fab fa-tiktok me-1"></i>TikTok</label>
                    <input type="url" name="tiktok_url" class="form-control form-control-sm" value="<?php echo e($settings['tiktok_url'] ?? ''); ?>">
                </div>
            </div>

            <!-- SEO -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-search"></i> SEO</div>
                <div class="mb-3">
                    <label class="form-label">عنوان الصفحة (عربي)</label>
                    <input type="text" name="meta_title_ar" class="form-control form-control-sm" value="<?php echo e($settings['meta_title_ar'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Page Title (English)</label>
                    <input type="text" name="meta_title_en" class="form-control form-control-sm" value="<?php echo e($settings['meta_title_en'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Sayfa Başlığı (Türkçe)</label>
                    <input type="text" name="meta_title_tr" class="form-control form-control-sm" value="<?php echo e($settings['meta_title_tr'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">وصف الصفحة (عربي)</label>
                    <textarea name="meta_description_ar" class="form-control form-control-sm" rows="2"><?php echo e($settings['meta_description_ar'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Page Description (English)</label>
                    <textarea name="meta_description_en" class="form-control form-control-sm" rows="2"><?php echo e($settings['meta_description_en'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sayfa Açıklaması (Türkçe)</label>
                    <textarea name="meta_description_tr" class="form-control form-control-sm" rows="2"><?php echo e($settings['meta_description_tr'] ?? ''); ?></textarea>
                </div>
            </div>

            <!-- Save -->
            <div class="d-grid">
                <button type="submit" class="btn btn-gold btn-lg">
                    <i class="fas fa-save me-2"></i>حفظ الإعدادات
                </button>
            </div>
        </div>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>