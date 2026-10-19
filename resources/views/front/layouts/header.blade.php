@php
    $lang = session('locale', 'ar');
@endphp

<link rel="stylesheet" href="{{ asset('front/css/shared-layout.css') }}">
<header class="header" id="header">
    <nav class="navbar container">
        <a href="{{ route('front.home') }}" class="logo">
            <img src="{{ asset('front/img/logo1.png') }}" alt="{{ $lang === 'ar' ? 'شعار المطيري للعقارات' : 'Al-Motairy Real Estate Logo' }}">
        </a>

        <!-- زر الموبايل -->
        <button type="button" class="menu-toggle" id="mobile-menu" aria-controls="nav-list" aria-expanded="false" aria-label="{{ $lang === 'ar' ? 'فتح القائمة' : 'Open menu' }}" data-open-label="{{ $lang === 'ar' ? 'فتح القائمة' : 'Open menu' }}" data-close-label="{{ $lang === 'ar' ? 'إغلاق القائمة' : 'Close menu' }}">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <!-- القوائم -->
        <ul class="nav-list" id="nav-list">
            <li class="mobile-nav-heading" aria-hidden="true">
                <span>{{ $lang === 'ar' ? 'المطيري للعقارات' : 'Al-Motairy Real Estate' }}</span>
                <small>{{ $lang === 'ar' ? 'القائمة الرئيسية' : 'Main menu' }}</small>
            </li>
            @if ($lang === 'ar')
                <li><a href="{{ route('front.home') }}" class="{{ request()->routeIs('front.home') ? 'active' : '' }}">الرئيسية</a></li>
                <li><a href="{{ route('front.about') }}" class="{{ request()->routeIs('front.about') ? 'active' : '' }}">من نحن</a></li>
                <li><a href="{{ route('front.properties') }}" class="{{ request()->routeIs('front.properties') ? 'active' : '' }}">العقارات</a></li>
                <li><a href="{{ route('front.contact') }}" class="btn-contact {{ request()->routeIs('front.contact') ? 'active' : '' }}">تواصل معنا</a></li>
            @else
                <li><a href="{{ route('front.home') }}" class="{{ request()->routeIs('front.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('front.about') }}" class="{{ request()->routeIs('front.about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('front.properties') }}" class="{{ request()->routeIs('front.properties') ? 'active' : '' }}">Properties</a></li>
                <li><a href="{{ route('front.contact') }}" class="btn-contact {{ request()->routeIs('front.contact') ? 'active' : '' }}">Contact</a></li>
            @endif

            <!-- زر تغيير اللغة -->
            <li class="lang-switch">
                @if($lang === 'ar')
                    <a href="{{ route('switch.language', 'en') }}">English</a>
                @else
                    <a href="{{ route('switch.language', 'ar') }}">العربية</a>
                @endif
            </li>
        </ul>
    </nav>
</header>
