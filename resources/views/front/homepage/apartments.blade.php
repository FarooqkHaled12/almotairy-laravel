@php
    use App\Models\Property;

    $lang = session('locale', 'ar');
    $apartments = Property::with(['building', 'category'])
        ->whereNotNull('building_id')
        ->latest()
        ->take(4)
        ->get();
    $previewMode = $apartments->isEmpty();
    if ($previewMode) {
        $apartments = Property::with('category')
            ->whereNull('building_id')
            ->whereNotNull('image_1')
            ->where('image_1', '!=', '')
            ->latest()
            ->take(4)
            ->get();
    }
@endphp

<section class="home-apartments" id="apartments" aria-labelledby="home-apartments-title">
    <div class="home-apartments__container">
        <div class="home-apartments__heading">
            <div>
                <span class="home-apartments__eyebrow">{{ $lang === 'ar' ? 'الشقق المميزة' : 'Featured Apartments' }}</span>
                <h2 id="home-apartments-title">{{ $lang === 'ar' ? 'أحدث الشقق المتاحة' : 'Latest Available Apartments' }}</h2>
            </div>
            <a href="{{ route('front.properties', ['type' => 'apartments']) }}" class="home-apartments__all">
                {{ $lang === 'ar' ? 'عرض كل الشقق' : 'View All Apartments' }}
                <i class="fa-solid {{ $lang === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}" aria-hidden="true"></i>
            </a>
        </div>

        @if($apartments->isNotEmpty())
            <div class="home-apartments__grid">
            @foreach($apartments as $apartment)
                @php
                    $sourceTitle = $lang === 'ar' ? ($apartment->name_ar ?: $apartment->name_en) : ($apartment->name_en ?: $apartment->name_ar);
                    $title = $previewMode
                        ? ($lang === 'ar' ? 'شقة في '.$sourceTitle : 'Apartment at '.$sourceTitle)
                        : $sourceTitle;
                    $buildingTitle = !$previewMode && $apartment->building
                        ? ($lang === 'ar' ? ($apartment->building->name_ar ?: $apartment->building->name_en) : ($apartment->building->name_en ?: $apartment->building->name_ar))
                        : ($previewMode ? $sourceTitle : '');
                    $location = $lang === 'ar' ? ($apartment->location_ar ?: $apartment->building?->location_ar) : ($apartment->location_en ?: $apartment->building?->location_en);
                    $area = $lang === 'ar' ? ($apartment->area_ar ?: $apartment->area_en) : ($apartment->area_en ?: $apartment->area_ar);
                    $payment = $lang === 'ar' ? ($apartment->payment_system_ar ?: $apartment->payment_system_en) : ($apartment->payment_system_en ?: $apartment->payment_system_ar);
                    $features = array_values(array_filter(
                        $lang === 'ar' ? ($apartment->features_ar ?? []) : ($apartment->features_en ?? []),
                        fn ($feature) => is_string($feature) && trim($feature) !== ''
                    ));
                    $image = $apartment->image_1 ?: $apartment->building?->image_1;
                    $detailsUrl = $previewMode
                        ? route('front.building.details', $apartment->id)
                        : route('front.property.details', $apartment->id);
                @endphp
                <article class="home-apartment-card">
                    <a href="{{ $detailsUrl }}" class="home-apartment-card__image" aria-label="{{ $title }}">
                        @if($image)
                            <img src="{{ asset('storage/'.$image) }}" alt="{{ $title }}" loading="lazy">
                        @else
                            <span class="home-apartment-card__placeholder"><i class="fa-regular fa-image" aria-hidden="true"></i></span>
                        @endif
                        <span class="home-apartment-card__status {{ $previewMode ? 'is-preview' : '' }}">{{ $previewMode ? ($lang === 'ar' ? 'نموذج عرض' : 'Preview') : ($lang === 'ar' ? 'للبيع' : 'For Sale') }}</span>
                    </a>
                    <div class="home-apartment-card__body">
                        <h3><a href="{{ $detailsUrl }}">{{ $title }}</a></h3>
                        @if($buildingTitle || $location)
                            <p class="home-apartment-card__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ collect([$buildingTitle, $location])->filter()->join(' — ') }}</p>
                        @endif
                        @if($area || $features)
                            <ul class="home-apartment-card__facts">
                                @if($area)<li><i class="fa-solid fa-vector-square" aria-hidden="true"></i><span>{{ $area }}</span></li>@endif
                                @foreach(array_slice($features, 0, 2) as $feature)
                                    <li><i class="fa-solid {{ $loop->first ? 'fa-bed' : 'fa-user' }}" aria-hidden="true"></i><span>{{ $feature }}</span></li>
                                @endforeach
                            </ul>
                        @endif
                        @if($payment)<p class="home-apartment-card__price">{{ $payment }}</p>@endif
                        <a href="{{ $detailsUrl }}" class="home-apartment-card__details">
                            {{ $previewMode ? ($lang === 'ar' ? 'عرض العمارة' : 'View Building') : ($lang === 'ar' ? 'عرض التفاصيل' : 'View Details') }}
                            <i class="fa-solid {{ $lang === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            @endforeach
            </div>
        @else
            <div class="home-apartments__empty">
                <i class="fa-regular fa-building" aria-hidden="true"></i>
                <div>
                    <h3>{{ $lang === 'ar' ? 'أضف صور العمارات أولًا لعرض نماذج الشقق' : 'Add building photos to preview apartment cards' }}</h3>
                    <p>{{ $lang === 'ar' ? 'الشقق الحقيقية المضافة من لوحة التحكم ستظهر هنا تلقائيًا.' : 'Real apartments added from the dashboard will appear here automatically.' }}</p>
                </div>
            </div>
        @endif
    </div>
</section>
