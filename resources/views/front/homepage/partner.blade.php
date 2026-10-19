@php
    $lang = session('locale', 'ar');
    $partnerServices = \App\Models\Service::orderBy('id')->take(3)->get();
    $partnerProperties = \App\Models\Property::whereNotNull('image_1')->where('image_1', '!=', '')->latest()->take(2)->get();
@endphp

@if($partnerServices->isNotEmpty() || $partnerProperties->isNotEmpty())
<section class="home-partner" aria-labelledby="home-partner-title">
    <div class="container">
        <div class="home-partner-heading">
            <span class="home-partner-eyebrow">{{ $lang == 'ar' ? 'المطيري للعقارات' : 'Al-Motairy Real Estate' }}</span>
            <h2 id="home-partner-title">{{ $lang == 'ar' ? 'خدمات وعقارات تناسب احتياجاتك' : 'Services and properties for your needs' }}</h2>
        </div>
        <div class="home-partner-layout">
            @if($partnerServices->isNotEmpty())
                <div class="home-partner-services">
                    <h3>{{ $lang == 'ar' ? 'خدماتنا' : 'Our services' }}</h3>
                    <ul>
                        @foreach($partnerServices as $service)
                            @php
                                $serviceTitle = $lang == 'ar' ? $service->title_ar : $service->title_en;
                                $serviceDescription = $lang == 'ar' ? $service->description_ar : $service->description_en;
                            @endphp
                            <li><h4>{{ $serviceTitle }}</h4>@if($serviceDescription)<div>{!! $serviceDescription !!}</div>@endif</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @foreach($partnerProperties as $property)
                @php
                    $propertyTitle = $lang == 'ar' ? $property->name_ar : $property->name_en;
                    $propertyDescription = $lang == 'ar' ? $property->description_ar : $property->description_en;
                    $propertyLocation = $lang == 'ar' ? $property->location_ar : $property->location_en;
                    $propertyArea = $lang == 'ar' ? $property->area_ar : $property->area_en;
                @endphp
                <article class="home-partner-property">
                    <a href="{{ route('front.property.details', $property->id) }}" class="home-partner-image">
                        <img src="{{ asset('storage/'.$property->image_1) }}" alt="{{ $propertyTitle }}" loading="lazy">
                    </a>
                    <h3>{{ $propertyTitle }}</h3>
                    @if($propertyDescription)<div class="home-partner-description">{!! $propertyDescription !!}</div>@endif
                    @if($propertyLocation)<p>{{ $propertyLocation }}</p>@endif
                    @if($propertyArea)<p>{{ $propertyArea }}</p>@endif
                    <a class="home-partner-link" href="{{ route('front.property.details', $property->id) }}">
                        {{ $lang == 'ar' ? 'تفاصيل العقار' : 'Property details' }} <span aria-hidden="true">{{ $lang == 'ar' ? '←' : '→' }}</span>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
