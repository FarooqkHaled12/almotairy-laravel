<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Value;
use Illuminate\Http\Request;

class ValueController extends Controller
{
    public function index()
    {
        $values = Value::latest()->get();
        return view('admin.values.index', compact('values'));
    }

    public function create()
    {
        $icons = config('icons');
        return view('admin.values.create', compact('icons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
        ]);

        Value::create($validated);

        return redirect()->route('admin.values.index')->with('success', 'تم إضافة القيمة بنجاح ✅');
    }

    public function edit($id)
    {
        $value = Value::findOrFail($id);
        $icons = config('icons');
        return view('admin.values.edit', compact('value', 'icons'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'icon' => 'required|string',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
        ]);

        $value = Value::findOrFail($id);
        $value->update($validated);

        return redirect()->route('admin.values.index')->with('success', 'تم تعديل القيمة بنجاح ✅');
    }

    public function destroy($id)
    {
        Value::findOrFail($id)->delete();
        return back()->with('success', 'تم حذف القيمة بنجاح ❌');
    }
}
