@php
    use App\Models\Service;

    $lang = session('locale', 'ar');
    $services = Service::orderBy('id')->take(4)->get();
@endphp

<section class="services home-services section-padding" id="services">
    <div class="container">
        <div class="home-services-heading">
            <span class="home-services-eyebrow">{{ $lang == 'ar' ? 'لماذا تختارنا؟' : 'Why choose us?' }}</span>
            <h2>{{ $lang == 'ar' ? 'خدمات عقارية متكاملة' : 'Comprehensive real estate services' }}</h2>
        </div>

        <div class="home-services-layout">
            <div class="home-services-list">
                @forelse($services as $index => $service)
                    @php
                        $title = $lang == 'ar' ? $service->title_ar : $service->title_en;
                        $desc = $lang == 'ar' ? $service->description_ar : $service->description_en;
                    @endphp
                    <article class="home-service">
                        <span class="home-service-number" aria-hidden="true">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="home-service-copy">
                            <h3>{{ $title }}</h3>
                            @if($desc)<div class="home-service-description">{!! $desc !!}</div>@endif
                        </div>
                    </article>
                @empty
                    <p class="home-services-empty">{{ $lang == 'ar' ? 'لا توجد خدمات متاحة حاليًا.' : 'No services are currently available.' }}</p>
                @endforelse
            </div>
            <div class="home-services-art" aria-hidden="true">
                <span class="home-services-art-building"></span>
                <span class="home-services-art-line"></span>
            </div>
        </div>
    </div>
</section>
