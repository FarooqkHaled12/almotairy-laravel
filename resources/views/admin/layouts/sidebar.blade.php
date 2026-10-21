@php
    $sidebarGroups = [
        ['title' => 'نظرة عامة', 'links' => [
            ['الرئيسية', 'admin.dashboard', 'admin.dashboard', 'M3 10.5 12 3l9 7.5M5.5 9.5V21h13V9.5M9.5 21v-7h5v7'],
        ]],
        ['title' => 'العقارات', 'links' => [
            ['العقارات', 'admin.properties.index', 'admin.properties.*', 'M3 21h18M5 21V7l7-4 7 4v14M9 10h.01M15 10h.01M9 14h.01M15 14h.01M10 21v-3h4v3'],
            ['تصنيفات العقارات', 'admin.categories.index', 'admin.categories.*', 'M4 6h16M4 12h16M4 18h16'],
        ]],
        ['title' => 'محتوى الموقع', 'links' => [
            ['القسم الرئيسي', 'admin.hero.edit', 'admin.hero.*', 'M4 5h16v14H4zM4 16l5-5 3 3 3-3 5 5M8 9h.01'],
            ['قسم من أنا', 'admin.about.edit', 'admin.about.*', 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4 21a8 8 0 0 1 16 0'],
            ['الخدمات', 'admin.services.edit', 'admin.services.*', 'M4 6h16M7 12h10M9 18h6'],
            ['الأسئلة الشائعة', 'admin.faq.index', 'admin.faq.*', 'M4 5h16v14H4zM9 9a3 3 0 0 1 6 0c0 2-3 2-3 4M12 16h.01'],
            ['قصتنا', 'admin.story.edit', 'admin.story.*', 'M3 6h7a2 2 0 0 1 2 2v12a2 2 0 0 0-2-2H3zM21 6h-7a2 2 0 0 0-2 2v12a2 2 0 0 1 2-2h7z'],
            ['القيم', 'admin.values.index', 'admin.values.*', 'M12 21s-8-4.5-8-10a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 11c0 5.5-8 10-8 10Z'],
            ['الإحصائيات', 'admin.statistics.edit', 'admin.statistics.*', 'M4 20V10M10 20V4M16 20v-7M22 20H2'],
            ['لماذا تختارنا', 'admin.why.edit', 'admin.why.*', 'm12 3 8 3v5c0 5-3 8-8 10-5-2-8-5-8-10V6zM9 12l2 2 4-4'],
            ['قسم CTA', 'admin.cta.edit', 'admin.cta.*', 'M4 5h16v14H4zM8 9h8M8 13h5M8 16h4'],
            ['الاستشارات', 'admin.consultations.edit', 'admin.consultations.*', 'M20 11a8 8 0 0 1-12 7l-4 1 1-4a8 8 0 1 1 15-4ZM8 11h8'],
        ]],
        ['title' => 'التواصل', 'links' => [
            ['طلبات العملاء', 'admin.inquiries.index', 'admin.inquiries.*', 'M3 5h18v14H3zM3 7l9 6 9-6M7 3v4M17 3v4'],
            ['بيانات التواصل', 'admin.contact.edit', 'admin.contact.*', 'M4 5h16v14H4zM4 7l8 6 8-6'],
            ['الاتصال 2', 'admin.contact2.edit', 'admin.contact2.*', 'M5 4h14v16H5zM8 8h8M8 12h8M8 16h5'],
            ['الخريطة', 'admin.map.edit', 'admin.map.*', 'M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0ZM12 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'],
        ]],
    ];
@endphp

<div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"></div>
<aside id="admin-sidebar" :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'" class="admin-sidebar fixed inset-y-0 right-0 z-30 w-64 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0 flex-shrink-0" aria-label="قائمة الإدارة">
    <div class="admin-sidebar__inner">
        <div class="admin-sidebar__header">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__brand">
                <span class="admin-sidebar__logo"><img src="{{ asset('front/img/logo.png') }}" alt=""></span>
                <span><strong>المطيري</strong><small>لوحة الإدارة</small></span>
            </a>
            <button type="button" @click="sidebarOpen = false" class="admin-sidebar__close lg:hidden" aria-label="إغلاق القائمة">×</button>
        </div>

        <nav class="admin-sidebar__nav" aria-label="أقسام لوحة الإدارة">
            @foreach($sidebarGroups as $group)
                @php
                    $groupIsActive = collect($group['links'])->contains(fn ($link) => request()->routeIs($link[2]));
                @endphp
                <details class="admin-sidebar__group" @if($groupIsActive || (request()->routeIs('admin.dashboard') && $group['title'] === 'العقارات')) open @endif>
                    <summary class="admin-sidebar__group-label"><span>{{ $group['title'] }}</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg></summary>
                    <div class="admin-sidebar__group-links">
                    @foreach($group['links'] as [$label, $routeName, $routePattern, $iconPath])
                        <a href="{{ route($routeName) }}" class="admin-sidebar__link {{ request()->routeIs($routePattern) ? 'is-active' : '' }}" @if(request()->routeIs($routePattern)) aria-current="page" @endif>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $iconPath }}"/></svg>
                            <span>{{ $label }}</span>
                        </a>
                    @endforeach
                    </div>
                </details>
            @endforeach
            <details class="admin-sidebar__group" @if(request()->routeIs('admin.password.*')) open @endif>
                <summary class="admin-sidebar__group-label"><span>الحساب</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg></summary>
                <div class="admin-sidebar__group-links">
                <a href="{{ route('admin.password.edit') }}" class="admin-sidebar__link {{ request()->routeIs('admin.password.edit') ? 'is-active' : '' }}" @if(request()->routeIs('admin.password.edit')) aria-current="page" @endif>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 11V7a4 4 0 1 1 8 0v4M6 11h12v10H6zM12 15v2"/></svg><span>تغيير كلمة المرور</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">@csrf
                    <button type="submit" class="admin-sidebar__link admin-sidebar__logout"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 17v3H4V4h6v3M14 8l4 4-4 4M8 12h10"/></svg><span>تسجيل الخروج</span></button>
                </form>
                </div>
            </details>
        </nav>
        <div class="admin-sidebar__profile"><span class="admin-sidebar__avatar">{{ mb_substr(Auth::guard('admin')->user()->name, 0, 1) }}</span><span class="admin-sidebar__profile-text"><strong>{{ Auth::guard('admin')->user()->name }}</strong><small>مسؤول النظام</small></span></div>
    </div>
</aside>
