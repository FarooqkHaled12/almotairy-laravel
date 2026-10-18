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
        $properties = Property::latest()->get();
        return view('admin.properties.index', compact('properties'));
    }

public function create()
{
    $categories = \App\Models\PropertyCategory::all();
    return view('admin.properties.create', compact('categories'));
}

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $this->handleImages($request, $validated);
        Property::create($validated);

        return redirect()->route('admin.properties.index')->with('success', '✅ تم إضافة العقار بنجاح');
    }

public function edit(Property $property)
{
    $categories = \App\Models\PropertyCategory::all();
    return view('admin.properties.edit', compact('property', 'categories'));
}

    public function update(Request $request, Property $property)
    {
        $validated = $this->validateData($request);
        $this->handleImages($request, $validated, $property);
        $property->update($validated);

        return redirect()->route('admin.properties.index')->with('success', '✅ تم تعديل العقار بنجاح');
    }

    public function destroy(Property $property)
    {
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
