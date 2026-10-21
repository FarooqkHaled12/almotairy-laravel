<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactInfoTwo;
use App\Models\Map;

class ContactController extends Controller
{
    // موقع المكتب من التصميم القديم (المريوطية - الهرم) يُستخدم لو لم تُحفظ خريطة من لوحة التحكم
    private const DEFAULT_COORDINATES = '29.9876543,31.1234567';

    public function index()
    {
        $lang = session('locale', 'ar');
        $info = ContactInfoTwo::first();
        $map  = Map::first();

        $address = ($lang === 'ar' ? $info?->address_ar : $info?->address_en) ?: __('Al-Mariouteya, Al-Haram Street, Giza');

        $contact = [
            'phone'    => $info?->phone_1 ?: '+20 100 000 0000',
            'email'    => $info?->email_1 ?: 'info@khaled-realestate.com',
            'whatsapp' => preg_replace('/\D+/', '', $info?->whatsapp ?: '201000000000'),
            'address'  => $address,
            'hours'    => $info?->working_hours ?: __('Saturday – Thursday, 9:00 AM – 6:00 PM'),
        ];

        // لو فيه خريطة محفوظة من لوحة التحكم نعرض الكود كما هو، والاتجاهات تبحث بالعنوان
        $mapEmbed      = $map?->map_embed;
        $mapSrc        = 'https://maps.google.com/maps?q=' . self::DEFAULT_COORDINATES . '&z=15&hl=' . $lang . '&output=embed';
        $directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($mapEmbed ? $address : self::DEFAULT_COORDINATES);

        return view('front.contact', compact('lang', 'contact', 'mapEmbed', 'mapSrc', 'directionsUrl'));
    }
}
