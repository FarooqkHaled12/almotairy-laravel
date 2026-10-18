<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function edit()
    {
        $contact = ContactInfo::first();
        if (!$contact) {
            $contact = ContactInfo::create([]);
        }
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address_ar' => 'nullable|string|max:255',
            'address_en' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:255',
        ], [
            'url' => 'اللينك غير صالح',
            'email' => 'يرجى إدخال بريد إلكتروني صحيح',
        ]);

        $contact = ContactInfo::first();
        $contact->update($validated);

        return back()->with('success', '✅ تم تحديث بيانات التواصل بنجاح');
    }
}
