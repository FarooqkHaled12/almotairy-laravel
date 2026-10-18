<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;

class PropertyCategoryController extends Controller
{
    public function index()
    {
        $categories = PropertyCategory::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        PropertyCategory::create($validated);

        return redirect()->route('admin.categories.index')->with('success', '✅ تم إضافة التصنيف بنجاح');
    }

    public function edit(PropertyCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, PropertyCategory $category)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', '✅ تم تعديل التصنيف بنجاح');
    }

    public function destroy(PropertyCategory $category)
    {
        $category->delete();
        return back()->with('success', '🗑️ تم حذف التصنيف بنجاح');
    }
}
