<?php $__env->startSection('title', 'تعديل مشروع'); ?>
<?php $__env->startSection('page-title', 'تعديل: ' . $project->getTitle()); ?>

<?php $__env->startPush('styles'); ?>
<style>
.nav-tabs .nav-link { color: #666; }
.nav-tabs .nav-link.active { color: var(--gold); border-bottom-color: var(--gold); font-weight: 600; }
.upload-area { border: 2px dashed #dee2e6; border-radius: 8px; cursor: pointer; overflow: hidden; }
.upload-area:hover { border-color: var(--gold); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex gap-2 mb-4">
    <a href="<?php echo e(route('admin.projects.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> رجوع
    </a>
    <a href="<?php echo e(route('projects.show', $project->slug)); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-eye me-1"></i> عرض على الموقع
    </a>
</div>

<form action="<?php echo e(route('admin.projects.update', $project)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

    <div class="row g-4">
        <!-- Language Tabs -->
        <div class="col-12">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-language"></i> محتوى المشروع (حسب اللغة)</div>

                <ul class="nav nav-tabs mb-3">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <button class="nav-link <?php echo e($i === 0 ? 'active' : ''); ?>" type="button"
                            data-bs-toggle="tab" data-bs-target="#tab-<?php echo e($lang->code); ?>">
                            <?php echo e($lang->name_native); ?>

                            <?php if($lang->is_default): ?>
                            <span class="badge ms-1" style="background:var(--gold);color:#000;font-size:0.65em;">افتراضي</span>
                            <?php endif; ?>
                        </button>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <div class="tab-content">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $t = $project->translations->firstWhere('locale', $lang->code); ?>
                    <div class="tab-pane fade <?php echo e($i === 0 ? 'show active' : ''); ?>" id="tab-<?php echo e($lang->code); ?>"
                        <?php if($lang->direction === 'rtl'): ?> dir="rtl" <?php endif; ?>>
                        <div class="mb-3">
                            <label class="form-label">اسم المشروع بـ <?php echo e($lang->name_native); ?>

                                <?php if($lang->is_default): ?><span class="text-danger">*</span><?php endif; ?>
                            </label>
                            <input type="text" name="translations[<?php echo e($lang->code); ?>][title]"
                                class="form-control" <?php echo e($lang->is_default ? 'required' : ''); ?>

                                value="<?php echo e(old("translations.{$lang->code}.title", $t?->title)); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الموقع بـ <?php echo e($lang->name_native); ?></label>
                            <input type="text" name="translations[<?php echo e($lang->code); ?>][location]" class="form-control"
                                value="<?php echo e(old("translations.{$lang->code}.location", $t?->location)); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف بـ <?php echo e($lang->name_native); ?></label>
                            <textarea name="translations[<?php echo e($lang->code); ?>][description]" class="form-control" rows="5"><?php echo e(old("translations.{$lang->code}.description", $t?->description)); ?></textarea>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-dollar-sign"></i> الأسعار</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">USD ($)</label>
                        <input type="number" name="price_usd" class="form-control" step="0.01" min="0"
                            value="<?php echo e(old('price_usd', $project->price_usd)); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">TRY (₺)</label>
                        <input type="number" name="price_try" class="form-control" min="0"
                            value="<?php echo e(old('price_try', $project->price_try)); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">IQD (د.ع)</label>
                        <input type="number" name="price_iqd" class="form-control" min="0"
                            value="<?php echo e(old('price_iqd', $project->price_iqd)); ?>">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-info-circle"></i> تفاصيل المشروع</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">المساحة</label>
                        <input type="text" name="area" class="form-control" value="<?php echo e(old('area', $project->area)); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الطوابق</label>
                        <input type="number" name="floors" class="form-control" value="<?php echo e(old('floors', $project->floors)); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الوحدات</label>
                        <input type="number" name="units" class="form-control" value="<?php echo e(old('units', $project->units)); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تاريخ التسليم</label>
                        <input type="date" name="delivery_date" class="form-control"
                            value="<?php echo e(old('delivery_date', $project->delivery_date?->format('Y-m-d'))); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رابط الفيديو</label>
                        <input type="url" name="video_url" class="form-control" value="<?php echo e(old('video_url', $project->video_url)); ?>">
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-map-marker-alt"></i> الموقع الجغرافي</div>
                <?php
                $locData   = config('locations');
                $selCountry = old('country', $project->country) ?: '';
                $selCity    = old('city',    $project->city)    ?: '';
                $selDistrict= old('district',$project->district)?: '';
                ?>
                <div class="row g-3">
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الدولة</label>
                        <select name="country" id="locCountry" class="form-select">
                            <option value="">-- اختر الدولة --</option>
                            <?php $__currentLoopData = $locData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($code); ?>" <?php echo e($selCountry === $code ? 'selected' : ''); ?>>
                                <?php echo e($c['name']['ar']); ?> / <?php echo e($c['name']['en']); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الولاية / المحافظة</label>
                        <select name="city" id="locProvince" class="form-select">
                            <option value="">-- اختر الولاية --</option>
                            <?php $__currentLoopData = $locData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $c['provinces']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pKey => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pKey); ?>"
                                data-country="<?php echo e($code); ?>"
                                <?php echo e($selCity === $pKey ? 'selected' : ''); ?>>
                                <?php echo e($p['name']['ar']); ?> / <?php echo e($p['name']['en']); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">المنطقة / القضاء</label>
                        <select name="district" id="locDistrict" class="form-select">
                            <option value="">-- اختر المنطقة --</option>
                            <?php $__currentLoopData = $locData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $c['provinces']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pKey => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $p['districts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dKey => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dKey); ?>"
                                data-province="<?php echo e($pKey); ?>"
                                <?php echo e($selDistrict === $dKey ? 'selected' : ''); ?>>
                                <?php echo e($d['ar']); ?> / <?php echo e($d['en']); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            باقي العنوان <span class="text-muted fw-normal">(اختياري — رقم الشارع، اسم المبنى...)</span>
                        </label>
                        <div class="row g-2">
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $t = $project->translations->firstWhere('locale', $lang->code); ?>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" style="min-width:42px;"><?php echo e(strtoupper($lang->code)); ?></span>
                                    <input type="text"
                                           name="translations[<?php echo e($lang->code); ?>][address_detail]"
                                           class="form-control"
                                           dir="<?php echo e($lang->direction); ?>"
                                           placeholder="<?php echo e($lang->name_native); ?>"
                                           value="<?php echo e(old("translations.{$lang->code}.address_detail", $t?->address_detail)); ?>">
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <p class="text-muted small mt-2 mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    سيتم استخدام هذه البيانات لعرض موقع المشروع في الفلاتر وصفحة المشروع.
                </p>
            </div>

            <!-- Features -->
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-list-check"></i> مميزات المشروع</div>
                <div class="row g-2 mb-2">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col"><small class="text-muted fw-bold"><?php echo e($lang->name_native); ?></small></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-auto"><small class="text-muted fw-bold">أيقونة</small></div>
                    <div class="col-auto" style="width:40px;"></div>
                </div>
                <div id="featuresContainer">
                    <?php $__currentLoopData = $project->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="feature-row row g-2 mb-2 align-items-center" id="fr<?php echo e($i); ?>">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $ft = $feature->translations->firstWhere('locale', $lang->code); ?>
                        <div class="col">
                            <input type="text" name="features[<?php echo e($i); ?>][<?php echo e($lang->code); ?>]"
                                class="form-control form-control-sm"
                                dir="<?php echo e($lang->direction); ?>"
                                value="<?php echo e($ft?->text); ?>"
                                placeholder="<?php echo e($lang->name_native); ?>">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-auto">
                            <input type="text" name="features[<?php echo e($i); ?>][icon]"
                                class="form-control form-control-sm"
                                value="<?php echo e($feature->icon); ?>" style="width:130px;">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.feature-row').remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addFeatureBtn">
                    <i class="fas fa-plus me-1"></i> إضافة ميزة
                </button>
            </div>

            
            <div class="form-card" id="galleryCard">
                <div class="form-card-title">
                    <i class="fas fa-images"></i> معرض الصور
                    <span class="badge ms-2" style="background:var(--gold)20;color:var(--gold);font-size:0.75rem;" id="imgCount">
                        <?php echo e($project->images->count() + $project->mediaImages->count()); ?> صورة
                    </span>
                </div>

                
                <div class="media-grid" id="imageGrid">
                    <?php $__currentLoopData = $project->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="media-thumb-card" id="image-<?php echo e($image->id); ?>" data-type="pimg">
                        <img src="<?php echo e($image->getThumbUrl()); ?>" alt="" loading="lazy">
                        <button type="button" class="media-delete-btn" onclick="deleteImage(<?php echo e($image->id); ?>)" title="حذف">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $project->mediaImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="media-thumb-card" id="media-img-<?php echo e($img->id); ?>" data-type="pmedia">
                        <img src="<?php echo e($img->getThumbUrl()); ?>" alt="" loading="lazy">
                        <button type="button" class="media-delete-btn" onclick="deleteMedia(<?php echo e($img->id); ?>)" title="حذف">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="media-upload-zone" id="imageUploadZone" onclick="document.getElementById('imageInput').click()">
                    <div class="muz-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div class="muz-text">اسحب الصور هنا أو <span class="muz-link">انقر للاختيار</span></div>
                    <div class="muz-hint">JPEG, PNG, WebP — حتى 10MB للصورة — يتم الرفع تلقائياً</div>
                    <input type="file" id="imageInput" accept="image/*" multiple class="d-none">
                </div>

                
                <div id="image-progress-list" class="mt-2"></div>
            </div>

            
            <div class="form-card">
                <div class="form-card-title">
                    <i class="fas fa-file-pdf text-danger"></i> ملفات PDF
                    <span class="text-muted small fw-normal ms-2">(كتيبات، مخططات)</span>
                </div>

                <div id="pdf-list">
                    <?php $__currentLoopData = $project->media()->where('type','pdf')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="media-file-row" id="media-<?php echo e($pdf->id); ?>">
                        <div class="mfr-icon text-danger"><i class="fas fa-file-pdf fa-lg"></i></div>
                        <div class="mfr-info">
                            <span class="mfr-name"><?php echo e($pdf->original_name ?: basename($pdf->path)); ?></span>
                            <span class="mfr-size"><?php echo e($pdf->getFileSizeFormatted()); ?></span>
                        </div>
                        <a href="<?php echo e($pdf->getUrl()); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" onclick="deleteMedia(<?php echo e($pdf->id); ?>)" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="media-upload-zone muz-pdf" id="pdfUploadZone" onclick="document.getElementById('pdfInput').click()">
                    <div class="muz-icon text-danger"><i class="fas fa-file-pdf"></i></div>
                    <div class="muz-text">اسحب ملفات PDF هنا أو <span class="muz-link">انقر للاختيار</span></div>
                    <div class="muz-hint">PDF فقط — الحد الأقصى 20MB</div>
                    <input type="file" id="pdfInput" accept=".pdf" multiple class="d-none">
                </div>
                <div id="pdf-progress-list" class="mt-2"></div>
            </div>

            
            <div class="form-card">
                <div class="form-card-title">
                    <i class="fas fa-video" style="color:#6366f1;"></i> ملفات الفيديو
                </div>

                <div id="video-list">
                    <?php $__currentLoopData = $project->media()->where('type','video')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="media-file-row" id="media-<?php echo e($vid->id); ?>">
                        <div class="mfr-icon" style="color:#6366f1;"><i class="fas fa-video fa-lg"></i></div>
                        <div class="mfr-info">
                            <span class="mfr-name"><?php echo e($vid->original_name ?: basename($vid->path)); ?></span>
                            <span class="mfr-size"><?php echo e($vid->getFileSizeFormatted()); ?></span>
                        </div>
                        <a href="<?php echo e($vid->getUrl()); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-play"></i>
                        </a>
                        <button type="button" onclick="deleteMedia(<?php echo e($vid->id); ?>)" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($project->video_url): ?>
                <div class="alert alert-info py-2 mb-3 small">
                    <i class="fas fa-link me-1"></i> رابط YouTube/Vimeo محفوظ أيضاً
                </div>
                <?php endif; ?>

                <div class="media-upload-zone muz-video" id="videoUploadZone" onclick="document.getElementById('videoInput').click()">
                    <div class="muz-icon" style="color:#6366f1;"><i class="fas fa-film"></i></div>
                    <div class="muz-text">اسحب ملف الفيديو هنا أو <span class="muz-link">انقر للاختيار</span></div>
                    <div class="muz-hint">MP4, MOV, AVI, WebM — الحد الأقصى 200MB</div>
                    <input type="file" id="videoInput" accept=".mp4,.mov,.avi,.webm,video/*" class="d-none">
                </div>
                <div id="video-progress-list" class="mt-2"></div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-tag"></i> التصنيف</div>
                <div class="mb-3">
                    <label class="form-label">النوع <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <?php $__currentLoopData = ['residential' => 'سكني', 'commercial' => 'تجاري', 'villa' => 'فيلا', 'apartment' => 'شقة', 'compound' => 'مجمع', 'tower' => 'برج']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val); ?>" <?php echo e(old('type', $project->type) === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">الحالة <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <?php $__currentLoopData = ['available' => 'متاح', 'under_construction' => 'قيد الإنشاء', 'coming_soon' => 'قريباً', 'sold_out' => 'مباع']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val); ?>" <?php echo e(old('status', $project->status) === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">ترتيب العرض</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo e(old('sort_order', $project->sort_order)); ?>">
                </div>
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" class="form-check-input" name="active" value="1" <?php echo e(old('active', $project->active) ? 'checked' : ''); ?>>
                    <label class="form-check-label">نشط</label>
                </div>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" name="featured" value="1" <?php echo e(old('featured', $project->featured) ? 'checked' : ''); ?>>
                    <label class="form-check-label">مميز</label>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title"><i class="fas fa-image"></i> الصورة الرئيسية</div>
                <?php if($project->main_image): ?>
                <img src="<?php echo e(asset('uploads/' . $project->main_image)); ?>" alt="" class="img-fluid rounded mb-2">
                <?php endif; ?>
                <div class="upload-area" id="uploadArea">
                    <div class="upload-placeholder text-center py-2">
                        <i class="fas fa-cloud-upload-alt text-muted mb-1 d-block"></i>
                        <small class="text-muted">تغيير الصورة</small>
                    </div>
                    <img id="imgPreview" src="" style="display:none; max-width:100%; border-radius:8px;">
                    <input type="file" name="main_image" id="mainImageInput" class="d-none" accept="image/*">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-gold btn-lg">
                    <i class="fas fa-save me-2"></i> حفظ التغييرات
                </button>
                <a href="<?php echo e(route('admin.projects.index')); ?>" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const uploadArea = document.getElementById('uploadArea');
const mainImageInput = document.getElementById('mainImageInput');
const imgPreview = document.getElementById('imgPreview');
uploadArea.addEventListener('click', () => mainImageInput.click());
mainImageInput.addEventListener('change', function() {
    if (this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            imgPreview.src = e.target.result;
            imgPreview.style.display = 'block';
            uploadArea.querySelector('.upload-placeholder').style.display = 'none';
        };
        reader.readAsDataURL(this.files[0]);
    }
});

function deleteImage(id) {
    if (!confirm('حذف هذه الصورة؟')) return;
    fetch(`/admin/projects/<?php echo e($project->id); ?>/images/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    }).then(r => r.json()).then(data => {
        if (data.success) { document.getElementById(`image-${id}`)?.remove(); updateImgCount(); }
    });
}

function updateImgCount() {
    const n = document.querySelectorAll('#imageGrid .media-thumb-card').length;
    const el = document.getElementById('imgCount');
    if (el) el.textContent = n + ' صورة';
}

const languages = <?php echo json_encode($languages->map(fn($l) => ['code' => $l->code, 'name' => $l->name_native, 'direction' => $l->direction])) ?>;
let featureCount = <?php echo e($project->features->count()); ?>;

function buildFeatureRow(index) {
    let cols = languages.map(lang =>
        `<div class="col">
            <input type="text" name="features[${index}][${lang.code}]"
                class="form-control form-control-sm"
                placeholder="${lang.name}" dir="${lang.direction}">
        </div>`
    ).join('');
    return `<div class="feature-row row g-2 mb-2 align-items-center" id="fr${index}">
        ${cols}
        <div class="col-auto">
            <input type="text" name="features[${index}][icon]" class="form-control form-control-sm"
                value="fas fa-check" style="width:130px;">
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('fr${index}').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>`;
}

document.getElementById('addFeatureBtn').addEventListener('click', function() {
    document.getElementById('featuresContainer').insertAdjacentHTML('beforeend', buildFeatureRow(featureCount++));
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ── Media Grid ── */
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 8px;
    margin-bottom: 1rem;
}
.media-thumb-card {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 4/3;
    background: #f0f0f0;
    box-shadow: 0 1px 4px rgba(0,0,0,.08);
    transition: transform .15s;
}
.media-thumb-card:hover { transform: scale(1.03); }
.media-thumb-card img { width:100%; height:100%; object-fit:cover; display:block; }
.media-delete-btn {
    position: absolute;
    top: 3px; right: 3px;
    width: 22px; height: 22px;
    background: rgba(220,38,38,.85);
    color: #fff;
    border: none;
    border-radius: 50%;
    font-size: 10px;
    cursor: pointer;
    display: flex; align-items:center; justify-content:center;
    opacity: 0;
    transition: opacity .15s;
}
.media-thumb-card:hover .media-delete-btn { opacity: 1; }

/* ── Upload Zone ── */
.media-upload-zone {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 1.5rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    user-select: none;
}
.media-upload-zone:hover, .media-upload-zone.muz-drag {
    border-color: var(--gold);
    background: #fdf8ef;
}
.muz-pdf:hover, .muz-pdf.muz-drag  { border-color: #dc3545; background: #fff5f5; }
.muz-video:hover, .muz-video.muz-drag { border-color: #6366f1; background: #f5f3ff; }
.muz-icon { font-size: 2rem; color: var(--gold); margin-bottom: .4rem; }
.muz-text { font-size: .9rem; color: #555; }
.muz-link { color: var(--gold); font-weight: 600; text-decoration: underline; }
.muz-hint { font-size: .75rem; color: #aaa; margin-top: .25rem; }

/* ── Media File Row (PDF/Video list) ── */
.media-file-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    margin-bottom: 6px;
    background: #fafafa;
    transition: background .15s;
}
.media-file-row:hover { background: #f5f5f5; }
.mfr-icon { font-size: 1.3rem; flex-shrink: 0; }
.mfr-info { flex: 1; min-width: 0; }
.mfr-name { display: block; font-weight: 600; font-size: .85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.mfr-size { font-size: .72rem; color: #888; }

/* ── Per-file Progress Row ── */
.upload-progress-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 10px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 4px;
    font-size: .8rem;
}
.upr-name { flex: 1; min-width:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#555; }
.upr-bar-wrap { width: 100px; height: 6px; background: #e5e7eb; border-radius: 3px; flex-shrink:0; overflow:hidden; }
.upr-bar { height:100%; background: var(--gold); border-radius:3px; transition: width .2s; }
.upr-pct { width: 34px; text-align:right; color:#666; flex-shrink:0; }
.upr-status { flex-shrink:0; font-size:1rem; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Three-level location: country → province → district
(function() {
    var cSel = document.getElementById('locCountry');
    var pSel = document.getElementById('locProvince');
    var dSel = document.getElementById('locDistrict');
    if (!cSel || !pSel || !dSel) return;

    var allProvinces = Array.from(pSel.querySelectorAll('option[data-country]'));
    var allDistricts = Array.from(dSel.querySelectorAll('option[data-province]'));

    function filterProvinces(keepVal) {
        var country = cSel.value;
        var cur = keepVal !== undefined ? keepVal : pSel.value;
        pSel.innerHTML = '<option value="">-- اختر الولاية --</option>';
        allProvinces.forEach(function(opt) {
            if (!country || opt.dataset.country === country) {
                var c = opt.cloneNode(true);
                if (c.value === cur) c.selected = true;
                pSel.appendChild(c);
            }
        });
        filterDistricts(dSel.value);
    }

    function filterDistricts(keepVal) {
        var province = pSel.value;
        var cur = keepVal !== undefined ? keepVal : dSel.value;
        dSel.innerHTML = '<option value="">-- اختر المنطقة --</option>';
        allDistricts.forEach(function(opt) {
            if (!province || opt.dataset.province === province) {
                var c = opt.cloneNode(true);
                if (c.value === cur) c.selected = true;
                dSel.appendChild(c);
            }
        });
    }

    cSel.addEventListener('change', function() { filterProvinces(''); });
    pSel.addEventListener('change', function() { filterDistricts(''); });
    // init on page load
    filterProvinces(pSel.value);
    filterDistricts(dSel.value);
})();

// ── Shared upload engine ────────────────────────────────────────────────────
const PID = '<?php echo e($project->id); ?>';

/**
 * Upload files one-by-one with XHR progress.
 * @param {FileList} files
 * @param {string}   url         POST endpoint
 * @param {string}   fieldName   FormData key  e.g. 'images[]'
 * @param {string}   progressListId  container for per-file rows
 * @param {Function} onItem      callback(item) after each file done — receives server item
 */
function uploadQueue(files, url, fieldName, progressListId, onItem) {
    const list = document.getElementById(progressListId);
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    Array.from(files).forEach(function(file) {
        // Create a progress row
        const rowId = 'pr-' + Math.random().toString(36).slice(2);
        const row = document.createElement('div');
        row.id = rowId;
        row.className = 'upload-progress-row';
        row.innerHTML = `
            <div class="upr-name">${file.name}</div>
            <div class="upr-bar-wrap"><div class="upr-bar" id="${rowId}-bar" style="width:0%"></div></div>
            <div class="upr-pct" id="${rowId}-pct">0%</div>
            <div class="upr-status" id="${rowId}-st"><i class="fas fa-spinner fa-spin text-muted"></i></div>`;
        list.appendChild(row);

        const fd = new FormData();
        fd.append(fieldName, file);
        fd.append('_token', csrf);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.upload.onprogress = function(e) {
            if (!e.lengthComputable) return;
            const pct = Math.round(e.loaded / e.total * 100);
            document.getElementById(rowId + '-bar').style.width = pct + '%';
            document.getElementById(rowId + '-pct').textContent = pct + '%';
        };

        xhr.onload = function() {
            let data = {};
            try { data = JSON.parse(xhr.responseText); } catch(e) {}

            if (data.success) {
                document.getElementById(rowId + '-bar').style.width = '100%';
                document.getElementById(rowId + '-pct').textContent = '100%';
                document.getElementById(rowId + '-st').innerHTML = '<i class="fas fa-check-circle text-success"></i>';
                // Remove progress row after 2s
                setTimeout(function() { row.remove(); }, 2000);
                // Add item to DOM
                if (data.items && data.items.length && onItem) {
                    data.items.forEach(onItem);
                }
            } else {
                document.getElementById(rowId + '-st').innerHTML = '<i class="fas fa-exclamation-circle text-danger"></i>';
                document.getElementById(rowId + '-pct').textContent = '';
                row.querySelector('.upr-bar-wrap').style.background = '#fee2e2';
            }
        };

        xhr.onerror = function() {
            document.getElementById(rowId + '-st').innerHTML = '<i class="fas fa-times-circle text-danger"></i>';
        };

        xhr.send(fd);
    });
}

// ── IMAGE UPLOAD ─────────────────────────────────────────────────────────────
(function() {
    const zone  = document.getElementById('imageUploadZone');
    const input = document.getElementById('imageInput');

    zone.addEventListener('dragover',  function(e) { e.preventDefault(); zone.classList.add('muz-drag'); });
    zone.addEventListener('dragleave', function()   { zone.classList.remove('muz-drag'); });
    zone.addEventListener('drop', function(e) {
        e.preventDefault(); zone.classList.remove('muz-drag');
        handleImages(e.dataTransfer.files);
    });
    input.addEventListener('change', function() { handleImages(this.files); this.value=''; });

    function handleImages(files) {
        uploadQueue(files, `/admin/projects/${PID}/images`, 'images[]', 'image-progress-list', function(item) {
            addImageThumb(item.id, item.thumb, item.url);
        });
    }

    function addImageThumb(id, thumb, url) {
        const grid = document.getElementById('imageGrid');
        const div  = document.createElement('div');
        div.className = 'media-thumb-card';
        div.id = 'media-img-' + id;
        div.dataset.type = 'pmedia';
        div.innerHTML = `
            <img src="${thumb}" alt="" loading="lazy">
            <button type="button" class="media-delete-btn" onclick="deleteMedia(${id})" title="حذف">
                <i class="fas fa-times"></i>
            </button>`;
        grid.appendChild(div);
        updateImgCount();
    }
})();

// ── PDF UPLOAD ────────────────────────────────────────────────────────────────
(function() {
    const zone  = document.getElementById('pdfUploadZone');
    const input = document.getElementById('pdfInput');

    zone.addEventListener('dragover',  function(e) { e.preventDefault(); zone.classList.add('muz-drag'); });
    zone.addEventListener('dragleave', function()   { zone.classList.remove('muz-drag'); });
    zone.addEventListener('drop', function(e) {
        e.preventDefault(); zone.classList.remove('muz-drag');
        handlePdfs(e.dataTransfer.files);
    });
    input.addEventListener('change', function() { handlePdfs(this.files); this.value=''; });

    function handlePdfs(files) {
        uploadQueue(files, `/admin/projects/${PID}/pdfs`, 'pdfs[]', 'pdf-progress-list', function(item) {
            addPdfRow(item);
        });
    }

    function addPdfRow(item) {
        const list = document.getElementById('pdf-list');
        const div  = document.createElement('div');
        div.className = 'media-file-row';
        div.id = 'media-' + item.id;
        div.innerHTML = `
            <div class="mfr-icon text-danger"><i class="fas fa-file-pdf fa-lg"></i></div>
            <div class="mfr-info">
                <span class="mfr-name">${item.name}</span>
                <span class="mfr-size">${item.size}</span>
            </div>
            <a href="${item.url}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></a>
            <button type="button" onclick="deleteMedia(${item.id})" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>`;
        list.appendChild(div);
    }
})();

// ── VIDEO UPLOAD ──────────────────────────────────────────────────────────────
(function() {
    const zone  = document.getElementById('videoUploadZone');
    const input = document.getElementById('videoInput');

    zone.addEventListener('dragover',  function(e) { e.preventDefault(); zone.classList.add('muz-drag'); });
    zone.addEventListener('dragleave', function()   { zone.classList.remove('muz-drag'); });
    zone.addEventListener('drop', function(e) {
        e.preventDefault(); zone.classList.remove('muz-drag');
        handleVideos(e.dataTransfer.files);
    });
    input.addEventListener('change', function() { handleVideos(this.files); this.value=''; });

    function handleVideos(files) {
        uploadQueue(files, `/admin/projects/${PID}/videos`, 'videos[]', 'video-progress-list', function(item) {
            addVideoRow(item);
        });
    }

    function addVideoRow(item) {
        const list = document.getElementById('video-list');
        const div  = document.createElement('div');
        div.className = 'media-file-row';
        div.id = 'media-' + item.id;
        div.innerHTML = `
            <div class="mfr-icon" style="color:#6366f1;"><i class="fas fa-video fa-lg"></i></div>
            <div class="mfr-info">
                <span class="mfr-name">${item.name}</span>
                <span class="mfr-size">${item.size}</span>
            </div>
            <a href="${item.url}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fas fa-play"></i></a>
            <button type="button" onclick="deleteMedia(${item.id})" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>`;
        list.appendChild(div);
    }
})();

// ── DELETE MEDIA / IMAGE ──────────────────────────────────────────────────────
function deleteMedia(id) {
    if (!confirm('حذف هذا الملف نهائياً؟')) return;
    fetch(`/admin/projects/${PID}/media/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
    }).then(r => r.json()).then(function(data) {
        if (data.success) {
            document.getElementById('media-' + id)?.remove();
            document.getElementById('media-img-' + id)?.remove();
            updateImgCount();
        }
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mohammadkfelati/Library/CloudStorage/OneDrive-Personal/Clients/GrandStar/Website/grandstart-realestate/resources/views/admin/projects/edit.blade.php ENDPATH**/ ?>