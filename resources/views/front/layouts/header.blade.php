@php
    $lang = session('locale', 'ar');
    $homeHeader = request()->routeIs('front.home');
    $immersiveHeader = request()->routeIs('front.home', 'front.building.details');
    $headerContact = \App\Models\ContactInfo::query()->first();
    $headerWhatsapp = preg_replace('/[^0-9]/', '', $headerContact?->whatsapp ?? '');
@endphp

<header class="header{{ $immersiveHeader ? ' header--home' : '' }}" id="header">
    <nav class="navbar container" aria-label="{{ $lang === 'ar' ? 'القائمة الرئيسية' : 'Main navigation' }}">
        <a href="{{ route('front.home') }}" class="logo" aria-label="{{ $lang === 'ar' ? 'المطيري للعقارات - الرئيسية' : 'Almotairy Real Estate - Home' }}">
            <img src="{{ asset($immersiveHeader ? 'front/img/home-logo.svg' : 'front/img/logo1.png') }}" alt="{{ $lang === 'ar' ? 'شعار المطيري للعقارات' : 'Al-Motairy Real Estate Logo' }}">
        </a>

        <button type="button" class="menu-toggle" id="mobile-menu" aria-controls="nav-list" aria-expanded="false" aria-label="{{ $lang === 'ar' ? 'فتح القائمة' : 'Open menu' }}" data-open-label="{{ $lang === 'ar' ? 'فتح القائمة' : 'Open menu' }}" data-close-label="{{ $lang === 'ar' ? 'إغلاق القائمة' : 'Close menu' }}">
            <span class="bar"></span><span class="bar"></span><span class="bar"></span>
        </button>

        <ul class="nav-list" id="nav-list">
            <li class="mobile-nav-heading" aria-hidden="true">
                <span>{{ $lang === 'ar' ? 'المطيري للعقارات' : 'Al-Motairy Real Estate' }}</span>
                <small>{{ $lang === 'ar' ? 'القائمة الرئيسية' : 'Main menu' }}</small>
            </li>
            @if ($lang === 'ar')
                <li><a href="{{ route('front.home') }}" class="{{ request()->routeIs('front.home') ? 'active' : '' }}">الرئيسية</a></li>
                <li><a href="{{ route('front.properties') }}" class="{{ request()->routeIs('front.properties', 'front.property.details', 'front.building.details') ? 'active' : '' }}">{{ $immersiveHeader ? 'المباني' : 'العقارات' }}</a></li>
                <li><a href="{{ route('front.about') }}" class="{{ request()->routeIs('front.about') ? 'active' : '' }}">من نحن</a></li>
                <li><a href="{{ route('front.contact') }}" class="{{ request()->routeIs('front.contact') ? 'active' : '' }}">تواصل معنا</a></li>
            @else
                <li><a href="{{ route('front.home') }}" class="{{ request()->routeIs('front.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('front.properties') }}" class="{{ request()->routeIs('front.properties', 'front.property.details', 'front.building.details') ? 'active' : '' }}">{{ $immersiveHeader ? 'Buildings' : 'Properties' }}</a></li>
                <li><a href="{{ route('front.about') }}" class="{{ request()->routeIs('front.about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('front.contact') }}" class="{{ request()->routeIs('front.contact') ? 'active' : '' }}">Contact</a></li>
            @endif

            @if ($immersiveHeader)
                <li class="home-nav-search">
                    <form action="{{ route('front.properties') }}" method="GET" role="search">
                        <label class="sr-only" for="homeBuildingSearch">{{ $lang === 'ar' ? 'ابحث عن مبنى أو منطقة' : 'Search buildings or areas' }}</label>
                        <input id="homeBuildingSearch" type="search" name="q" placeholder="{{ $lang === 'ar' ? 'ابحث عن مبنى أو منطقة...' : 'Search buildings or areas...' }}">
                        <button type="submit" aria-label="{{ $lang === 'ar' ? 'بحث' : 'Search' }}"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></button>
                    </form>
                </li>
                <li class="home-nav-whatsapp">
                    @if ($headerWhatsapp)
                        <a href="https://wa.me/{{ $headerWhatsapp }}" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><span>{{ $lang === 'ar' ? 'تواصل عبر واتساب' : 'Contact on WhatsApp' }}</span></a>
                    @else
                        <a href="{{ route('front.contact') }}"><i class="fa-regular fa-paper-plane" aria-hidden="true"></i><span>{{ $lang === 'ar' ? 'تواصل معنا' : 'Contact us' }}</span></a>
                    @endif
                </li>
            @endif

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
