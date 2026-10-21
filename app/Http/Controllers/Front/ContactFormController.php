<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255',
            'phone'    => 'required|string|max:50',
            'interest' => 'nullable|in:buy,rent,sell,invest,general',
            'message'  => 'nullable|string|max:5000',
            'property_id' => 'nullable|integer|exists:properties,id',
            'preferred_visit_at' => 'nullable|date|after:now',
            'preferred_location' => 'nullable|string|max:255',
            'preferred_category_id' => 'nullable|integer|exists:property_categories,id',
            'budget_min' => 'nullable|integer|min:0|max:99999999999',
            'budget_max' => 'nullable|integer|min:0|max:99999999999',
            'area_min' => 'nullable|integer|min:0|max:10000000',
            'area_max' => 'nullable|integer|min:0|max:10000000',
        ]);

        foreach (['budget', 'area'] as $range) {
            $min = $data[$range.'_min'] ?? null;
            $max = $data[$range.'_max'] ?? null;
            if ($min !== null && $max !== null && $max < $min) {
                return back()->withErrors([
                    $range.'_max' => $range === 'budget'
                        ? (session('locale') === 'en' ? 'Maximum budget must be at least the minimum budget.' : 'الحد الأعلى للميزانية يجب أن يساوي الحد الأدنى أو يزيد عليه.')
                        : (session('locale') === 'en' ? 'Maximum area must be at least the minimum area.' : 'المساحة القصوى يجب أن تساوي المساحة الدنيا أو تزيد عليها.'),
                ])->withInput();
            }
        }

        $inquiry = Inquiry::create([
            ...$data,
            'locale' => in_array(session('locale'), ['ar', 'en'], true) ? session('locale') : 'ar',
        ]);

        try {
            Mail::raw(
                "Name: {$data['name']}\n".
                "Email: ".($data['email'] ?? '-')."\n".
                "Phone: {$data['phone']}\n".
                "Interest: ".($data['interest'] ?? '-')."\n".
                "Property ID: ".($data['property_id'] ?? '-')."\n\n".
                "Preferred visit: ".($data['preferred_visit_at'] ?? '-')."\n\n".
                "Preferred location: ".($data['preferred_location'] ?? '-')."\n".
                "Preferred category ID: ".($data['preferred_category_id'] ?? '-')."\n".
                "Budget: ".($data['budget_min'] ?? '-')." - ".($data['budget_max'] ?? '-')." EGP\n".
                "Area: ".($data['area_min'] ?? '-')." - ".($data['area_max'] ?? '-')." sqm\n\n".
                "Message:\n".($data['message'] ?? '-'),
                function ($msg) {
                    $msg->to(config('mail.to.address', 'admin@example.com'))
                        ->subject('New contact request');
                }
            );
        } catch (\Throwable $exception) {
            Log::warning('Inquiry saved, but the notification email could not be sent.', [
                'inquiry_id' => $inquiry->id,
                'exception' => $exception->getMessage(),
            ]);
        }

        return back()->with('success', __('Thank you! We received your request and will contact you soon.'));
    }
}
