@php $lang = session('locale','ar'); @endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $lang == 'ar' ? 'خالد للعقارات - الرئيسية' : 'Khalid Real Estate - Home' }}</title>
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

@include('front.layouts.header')

@include('front.homepage.hero')
@include('front.homepage.about')
@include('front.homepage.properties')
@include('front.homepage.services')
@include('front.homepage.faq')
@include('front.homepage.contact')

@include('front.layouts.footer')

</body>
</html>
