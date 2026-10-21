@php
    $lang = session('locale', 'ar');
    $rtl = $lang === 'ar';
    $rootBuildings = \App\Models\Property::query()->whereNull('building_id');
    $buildingCount = (clone $rootBuildings)->where('is_building', true)->count()
        ?: (clone $rootBuildings)->count();
    $featuredBuilding = (clone $rootBuildings)->where('is_building', true)->withCount('units')->latest()->first();
    $heroContact = \App\Models\ContactInfo::query()->first();
    $heroWhatsapp = preg_replace('/[^0-9]/', '', $heroContact?->whatsapp ?? '');
    $featuredTitle = $featuredBuilding ? ($rtl ? ($featuredBuilding->name_ar ?: $featuredBuilding->name_en) : ($featuredBuilding->name_en ?: $featuredBuilding->name_ar)) : ($rtl ? 'استكشف مبانينا' : 'Explore our buildings');
    $featuredLocation = $featuredBuilding ? ($rtl ? ($featuredBuilding->location_ar ?: $featuredBuilding->location_en) : ($featuredBuilding->location_en ?: $featuredBuilding->location_ar)) : ($rtl ? 'القاهرة الجديدة' : 'New Cairo');
    $featuredImage = $featuredBuilding?->image_1 ? asset('storage/' . $featuredBuilding->image_1) : asset('front/img/home-hero-building.png');
    $buildingLink = $featuredBuilding ? route('front.building.details', $featuredBuilding->id) : route('front.properties');
@endphp

<section class="hero hero--editorial" id="home" aria-labelledby="homeHeroTitle">
    <div class="hero__photo" aria-hidden="true"></div>
    <div class="hero__street" aria-hidden="true"></div>
    <div class="hero__wash" aria-hidden="true"></div>

    <div class="hero__inner container">
        <div class="hero__copy">
            <p class="hero__eyebrow"><span></span>{{ $rtl ? 'عقارات سكنية في القاهرة الجديدة والقاهرة الكبرى' : 'Real estate in New Cairo & Greater Cairo' }}</p>
            <h1 id="homeHeroTitle">{{ $rtl ? 'اعثر على' : 'Find Your' }}<br>{{ $rtl ? 'منزلك القادم' : 'Next Home' }}</h1>
            <p class="hero__description">{{ $rtl ? 'مجموعة مختارة من المباني السكنية المميزة والوحدات المتاحة، بخطوات سهلة وتواصل مباشر ودعم كامل.' : 'A selection of premium residential buildings with available units. Simple process, direct communication, and full support.' }}</p>

            <a class="hero__cta" href="{{ $heroWhatsapp ? 'https://wa.me/' . $heroWhatsapp : route('front.contact') }}" @if($heroWhatsapp) target="_blank" rel="noopener noreferrer" @endif>
                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                <span>{{ $rtl ? 'تواصل معنا عبر واتساب' : 'Contact on WhatsApp' }}</span>
                <i class="fa-solid fa-arrow-{{ $rtl ? 'left' : 'right' }}" aria-hidden="true"></i>
            </a>

            <div class="hero__proof" aria-label="{{ $rtl ? 'مميزاتنا' : 'Our advantages' }}">
                <div class="hero__proof-item"><i class="fa-regular fa-building" aria-hidden="true"></i><span><strong>{{ $buildingCount }}{{ $buildingCount >= 10 ? '+' : '' }}</strong><small>{{ $rtl ? 'مبنى سكني' : 'Residential Buildings' }}</small></span></div>
                <div class="hero__proof-item"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span><strong>{{ $rtl ? 'مواقع مميزة' : 'Prime' }}</strong><small>{{ $rtl ? 'مناطق مختارة' : 'Locations' }}</small></span></div>
                <div class="hero__proof-item"><i class="fa-regular fa-user" aria-hidden="true"></i><span><strong>{{ $rtl ? 'تواصل مباشر' : 'Direct' }}</strong><small>{{ $rtl ? 'مع المالك' : 'Owner Communication' }}</small></span></div>
            </div>
        </div>

        <a class="hero-featured" href="{{ $buildingLink }}" aria-label="{{ $rtl ? 'عرض المبنى المميز: ' : 'View featured building: ' }}{{ $featuredTitle }}">
            <img src="{{ $featuredImage }}" alt="{{ $featuredTitle }}" loading="eager">
            <span class="hero-featured__copy">
                <small>{{ $rtl ? 'مبنى مميز' : 'Featured Building' }}</small>
                <strong>{{ $featuredTitle }}</strong>
                <span>{{ $featuredLocation ?: ($rtl ? 'موقع مميز' : 'Prime location') }}</span>
            </span>
            <i class="fa-solid fa-arrow-{{ $rtl ? 'left' : 'right' }}" aria-hidden="true"></i>
        </a>
    </div>
</section>
