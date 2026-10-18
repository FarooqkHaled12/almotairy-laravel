<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // عرض كل الأسئلة
    public function index()
    {
        $faqs = Faq::latest()->paginate(10);
        return view('admin.faqs.index', compact('faqs'));
    }

    // صفحة الإضافة
    public function create()
    {
        return view('admin.faqs.create');
    }

    // حفظ سؤال جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_ar' => 'required|string|max:255',
            'question_en' => 'required|string|max:255',
            'answer_ar' => 'required|string',
            'answer_en' => 'required|string',
        ], [
            'required' => 'هذا الحقل مطلوب'
        ]);

        Faq::create($validated);
        return redirect()->route('admin.faq.index')->with('success', 'تم إضافة السؤال بنجاح ✅');
    }

    // صفحة التعديل
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    // تحديث السؤال
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question_ar' => 'required|string|max:255',
            'question_en' => 'required|string|max:255',
            'answer_ar' => 'required|string',
            'answer_en' => 'required|string',
        ], [
            'required' => 'هذا الحقل مطلوب'
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($validated);

        return redirect()->route('admin.faq.index')->with('success', 'تم تحديث السؤال بنجاح ✅');
    }

    // حذف سؤال
    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return back()->with('success', 'تم حذف السؤال بنجاح ❌');
    }
}
