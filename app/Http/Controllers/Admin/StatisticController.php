<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function edit()
    {
        $stats = Statistic::orderBy('id')->get();

        // لو مش موجودين اعمل 4 افتراضياً
        if ($stats->count() < 4) {
            for ($i = $stats->count(); $i < 4; $i++) {
                Statistic::create([
                    'icon' => 'fa-star',
                    'number' => 0,
                    'title_ar' => '',
                    'title_en' => '',
                ]);
            }
            $stats = Statistic::orderBy('id')->get();
        }

        $icons = config('icons');
        return view('admin.statistics.edit', compact('stats', 'icons'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'stats.*.icon' => 'required|string',
            'stats.*.number' => 'required|string|max:255',
            'stats.*.title_ar' => 'required|string|max:255',
            'stats.*.title_en' => 'required|string|max:255',
        ], [
            'required' => 'هذا الحقل مطلوب',
        ]);

        foreach ($validated['stats'] as $id => $data) {
            $stat = Statistic::findOrFail($id);
            $stat->update($data);
        }

        return back()->with('success', '✅ تم حفظ الإحصائيات بنجاح');
    }
}
