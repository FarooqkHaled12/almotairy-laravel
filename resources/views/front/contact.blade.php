@php $lang = session('locale','ar'); @endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $lang == 'ar' ? 'اتصل بنا' : 'Contact us' }}</title>

    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/shared-layout.css') }}?v={{ file_exists(public_path('front/css/shared-layout.css')) ? filemtime(public_path('front/css/shared-layout.css')) : '1' }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

@include('front.layouts.header')

@include('front.contact.cards')
@include('front.homepage.contact')
@include('front.contact.map')
@include('front.contact.faq')

@include('front.layouts.footer')

<script src="{{ asset('front/js/script.js') }}"></script>
<script src="{{ asset('front/js/contact.js') }}"></script>
</body>
</html>
