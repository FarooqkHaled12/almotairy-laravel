<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::withCount('units')->whereNull('building_id')->latest()->get();
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $categories = \App\Models\PropertyCategory::all();
        $building = null;
        return view('admin.properties.create', compact('categories', 'building'));
    }

    public function units(Property $property)
    {
        abort_unless($property->is_building && !$property->building_id, 404);
        $units = $property->units()->latest()->get();
        return view('admin.properties.units', compact('property', 'units'));
    }

    public function createUnit(Property $property)
    {
        abort_unless($property->is_building && !$property->building_id, 404);
        $categories = \App\Models\PropertyCategory::all();
        $building = $property;
        return view('admin.properties.create', compact('categories', 'building'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $validated['is_building'] = $request->boolean('is_building');
        $this->handleImages($request, $validated);
        Property::create($validated);

        return redirect()->route('admin.properties.index')->with('success', '✅ تم إضافة العقار بنجاح');
    }

    public function storeUnit(Request $request, Property $property)
    {
        abort_unless($property->is_building && !$property->building_id, 404);
        $validated = $this->validateData($request);
        $validated['category_id'] = $property->category_id;
        $validated['is_building'] = false;
        $validated['building_id'] = $property->id;
        $this->handleImages($request, $validated);
        Property::create($validated);

        return redirect()->route('admin.properties.units', $property)->with('success', 'تمت إضافة الشقة للعمارة بنجاح.');
    }

    public function edit(Property $property)
    {
        $categories = \App\Models\PropertyCategory::all();
        $building = $property->building;
        return view('admin.properties.edit', compact('property', 'categories', 'building'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $this->validateData($request);
        $validated['is_building'] = $property->building_id
            ? false
            : ($property->units()->exists() || $request->boolean('is_building'));
        $this->handleImages($request, $validated, $property);
        $property->update($validated);

        if ($property->building_id) {
            return redirect()->route('admin.properties.units', $property->building_id)->with('success', 'تم تعديل بيانات الشقة بنجاح.');
        }

        return redirect()->route('admin.properties.index')->with('success', '✅ تم تعديل العقار بنجاح');
    }

    public function destroy(Property $property)
    {
        foreach ($property->units as $unit) {
            foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $field) {
                if ($unit->$field && Storage::disk('public')->exists($unit->$field)) {
                    Storage::disk('public')->delete($unit->$field);
                }
            }
            $unit->delete();
        }
        foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $field) {
            if ($property->$field && Storage::disk('public')->exists($property->$field))
                Storage::disk('public')->delete($property->$field);
        }
        $property->delete();
        return back()->with('success', '🗑️ تم حذف العقار بنجاح');
    }

private function validateData($request)
{
    return $request->validate([
        'category_id' => 'required|exists:property_categories,id',  // ← أهم سطر

        'is_building' => 'nullable|boolean',
        'name_ar' => 'required|string|max:255',
        'name_en' => 'required|string|max:255',
        'area_ar' => 'nullable|string|max:255',
        'area_en' => 'nullable|string|max:255',
        'description_ar' => 'nullable|string',
        'description_en' => 'nullable|string',
        'features_ar' => 'nullable|array',
        'features_en' => 'nullable|array',
        'phone' => 'nullable|string|max:20',
        'whatsapp' => 'nullable|string|max:20',
        'location_ar' => 'nullable|string|max:255',
        'location_en' => 'nullable|string|max:255',
        'legal_status_ar' => 'nullable|string|max:255',
        'legal_status_en' => 'nullable|string|max:255',
        'payment_system_ar' => 'nullable|string',
        'payment_system_en' => 'nullable|string',
        'image_1' => 'nullable|image|mimes:jpg,png,webp|max:2048',
        'image_2' => 'nullable|image|mimes:jpg,png,webp|max:2048',
        'image_3' => 'nullable|image|mimes:jpg,png,webp|max:2048',
        'image_4' => 'nullable|image|mimes:jpg,png,webp|max:2048',
    ]);
}


    private function handleImages($request, &$validated, $property = null)
    {
        for ($i = 1; $i <= 4; $i++) {
            $field = "image_$i";
            if ($request->hasFile($field)) {
                if ($property && $property->$field && Storage::disk('public')->exists($property->$field)) {
                    Storage::disk('public')->delete($property->$field);
                }
                $validated[$field] = $request->file($field)->store('properties', 'public');
            }
        }
    }
}
