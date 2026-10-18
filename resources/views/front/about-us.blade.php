@php $lang = session('locale','ar'); @endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $lang == 'ar' ? 'من نحن - خالد للعقارات' : 'About Us - Khalid Real Estate' }}</title>

    {{-- ملفات الـ CSS العامة --}}
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

    {{-- نفس ملف تنسيق صفحة about-us في النسخة القديمة --}}
    <link rel="stylesheet" href="{{ asset('front/css/about-us.css') }}">

    {{-- أي مكتبة أيقونات كنت مستخدمها --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    @include('front.layouts.header')

    @include('front.about.story')
    @include('front.about.values')
    @include('front.about.statistics')
    @include('front.about.why')
@include('front.about.cta')

    @include('front.layouts.footer')

    {{-- سكربتات الصفحة العامة --}}
    <script src="{{ asset('front/js/script.js') }}"></script>

    {{-- سكربت صفحة من نحن القديمة --}}
    <script src="{{ asset('front/js/about-us.js') }}"></script>
</body>
</html>
