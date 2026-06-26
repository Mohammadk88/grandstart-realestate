<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\LocaleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminLanguageController;
use App\Http\Controllers\Admin\AdminCountryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\PageBuilderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['geo.target', 'set.locale'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});

Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth (no middleware)
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {

        // Dashboard — all roles
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // ── Projects ────────────────────────────────────────────────────────
        Route::middleware('admin.permission:projects.view')->group(function () {
            Route::get('projects',         [AdminProjectController::class, 'index'])->name('projects.index');
            Route::get('projects/{project}',[AdminProjectController::class, 'show'])->name('projects.show');
        });
        Route::middleware('admin.permission:projects.create')->group(function () {
            Route::get('projects/create',          [AdminProjectController::class, 'create'])->name('projects.create');
            Route::post('projects',                [AdminProjectController::class, 'store'])->name('projects.store');
            Route::post('projects/{project}/images',[AdminProjectController::class, 'uploadImages'])->name('projects.images.upload');
            Route::post('projects/{project}/pdfs',  [AdminProjectController::class, 'uploadPdfs'])->name('projects.pdfs.upload');
            Route::post('projects/{project}/videos',[AdminProjectController::class, 'uploadVideos'])->name('projects.videos.upload');
        });
        Route::middleware('admin.permission:projects.edit')->group(function () {
            Route::get('projects/{project}/edit',   [AdminProjectController::class, 'edit'])->name('projects.edit');
            Route::put('projects/{project}',        [AdminProjectController::class, 'update'])->name('projects.update');
            Route::patch('projects/{project}',      [AdminProjectController::class, 'update']);
            Route::post('projects/{project}/toggle-featured',[AdminProjectController::class, 'toggleFeatured'])->name('projects.toggle-featured');
        });
        Route::middleware('admin.permission:projects.delete')->group(function () {
            Route::delete('projects/{project}',             [AdminProjectController::class, 'destroy'])->name('projects.destroy');
            Route::delete('projects/{project}/images/{image}',[AdminProjectController::class, 'deleteImage'])->name('projects.images.delete');
            Route::delete('projects/{project}/media/{media}', [AdminProjectController::class, 'deleteMedia'])->name('projects.media.delete');
        });

        // ── Contacts / CRM ──────────────────────────────────────────────────
        Route::middleware('admin.permission:contacts.view')->group(function () {
            Route::get('contacts',          [AdminContactController::class, 'index'])->name('contacts.index');
            Route::get('contacts/export',   [AdminContactController::class, 'export'])->name('contacts.export');
            Route::get('contacts/{contact}',[AdminContactController::class, 'show'])->name('contacts.show');
        });
        Route::middleware('admin.permission:contacts.edit')->group(function () {
            Route::post('contacts/{contact}/mark-read', [AdminContactController::class, 'markRead'])->name('contacts.mark-read');
            Route::post('contacts/{contact}/crm',       [AdminContactController::class, 'updateCrm'])->name('contacts.crm');
            Route::post('contacts/bulk-action',         [AdminContactController::class, 'bulkAction'])->name('contacts.bulk');
        });
        Route::middleware('admin.permission:contacts.delete')->group(function () {
            Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
        });

        // ── Users Management (super_admin only) ──────────────────────────────
        Route::middleware('admin.permission:users.manage')->group(function () {
            Route::get('users',                        [AdminUserController::class, 'index'])->name('users.index');
            Route::get('users/create',                 [AdminUserController::class, 'create'])->name('users.create');
            Route::post('users',                       [AdminUserController::class, 'store'])->name('users.store');
            Route::get('users/{user}/edit',            [AdminUserController::class, 'edit'])->name('users.edit');
            Route::put('users/{user}',                 [AdminUserController::class, 'update'])->name('users.update');
            Route::delete('users/{user}',              [AdminUserController::class, 'destroy'])->name('users.destroy');
            Route::post('users/{user}/toggle-active',  [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
        });

        // ── Languages ────────────────────────────────────────────────────────
        Route::middleware('admin.permission:languages.manage')->group(function () {
            Route::get('/languages',                              [AdminLanguageController::class, 'index'])->name('languages.index');
            Route::post('/languages',                             [AdminLanguageController::class, 'store'])->name('languages.store');
            Route::put('/languages/{language}',                   [AdminLanguageController::class, 'update'])->name('languages.update');
            Route::delete('/languages/{language}',                [AdminLanguageController::class, 'destroy'])->name('languages.destroy');
            Route::post('/languages/{language}/toggle-active',    [AdminLanguageController::class, 'toggleActive'])->name('languages.toggle-active');
            Route::post('/languages/{language}/set-default',      [AdminLanguageController::class, 'setDefault'])->name('languages.set-default');
        });

        // ── Countries ────────────────────────────────────────────────────────
        Route::middleware('admin.permission:countries.manage')->group(function () {
            Route::resource('countries', AdminCountryController::class)->except(['show']);
            Route::post('countries/{country}/set-default',    [AdminCountryController::class, 'setDefault'])->name('countries.set-default');
            Route::post('countries/{country}/toggle-active',  [AdminCountryController::class, 'toggleActive'])->name('countries.toggle-active');
        });

        // ── Settings ─────────────────────────────────────────────────────────
        Route::middleware('admin.permission:settings.manage')->group(function () {
            Route::get('/settings',  [SettingController::class, 'index'])->name('settings.index');
            Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        });

        // ── Pages ─────────────────────────────────────────────────────────────
        Route::middleware('admin.permission:pages.manage')->group(function () {
            Route::resource('pages', PageController::class)->only(['index', 'edit', 'update']);
        });

        // ── Hero Slides ───────────────────────────────────────────────────────
        Route::middleware('admin.permission:hero.manage')->group(function () {
            Route::get('/hero',                   [HeroSlideController::class, 'index'])->name('hero.index');
            Route::post('/hero',                  [HeroSlideController::class, 'store'])->name('hero.store');
            Route::post('/hero/type',             [HeroSlideController::class, 'setType'])->name('hero.type');
            Route::post('/hero/reorder',          [HeroSlideController::class, 'reorder'])->name('hero.reorder');
            Route::put('/hero/{heroSlide}',       [HeroSlideController::class, 'update'])->name('hero.update');
            Route::delete('/hero/{heroSlide}',    [HeroSlideController::class, 'destroy'])->name('hero.destroy');
        });

        // ── Page Builder ──────────────────────────────────────────────────────
        Route::middleware('admin.permission:page_builder.manage')->group(function () {
            Route::get('/page-builder',                        [PageBuilderController::class, 'index'])->name('page-builder.index');
            Route::post('/page-builder/reorder',               [PageBuilderController::class, 'reorder'])->name('page-builder.reorder');
            Route::post('/page-builder/{pageSection}/toggle',  [PageBuilderController::class, 'toggle'])->name('page-builder.toggle');
        });
    });
});
