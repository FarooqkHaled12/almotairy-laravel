@php
    use App\Models\Service;

    $lang = session('locale', 'ar');
    $services = Service::orderBy('id')->take(4)->get();
@endphp

<section class="services home-services section-padding" id="services">
    <div class="container">
        <div class="home-services-heading">
            <span class="home-services-eyebrow">{{ $lang == 'ar' ? 'لماذا تختارنا؟' : 'Why choose us?' }}</span>
            <div>
                <h2>{{ $lang == 'ar' ? 'تجربة عقارية أفضل' : 'A Better Real Estate Experience' }}</h2>
                <p>{{ $lang == 'ar' ? 'نلتزم بتقديم قيمة استثنائية من خلال الخبرة والشفافية ونهج يضع العميل أولاً.' : 'We are committed to delivering exceptional value through expertise, transparency, and a client-first approach.' }}</p>
            </div>
        </div>

        <div class="home-services-list">
                @forelse($services as $index => $service)
                    @php
                        $title = $lang == 'ar' ? $service->title_ar : $service->title_en;
                        $desc = $lang == 'ar' ? $service->description_ar : $service->description_en;
                    @endphp
                    <article class="home-service">
                        <span class="home-service-number" aria-hidden="true"><i class="fa-solid {{ ['fa-house', 'fa-chart-column', 'fa-handshake'][min($index, 2)] }}"></i></span>
                        <div class="home-service-copy">
                            <h3>{{ $title }}</h3>
                            @if($desc)<div class="home-service-description">{!! $desc !!}</div>@endif
                        </div>
                    </article>
                @empty
                    <p class="home-services-empty">{{ $lang == 'ar' ? 'لا توجد خدمات متاحة حاليًا.' : 'No services are currently available.' }}</p>
                @endforelse
        </div>
    </div>
</section>
