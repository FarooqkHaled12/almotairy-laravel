@extends('admin.layouts.app')

@section('title', 'الرئيسية')
@section('page-title', 'لوحة التحكم')

@section('content')
    <div class="admin-home">
        <section class="admin-home__welcome" aria-labelledby="dashboard-welcome">
            <div>
                <span class="admin-home__eyebrow">لوحة إدارة المطيري</span>
                <h2 id="dashboard-welcome">مرحباً بك، {{ Auth::guard('admin')->user()->name }}</h2>
                <p>أدر محتوى موقعك وعقاراتك من مكان واحد.</p>
                <a class="admin-home__visit" href="{{ route('front.home') }}" target="_blank" rel="noopener noreferrer">زيارة الموقع <span aria-hidden="true">↗</span></a>
            </div>
            <div class="admin-home__brand" aria-hidden="true">
                <img src="{{ asset('front/img/logo.png') }}" alt="">
            </div>
        </section>

        <section class="admin-home__section" aria-labelledby="dashboard-statistics">
            <div class="admin-home__section-heading">
                <span class="admin-home__eyebrow admin-home__eyebrow--dark">نظرة عامة</span>
                <h2 id="dashboard-statistics">إحصائيات العقارات</h2>
                <p>ملخص مباشر لبيانات العقارات والتصنيفات المسجلة.</p>
            </div>
            <div class="admin-home__stats">
                <a class="admin-home__stat" href="{{ route('admin.properties.index') }}"><span>إجمالي العقارات</span><strong>{{ number_format($propertyCount) }}</strong><small>عرض العقارات <span aria-hidden="true">←</span></small></a>
                <a class="admin-home__stat" href="{{ route('admin.categories.index') }}"><span>إجمالي التصنيفات</span><strong>{{ number_format($categories->count()) }}</strong><small>عرض التصنيفات <span aria-hidden="true">←</span></small></a>
                <div class="admin-home__distribution">
                    <h3>العقارات حسب التصنيف</h3>
                    <div class="admin-home__distribution-list">
                        @forelse($categories as $category)
                            <div class="admin-home__distribution-row"><span>{{ $category->name_ar ?: $category->name_en }}</span><strong>{{ number_format($category->properties_count) }}</strong></div>
                        @empty
                            <p>لا توجد تصنيفات مسجلة حتى الآن.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <section class="admin-home__section" aria-labelledby="dashboard-shortcuts">
            <div class="admin-home__section-heading">
                <div><span class="admin-home__eyebrow admin-home__eyebrow--dark">إدارة الموقع</span><h2 id="dashboard-shortcuts">الوصول السريع</h2><p>انتقل مباشرة إلى أقسام الإدارة الأكثر استخداماً.</p></div>
            </div>
            <div class="admin-home__grid">
                <a class="admin-home__card" href="{{ route('admin.properties.index') }}">
                    <span class="admin-home__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M3 10.5 12 3l9 7.5M5.5 9.5V21h13V9.5M9.5 21v-7h5v7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    <span class="admin-home__card-title">العقارات</span><span class="admin-home__card-desc">إدارة العقارات وتفاصيلها</span><span class="admin-home__card-link">فتح القسم <span aria-hidden="true">←</span></span>
                </a>
                <a class="admin-home__card" href="{{ route('admin.categories.index') }}">
                    <span class="admin-home__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg></span>
                    <span class="admin-home__card-title">تصنيفات العقارات</span><span class="admin-home__card-desc">تنظيم تصنيفات العقارات</span><span class="admin-home__card-link">فتح القسم <span aria-hidden="true">←</span></span>
                </a>
                <a class="admin-home__card" href="{{ route('admin.hero.edit') }}">
                    <span class="admin-home__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9" r="1.5"/><path d="m4 17 5-5 3 3 3-3 5 5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    <span class="admin-home__card-title">واجهة الموقع</span><span class="admin-home__card-desc">تعديل محتوى القسم الرئيسي</span><span class="admin-home__card-link">فتح القسم <span aria-hidden="true">←</span></span>
                </a>
                <a class="admin-home__card" href="{{ route('admin.faq.index') }}">
                    <span class="admin-home__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M21 11.5a8.5 8.5 0 0 1-12.6 7.4L3 20l1.1-5.4A8.5 8.5 0 1 1 21 11.5Z" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.5 9a2.5 2.5 0 0 1 5 0c0 1.5-2.5 1.8-2.5 3.5M12 15.5h.01" stroke-linecap="round"/></svg></span>
                    <span class="admin-home__card-title">الأسئلة الشائعة</span><span class="admin-home__card-desc">إدارة الأسئلة والإجابات</span><span class="admin-home__card-link">فتح القسم <span aria-hidden="true">←</span></span>
                </a>
            </div>
        </section>

        <div class="admin-home__bottom">
            <section class="admin-home__content-panel" aria-labelledby="dashboard-content">
                <div class="admin-home__panel-head">
                    <div><span class="admin-home__eyebrow admin-home__eyebrow--dark">إدارة المحتوى</span><h2 id="dashboard-content">أقسام الموقع</h2><p>حدّث معلومات الموقع ومحتواه بسهولة.</p></div>
                    <span class="admin-home__panel-mark" aria-hidden="true">✦</span>
                </div>
                <div class="admin-home__links">
                    <a href="{{ route('admin.services.edit') }}"><span class="admin-home__link-icon" aria-hidden="true">✧</span><span><strong>الخدمات</strong><small>إدارة الخدمات المعروضة</small></span><span class="admin-home__link-arrow" aria-hidden="true">←</span></a>
                    <a href="{{ route('admin.about.edit') }}"><span class="admin-home__link-icon" aria-hidden="true">◉</span><span><strong>قسم من أنا</strong><small>تحديث معلومات التعريف</small></span><span class="admin-home__link-arrow" aria-hidden="true">←</span></a>
                    <a href="{{ route('admin.contact.edit') }}"><span class="admin-home__link-icon" aria-hidden="true">✉</span><span><strong>بيانات التواصل</strong><small>إدارة معلومات التواصل</small></span><span class="admin-home__link-arrow" aria-hidden="true">←</span></a>
                </div>
            </section>
            <section class="admin-home__guide" aria-labelledby="dashboard-guide">
                <span class="admin-home__guide-label">ALMOTAIRY REAL ESTATE</span>
                <div class="admin-home__guide-symbol" aria-hidden="true"><svg viewBox="0 0 80 80" fill="none"><path d="M10 67V31L29 12v55M29 30l15-10v47M44 42l18-10v35M4 67h70" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg></div>
                <h2 id="dashboard-guide">موقعك بين يديك</h2>
                <p>استخدم القائمة الجانبية للوصول إلى جميع أقسام لوحة التحكم وإدارة محتوى الموقع.</p>
                <a href="{{ route('front.home') }}" target="_blank" rel="noopener noreferrer">عرض الموقع <span aria-hidden="true">↗</span></a>
            </section>
        </div>
    </div>
@endsection
