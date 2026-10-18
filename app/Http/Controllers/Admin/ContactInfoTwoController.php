<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfoTwo;
use Illuminate\Http\Request;

class ContactInfoTwoController extends Controller
{
    public function edit()
    {
        $contact = ContactInfoTwo::first();
        if (!$contact) {
            $contact = ContactInfoTwo::create([]);
        }

        return view('admin.contact2.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'working_hours' => 'nullable|string|max:255',
            'phone_1' => 'nullable|string|max:50',
            'phone_2' => 'nullable|string|max:50',
            'email_1' => 'nullable|email|max:255',
            'email_2' => 'nullable|email|max:255',
            'email_3' => 'nullable|email|max:255',
            'address_ar' => 'nullable|string|max:255',
            'address_en' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:100',
        ], [
            'email' => 'يرجى إدخال بريد إلكتروني صحيح',
        ]);

        $contact = ContactInfoTwo::first();
        $contact->update($validated);

        return back()->with('success', '✅ تم تحديث بيانات الاتصال 2 بنجاح');
    }
}
