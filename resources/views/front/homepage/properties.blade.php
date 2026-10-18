@php
    use App\Models\Property;
    use App\Models\PropertyCategory;

    $lang = session('locale','ar');

    // كل التصنيفات
    $categories = PropertyCategory::all();

    // آخر العقارات
    $properties = Property::with('category')->latest()->take(12)->get();
@endphp

<section class="properties section-padding bg-light" id="properties">
    <div class="container">

        {{-- العناوين --}}
        <div class="section-header text-center">
            <h4 class="section-subtitle">
                {{ $lang == 'ar' ? 'الوحدات المتاحة' : 'Available Units' }}
            </h4>
            <h2 class="section-title">
                {{ $lang == 'ar' ? 'أحدث العروض المميزة' : 'Latest Featured Offers' }}
            </h2>

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
        </div>

        {{-- شبكة العقارات --}}
        <div class="properties-grid">
            @forelse($properties as $property)
                @php
                    $title      = $lang == 'ar' ? $property->name_ar : $property->name_en;
                    $area       = $lang == 'ar' ? $property->area_ar : $property->area_en;
                    $location   = $lang == 'ar' ? ($property->location_ar ?? '') : ($property->location_en ?? '');
                    $features   = $lang == 'ar' ? ($property->features_ar ?? []) : ($property->features_en ?? []);
                    $catClass   = $property->category ? 'cat-'.$property->category_id : 'cat-none';
                    $image      = $property->image_1
                                    ? asset('storage/'.$property->image_1)
                                    : 'https://images.unsplash.com/photo-1600596542815-e32c630bd1ba?auto=format&fit=crop&w=800&q=80';
                    $whatsapp   = $property->whatsapp ? 'https://wa.me/'.$property->whatsapp : '#';
                @endphp

                <div class="property-card" data-category="{{ $catClass }}">
                    <div class="card-image">
                        @if($lang == 'ar')
                            <span class="badge sale">عرض</span>
                        @else
                            <span class="badge sale">Offer</span>
                        @endif

                        <img src="{{ $image }}" alt="{{ $title }}">

                        {{-- السعر لو حابب تضيفه كجزء من الوصف أو نظام الدفع --}}
                        @if($property->payment_system_ar || $property->payment_system_en)
                            <div class="price">
                                {{ $lang == 'ar' ? $property->payment_system_ar : $property->payment_system_en }}
                            </div>
                        @endif
                    </div>

                    <div class="card-details">
                        @if($location)
                            <div class="location">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $location }}
                            </div>
                        @endif

                        <h3>{{ $title }}</h3>

                        <ul class="facilities">
                            @if($area)
                                <li>
                                    <i class="fa-solid fa-ruler-combined"></i>
                                    {{ $area }}
                                </li>
                            @endif

                            @if(!empty($features))
                                @foreach(array_slice($features, 0, 2) as $f)
                                    <li><i class="fa-solid fa-check"></i> {{ $f }}</li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="card-footer">
                            <a href="{{ route('front.property.details', $property->id) }}" class="btn-card">
                                {{ $lang == 'ar' ? 'تفاصيل أكثر' : 'More details' }}
                            </a>
                            @if($property->whatsapp)
                                <a href="{{ $whatsapp }}" target="_blank" class="btn-whatsapp">
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

        {{-- زر عرض كل العقارات --}}
        <div class="view-all-btn-wrapper">
            <a href="{{ route('front.properties') }}" class="btn btn-primary">
                {{ $lang == 'ar' ? 'عرض كل العقارات' : 'View all properties' }}
            </a>
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
