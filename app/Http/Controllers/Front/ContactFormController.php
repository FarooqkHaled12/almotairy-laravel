<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255',
            'phone'    => 'required|string|max:50',
            'interest' => 'nullable|string|max:50',
            'message'  => 'nullable|string',
        ]);

        // مثال: إرسال إيميل للأدمن
        Mail::raw(
            "Name: {$data['name']}\n".
            "Email: ".($data['email'] ?? '-')."\n".
            "Phone: {$data['phone']}\n".
            "Interest: ".($data['interest'] ?? '-')."\n\n".
            "Message:\n".($data['message'] ?? '-'),
            function ($msg) {
                $msg->to(config('mail.to.address', 'admin@example.com'))
                    ->subject('New contact request');
            }
        );

        return back()
            ->with('success', __('Thank you! We received your request and will contact you soon.'))
            ->withFragment('contact-form');
    }
}
