@php
    use App\Models\Property;
    use App\Models\PropertyCategory;

    $lang = session('locale','ar');

    // كل التصنيفات
    $categories = PropertyCategory::all();

    // آخر العقارات
    $properties = Property::with('category')->latest()->take(12)->get();
@endphp

<section class="properties featured-properties section-padding" id="properties">
    <div class="container">

        {{-- العناوين --}}
        <div class="featured-heading">
        <div class="section-header">
            <h4 class="section-subtitle">
                {{ $lang == 'ar' ? 'الوحدات المتاحة' : 'Available Units' }}
            </h4>
            <h2 class="section-title">
                {{ $lang == 'ar' ? 'أحدث العروض المميزة' : 'Latest Featured Offers' }}
            </h2>

        </div>
        <a href="{{ route('front.properties') }}" class="featured-view-all">
            {{ $lang == 'ar' ? 'عرض كل العقارات' : 'View all properties' }}
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
        <div class="properties-grid">
            @forelse($properties as $property)
                @php
                    $title      = $lang == 'ar' ? $property->name_ar : $property->name_en;
                    $area       = $lang == 'ar' ? $property->area_ar : $property->area_en;
                    $location   = $lang == 'ar' ? ($property->location_ar ?? '') : ($property->location_en ?? '');
                    $features   = array_values(array_filter($lang == 'ar' ? ($property->features_ar ?? []) : ($property->features_en ?? []), fn ($feature) => is_string($feature) && trim($feature) !== ''));
                    $catClass   = $property->category ? 'cat-'.$property->category_id : 'cat-none';
                    $categoryName = $property->category ? ($lang == 'ar' ? $property->category->name_ar : $property->category->name_en) : null;
                    $image      = $property->image_1 ? asset('storage/'.$property->image_1) : null;
                    $whatsapp   = $property->whatsapp ? 'https://wa.me/'.$property->whatsapp : '#';
                @endphp

                <div class="property-card" data-category="{{ $catClass }}">
                    <div class="card-image">
                        @if($image)
                            <a class="featured-image-link" href="{{ route('front.property.details', $property->id) }}" aria-label="{{ $lang == 'ar' ? '?????? ??????' : 'View property' }}: {{ $title }}"><img src="{{ $image }}" alt="{{ $title }}" loading="lazy"></a>
                        @endif
                        @if($categoryName)<span class="featured-category">{{ $categoryName }}</span>@endif
                    </div>
                    <div class="card-details">
                        <div class="featured-card-heading">
                            <h3><a href="{{ route('front.property.details', $property->id) }}">{{ $title }}</a></h3>
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
                            <a href="{{ route('front.property.details', $property->id) }}" class="btn-card">
                                {{ $lang == 'ar' ? 'تفاصيل أكثر' : 'More details' }} <span aria-hidden="true">{{ $lang == 'ar' ? '←' : '→' }}</span>
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
// فلترة على الواجهة فقط حسب data-category
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.filter-btn');
    const cards   = document.querySelectorAll('.property-card');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');

            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            cards.forEach(card => {
                const cat = card.getAttribute('data-category');
                if (filter === 'all' || cat === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
