@php
    // These property records were explicitly confirmed as developments.
    $developments = \App\Models\Property::whereIn('id', [13, 14, 15, 16])->get()->keyBy('id');
    $featured = $developments->get(14) ?? $developments->first();
    $otherDevelopments = $featured ? $developments->except($featured->id) : collect();
    $lang = session('locale', 'ar');
@endphp

@if($featured)
<section class="developments" aria-labelledby="developments-title">
    <div class="container">
        <div class="developments-heading">
            <span class="developments-eyebrow">{{ $lang === 'ar' ? 'مشاريعنا' : 'Our developments' }}</span>
            <h2 id="developments-title">{{ $lang === 'ar' ? 'اكتشف مشاريعنا' : 'Discover Developments' }}</h2>
        </div>

        <div class="developments-layout">
            <div class="developments-feature-column">
                @php
                    $featuredTitle = $lang === 'ar' ? $featured->name_ar : $featured->name_en;
                    $featuredLocation = $lang === 'ar' ? $featured->location_ar : $featured->location_en;
                    $featuredDescription = $lang === 'ar' ? $featured->description_ar : $featured->description_en;
                    $featuredImages = array_values(array_filter([$featured->image_1, $featured->image_2, $featured->image_3, $featured->image_4]));
                @endphp
                <article class="development-feature">
                    <div class="development-feature-copy">
                        <span class="development-feature-label">{{ $lang === 'ar' ? 'مشروع مميز' : 'Featured project' }}</span>
                        <h3>{{ $featuredTitle }}</h3>
                        @if($featuredLocation)<p class="development-location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $featuredLocation }}</p>@endif
                        @if($featuredDescription)<div class="development-description">{!! $featuredDescription !!}</div>@endif
                        <a class="development-feature-link" href="{{ route('front.property.details', $featured->id) }}">
                            {{ $lang === 'ar' ? 'تفاصيل المشروع' : 'Explore project' }} <span aria-hidden="true">{{ $lang === 'ar' ? '←' : '→' }}</span>
                        </a>
                    </div>
                    @if(count($featuredImages))
                        <img class="development-feature-image" src="{{ asset('storage/'.$featuredImages[0]) }}" alt="{{ $featuredTitle }}" loading="lazy">
                    @endif
                </article>
                @if(count($featuredImages) > 1)
                    <div class="development-images" aria-label="{{ $lang === 'ar' ? 'صور المشروع' : 'Project images' }}">
                        @foreach($featuredImages as $image)
                            <a href="{{ route('front.property.details', $featured->id) }}" aria-label="{{ $lang === 'ar' ? 'عرض تفاصيل' : 'View details for' }} {{ $featuredTitle }}">
                                <img src="{{ asset('storage/'.$image) }}" alt="" loading="lazy">
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="developments-list">
                @foreach($otherDevelopments as $development)
                    @php
                        $developmentTitle = $lang === 'ar' ? $development->name_ar : $development->name_en;
                        $developmentLocation = $lang === 'ar' ? $development->location_ar : $development->location_en;
                    @endphp
                    <a class="development-card" href="{{ route('front.property.details', $development->id) }}">
                        @if($development->image_1)<img src="{{ asset('storage/'.$development->image_1) }}" alt="" loading="lazy">@endif
                        <div class="development-card-copy">
                            <div><h3>{{ $developmentTitle }}</h3>
                                @if($developmentLocation)<p><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $developmentLocation }}</p>@endif
                            </div>
                            <span class="development-arrow" aria-hidden="true">{{ $lang === 'ar' ? '←' : '→' }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
