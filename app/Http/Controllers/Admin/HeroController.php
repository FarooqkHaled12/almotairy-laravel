<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function edit()
    {
        $hero = HeroSection::first();
        
        if (!$hero) {
            $hero = HeroSection::create([
                'title_ar' => '',
                'title_en' => '',
                'highlight_word_1_ar' => '',
                'highlight_word_1_en' => '',
                'subtitle_ar' => '',
                'subtitle_en' => '',
                'highlight_word_2_ar' => '',
                'highlight_word_2_en' => '',
                'description_ar' => '',
                'description_en' => '',
                'button_1_title_ar' => '',
                'button_1_title_en' => '',
                'button_1_link' => '',
                'button_2_title_ar' => '',
                'button_2_title_en' => '',
                'button_2_link' => '',
                'stat_1_number' => '',
                'stat_1_title_ar' => '',
                'stat_1_title_en' => '',
                'stat_2_number' => '',
                'stat_2_title_ar' => '',
                'stat_2_title_en' => '',
                'stat_3_number' => '',
                'stat_3_title_ar' => '',
                'stat_3_title_en' => '',
            ]);
        }
        
        return view('admin.hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'highlight_word_1_ar' => 'required|string|max:255',
            'subtitle_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'required' => 'هذا الحقل مطلوب',
            'string' => 'هذا الحقل يجب أن يكون نص',
            'max' => 'الحد الأقصى :max حرف',
            'image' => 'يجب أن يكون الملف صورة',
            'mimes' => 'يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, webp',
            'image.max' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت',
        ]);

        $hero = HeroSection::first();
        
        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($hero->image && Storage::disk('public')->exists($hero->image)) {
                Storage::disk('public')->delete($hero->image);
            }
            
            // Upload new image
            $imagePath = $request->file('image')->store('hero', 'public');
            $data['image'] = $imagePath;
        }
        
        $hero->update($data);
        
        return redirect()->route('admin.hero.edit')->with('success', 'تم تحديث قسم الهيرو بنجاح');
    }
}
