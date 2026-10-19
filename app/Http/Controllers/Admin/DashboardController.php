<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyCategory;

class DashboardController extends Controller
{
    public function index()
    {
        $propertyCount = Property::count();
        $categories = PropertyCategory::query()
            ->select('property_categories.id', 'property_categories.name_ar', 'property_categories.name_en')
            ->selectSub(
                Property::query()->selectRaw('count(*)')->whereColumn('properties.category_id', 'property_categories.id'),
                'properties_count'
            )
            ->orderBy('name_ar')
            ->get();

        return view('admin.dashboard', compact('propertyCount', 'categories'));
    }
}
