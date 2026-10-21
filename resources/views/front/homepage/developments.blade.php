@php
    $developments = \App\Models\Property::whereNull('building_id')
        ->orderByDesc('created_at')
        ->get();
    $lang = session('locale', 'ar');
@endphp

@if($developments->isNotEmpty())
<section class="developments" aria-labelledby="developments-title" data-development-slider>
    <div class="developments-shell">
        <div class="developments-heading">
            <span class="developments-eyebrow">{{ $lang === 'ar' ? 'مشاريعنا' : 'Our Developments' }}</span>
            <h2 id="developments-title">{{ $lang === 'ar' ? 'اكتشف مشاريعنا' : 'Discover Our Projects' }}</h2>
        </div>

        <div class="developments-slider">
            <div class="developments-controls" role="group" aria-label="{{ $lang === 'ar' ? 'التنقل بين المشاريع' : 'Project navigation' }}">
                <button type="button" class="developments-control developments-control--previous" aria-controls="developments-track" aria-label="{{ $lang === 'ar' ? 'المشروع السابق' : 'Previous project' }}"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></button>
                <button type="button" class="developments-control developments-control--next" aria-controls="developments-track" aria-label="{{ $lang === 'ar' ? 'المشروع التالي' : 'Next project' }}"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button>
            </div>

            <div class="developments-track" id="developments-track" tabindex="0" aria-label="{{ $lang === 'ar' ? 'مشاريع المطيري' : 'Almotairy projects' }}">
                @foreach($developments as $development)
                    @php
                        $title = $lang === 'ar' ? ($development->name_ar ?: $development->name_en) : ($development->name_en ?: $development->name_ar);
                        $location = $lang === 'ar' ? ($development->location_ar ?: $development->area_ar) : ($development->location_en ?: $development->area_en);
                        $description = trim(strip_tags($lang === 'ar' ? $development->description_ar : $development->description_en));
                        $image = collect([$development->image_1, $development->image_2, $development->image_3, $development->image_4])->first(fn ($item) => filled($item));
                    @endphp
                    <article class="development-slide">
                        <a class="development-slide__image" href="{{ route('front.property.details', $development->id) }}" aria-label="{{ $title }}">
                            @if($image)
                                <img src="{{ asset('storage/'.$image) }}" alt="{{ $title }}" loading="lazy">
                            @else
                                <span class="development-slide__placeholder"><i class="fa-regular fa-image" aria-hidden="true"></i></span>
                            @endif
                        </a>
                        <div class="development-slide__body">
                            @if($location)<p class="development-slide__location">{{ $location }}</p>@endif
                            <h3><a href="{{ route('front.property.details', $development->id) }}">{{ $title }}</a></h3>
                            @if($description)<p class="development-slide__description">{{ \Illuminate\Support\Str::limit($description, 72) }}</p>@endif
                            <a class="development-slide__link" href="{{ route('front.property.details', $development->id) }}" aria-label="{{ $lang === 'ar' ? 'تفاصيل مشروع' : 'View project' }} {{ $title }}"><i class="fa-solid {{ $lang === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}" aria-hidden="true"></i></a>
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
    const cards = [...track.querySelectorAll('.development-slide')];
    const previous = section.querySelector('.developments-control--previous');
    const next = section.querySelector('.developments-control--next');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let timer = null;
    const step = () => cards[0] ? cards[0].getBoundingClientRect().width + (parseFloat(getComputedStyle(track).columnGap) || 0) : track.clientWidth;
    const move = direction => {
        const atStart = track.scrollLeft <= 2;
        const atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 2;
        if (direction > 0 && atEnd) return track.scrollTo({ left: 0, behavior: reduceMotion.matches ? 'auto' : 'smooth' });
        if (direction < 0 && atStart) return track.scrollTo({ left: track.scrollWidth, behavior: reduceMotion.matches ? 'auto' : 'smooth' });
        track.scrollBy({ left: direction * step(), behavior: reduceMotion.matches ? 'auto' : 'smooth' });
    };
    const stop = () => { if (timer) window.clearInterval(timer); timer = null; };
    const start = () => { stop(); if (!reduceMotion.matches && cards.length > 1) timer = window.setInterval(() => move(1), 4200); };
    previous.addEventListener('click', () => { move(-1); start(); });
    next.addEventListener('click', () => { move(1); start(); });
    section.addEventListener('mouseenter', stop);
    section.addEventListener('mouseleave', start);
    section.addEventListener('focusin', stop);
    section.addEventListener('focusout', event => { if (!section.contains(event.relatedTarget)) start(); });
    track.addEventListener('pointerdown', stop, { passive: true });
    track.addEventListener('pointerup', start, { passive: true });
    reduceMotion.addEventListener?.('change', start);
    start();
});
</script>
@endif
