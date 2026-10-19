@php
    $lang = session('locale', 'ar');
    $exploreProperty = \App\Models\Property::whereNotNull('image_1')->where('image_1', '!=', '')->latest()->first();
@endphp

@if($exploreProperty)
    @php
        $exploreTitle = $lang == 'ar' ? $exploreProperty->name_ar : $exploreProperty->name_en;
        $exploreDescription = $lang == 'ar' ? $exploreProperty->description_ar : $exploreProperty->description_en;
        $exploreArea = $lang == 'ar' ? $exploreProperty->area_ar : $exploreProperty->area_en;
        $exploreLocation = $lang == 'ar' ? $exploreProperty->location_ar : $exploreProperty->location_en;
    @endphp
    <section class="home-explore" aria-labelledby="home-explore-title">
        <div class="container home-explore-layout">
            <div class="home-explore-image">
                <img src="{{ asset('storage/'.$exploreProperty->image_1) }}" alt="{{ $exploreTitle }}" loading="lazy">
            </div>
            <div class="home-explore-content">
                <span class="home-explore-eyebrow">{{ $lang == 'ar' ? 'العقارات المتاحة' : 'Available properties' }}</span>
                <h2 id="home-explore-title">{{ $lang == 'ar' ? 'اكتشف العقارات المتاحة' : 'Explore Available Real Estate' }}</h2>
                <div class="home-explore-property">
                    <h3>{{ $exploreTitle }}</h3>
                    @if($exploreLocation)<p class="home-explore-location">{{ $exploreLocation }}</p>@endif
                    @if($exploreArea)<p class="home-explore-area">{{ $exploreArea }}</p>@endif
                    @if($exploreDescription)<div class="home-explore-description">{!! $exploreDescription !!}</div>@endif
                    <a href="{{ route('front.property.details', $exploreProperty->id) }}" class="home-explore-link">
                        {{ $lang == 'ar' ? 'تفاصيل العقار' : 'View property details' }}
                        <span aria-hidden="true">{{ $lang == 'ar' ? '←' : '→' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif
