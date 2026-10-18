<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{
    public function edit()
    {
        $types = ['استشارات عقارية', 'تشطيبات', 'إدارة أصول', 'تثمين عقاري'];

        foreach ($types as $type) {
            Consultation::firstOrCreate(['type' => $type]);
        }

        $consultations = Consultation::orderBy('id')->get();

        return view('admin.consultations.edit', compact('consultations'));
    }

    public function update(Request $request)
    {
        foreach ($request->consultations as $id => $data) {
            $consult = Consultation::findOrFail($id);

            $fields = collect($data)->except('image', 'features_ar', 'features_en')->toArray();

            $fields['features_ar'] = array_filter($data['features_ar'] ?? []);
            $fields['features_en'] = array_filter($data['features_en'] ?? []);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($consult->image && Storage::disk('public')->exists($consult->image)) {
                    Storage::disk('public')->delete($consult->image);
                }
                $fields['image'] = $data['image']->store('consultations', 'public');
            }

            $consult->update($fields);
        }

        return back()->with('success', '✅ تم تعديل بيانات الاستشارات بنجاح');
    }
}
