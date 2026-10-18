@php
    use App\Models\Property;
    use App\Models\PropertyCategory;

    $lang = session('locale','ar');

    // التصنيفات
    $categories = PropertyCategory::orderBy('id')->get();

    // كل العقارات مع التصنيف
    $properties = Property::with('category')->latest()->get();
@endphp

<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ $lang == 'ar' ? 'جميع العقارات | المطيري للعقارات' : 'All Properties | Almotairy Real Estate' }}
    </title>
    <meta name="description"
          content="{{ $lang == 'ar'
            ? 'تصفح جميع العقارات المتاحة مع فلترة حسب المناطق وأنواع العقارات.'
            : 'Browse all available properties with filters by areas and types.'
          }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/all-properties.css') }}">
</head>
<body>

@include('front.layouts.header')

{{-- الهيرو --}}
<section class="page-hero properties-hero">
    <div class="page-hero-overlay"></div>
    <div class="container">
        <div class="page-hero-content">
            <h1>{{ $lang == 'ar' ? 'جميع العقارات المتاحة' : 'All available properties' }}</h1>
            <p class="breadcrumb">
                <a href="{{ route('front.home') }}">
                    {{ $lang == 'ar' ? 'الرئيسية' : 'Home' }}
                </a>
                /
                <span>{{ $lang == 'ar' ? 'جميع العقارات' : 'All properties' }}</span>
            </p>
            <p class="hero-text">
                {{ $lang == 'ar'
                    ? 'اختر من مجموعة متنوعة من العقارات في أفضل المناطق، مع إمكانية فلترة بسيطة حسب المنطقة ونوع العقار.'
                    : 'Choose from a wide range of properties in prime areas, with easy filters by area and property type.'
                }}
            </p>
        </div>
    </div>
</section>

<section class="properties-main section-padding">
    <div class="container-full">
        <div class="properties-layout">

            {{-- الفلتر الجانبي --}}
            <aside class="properties-sidebar" id="propertiesSidebar">
                <div class="sidebar-header">
                    <h3>{{ $lang == 'ar' ? 'التصنيفات' : 'Categories' }}</h3>
                    <button class="sidebar-close" id="closeSidebar">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="filter-section">
                    <h4>{{ $lang == 'ar' ? 'المناطق' : 'Areas' }}</h4>
                    <ul class="filter-list">
                        {{-- الكل --}}
                        <li>
                            <button class="filter-btn active" data-category="all">
                                <i class="fa-solid fa-border-all"></i>
                                <span>{{ $lang == 'ar' ? 'جميع العقارات' : 'All properties' }}</span>
                                <span class="count">{{ $properties->count() }}</span>
                            </button>
                        </li>

                        {{-- التصنيفات من الداتابيس --}}
                        @foreach($categories as $category)
                            @php
                                $catName = $lang == 'ar' ? $category->name_ar : $category->name_en;
                                $catSlug = 'cat-'.$category->id;
                                $catCount = $properties->where('category_id', $category->id)->count();
                            @endphp
                            <li>
                                <button class="filter-btn" data-category="{{ $catSlug }}">
                                    <i class="fa-solid fa-building"></i>
                                    <span>{{ $catName }}</span>
                                    <span class="count">{{ $catCount }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- منطقة العقارات --}}
            <div class="properties-content">
                <button class="mobile-filter-btn" id="openSidebar">
                    <i class="fa-solid fa-sliders"></i>
                    <span>{{ $lang == 'ar' ? 'التصنيفات' : 'Filters' }}</span>
                </button>

                <div class="properties-results-header">
                    <h3>
                        {{ $lang == 'ar' ? 'عرض' : 'Showing' }}
                        <span id="resultCount">{{ $properties->count() }}</span>
                        {{ $lang == 'ar' ? 'عقار' : 'properties' }}
                    </h3>
                </div>

                <div class="properties-grid">
                    @forelse($properties as $property)
                        @php
                            $title    = $lang == 'ar' ? $property->name_ar  : $property->name_en;
                            $location = $lang == 'ar' ? $property->location_ar : $property->location_en;
                            $area     = $lang == 'ar' ? $property->area_ar : $property->area_en;
                            $features = $lang == 'ar'
                                ? ($property->features_ar ?? [])
                                : ($property->features_en ?? []);
                            $catClass = $property->category ? 'cat-'.$property->category_id : 'cat-none';
                            $image    = $property->image_1
                                ? asset('storage/'.$property->image_1)
                                : 'https://images.unsplash.com/photo-1600596542815-e32c630bd1ba?w=800';
                            $price    = $lang == 'ar'
                                ? ($property->payment_system_ar ?? '')
                                : ($property->payment_system_en ?? '');
                            $whatsapp = $property->whatsapp ? 'https://wa.me/'.$property->whatsapp : null;
                        @endphp

                        <div class="property-card" data-category="{{ $catClass }}" data-type="apartment">
                            <div class="card-image">
                                <span class="badge sale">
                                    {{ $lang == 'ar' ? 'عرض' : 'Offer' }}
                                </span>
                                <img src="{{ $image }}" alt="{{ $title }}">
                                @if($price)
                                    <div class="price">{{ $price }}</div>
                                @endif
                            </div>
                            <div class="card-details">
                                @if($location)
                                    <div class="location">
                                        <i class="fa-solid fa-location-dot"></i> {{ $location }}
                                    </div>
                                @endif
                                <h3>{{ $title }}</h3>
                                <ul class="facilities">
                                    @if($area)
                                        <li>
                                            <i class="fa-solid fa-ruler-combined"></i> {{ $area }}
                                        </li>
                                    @endif
                                    @foreach(array_slice($features, 0, 2) as $f)
                                        <li>
                                            <i class="fa-solid fa-check"></i> {{ $f }}
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="card-footer">
                                    <a href="{{ route('front.property.details', $property->id) }}"
                                       class="btn-card">
                                        {{ $lang == 'ar' ? 'تفاصيل أكثر' : 'More details' }}
                                    </a>
                                    @if($whatsapp)
                                        <a href="{{ $whatsapp }}" class="btn-whatsapp" target="_blank">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- لو مفيش أي عقارات --}}
                    @endforelse
                </div>

                <div class="no-results" id="noResults" style="display:none;">
                    <i class="fa-solid fa-search"></i>
                    <h3>{{ $lang == 'ar' ? 'لا توجد عقارات تطابق اختيارك' : 'No properties match your filter' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'جرب تغيير التصنيف أو تواصل معنا مباشرة.'
                            : 'Try changing the filter or contact us directly.'
                        }}
                    </p>
                    <a href="{{ route('front.contact') }}" class="btn btn-primary">
                        {{ $lang == 'ar' ? 'تواصل معنا' : 'Contact us' }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@include('front.layouts.footer')

<script src="{{ asset('front/js/script.js') }}"></script>
<script src="{{ asset('front/js/all-properties.js') }}"></script>

<script>
// فلترة العقارات حسب التصنيف (نفس فكرة الهوم بيج لكن على مستوى الصفحة)
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns  = document.querySelectorAll('.filter-btn');
    const cards       = document.querySelectorAll('.property-card');
    const resultCount = document.getElementById('resultCount');
    const noResults   = document.getElementById('noResults');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const category = btn.getAttribute('data-category');

            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            let visible = 0;

            cards.forEach(card => {
                const cardCat = card.getAttribute('data-category');
                if (category === 'all' || cardCat === category) {
                    card.style.display = 'block';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });

            resultCount.textContent = visible;

            if (visible === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });
    });
});
</script>

</body>
</html>
