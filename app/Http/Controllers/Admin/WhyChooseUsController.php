<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WhyChooseUsController extends Controller
{
    public function edit()
    {
        $data = WhyChooseUs::first();

        if (!$data) {
            $data = WhyChooseUs::create([]);
        }

        return view('admin.why_choose_us.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'highlight_word_ar' => 'nullable|string|max:255',
            'highlight_word_en' => 'nullable|string|max:255',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = WhyChooseUs::first();

        $attributes = $request->except('image');

        if ($request->hasFile('image')) {
            if ($data->image && Storage::disk('public')->exists($data->image)) {
                Storage::disk('public')->delete($data->image);
            }
            $attributes['image'] = $request->file('image')->store('why_choose_us', 'public');
        }

        $data->update($attributes);

        return back()->with('success', '✅ تم تحديث قسم لماذا تختارنا بنجاح');
    }
}
