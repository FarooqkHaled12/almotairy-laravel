<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Property;

/*
|--------------------------------------------------------------------------
| Front-End Routes
|--------------------------------------------------------------------------
| جميع الصفحات العامة الخاصة بالموقع (الهوم، من نحن، الخدمات، العقارات..)
| الترجمة داخل ملفات الـ Blade نفسها بدون استخدام مجلد lang
|--------------------------------------------------------------------------
*/

// ✅ الصفحة الرئيسية
Route::get('/', function () {
    return view('front.index');
})->name('front.home');

// ✅ صفحة من نحن
Route::get('/about-us', [\App\Http\Controllers\Front\AboutController::class, 'index'])->name('front.about');

// ✅ صفحة الخدمات
Route::get('/services', function () {
    return view('front.services');
})->name('front.services');

// ✅ صفحة تواصل معنا (لو حبيت صفحة مستقلة غير سكشن الهوم)
Route::get('/contact', [\App\Http\Controllers\Front\ContactController::class, 'index'])->name('front.contact');

// ✅ جميع العقارات
Route::get('/all-properties', function () {
    $properties = Property::whereNull('building_id')->latest()->get();
    return view('front.all-properties', compact('properties'));
})->name('front.properties');

// صفحة العمارة وشققها. هذا المسار لا يعتمد على قيمة is_building حتى تظل
// كروت العمارات القديمة متصلة بصفحة الوحدات الخاصة بها.
Route::get('/building/{id}', function ($id) {
    $property = Property::with('units')->findOrFail($id);
    return view('front.building-details', compact('property'));
})->name('front.building.details');

// ✅ تفاصيل العقار الواحد
Route::get('/property-details/{id}', function ($id) {
    $property = Property::with('units')->findOrFail($id);
    // Some earlier building entries predate the is_building field. Keep those
    // listings on the building page while standalone apartments retain their
    // own detail page.
    $legacyBuildingName = mb_strtolower($property->name_ar.' '.$property->name_en);
    $isLegacyBuilding = str_contains($legacyBuildingName, 'عمارة')
        || str_contains($legacyBuildingName, 'ابراج')
        || str_contains($legacyBuildingName, 'أبراج')
        || str_contains($legacyBuildingName, 'برج')
        || str_contains($legacyBuildingName, 'building')
        || str_contains($legacyBuildingName, 'residence');

    if ($property->is_building || $property->units->isNotEmpty() || $isLegacyBuilding) {
        return redirect()->route('front.building.details', $property->id);
    }
    return view('front.property-details', compact('property'));
})->name('front.property.details');

// ✅ إرسال نموذج التواصل (الفرونت)
Route::post('/contact-submit', [\App\Http\Controllers\Front\ContactFormController::class, 'submit'])
    ->middleware('throttle:5,1')
    ->name('front.contact.submit');

// ✅ محوّل اللغة (Session-Based)
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['ar', 'en'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return back();
})->name('switch.language');
