<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cta;
use App\Models\Statistic;
use App\Models\Value;
use App\Models\WhyChooseUs;

class AboutController extends Controller
{
    /**
     * صفحة من نحن: البيانات القابلة للتعديل من لوحة التحكم، والنصوص الافتراضية داخل الـ Blade.
     */
    public function index()
    {
        $lang = session('locale', 'ar');

        $stats = Statistic::orderBy('id')->take(5)->get()
            ->map(fn ($stat) => [
                // الأيقونة مخزنة بدون prefix (fa-heart) فنضيف fa-solid لها
                'icon'   => str_contains((string) $stat->icon, ' ') ? $stat->icon : 'fa-solid ' . ($stat->icon ?: 'fa-star'),
                'number' => $stat->number,
                'title'  => $lang === 'ar' ? $stat->title_ar : $stat->title_en,
            ])
            ->filter(fn ($stat) => trim((string) $stat['number']) !== '' && trim((string) $stat['title']) !== '')
            ->values();

        $values = Value::orderBy('id')->take(4)->get()
            ->map(fn ($value) => [
                'icon'  => $value->icon ?: 'fa-solid fa-star',
                'title' => $lang === 'ar' ? $value->title_ar : $value->title_en,
                'desc'  => $lang === 'ar' ? $value->description_ar : $value->description_en,
            ])
            ->filter(fn ($value) => trim((string) $value['title']) !== '')
            ->values();

        $expertise = collect();
        if ($why = WhyChooseUs::first()) {
            for ($i = 1; $i <= 4; $i++) {
                $title = $lang === 'ar' ? $why->{"point_{$i}_title_ar"} : $why->{"point_{$i}_title_en"};
                $desc  = $lang === 'ar' ? $why->{"point_{$i}_desc_ar"} : $why->{"point_{$i}_desc_en"};
                if ($title || $desc) {
                    $expertise->push(['title' => $title, 'desc' => $desc]);
                }
            }
        }

        $cta = Cta::first();

        return view('front.about-us', compact('lang', 'stats', 'values', 'expertise', 'cta'));
    }
}
