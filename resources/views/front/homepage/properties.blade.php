@php
    use App\Models\Property;
    use App\Models\PropertyCategory;

    $lang = session('locale','ar');

    // كل التصنيفات
    $categories = PropertyCategory::all();

    // آخر العقارات
    $properties = Property::with('category')
        ->withCount('units')
        ->whereNull('building_id')
        ->latest()
        ->take(6)
        ->get();
@endphp

<section class="properties featured-properties section-padding" id="properties">
    <div class="container">

        {{-- العناوين --}}
        <div class="featured-heading">
        <div class="section-header">
            <h4 class="section-subtitle">
                {{ $lang == 'ar' ? 'مبانينا' : 'Our Buildings' }}
            </h4>
            <h2 class="section-title">
                {{ $lang == 'ar' ? 'استكشف مبانينا' : 'Explore Our Buildings' }}
            </h2>

        </div>
        <a href="{{ route('front.properties') }}" class="featured-view-all">
            {{ $lang == 'ar' ? 'عرض كل المباني' : 'View All Buildings' }}
            <span aria-hidden="true">{{ $lang == 'ar' ? '←' : '→' }}</span>
        </a>
        </div>

            {{-- الفلاتر حسب التصنيفات --}}
            <div class="filters">
                <button class="filter-btn active" data-filter="all">
                    {{ $lang == 'ar' ? 'الكل' : 'All' }}
                </button>

                @foreach($categories as $category)
                    @php
                        $catName = $lang == 'ar' ? $category->name_ar : $category->name_en;
                        $catSlug = 'cat-'.$category->id;
                    @endphp
                    <button class="filter-btn" data-filter="{{ $catSlug }}">
                        {{ $catName }}
                    </button>
                @endforeach
            </div>
        {{-- شبكة العقارات --}}
        <div class="featured-slider-controls" role="group" aria-label="{{ $lang == 'ar' ? 'تصفح العقارات' : 'Browse properties' }}" hidden>
            <button type="button" class="featured-slider-prev" aria-controls="featured-properties-track" aria-label="{{ $lang == 'ar' ? 'العقارات السابقة' : 'Previous properties' }}"><i class="fa-solid {{ $lang == 'ar' ? 'fa-arrow-right' : 'fa-arrow-left' }}" aria-hidden="true"></i></button>
            <button type="button" class="featured-slider-next" aria-controls="featured-properties-track" aria-label="{{ $lang == 'ar' ? 'العقارات التالية' : 'Next properties' }}"><i class="fa-solid {{ $lang == 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}" aria-hidden="true"></i></button>
        </div>
        <div class="properties-grid" id="featured-properties-track" tabindex="0" aria-label="{{ $lang == 'ar' ? 'العقارات المميزة' : 'Featured properties' }}">
            @forelse($properties as $property)
                @php
                    $title      = $lang == 'ar' ? $property->name_ar : $property->name_en;
                    $area       = $lang == 'ar' ? $property->area_ar : $property->area_en;
                    $location   = $lang == 'ar' ? ($property->location_ar ?? '') : ($property->location_en ?? '');
                    $features   = array_values(array_filter($lang == 'ar' ? ($property->features_ar ?? []) : ($property->features_en ?? []), fn ($feature) => is_string($feature) && trim($feature) !== ''));
                    $catClass   = $property->category ? 'cat-'.$property->category_id : 'cat-none';
                    $categoryName = $property->category ? ($lang == 'ar' ? $property->category->name_ar : $property->category->name_en) : null;
                    $categoryLabel = $property->is_building && $property->units_count > 0
                        ? ($lang == 'ar' ? 'وحدات متاحة' : 'Available Units')
                        : $categoryName;
                    $image      = $property->image_1 ? asset('storage/'.$property->image_1) : null;
                    $whatsapp   = $property->whatsapp ? 'https://wa.me/'.$property->whatsapp : '#';
                @endphp

                <div class="property-card" data-category="{{ $catClass }}">
                    <div class="card-image">
                        @if($image)
                            <a class="featured-image-link" href="{{ route('front.building.details', $property->id) }}" aria-label="{{ $lang == 'ar' ? 'عرض شقق العمارة' : 'View building apartments' }}: {{ $title }}"><img src="{{ $image }}" alt="{{ $title }}" loading="lazy"></a>
                        @endif
                        @if($categoryLabel)<span class="featured-category">{{ $categoryLabel }}</span>@endif
                    </div>
                    <div class="card-details">
                        <div class="featured-card-heading">
                            <h3><a href="{{ route('front.building.details', $property->id) }}">{{ $title }}</a></h3>
                        @if($property->payment_system_ar || $property->payment_system_en)
                            <div class="price">
                                {{ $lang == 'ar' ? $property->payment_system_ar : $property->payment_system_en }}
                            </div>
                        @endif
                        </div>
                        @if($location)
                            <div class="location">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $location }}
                            </div>
                        @endif
                        @if($area || !empty($features))
                        <ul class="facilities">
                            @if($area)
                                <li>
                                    {{ $area }}
                                </li>
                            @endif

                            @if(!empty($features))
                                @foreach(array_slice($features, 0, 2) as $f)
                                    <li><i class="fa-solid fa-check"></i> {{ $f }}</li>
                                @endforeach
                            @endif
                        </ul>
                        @endif

                        <div class="card-footer">
                            <a href="{{ route('front.building.details', $property->id) }}" class="btn-card">
                                {{ $lang == 'ar' ? 'عرض شقق العمارة' : 'View apartments' }} <span aria-hidden="true">{{ $lang == 'ar' ? '←' : '→' }}</span>
                            </a>
                            @if($property->whatsapp)
                                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-whatsapp" aria-label="{{ $lang == 'ar' ? 'واتساب' : 'WhatsApp' }}: {{ $title }}">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">
                    {{ $lang == 'ar' ? 'لا توجد عقارات متاحة حالياً.' : 'No properties available at the moment.' }}
                </p>
            @endforelse
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const section = document.querySelector('.featured-properties');
    if (!section) return;
    const track = section.querySelector('.properties-grid');
    const controls = section.querySelector('.featured-slider-controls');
    const previous = controls.querySelector('.featured-slider-prev');
    const next = controls.querySelector('.featured-slider-next');
    const cards = [...track.querySelectorAll('.property-card')];
    const filters = [...section.querySelectorAll('.filter-btn')];
    const rtl = getComputedStyle(track).direction === 'rtl';
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    function updateControls() {
        const max = Math.max(0, track.scrollWidth - track.clientWidth);
        const position = Math.abs(track.scrollLeft);
        previous.disabled = position <= 1;
        next.disabled = position >= max - 1;
    }
    function move(direction) {
        const card = cards.find(item => !item.hidden);
        if (!card) return;
        const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
        track.scrollBy({ left: (rtl ? -1 : 1) * direction * (card.getBoundingClientRect().width + gap), behavior: reduceMotion.matches ? 'auto' : 'smooth' });
    }
    controls.hidden = false;
    previous.addEventListener('click', () => move(-1));
    next.addEventListener('click', () => move(1));
    track.addEventListener('scroll', updateControls, { passive: true });
    window.addEventListener('resize', updateControls);
    filters.forEach(button => button.addEventListener('click', () => {
        filters.forEach(item => { item.classList.remove('active'); item.setAttribute('aria-pressed', 'false'); });
        button.classList.add('active');
        button.setAttribute('aria-pressed', 'true');
        cards.forEach(card => { card.hidden = button.dataset.filter !== 'all' && card.dataset.category !== button.dataset.filter; });
        track.scrollLeft = 0;
        updateControls();
    }));
    filters.forEach(button => button.setAttribute('aria-pressed', button.classList.contains('active') ? 'true' : 'false'));
    let startX = 0, startScroll = 0, dragging = false, moved = false;
    track.addEventListener('pointerdown', event => {
        if (event.pointerType !== 'mouse' || event.button !== 0) return;
        startX = event.clientX; startScroll = track.scrollLeft; dragging = true; moved = false;
    });
    window.addEventListener('pointermove', event => {
        if (!dragging) return;
        const delta = event.clientX - startX;
        if (Math.abs(delta) > 5) moved = true;
        if (moved) { track.scrollLeft = startScroll - delta; track.classList.add('is-dragging'); }
    });
    window.addEventListener('pointerup', () => { dragging = false; track.classList.remove('is-dragging'); });
    track.addEventListener('click', event => { if (moved) { event.preventDefault(); event.stopPropagation(); moved = false; } }, true);
    updateControls();
});
</script>
