@php 
    $lang = session('locale', 'ar'); 
@endphp

<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lang == 'ar' ? 'خالد للعقارات' : 'Khalid Real Estate' }}</title>
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <style>
        /* الأساسيات */
        body {
            margin: 0;
            font-family: "Cairo", sans-serif;
            background: #fff;
        }
        .header {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }
        .logo img {
            height: 125px;
        }
        /* قائمة الروابط الرئيسية */
        .nav-list {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }
        .nav-list a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: color 0.3s;
        }
        .nav-list a:hover, .nav-list a.active {
            color: #6d28d9;
        }
        .btn-contact {
            background: #6d28d9;
            color: #fff !important;
            padding: 8px 14px;
            border-radius: 5px;
        }
        /* محول اللغة */
        .lang-switch a {
            padding: 6px 12px;
            background: #f3f4f6;
            color: #6d28d9;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .lang-switch a:hover {
            background: #6d28d9;
            color: #fff;
        }
        /* زر القائمة للموبايل */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }
        .menu-toggle .bar {
            height: 3px;
            width: 25px;
            background: #333;
            margin: 4px 0;
            border-radius: 3px;
        }
        /* موبايل */
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }
            .nav-list {
                position: absolute;
                top: 70px;
                {{ $lang == 'ar' ? 'right' : 'left' }}: 0;
                background: #fff;
                flex-direction: column;
                align-items: center;
                width: 100%;
                padding: 20px 0;
                display: none;
                border-top: 1px solid #eee;
            }
            .nav-list.active {
                display: flex;
                padding-bottom: 50%;
            }
        }
    </style>
</head>
<body>

<header class="header" id="header">
    <nav class="navbar container">
        <a href="{{ route('front.home') }}" class="logo">
            <img src="{{ asset('front/img/logo.png') }}" alt="{{ $lang == 'ar' ? 'شعار خالد للعقارات' : 'Khalid Real Estate Logo' }}">
        </a>

        <!-- زر الموبايل -->
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <!-- القوائم -->
        <ul class="nav-list" id="nav-list">
            @if ($lang == 'ar')
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
                @if($lang == 'ar')
                    <a href="{{ route('switch.language', 'en') }}">English</a>
                @else
                    <a href="{{ route('switch.language', 'ar') }}">العربية</a>
                @endif
            </li>
        </ul>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('mobile-menu');
    const navList = document.getElementById('nav-list');

    menuBtn.addEventListener('click', function() {
        navList.classList.toggle('active');

        // حركة الزر (X animation)
        menuBtn.classList.toggle('open');
    });
});
</script>

<style>
.menu-toggle.open .bar:nth-child(1) {
    transform: rotate(45deg) translate(5px, 6px);
}
.menu-toggle.open .bar:nth-child(2) {
    opacity: 0;
}
.menu-toggle.open .bar:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -7px);
}
</style>

</body>
</html>
