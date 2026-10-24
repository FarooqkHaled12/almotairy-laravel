@php
    $developments = \App\Models\Property::withCount('units')
        ->whereNull('building_id')
        ->orderByDesc('created_at')
        ->get();
    $lang = session('locale', 'ar');
    $isRtl = $lang === 'ar';
@endphp

@if($developments->isNotEmpty())
<section class="developments" id="developments" aria-labelledby="developments-title" data-development-slider>
    <div class="developments-shell">
        <div class="developments-header">
            <div class="developments-heading">
                <span class="developments-eyebrow">
                    <span class="eyebrow-line" aria-hidden="true"></span>
                    {{ $isRtl ? 'مشاريعنا المعمارية' : 'OUR DEVELOPMENTS' }}
                </span>
                <h2 id="developments-title">{{ $isRtl ? 'اكتشف أبرز مشاريعنا السكنية' : 'Discover Our Premier Projects' }}</h2>
                <p class="developments-subtitle">{{ $isRtl ? 'مشاريع متميزة بتصاميم حديثة ومواقع استراتيجية توفر لك الراحة والاستثمار الأمثل' : 'Distinctive developments featuring modern architecture and strategic locations for living and investment.' }}</p>
            </div>

            <div class="developments-actions">
                <a href="{{ route('front.properties') }}" class="developments-view-all">
                    <span>{{ $isRtl ? 'عرض كل المشاريع' : 'View All Projects' }}</span>
                    <i class="fa-solid {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}" aria-hidden="true"></i>
                </a>
                <div class="developments-controls" role="group" aria-label="{{ $isRtl ? 'التنقل بين المشاريع' : 'Project navigation' }}">
                    <button type="button" class="developments-control developments-control--previous" aria-controls="developments-track" aria-label="{{ $isRtl ? 'المشروع السابق' : 'Previous project' }}">
                        <i class="fa-solid {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="developments-control developments-control--next" aria-controls="developments-track" aria-label="{{ $isRtl ? 'المشروع التالي' : 'Next project' }}">
                        <i class="fa-solid {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="developments-slider">
            <div class="developments-track" id="developments-track" tabindex="0" aria-label="{{ $isRtl ? 'مشاريع المطيري' : 'Almotairy projects' }}">
                @foreach($developments as $development)
                    @php
                        $title = $isRtl ? ($development->name_ar ?: $development->name_en) : ($development->name_en ?: $development->name_ar);
                        $location = $isRtl ? ($development->location_ar ?: $development->area_ar) : ($development->location_en ?: $development->area_en);
                        $description = trim(strip_tags($isRtl ? $development->description_ar : $development->description_en));
                        $image = collect([$development->image_1, $development->image_2, $development->image_3, $development->image_4])->first(fn ($item) => filled($item));
                        $detailsRoute = $development->is_building ? route('front.building.details', $development->id) : route('front.property.details', $development->id);
                        $unitsCount = $development->units_count ?? 0;
                    @endphp
                    <article class="development-slide">
                        <div class="development-card">
                            <div class="development-card__media">
                                <a class="development-card__image-link" href="{{ $detailsRoute }}" aria-label="{{ $title }}">
                                    @if($image)
                                        <img src="{{ asset('storage/'.$image) }}" alt="{{ $title }}" loading="lazy">
                                    @else
                                        <div class="development-card__placeholder">
                                            <i class="fa-regular fa-building" aria-hidden="true"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="development-card__badges">
                                    @if($location)
                                        <span class="development-card__badge development-card__badge--location">
                                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                            <span>{{ $location }}</span>
                                        </span>
                                    @endif
                                    @if($unitsCount > 0)
                                        <span class="development-card__badge development-card__badge--units">
                                            <i class="fa-solid fa-door-open" aria-hidden="true"></i>
                                            <span>{{ $unitsCount }} {{ $isRtl ? 'شقة' : 'Units' }}</span>
                                        </span>
                                    @elseif($development->is_building)
                                        <span class="development-card__badge development-card__badge--units">
                                            <i class="fa-solid fa-city" aria-hidden="true"></i>
                                            <span>{{ $isRtl ? 'عمارة سكنية' : 'Residential' }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="development-card__content">
                                <h3 class="development-card__title">
                                    <a href="{{ $detailsRoute }}" title="{{ $title }}">{{ $title }}</a>
                                </h3>

                                @if($description)
                                    <p class="development-card__desc">{{ \Illuminate\Support\Str::limit($description, 85) }}</p>
                                @endif

                                <div class="development-card__footer">
                                    <a class="development-card__cta" href="{{ $detailsRoute }}" aria-label="{{ $isRtl ? 'تفاصيل مشروع' : 'View project' }} {{ $title }}">
                                        <span>{{ $isRtl ? 'استكشف المشروع' : 'Explore Project' }}</span>
                                        <span class="development-card__arrow" aria-hidden="true">
                                            <i class="fa-solid {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-development-slider]');
    if (!section) return;

    const track = section.querySelector('.developments-track');
    if (!track) return;

    const cards = [...track.querySelectorAll('.development-slide')];
    if (cards.length === 0) return;

    const prevBtn = section.querySelector('.developments-control--previous');
    const nextBtn = section.querySelector('.developments-control--next');
    const isRtl = document.documentElement.dir === 'rtl' || getComputedStyle(track).direction === 'rtl';
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    const getStep = () => {
        if (!cards[0]) return track.clientWidth * 0.8;
        const cardWidth = cards[0].getBoundingClientRect().width;
        const gap = parseFloat(getComputedStyle(track).gap) || 24;
        return cardWidth + gap;
    };

    const updateControls = () => {
        const scrollLeft = Math.abs(track.scrollLeft);
        const maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
        if (prevBtn) prevBtn.disabled = scrollLeft <= 4;
        if (nextBtn) nextBtn.disabled = scrollLeft >= maxScroll - 4;
    };

    const scrollByStep = (direction) => {
        const step = getStep();
        const multiplier = isRtl ? -1 : 1;
        track.scrollBy({
            left: direction * step * multiplier,
            behavior: reduceMotion.matches ? 'auto' : 'smooth'
        });
    };

    if (prevBtn) prevBtn.addEventListener('click', () => scrollByStep(-1));
    if (nextBtn) nextBtn.addEventListener('click', () => scrollByStep(1));

    track.addEventListener('scroll', updateControls, { passive: true });
    window.addEventListener('resize', updateControls);

    // Mouse drag support
    let isDown = false;
    let startX = 0;
    let scrollStart = 0;
    let hasMoved = false;

    track.addEventListener('mousedown', (e) => {
        isDown = true;
        hasMoved = false;
        startX = e.pageX - track.offsetLeft;
        scrollStart = track.scrollLeft;
        track.style.cursor = 'grabbing';
        track.style.userSelect = 'none';
    });

    window.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        const x = e.pageX - track.offsetLeft;
        const walk = (x - startX);
        if (Math.abs(walk) > 5) hasMoved = true;
        track.scrollLeft = scrollStart - walk;
    });

    const stopDrag = () => {
        if (!isDown) return;
        isDown = false;
        track.style.cursor = '';
        track.style.removeProperty('user-select');
    };

    window.addEventListener('mouseup', stopDrag);

    // Prevent clicking links if dragged
    track.addEventListener('click', (e) => {
        if (hasMoved) {
            e.preventDefault();
            e.stopPropagation();
            hasMoved = false;
        }
    }, true);

    updateControls();
});
</script>
@endif
