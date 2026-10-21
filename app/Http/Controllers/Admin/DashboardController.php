<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\PropertyCategory;

class DashboardController extends Controller
{
    public function index()
    {
        $propertyCount = Property::count();
        $newInquiryCount = Inquiry::where('status', 'new')->count();
        $followUpInquiryCount = Inquiry::where('status', 'follow_up')->count();
        $categories = PropertyCategory::query()
            ->select('property_categories.id', 'property_categories.name_ar', 'property_categories.name_en')
            ->selectSub(
                Property::query()->selectRaw('count(*)')->whereColumn('properties.category_id', 'property_categories.id'),
                'properties_count'
            )
            ->orderBy('name_ar')
            ->get();

        // Operational checks use existing property fields only; no schema changes needed.
        $propertiesMissingPhotos = Property::query()
            ->where(function ($query) {
                $query->whereNull('image_1')->orWhere('image_1', '');
            })
            ->count();

        $propertiesMissingEnglish = Property::query()
            ->where(function ($query) {
                $query->whereNull('name_en')->orWhere('name_en', '')
                    ->orWhereNull('area_en')->orWhere('area_en', '')
                    ->orWhereNull('description_en')->orWhere('description_en', '');
            })
            ->count();

        $recentProperties = Property::query()->latest()->take(5)->get();
        $propertiesNeedingReview = Property::query()
            ->where(function ($query) {
                $query->where(function ($photoQuery) {
                    $photoQuery->whereNull('image_1')->orWhere('image_1', '');
                })->orWhere(function ($englishQuery) {
                    $englishQuery->whereNull('name_en')->orWhere('name_en', '')
                        ->orWhereNull('area_en')->orWhere('area_en', '')
                        ->orWhereNull('description_en')->orWhere('description_en', '');
                });
            })
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();
        $emptyCategories = $categories->where('properties_count', 0);

        return view('admin.dashboard', compact(
            'propertyCount',
            'newInquiryCount',
            'followUpInquiryCount',
            'categories',
            'propertiesMissingPhotos',
            'propertiesMissingEnglish',
            'recentProperties',
            'propertiesNeedingReview',
            'emptyCategories'
        ));
    }
}
