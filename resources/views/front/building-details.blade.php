@php
    $lang = session('locale', 'ar');
    $isArabic = $lang === 'ar';
    $title = $isArabic ? $property->name_ar : $property->name_en;
    $location = $isArabic ? ($property->location_ar ?: $property->area_ar) : ($property->location_en ?: $property->area_en);
    $description = $isArabic ? $property->description_ar : $property->description_en;
    $buildingImages = array_values(array_filter([$property->image_1, $property->image_2, $property->image_3, $property->image_4]));
@endphp

@extends('front.layouts.app')

@section('title', $title.' | '.($isArabic ? 'شقق العمارة' : 'Building apartments'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/building-details.css') }}?v={{ file_exists(public_path('front/css/building-details.css')) ? filemtime(public_path('front/css/building-details.css')) : '1' }}">
@endpush

@section('content')
<section class="building-hero">
    <div class="building-shell building-hero__grid">
        <div class="building-hero__copy">
            <span class="building-eyebrow"><i class="fa-solid fa-building" aria-hidden="true"></i> {{ $isArabic ? 'عمارة سكنية' : 'Residential building' }}</span>
            <h1>{{ $title }}</h1>
            @if($location)<p class="building-hero__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $location }}</p>@endif
            @if($description)<p class="building-hero__description">{{ \Illuminate\Support\Str::limit(strip_tags($description), 240) }}</p>@endif
            <div class="building-hero__actions">
                <a href="#building-units" class="building-button building-button--primary">{{ $isArabic ? 'تصفح الشقق' : 'Browse apartments' }} <i class="fa-solid fa-arrow-down" aria-hidden="true"></i></a>
                <button type="button" class="building-button building-button--light" data-lead-open data-lead-property-id="{{ $property->id }}" data-lead-location="{{ $location }}" data-lead-category-id="{{ $property->category_id }}">{{ $isArabic ? 'اسأل عن العمارة' : 'Ask about this building' }}</button>
            </div>
        </div>
        <div class="building-hero__gallery">
            @if($buildingImages)
                <img class="building-hero__main-image" src="{{ asset('storage/'.$buildingImages[0]) }}" alt="{{ $title }}" fetchpriority="high">
                @if(count($buildingImages) > 1)
                    <div class="building-hero__thumbnails">
                        @foreach(array_slice($buildingImages, 1, 2) as $image)
                            <img src="{{ asset('storage/'.$image) }}" alt="{{ $title }}" loading="lazy">
                        @endforeach
                    </div>
                @endif
            @else
                <div class="building-hero__placeholder"><i class="fa-regular fa-image" aria-hidden="true"></i><span>{{ $isArabic ? 'صور العمارة ستظهر هنا' : 'Building photos will appear here' }}</span></div>
            @endif
            <div class="building-hero__unit-count"><strong>{{ $property->units->count() }}</strong><span>{{ $isArabic ? 'شقة متاحة' : 'apartments' }}</span></div>
        </div>
    </div>
</section>

<section class="building-units" id="building-units">
    <div class="building-shell">
        <div class="building-section-heading">
            <div><span class="building-eyebrow building-eyebrow--dark">{{ $isArabic ? 'اختر وحدتك' : 'FIND YOUR HOME' }}</span><h2>{{ $isArabic ? 'الشقق المتاحة في العمارة' : 'Apartments in this building' }}</h2><p>{{ $isArabic ? 'استعرض تفاصيل كل شقة وتواصل معنا لحجز معاينة.' : 'Compare apartment details and contact us to arrange a viewing.' }}</p></div>
            <span class="building-units-total">{{ $property->units->count() }} {{ $isArabic ? 'وحدة' : 'units' }}</span>
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
                            @if($unitImage)<img src="{{ asset('storage/'.$unitImage) }}" alt="{{ $unitTitle }}" loading="lazy">@else<div class="building-unit-card__placeholder"><i class="fa-solid fa-house" aria-hidden="true"></i></div>@endif
                            <span>{{ $isArabic ? 'شقة' : 'Apartment' }}</span>
                        </a>
                        <div class="building-unit-card__body">
                            <div class="building-unit-card__heading"><h3><a href="{{ route('front.property.details', $unit) }}">{{ $unitTitle }}</a></h3>@if($unitArea)<span>{{ $unitArea }}</span>@endif</div>
                            @if($unitLocation)<p class="building-unit-card__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $unitLocation }}</p>@endif
                            @if($unitPayment)<p class="building-unit-card__payment">{{ $unitPayment }}</p>@endif
                            @if($unitFeatures)<ul class="building-unit-card__features">@foreach($unitFeatures as $feature)<li><i class="fa-solid fa-check" aria-hidden="true"></i>{{ $feature }}</li>@endforeach</ul>@endif
                            <div class="building-unit-card__actions">
                                <a href="{{ route('front.property.details', $unit) }}">{{ $isArabic ? 'تفاصيل الشقة' : 'Apartment details' }} <i class="fa-solid fa-arrow-left" aria-hidden="true"></i></a>
                                <button type="button" data-lead-open data-lead-property-id="{{ $unit->id }}" data-lead-location="{{ $unitLocation }}" data-lead-category-id="{{ $unit->category_id }}" data-lead-area="{{ preg_replace('/[^0-9.]/', '', (string) $unitArea) }}" aria-label="{{ $isArabic ? 'احجز معاينة' : 'Book a viewing' }}: {{ $unitTitle }}"><i class="fa-regular fa-calendar-check" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="building-units-empty"><i class="fa-regular fa-building" aria-hidden="true"></i><h3>{{ $isArabic ? 'الشقق لم تُضف بعد' : 'Apartments are coming soon' }}</h3><p>{{ $isArabic ? 'تواصل معنا وسنساعدك في معرفة الوحدات المتاحة.' : 'Contact us and we will help you find an available unit.' }}</p><button type="button" data-lead-open data-lead-property-id="{{ $property->id }}" data-lead-location="{{ $location }}" data-lead-category-id="{{ $property->category_id }}">{{ $isArabic ? 'تواصل معنا' : 'Contact us' }}</button></div>
        @endif
    </div>
</section>
@endsection
