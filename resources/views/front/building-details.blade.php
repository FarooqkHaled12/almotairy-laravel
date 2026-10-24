@php
    $lang = session('locale', 'ar');
    $isArabic = $lang === 'ar';
    $title = $isArabic ? $property->name_ar : $property->name_en;
    $location = $isArabic ? ($property->location_ar ?: $property->area_ar) : ($property->location_en ?: $property->area_en);
    $description = $isArabic ? $property->description_ar : $property->description_en;
    $featureList = array_values(array_filter($isArabic ? ($property->features_ar ?? []) : ($property->features_en ?? [])));
    $galleryImages = collect([$property->image_1, $property->image_2, $property->image_3, $property->image_4])
        ->merge($property->units->flatMap(fn ($unit) => [$unit->image_1, $unit->image_2, $unit->image_3, $unit->image_4]))
        ->filter()
        ->unique()
        ->values()
        ->all();
    $fallbackImage = asset('front/img/home-hero-building.png');
    $imageUrl = static fn ($image) => $image ? asset('storage/'.$image) : $fallbackImage;
    $heroImage = $imageUrl($galleryImages[0] ?? null);
    $unitsCount = $property->units->count();
    $galleryCount = count($galleryImages);
    $defaultFeatures = $isArabic
        ? ['مدخل عصري', 'مصعد حديث', 'موقف سيارات خاص', 'أمن وحراسة', 'تشطيبات عالية الجودة', 'موقع مميز']
        : ['Modern entrance', 'Modern elevator', 'Private parking', '24/7 security', 'High quality finishing', 'Prime location'];
    $overviewFeatures = array_slice($featureList ?: $defaultFeatures, 0, 6);
@endphp

@extends('front.layouts.app')

@section('title', $title.' | '.($isArabic ? 'شقق العمارة' : 'Building apartments'))
@section('body-class', 'building-details-page')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/css/building-details.css') }}?v={{ file_exists(public_path('front/css/building-details.css')) ? filemtime(public_path('front/css/building-details.css')) : '1' }}">
@endpush

@section('content')
<section class="building-hero" style="--building-hero-image:url('{{ $heroImage }}')">
    <div class="building-shell building-hero__grid">
        <div class="building-hero__copy">
            <span class="building-availability"><i class="fa-solid fa-circle" aria-hidden="true"></i> {{ $isArabic ? 'وحدات متاحة' : 'Available Units' }}</span>
            <h1>{{ $title }}</h1>
            @if($location)
                <p class="building-hero__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $location }}</p>
            @endif
            @if($description)
                <p class="building-hero__description">{{ \Illuminate\Support\Str::limit(strip_tags($description), 200) }}</p>
            @endif

            <div class="building-highlights" aria-label="{{ $isArabic ? 'مميزات العمارة' : 'Building highlights' }}">
                <div class="building-highlight"><i class="fa-regular fa-building" aria-hidden="true"></i><span><strong>{{ $unitsCount }}</strong><small>{{ $isArabic ? 'إجمالي الوحدات' : 'Total Units' }}</small></span></div>
                <div class="building-highlight"><i class="fa-regular fa-house" aria-hidden="true"></i><span><strong>{{ $unitsCount }}</strong><small>{{ $isArabic ? 'وحدات متاحة' : 'Available Units' }}</small></span></div>
                <div class="building-highlight"><i class="fa-solid fa-sliders" aria-hidden="true"></i><span><strong>{{ $isArabic ? 'جاهز' : 'Ready' }}</strong><small>{{ $isArabic ? 'للسكن' : 'To Move' }}</small></span></div>
                <div class="building-highlight"><i class="fa-solid fa-square-parking" aria-hidden="true"></i><span><strong>{{ $isArabic ? 'موقف' : 'Parking' }}</strong><small>{{ $isArabic ? 'متاح' : 'Available' }}</small></span></div>
            </div>

            <div class="building-hero__actions">
                <button type="button" class="building-button building-button--primary" data-lead-open data-lead-property-id="{{ $property->id }}" data-lead-location="{{ $location }}" data-lead-category-id="{{ $property->category_id }}"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i>{{ $isArabic ? 'تواصل عبر واتساب' : 'Contact on WhatsApp' }}<i class="fa-solid fa-arrow-{{ $isArabic ? 'left' : 'right' }}" aria-hidden="true"></i></button>
                <a href="#building-location" class="building-button building-button--outline"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>{{ $isArabic ? 'عرض الموقع' : 'View Location' }}<i class="fa-solid fa-arrow-{{ $isArabic ? 'left' : 'right' }}" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="building-gallery" data-building-gallery data-images='@json(array_map($imageUrl, $galleryImages ?: [null]))'>
            <div class="building-gallery__main">
                <img src="{{ $heroImage }}" alt="{{ $title }}" fetchpriority="high" data-gallery-main>
                <button class="building-gallery__arrow building-gallery__arrow--previous" type="button" aria-label="{{ $isArabic ? 'الصورة السابقة' : 'Previous photo' }}" data-gallery-previous><i class="fa-solid fa-arrow-{{ $isArabic ? 'right' : 'left' }}" aria-hidden="true"></i></button>
                <button class="building-gallery__arrow building-gallery__arrow--next" type="button" aria-label="{{ $isArabic ? 'الصورة التالية' : 'Next photo' }}" data-gallery-next><i class="fa-solid fa-arrow-{{ $isArabic ? 'left' : 'right' }}" aria-hidden="true"></i></button>
                <span class="building-gallery__counter" data-gallery-counter>1/{{ max($galleryCount, 1) }}</span>
            </div>
            <div class="building-gallery__thumbnails" aria-label="{{ $isArabic ? 'صور العمارة' : 'Building photos' }}">
                @foreach(array_slice($galleryImages ?: [null], 0, 4) as $index => $image)
                    <button type="button" class="building-gallery__thumbnail{{ $index === 0 ? ' is-active' : '' }}" data-gallery-thumbnail data-index="{{ $index }}" aria-label="{{ $isArabic ? 'عرض الصورة' : 'View photo' }} {{ $index + 1 }}"><img src="{{ $imageUrl($image) }}" alt="{{ $title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}"></button>
                @endforeach
                @if($galleryCount > 4)
                    <button type="button" class="building-gallery__more" data-gallery-more><strong>+{{ $galleryCount - 4 }}</strong><span>{{ $isArabic ? 'صور إضافية' : 'More Photos' }}</span></button>
                @endif
            </div>
        </div>
    </div>
</section>

<nav class="building-section-nav" aria-label="{{ $isArabic ? 'أقسام صفحة العمارة' : 'Building page sections' }}">
    <div class="building-shell">
        <a href="#building-overview" class="is-active"><i class="fa-regular fa-house" aria-hidden="true"></i>{{ $isArabic ? 'نظرة عامة' : 'Overview' }}</a>
        <a href="#building-units"><i class="fa-regular fa-building" aria-hidden="true"></i>{{ $isArabic ? 'الشقق المتاحة' : 'Available Apartments' }}</a>
        <a href="#building-gallery"><i class="fa-regular fa-images" aria-hidden="true"></i>{{ $isArabic ? 'الصور' : 'Gallery' }}</a>
        <a href="#building-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>{{ $isArabic ? 'الموقع' : 'Location' }}</a>
    </div>
</nav>

<section class="building-overview" id="building-overview">
    <div class="building-shell building-overview__grid">
        <div class="building-overview__content">
            <span class="building-kicker">{{ $isArabic ? 'عن العمارة' : 'ABOUT THE BUILDING' }}</span>
            <h2>{{ $isArabic ? 'عن '.$title : 'About '.$title }}</h2>
            <p>{{ $description ?: ($isArabic ? 'عمارة سكنية مميزة صُممت لتجمع بين الراحة والموقع المناسب والتشطيبات العملية.' : 'A distinctive residential building created for comfortable living, a convenient location, and practical finishes.') }}</p>
            <div class="building-overview__stats">
                <span><i class="fa-solid fa-check" aria-hidden="true"></i>{{ $isArabic ? 'موقع متميز' : 'Prime location' }}</span>
                <span><i class="fa-solid fa-check" aria-hidden="true"></i>{{ $isArabic ? 'تصميم عصري' : 'Modern design' }}</span>
                <span><i class="fa-solid fa-check" aria-hidden="true"></i>{{ $isArabic ? 'وحدات متنوعة' : 'Varied unit sizes' }}</span>
                <span><i class="fa-solid fa-check" aria-hidden="true"></i>{{ $isArabic ? 'تشطيبات جيدة' : 'Quality finishes' }}</span>
            </div>
        </div>
        <img class="building-overview__image" src="{{ $imageUrl($galleryImages[1] ?? $galleryImages[0] ?? null) }}" alt="{{ $title }}" loading="lazy">
        <aside class="building-feature-card">
            <h3><i class="fa-regular fa-building" aria-hidden="true"></i>{{ $isArabic ? 'مميزات العمارة' : 'Building Features' }}</h3>
            <ul>@foreach($overviewFeatures as $feature)<li><i class="fa-solid fa-check" aria-hidden="true"></i>{{ $feature }}</li>@endforeach</ul>
        </aside>
    </div>
</section>

<section class="building-units" id="building-units">
    <div class="building-shell">
        <div class="building-section-heading">
            <div><span class="building-kicker">{{ $isArabic ? 'اختر وحدتك' : 'AVAILABLE APARTMENTS' }}</span><h2>{{ $isArabic ? 'الشقق المتاحة' : 'Available Apartments' }}</h2><p>{{ $isArabic ? 'اختر الوحدة المناسبة وتواصل معنا لحجز المعاينة.' : 'Choose your preferred unit and contact us to arrange a viewing.' }}</p></div>
            <span class="building-units-total"><strong>{{ $unitsCount }}</strong> {{ $isArabic ? 'وحدة متاحة' : 'Units Available' }}</span>
        </div>

        @if($property->units->isNotEmpty())
            <div class="building-unit-grid">
                @foreach($property->units as $unit)
                    @php
                        $unitTitle = $isArabic ? $unit->name_ar : $unit->name_en;
                        $unitArea = $isArabic ? $unit->area_ar : $unit->area_en;
                        $unitLocation = $isArabic ? ($unit->location_ar ?: $location) : ($unit->location_en ?: $location);
                        $unitPayment = $isArabic ? $unit->payment_system_ar : $unit->payment_system_en;
                        $unitFeatures = array_slice(array_filter($isArabic ? ($unit->features_ar ?? []) : ($unit->features_en ?? [])), 0, 3);
                        $unitImage = $unit->image_1 ?: $property->image_1;
                    @endphp
                    <article class="building-unit-card">
                        <a class="building-unit-card__image" href="{{ route('front.property.details', $unit) }}">
                            <img src="{{ $imageUrl($unitImage) }}" alt="{{ $unitTitle }}" loading="lazy">
                            <span>{{ $isArabic ? 'متاحة' : 'Available' }}</span>
                        </a>
                        <div class="building-unit-card__body">
                            <h3><a href="{{ route('front.property.details', $unit) }}">{{ $unitTitle }}</a></h3>
                            @if($unitLocation)<p class="building-unit-card__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $unitLocation }}</p>@endif
                            <div class="building-unit-card__details">
                                @if($unitArea)<span><i class="fa-regular fa-square" aria-hidden="true"></i>{{ $unitArea }}</span>@endif
                                @foreach($unitFeatures as $feature)<span><i class="fa-solid fa-check" aria-hidden="true"></i>{{ $feature }}</span>@endforeach
                            </div>
                            @if($unitPayment)<p class="building-unit-card__payment">{{ $unitPayment }}</p>@endif
                            <div class="building-unit-card__actions">
                                <a href="{{ route('front.property.details', $unit) }}">{{ $isArabic ? 'تفاصيل الشقة' : 'View Details' }} <i class="fa-solid fa-arrow-{{ $isArabic ? 'left' : 'right' }}" aria-hidden="true"></i></a>
                                <button type="button" data-lead-open data-lead-property-id="{{ $unit->id }}" data-lead-location="{{ $unitLocation }}" data-lead-category-id="{{ $unit->category_id }}" data-lead-area="{{ preg_replace('/[^0-9.]/', '', (string) $unitArea) }}"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i>{{ $isArabic ? 'استفسر' : 'Inquire' }}</button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="building-units-empty"><i class="fa-regular fa-building" aria-hidden="true"></i><h3>{{ $isArabic ? 'الشقق ستتوفر قريباً' : 'Apartments are coming soon' }}</h3><p>{{ $isArabic ? 'تواصل معنا لمعرفة الوحدات المتاحة في هذه العمارة.' : 'Contact us to learn about upcoming apartments in this building.' }}</p><button type="button" data-lead-open data-lead-property-id="{{ $property->id }}" data-lead-location="{{ $location }}" data-lead-category-id="{{ $property->category_id }}">{{ $isArabic ? 'تواصل معنا' : 'Contact us' }}</button></div>
        @endif
    </div>
</section>

<section class="building-photo-section" id="building-gallery">
    <div class="building-shell">
        <div class="building-section-heading"><div><span class="building-kicker">{{ $isArabic ? 'معرض الصور' : 'PHOTO GALLERY' }}</span><h2>{{ $isArabic ? 'اكتشف '.$title : 'Discover '.$title }}</h2></div></div>
        <div class="building-photo-grid">
            @foreach(array_slice($galleryImages ?: [null], 0, 5) as $index => $image)
                <button type="button" data-gallery-jump="{{ $index }}"><img src="{{ $imageUrl($image) }}" alt="{{ $title }}" loading="lazy"></button>
            @endforeach
        </div>
    </div>
</section>

<section class="building-location" id="building-location">
    <div class="building-shell building-location__card">
        <div><span class="building-kicker">{{ $isArabic ? 'الموقع والمحيط' : 'LOCATION & SURROUNDINGS' }}</span><h2>{{ $location ?: ($isArabic ? 'موقع مميز' : 'A prime location') }}</h2><p>{{ $isArabic ? 'تواصل معنا لمعرفة تفاصيل الموقع وحجز معاينة للعمارة أو للشقق المتاحة.' : 'Contact us for the exact location and to arrange a viewing of the building or available apartments.' }}</p></div>
        <button type="button" class="building-button building-button--primary" data-lead-open data-lead-property-id="{{ $property->id }}" data-lead-location="{{ $location }}" data-lead-category-id="{{ $property->category_id }}"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i>{{ $isArabic ? 'تواصل على واتساب' : 'Chat on WhatsApp' }}</button>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const gallery = document.querySelector('[data-building-gallery]');
    if (!gallery) return;
    const images = JSON.parse(gallery.dataset.images || '[]');
    const main = gallery.querySelector('[data-gallery-main]');
    const counter = gallery.querySelector('[data-gallery-counter]');
    const thumbnails = gallery.querySelectorAll('[data-gallery-thumbnail]');
    let current = 0;
    const showImage = function (index) {
        if (!images.length) return;
        current = (index + images.length) % images.length;
        main.src = images[current];
        counter.textContent = (current + 1) + '/' + images.length;
        thumbnails.forEach(function (thumbnail) { thumbnail.classList.toggle('is-active', Number(thumbnail.dataset.index) === current); });
    };
    gallery.querySelector('[data-gallery-previous]').addEventListener('click', function () { showImage(current - 1); });
    gallery.querySelector('[data-gallery-next]').addEventListener('click', function () { showImage(current + 1); });
    thumbnails.forEach(function (thumbnail) { thumbnail.addEventListener('click', function () { showImage(Number(thumbnail.dataset.index)); }); });
    document.querySelectorAll('[data-gallery-jump]').forEach(function (button) { button.addEventListener('click', function () { showImage(Number(button.dataset.galleryJump)); document.querySelector('.building-hero').scrollIntoView({ behavior: 'smooth', block: 'start' }); }); });
    const navLinks = document.querySelectorAll('.building-section-nav a');
    navLinks.forEach(function (link) { link.addEventListener('click', function () { navLinks.forEach(function (item) { item.classList.remove('is-active'); }); link.classList.add('is-active'); }); });
});
</script>
@endpush
