<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $about = AboutSection::firstOrCreate([], [
            'title_1_ar' => '',
            'title_1_en' => '',
            'title_2_ar' => '',
            'title_2_en' => '',
            'description_ar' => '',
            'description_en' => '',
            'features_ar' => [],
            'features_en' => [],
            'signature_ar' => '',
            'signature_en' => '',
        ]);

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_1_ar' => 'required|string|max:255',
            'title_1_en' => 'required|string|max:255',
            'title_2_ar' => 'required|string|max:255',
            'title_2_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'signature_ar' => 'required|string|max:255',
            'signature_en' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'required' => 'هذا الحقل مطلوب',
            'string' => 'القيمة يجب أن تكون نصية',
            'image' => 'يجب اختيار ملف صورة صالح',
        ]);

        $about = AboutSection::first();

        $data = $request->except('image', 'features_ar', 'features_en');
        $data['features_ar'] = array_filter($request->input('features_ar', []));
        $data['features_en'] = array_filter($request->input('features_en', []));

        if ($request->hasFile('image')) {
            if ($about->image && Storage::disk('public')->exists($about->image)) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        $about->update($data);

        return redirect()->route('admin.about.edit')->with('success', 'تم تحديث قسم من أنا بنجاح');
    }
}
