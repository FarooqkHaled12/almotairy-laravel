<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OurStoryController;
use App\Http\Controllers\Admin\ValueController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Http\Controllers\Admin\CtaController;
use App\Http\Controllers\Admin\ConsultationController;
use App\Http\Controllers\Admin\ContactInfoTwoController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\PropertyCategoryController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\InquiryController;

// ✅ ربط مسارات الموقع العام (الفرونت)
require __DIR__ . '/front.php';


// ✅ مسارات لوحة التحكم فقط
Route::prefix('admin')->name('admin.')->group(function () {

    // التوجيه التلقائي عند فتح /admin
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    // 🔓 صفحات دخول الأدمن (تم إزالة middleware guest لتجنب التوجيه التلقائي للصفحة الرئيسية)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // 🔐 الصفحات المحمية بعد تسجيل الدخول
    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
        Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');

        // كلمة المرور
        Route::get('/password/edit', [PasswordController::class, 'edit'])->name('password.edit');
        Route::post('/password/update', [PasswordController::class, 'update'])->name('password.update');

        // قسم الهيرو
        Route::get('/hero/edit', [HeroController::class, 'edit'])->name('hero.edit');
        Route::post('/hero/update', [HeroController::class, 'update'])->name('hero.update');

        // قسم من أنا
        Route::get('/about/edit', [AboutController::class, 'edit'])->name('about.edit');
        Route::post('/about/update', [AboutController::class, 'update'])->name('about.update');

        // الخدمات
        Route::get('/services/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::post('/services/update', [ServiceController::class, 'update'])->name('services.update');

        // الأسئلة الشائعة
        Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
        Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
        Route::post('/faq/update/{id}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faq/delete/{id}', [FaqController::class, 'destroy'])->name('faq.delete');

        // بيانات التواصل (1)
        Route::get('/contact/edit', [ContactController::class, 'edit'])->name('contact.edit');
        Route::post('/contact/update', [ContactController::class, 'update'])->name('contact.update');

        // بيانات التواصل (2)
        Route::get('/contact2/edit', [ContactInfoTwoController::class, 'edit'])->name('contact2.edit');
        Route::post('/contact2/update', [ContactInfoTwoController::class, 'update'])->name('contact2.update');

        // قصتنا
        Route::get('/story/edit', [OurStoryController::class, 'edit'])->name('story.edit');
        Route::post('/story/update', [OurStoryController::class, 'update'])->name('story.update');

        // القيم
        Route::get('/values', [ValueController::class, 'index'])->name('values.index');
        Route::get('/values/create', [ValueController::class, 'create'])->name('values.create');
        Route::post('/values/store', [ValueController::class, 'store'])->name('values.store');
        Route::get('/values/{id}/edit', [ValueController::class, 'edit'])->name('values.edit');
        Route::post('/values/{id}/update', [ValueController::class, 'update'])->name('values.update');
        Route::delete('/values/{id}/delete', [ValueController::class, 'destroy'])->name('values.delete');

        // الإحصائيات
        Route::get('/statistics/edit', [StatisticController::class, 'edit'])->name('statistics.edit');
        Route::post('/statistics/update', [StatisticController::class, 'update'])->name('statistics.update');

        // لماذا تختارنا
        Route::get('/why-choose-us/edit', [WhyChooseUsController::class, 'edit'])->name('why.edit');
        Route::post('/why-choose-us/update', [WhyChooseUsController::class, 'update'])->name('why.update');

        // قسم CTA
        Route::get('/cta/edit', [CtaController::class, 'edit'])->name('cta.edit');
        Route::post('/cta/update', [CtaController::class, 'update'])->name('cta.update');

        // الاستشارات
        Route::get('/consultations/edit', [ConsultationController::class, 'edit'])->name('consultations.edit');
        Route::post('/consultations/update', [ConsultationController::class, 'update'])->name('consultations.update');

        // الخريطة
        Route::get('/map/edit', [MapController::class, 'edit'])->name('map.edit');
        Route::post('/map/update', [MapController::class, 'update'])->name('map.update');

        // تصنيفات العقارات
        Route::get('/categories', [PropertyCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [PropertyCategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/store', [PropertyCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [PropertyCategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/categories/{category}/update', [PropertyCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}/delete', [PropertyCategoryController::class, 'destroy'])->name('categories.delete');

        // العقارات
        Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
        Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
        Route::post('/properties/store', [PropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/{property}/units', [PropertyController::class, 'units'])->name('properties.units');
        Route::get('/properties/{property}/units/create', [PropertyController::class, 'createUnit'])->name('properties.units.create');
        Route::post('/properties/{property}/units', [PropertyController::class, 'storeUnit'])->name('properties.units.store');
        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::post('/properties/{property}/update', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}/delete', [PropertyController::class, 'destroy'])->name('properties.delete');
    });
});
