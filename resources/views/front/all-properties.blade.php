@php
    use App\Models\Property;
    use App\Models\PropertyCategory;
    $lang = session('locale', 'ar');
    $categories = PropertyCategory::orderBy('id')->get();
    $apartmentsOnly = request('type') === 'apartments';
    $properties = Property::with(['category', 'building'])->withCount('units')
        ->when($apartmentsOnly, fn ($query) => $query->whereNotNull('building_id'))
        ->when(!$apartmentsOnly, fn ($query) => $query->whereNull('building_id'))
        ->latest()
        ->get();
    $pageTitle = $apartmentsOnly
        ? ($lang === 'ar' ? 'كل الشقق | المطيري للعقارات' : 'All Apartments | Almotairy Real Estate')
        : ($lang === 'ar' ? 'جميع العقارات | المطيري للعقارات' : 'All Properties | Almotairy Real Estate');
    $heroTitle = $apartmentsOnly
        ? ($lang === 'ar' ? 'اعثر على شقتك المناسبة' : 'Find Your Ideal Apartment')
        : ($lang === 'ar' ? 'اعثر على عقارك المناسب' : 'Find Your Ideal Property');
    $sectionTitle = $apartmentsOnly
        ? ($lang === 'ar' ? 'الشقق المتاحة' : 'Explore Available Apartments')
        : ($lang === 'ar' ? 'العقارات المتاحة' : 'Explore Available Properties');
    $heroImage = $properties->first(fn ($property) => $property->image_1);
    $listingContact = \App\Models\ContactInfo::first();
    $areaValueFor = static function ($value) {
        $digits = ['٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9', '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'];
        $areaText = strtr((string) $value, $digits);
        return preg_match('/\d+(?:[.,]\d+)?/u', str_replace(',', '.', $areaText), $matches) ? (int) round((float) $matches[0]) : '';
    };
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $lang === 'ar' ? 'تصفح العقارات المتاحة لدى المطيري للعقارات.' : 'Browse available properties from Almotairy Real Estate.' }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/all-properties.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/shared-layout.css') }}?v={{ file_exists(public_path('front/css/shared-layout.css')) ? filemtime(public_path('front/css/shared-layout.css')) : '1' }}">
</head>
<body class="all-properties-page">
@include('front.layouts.header')
<main>
    <section class="listing-hero" @if($heroImage) style="--listing-hero-image: url('{{ asset('storage/'.$heroImage->image_1) }}')" @endif>
        <div class="listing-container listing-hero__content">
            <nav class="listing-breadcrumb" aria-label="{{ $lang === 'ar' ? 'مسار الصفحة' : 'Breadcrumb' }}"><a href="{{ route('front.home') }}">{{ $lang === 'ar' ? 'الرئيسية' : 'Home' }}</a><span aria-hidden="true">/</span><span aria-current="page">{{ $lang === 'ar' ? 'العقارات' : 'Properties' }}</span></nav>
            <div class="listing-hero__layout"><div class="listing-hero__copy">
            <span class="listing-eyebrow">{{ $lang === 'ar' ? 'المطيري للعقارات' : 'ALMOTAIRY REAL ESTATE' }}</span>
            <h1>{{ $heroTitle }}</h1>
            <p>{{ $lang === 'ar' ? 'اكتشف العقارات المتاحة واختر ما يناسب احتياجاتك.' : 'Explore available properties and find the right fit for you.' }}</p>
            <a class="listing-hero__browse" href="#listing-heading">{{ $lang === 'ar' ? 'تصفح العقارات' : 'Browse properties' }} <span aria-hidden="true">{{ $lang === 'ar' ? '←' : '→' }}</span></a>
            </div><div class="listing-hero__summary"><span class="listing-hero__summary-icon"><i class="fa-regular fa-building" aria-hidden="true"></i></span><strong>{{ $properties->count() }}</strong><span>{{ $lang === 'ar' ? 'عقار متاح للاستكشاف' : 'properties to explore' }}</span></div></div>
        </div>
    </section>

    <section class="listing-content" aria-labelledby="listing-heading">
        <div class="listing-container">
            <form class="listing-search" id="propertySearch">
                <div class="listing-search__intro"><span class="listing-search__intro-icon"><i class="fa-solid fa-sliders" aria-hidden="true"></i></span><div><strong>{{ $lang === 'ar' ? 'ابدأ البحث' : 'Find your property' }}</strong><small>{{ $lang === 'ar' ? 'اختر ما يناسبك' : 'Explore your options' }}</small></div></div>
                <div class="listing-search__field">
                    <label for="locationSearch">{{ $lang === 'ar' ? 'الموقع' : 'Location' }}</label>
                    <div class="listing-search__input"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><input id="locationSearch" type="search" value="{{ request('q') }}" placeholder="{{ $lang === 'ar' ? 'ابحث عن موقع' : 'Search location' }}"></div>
                </div>
                <div class="listing-search__field">
                    <label for="categorySearch">{{ $lang === 'ar' ? 'التصنيف' : 'Category' }}</label>
                    <select id="categorySearch">
                        <option value="all">{{ $lang === 'ar' ? 'جميع التصنيفات' : 'All categories' }}</option>
                        @foreach($categories as $category)
                            <option value="cat-{{ $category->id }}">{{ $lang === 'ar' ? $category->name_ar : $category->name_en }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="listing-search__field listing-search__area">
                    <label>{{ $lang === 'ar' ? 'المساحة (م²)' : 'Area (sqm)' }}</label>
                    <div class="listing-search__area-inputs">
                        <input id="areaMin" type="number" min="0" inputmode="numeric" aria-label="{{ $lang === 'ar' ? 'أقل مساحة' : 'Minimum area' }}" placeholder="{{ $lang === 'ar' ? 'من' : 'Min' }}">
                        <input id="areaMax" type="number" min="0" inputmode="numeric" aria-label="{{ $lang === 'ar' ? 'أقصى مساحة' : 'Maximum area' }}" placeholder="{{ $lang === 'ar' ? 'إلى' : 'Max' }}">
                    </div>
                </div>
                <button class="listing-search__submit" type="submit"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> {{ $lang === 'ar' ? 'بحث عن عقار' : 'Search properties' }}</button>
            </form>

            <div class="listing-heading">
                <div><span class="listing-eyebrow listing-eyebrow--dark">{{ $apartmentsOnly ? ($lang === 'ar' ? 'شققنا' : 'OUR APARTMENTS') : ($lang === 'ar' ? 'عقاراتنا' : 'OUR PROPERTIES') }}</span><h2 id="listing-heading">{{ $sectionTitle }}</h2><p>{{ $apartmentsOnly ? ($lang === 'ar' ? 'تصفح الشقق المتاحة واختر الوحدة المناسبة لك.' : 'Browse available apartments and choose the right unit for you.') : ($lang === 'ar' ? 'تصفح العقارات واختر التصنيف المناسب لك.' : 'Browse our properties and choose the category that suits you.') }}</p></div>
                <p class="listing-count" aria-live="polite">{{ $lang === 'ar' ? 'عرض' : 'Showing' }} <strong id="resultCount">{{ $properties->count() }}</strong> {{ $lang === 'ar' ? 'عقار' : 'properties' }}</p>
            </div>
            <div class="listing-filter-bar"><div class="listing-filters" role="group" aria-label="{{ $lang === 'ar' ? 'تصفية حسب التصنيف' : 'Filter by category' }}">
                <button type="button" class="listing-filter active" data-category="all" aria-pressed="true">{{ $lang === 'ar' ? 'الكل' : 'All' }} <span>{{ $properties->count() }}</span></button>
                @foreach($categories as $category)
                    <button type="button" class="listing-filter" data-category="cat-{{ $category->id }}" aria-pressed="false">{{ $lang === 'ar' ? $category->name_ar : $category->name_en }} <span>{{ $properties->where('category_id', $category->id)->count() }}</span></button>
                @endforeach
            </div><div class="listing-display-controls"><button class="listing-reset" id="resetFilters" type="button" hidden><i class="fa-solid fa-rotate-right" aria-hidden="true"></i> {{ $lang === 'ar' ? 'مسح الفلاتر' : 'Clear filters' }}</button><div class="listing-sort"><label for="propertySort">{{ $lang === 'ar' ? 'الترتيب' : 'Sort' }}</label><select id="propertySort" aria-controls="propertyGrid"><option value="newest">{{ $lang === 'ar' ? 'الأحدث أولًا' : 'Newest first' }}</option><option value="oldest">{{ $lang === 'ar' ? 'الأقدم أولًا' : 'Oldest first' }}</option></select></div><div class="listing-view-switch" role="group" aria-label="{{ $lang === 'ar' ? 'طريقة عرض العقارات' : 'Property display' }}"><button type="button" class="listing-view-switch__button is-active" data-listing-view="grid" aria-controls="propertyGrid" aria-pressed="true" aria-label="{{ $lang === 'ar' ? 'عرض شبكي' : 'Grid view' }}"><i class="fa-solid fa-border-all" aria-hidden="true"></i></button><button type="button" class="listing-view-switch__button" data-listing-view="list" aria-controls="propertyGrid" aria-pressed="false" aria-label="{{ $lang === 'ar' ? 'عرض قائمة' : 'List view' }}"><i class="fa-solid fa-list" aria-hidden="true"></i></button></div></div></div>
            <div class="listing-match-banner" id="listingMatchBanner" hidden aria-live="polite" data-match-text="{{ $lang === 'ar' ? 'وجدنا :count عقارًا يناسب اختياراتك.' : 'We found :count properties matching your preferences.' }}" data-no-match-text="{{ $lang === 'ar' ? 'لا يوجد تطابق كامل الآن. أرسل تفضيلاتك وسنساعدك في إيجاد بدائل مناسبة.' : 'No exact match right now. Share your preferences and we will help find alternatives.' }}">
                <span class="listing-match-banner__icon"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i></span>
                <p id="listingMatchMessage"></p>
                <button type="button" data-lead-open data-lead-save-search><i class="fa-regular fa-paper-plane" aria-hidden="true"></i> {{ $lang === 'ar' ? 'أرسل احتياجاتي للمستشار' : 'Share my preferences' }}</button>
            </div>
            <div class="listing-grid" id="propertyGrid">
                @foreach($properties as $property)
                    @php
                        $title = $lang === 'ar' ? $property->name_ar : $property->name_en;
                        $location = $lang === 'ar' ? $property->location_ar : $property->location_en;
                        $area = $lang === 'ar' ? $property->area_ar : $property->area_en;
                        $areaValue = $areaValueFor($area);
                        $payment = $lang === 'ar' ? $property->payment_system_ar : $property->payment_system_en;
                        $features = array_values(array_filter($lang === 'ar' ? ($property->features_ar ?? []) : ($property->features_en ?? []), fn ($feature) => is_string($feature) && trim($feature) !== ''));
                        $categoryName = $property->category ? ($lang === 'ar' ? $property->category->name_ar : $property->category->name_en) : null;
                        $description = $lang === 'ar' ? $property->description_ar : $property->description_en;
                        $cardImages = array_values(array_filter([$property->image_1, $property->image_2, $property->image_3, $property->image_4]));
                    @endphp
                    <article class="listing-card" data-category="{{ $property->category_id ? 'cat-'.$property->category_id : 'cat-none' }}" data-location="{{ $location }} {{ $title }}" data-area="{{ $areaValue }}">
                        <div class="listing-card__gallery">
                        <a class="listing-card__image" href="{{ route('front.property.details', $property->id) }}" aria-label="{{ $title }}">
                            @forelse($cardImages as $cardImage)<img src="{{ asset('storage/'.$cardImage) }}" alt="{{ $title }}" loading="lazy" @if(!$loop->first) hidden @endif>@empty<span class="listing-card__no-image" aria-hidden="true"><i class="fa-regular fa-image"></i></span>@endforelse
                            @if($categoryName)<span class="listing-card__badge">{{ $categoryName }}</span>@endif
                        </a>
                        @if(count($cardImages) > 1)<div class="listing-card__gallery-controls" hidden><button type="button" data-gallery-step="-1" aria-label="{{ $lang === 'ar' ? 'الصورة السابقة' : 'Previous image' }}"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></button><span class="listing-card__gallery-count" aria-live="polite" aria-atomic="true">1 / {{ count($cardImages) }}</span><button type="button" data-gallery-step="1" aria-label="{{ $lang === 'ar' ? 'الصورة التالية' : 'Next image' }}"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button></div>@endif
                        @if(count($cardImages) > 1)<div class="listing-card__gallery-dots" role="group" aria-label="{{ $lang === 'ar' ? 'اختر صورة العقار' : 'Choose property image' }}" hidden>@foreach($cardImages as $cardImage)<button type="button" data-gallery-index="{{ $loop->index }}" aria-label="{{ $lang === 'ar' ? 'صورة' : 'Image' }} {{ $loop->iteration }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}"></button>@endforeach</div>@endif
                        </div>
                        <div class="listing-card__body">
                            <div class="listing-card__heading"><h3><a href="{{ route('front.property.details', $property->id) }}">{{ $title }}</a></h3>
                            @if($location)<p class="listing-card__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $location }}</p>@endif</div>
                            @if($property->is_building)<p class="listing-card__building-meta"><i class="fa-solid fa-building" aria-hidden="true"></i> {{ $property->units_count }} {{ $lang === 'ar' ? 'شقة داخل العمارة' : 'apartments in this building' }}</p>@endif
                            @if($description && trim(strip_tags($description)))<p class="listing-card__description">{{ \Illuminate\Support\Str::limit(trim(strip_tags($description)), 105) }}</p>@endif
                            @if($payment)<p class="listing-card__payment"><span>{{ $lang === 'ar' ? 'نظام الدفع' : 'Payment' }}</span> {{ $payment }}</p>@endif
                            @if($area || count($features))<ul class="listing-card__features">@if($area)<li><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $area }}</li>@endif @foreach(array_slice($features, 0, 2) as $feature)<li><i class="fa-solid fa-check" aria-hidden="true"></i> {{ $feature }}</li>@endforeach</ul>@endif
                            <div class="listing-card__footer"><a class="listing-card__details" href="{{ route('front.property.details', $property->id) }}">{{ $lang === 'ar' ? 'تفاصيل العقار' : 'View details' }} <span aria-hidden="true">{{ $lang === 'ar' ? '←' : '→' }}</span></a><button class="listing-card__book" type="button" data-lead-open data-lead-property-id="{{ $property->id }}" data-lead-location="{{ $location }}" data-lead-category-id="{{ $property->category_id }}" data-lead-area="{{ $areaValue }}"><i class="fa-regular fa-calendar-check" aria-hidden="true"></i><span>{{ $lang === 'ar' ? 'حجز معاينة' : 'Book a viewing' }}</span></button>@if($property->phone)<a class="listing-card__call" href="tel:{{ $property->phone }}" aria-label="{{ $lang === 'ar' ? 'اتصل بخصوص' : 'Call about' }} {{ $title }}"><i class="fa-solid fa-phone" aria-hidden="true"></i><span>{{ $lang === 'ar' ? 'اتصال' : 'Call' }}</span></a>@endif @if($property->whatsapp)<a class="listing-card__whatsapp" href="https://wa.me/{{ $property->whatsapp }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp: {{ $title }}"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>@endif</div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="listing-empty" id="noResults" {{ $properties->isNotEmpty() ? 'hidden' : '' }}><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><h3>{{ $lang === 'ar' ? 'لا توجد عقارات تطابق اختيارك' : 'No properties match your search' }}</h3><p>{{ $lang === 'ar' ? 'جرّب تغيير البحث أو التصنيف.' : 'Try changing your search or category.' }}</p><button class="listing-empty__reset" type="button" id="resetEmpty">{{ $lang === 'ar' ? 'عرض كل العقارات' : 'View all properties' }}</button></div>

            @if($properties->isNotEmpty())
                @php
                    $latestProperty = $properties->first();
                    $latestTitle = $lang === 'ar' ? $latestProperty->name_ar : $latestProperty->name_en;
                    $latestLocation = $lang === 'ar' ? $latestProperty->location_ar : $latestProperty->location_en;
                    $latestDescription = $lang === 'ar' ? $latestProperty->description_ar : $latestProperty->description_en;
                    $latestArea = $lang === 'ar' ? $latestProperty->area_ar : $latestProperty->area_en;
                    $latestCategory = $latestProperty->category ? ($lang === 'ar' ? $latestProperty->category->name_ar : $latestProperty->category->name_en) : null;
                    $latestImages = array_values(array_filter([$latestProperty->image_1, $latestProperty->image_2, $latestProperty->image_3, $latestProperty->image_4]));
                @endphp
                <section class="listing-highlight {{ count($latestImages) ? '' : 'listing-highlight--no-image' }}" aria-labelledby="listing-highlight-title">
                    <div class="listing-highlight__copy">
                        <span class="listing-highlight__eyebrow">{{ $lang === 'ar' ? 'أحدث العقارات' : 'LATEST PROPERTY' }}</span>
                        <h2 id="listing-highlight-title">{{ $latestTitle }}</h2>
                        @if($latestLocation)<p class="listing-highlight__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $latestLocation }}</p>@endif
                        @if($latestDescription)<p class="listing-highlight__description">{{ \Illuminate\Support\Str::limit(strip_tags($latestDescription), 160) }}</p>@endif
                        <a class="listing-highlight__link" href="{{ route('front.property.details', $latestProperty->id) }}">{{ $lang === 'ar' ? 'اكتشف العقار' : 'Explore property' }} <span aria-hidden="true">{{ $lang === 'ar' ? '←' : '→' }}</span></a>
                        @if($latestCategory || $latestArea)<div class="listing-highlight__facts">@if($latestCategory)<span><i class="fa-regular fa-building" aria-hidden="true"></i> {{ $latestCategory }}</span>@endif @if($latestArea)<span><i class="fa-solid fa-ruler-combined" aria-hidden="true"></i> {{ $latestArea }}</span>@endif</div>@endif
                    </div>
                    @if(count($latestImages))
                        <div class="listing-highlight__gallery {{ count($latestImages) > 1 ? 'has-thumbnails' : '' }}">
                            <a class="listing-highlight__main-image" href="{{ route('front.property.details', $latestProperty->id) }}"><img src="{{ asset('storage/'.$latestImages[0]) }}" alt="{{ $latestTitle }}" loading="lazy"></a>
                            @if(count($latestImages) > 1)<div class="listing-highlight__thumbnails">@foreach(array_slice($latestImages, 1, 2) as $image)<a href="{{ route('front.property.details', $latestProperty->id) }}" aria-label="{{ $latestTitle }}"><img src="{{ asset('storage/'.$image) }}" alt="" loading="lazy"></a>@endforeach</div>@endif
                        </div>
                    @endif
                </section>
            @endif
            @php
                $locationField = $lang === 'ar' ? 'location_ar' : 'location_en';
                $locatedProperties = $properties->filter(fn ($item) => is_string($item->$locationField) && trim($item->$locationField) !== '');
                $availableLocations = $locatedProperties->map(fn ($item) => trim($item->$locationField))->unique()->values();
                $initialLocation = $availableLocations->first();
            @endphp
            @if($availableLocations->isNotEmpty())
                <section class="location-properties" aria-labelledby="location-properties-title">
                    <div class="location-properties__heading">
                        <span class="listing-eyebrow listing-eyebrow--dark">{{ $lang === 'ar' ? 'اكتشف المناطق' : 'EXPLORE LOCATIONS' }}</span>
                        <h2 id="location-properties-title">{{ $lang === 'ar' ? 'عقارات حسب الموقع' : 'Properties by location' }}</h2>
                        <p>{{ $lang === 'ar' ? 'اختر موقعًا لتصفح العقارات المتاحة فيه.' : 'Choose a location to explore available properties.' }}</p>
                    </div>
                    <div class="location-properties__toolbar">
                        <label for="propertyLocation">{{ $lang === 'ar' ? 'الموقع' : 'Location' }}</label>
                        <select id="propertyLocation">@foreach($availableLocations as $availableLocation)<option value="{{ $availableLocation }}">{{ $availableLocation }}</option>@endforeach</select>
                    </div>
                    <div class="location-properties__grid">
                        @foreach($locatedProperties as $locatedProperty)
                            @php
                                $locatedTitle = $lang === 'ar' ? $locatedProperty->name_ar : $locatedProperty->name_en;
                                $locatedLocation = trim($locatedProperty->$locationField);
                                $locatedPayment = $lang === 'ar' ? $locatedProperty->payment_system_ar : $locatedProperty->payment_system_en;
                                $locatedArea = $lang === 'ar' ? $locatedProperty->area_ar : $locatedProperty->area_en;
                            @endphp
                            <article class="location-card" data-location="{{ $locatedLocation }}" @if($locatedLocation !== $initialLocation) hidden @endif>
                                <a class="location-card__image" href="{{ route('front.property.details', $locatedProperty->id) }}" aria-label="{{ $locatedTitle }}">
                                    @if($locatedProperty->image_1)<img src="{{ asset('storage/'.$locatedProperty->image_1) }}" alt="{{ $locatedTitle }}" loading="lazy">@else<span class="listing-card__no-image" aria-hidden="true"><i class="fa-regular fa-image"></i></span>@endif
                                </a>
                                <div class="location-card__body">
                                    @if($locatedPayment)<p class="location-card__payment">{{ $locatedPayment }}</p>@endif
                                    <h3><a href="{{ route('front.property.details', $locatedProperty->id) }}">{{ $locatedTitle }}</a></h3>
                                    <p class="location-card__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $locatedLocation }}</p>
                                    @if($locatedArea)<p class="location-card__area"><i class="fa-solid fa-ruler-combined" aria-hidden="true"></i> {{ $locatedArea }}</p>@endif
                                    <a class="location-card__link" href="{{ route('front.property.details', $locatedProperty->id) }}">{{ $lang === 'ar' ? 'تفاصيل العقار' : 'View details' }} <span aria-hidden="true">{{ $lang === 'ar' ? '←' : '→' }}</span></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>
</main>
<section class="listing-contact" aria-labelledby="listing-contact-title">
    <div class="listing-container listing-contact__inner">
        <div class="listing-contact__copy">
            <span class="listing-contact__eyebrow">{{ $lang === 'ar' ? 'نحن هنا لمساعدتك' : 'GET IN TOUCH' }}</span>
            <h2 id="listing-contact-title">{{ $lang === 'ar' ? 'لنساعدك في العثور على عقارك' : 'Let’s Find Your Property' }}</h2>
            <p>{{ $lang === 'ar' ? 'تواصل معنا للاستفسار عن العقارات المتاحة.' : 'Get in touch to ask about available properties.' }}</p>
            <a class="listing-contact__button" href="{{ route('front.contact') }}">{{ $lang === 'ar' ? 'تواصل معنا' : 'Contact us' }} <span aria-hidden="true">{{ $lang === 'ar' ? '←' : '→' }}</span></a>
        </div>
        @if($listingContact && ($listingContact->phone || $listingContact->email || ($lang === 'ar' ? $listingContact->address_ar : $listingContact->address_en)))
            <div class="listing-contact__details">
                @if($listingContact->phone)<div class="listing-contact__item"><span class="listing-contact__icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></span><span><small>{{ $lang === 'ar' ? 'اتصل بنا' : 'Call us' }}</small><a dir="ltr" href="tel:{{ $listingContact->phone }}">{{ $listingContact->phone }}</a></span></div>@endif
                @if($listingContact->email)<div class="listing-contact__item"><span class="listing-contact__icon"><i class="fa-regular fa-envelope" aria-hidden="true"></i></span><span><small>{{ $lang === 'ar' ? 'البريد الإلكتروني' : 'Email us' }}</small><a href="mailto:{{ $listingContact->email }}">{{ $listingContact->email }}</a></span></div>@endif
                @if($lang === 'ar' ? $listingContact->address_ar : $listingContact->address_en)<div class="listing-contact__item"><span class="listing-contact__icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span><span><small>{{ $lang === 'ar' ? 'عنوان المكتب' : 'Visit our office' }}</small><span>{{ $lang === 'ar' ? $listingContact->address_ar : $listingContact->address_en }}</span></span></div>@endif
            </div>
        @endif
        @if($heroImage)<div class="listing-contact__image"><img src="{{ asset('storage/'.$heroImage->image_1) }}" alt="" loading="lazy"></div>@endif
    </div>
</section>
@include('front.layouts.footer')
<script src="{{ asset('front/js/script.js') }}"></script>
<script src="{{ asset('front/js/all-properties.js') }}"></script>
</body>
</html>
