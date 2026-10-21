<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // نفس اللغة الافتراضية المستخدمة في ملفات الـ Blade (العربية) حتى تتطابق __() مع باقي الصفحة
        $locale = session('locale', 'ar');
        app()->setLocale($locale);

        return $next($request);
    }
}
