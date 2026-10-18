<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function edit()
    {
        $services = Service::orderBy('id')->take(4)->get();

        // لو الجدول فاضي أنشئ 4 خدمات افتراضية
        if ($services->count() < 4) {
            for ($i = $services->count(); $i < 4; $i++) {
                Service::create([
                    'title_ar' => '',
                    'title_en' => '',
                    'description_ar' => '',
                    'description_en' => '',
                ]);
            }
            $services = Service::orderBy('id')->take(4)->get();
        }

        return view('admin.services.edit', compact('services'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'services.*.title_ar' => 'required|string|max:255',
            'services.*.title_en' => 'required|string|max:255',
            'services.*.description_ar' => 'required|string',
            'services.*.description_en' => 'required|string',
        ], [
            'required' => 'هذا الحقل مطلوب',
        ]);

        foreach ($validated['services'] as $id => $data) {
            $service = Service::findOrFail($id);
            $service->update($data);
        }

        return back()->with('success', 'تم تحديث الخدمات بنجاح');
    }
}
