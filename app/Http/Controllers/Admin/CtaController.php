<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cta;
use Illuminate\Http\Request;

class CtaController extends Controller
{
    public function edit()
    {
        $cta = Cta::first();
        if (!$cta) {
            $cta = Cta::create([]);
        }

        return view('admin.cta.edit', compact('cta'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'button_1_text_ar' => 'nullable|string|max:255',
            'button_1_text_en' => 'nullable|string|max:255',
            'button_1_link' => 'nullable|string|max:255',
            'button_2_text_ar' => 'nullable|string|max:255',
            'button_2_text_en' => 'nullable|string|max:255',
            'button_2_link' => 'nullable|string|max:255',
        ], [
            'required' => 'هذا الحقل مطلوب',
        ]);

        $cta = Cta::first();
        $cta->update($validated);

        return back()->with('success', '✅ تم تحديث بيانات قسم CTA بنجاح');
    }
}
