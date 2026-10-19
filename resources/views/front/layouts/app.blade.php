@php
    $lang = session('locale', 'ar');
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $lang === 'ar' ? 'المطيري للعقارات' : 'Al-Motairy Real Estate')</title>

    {{-- Fonts & Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Global Styles --}}
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

    @stack('styles')
</head>
<body class="@yield('body-class')">

@include('front.layouts.header')

<main id="main-content">
    @yield('content')
</main>

@include('front.layouts.footer')

{{-- Global Scripts --}}
<script src="{{ asset('front/js/script.js') }}"></script>

@stack('scripts')

</body>
</html>
