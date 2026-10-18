@php
    $lang = session('locale','ar');

    $title       = $lang == 'ar' ? $property->name_ar       : $property->name_en;
    $location    = $lang == 'ar' ? $property->location_ar    : $property->location_en;
    $area        = $lang == 'ar' ? $property->area_ar        : $property->area_en;
    $description = $lang == 'ar' ? $property->description_ar : $property->description_en;
    $features    = $lang == 'ar' ? ($property->features_ar ?? []) : ($property->features_en ?? []);
    $legal       = $lang == 'ar' ? $property->legal_status_ar : $property->legal_status_en;
    $payment     = $lang == 'ar' ? $property->payment_system_ar : $property->payment_system_en;

    $images = [];
    for ($i = 1; $i <= 4; $i++) {
        $field = 'image_'.$i;
        if ($property->$field) {
            $images[] = asset('storage/'.$property->$field);
        }
    }
    if (empty($images)) {
        $images[] = 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200';
    }

    $phone    = $property->phone ?: '+201000000000';
    $whatsapp = $property->whatsapp ?: '201000000000';
@endphp

<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ $lang == 'ar' ? ($title.' | المطيري للعقارات') : ($title.' | Almotairy Real Estate') }}
    </title>
    <meta name="description"
          content="{{ Str::limit(strip_tags($description ?? ''), 150) }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/property-details.css') }}">
</head>
<body>

@include('front.layouts.header')

<section class="property-hero">
    <div class="container">
        <div class="hero-top">
            <div>
                <h1>{{ $title }}</h1>
                @if($location)
                    <p class="property-location">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $location }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="property-main section-padding">
    <div class="container">
        <div class="property-layout">
            {{-- معرض الصور --}}
            <div class="gallery-section">
                <div class="gallery-main">
                    <img id="mainImage" src="{{ $images[0] }}" alt="{{ $title }}">
                    <button class="gallery-nav prev" id="prevImage">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    <button class="gallery-nav next" id="nextImage">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                </div>
                @if(count($images) > 1)
                    <div class="gallery-thumbs" id="galleryThumbs">
                        @foreach($images as $index => $img)
                            <img src="{{ $img }}"
                                 alt="{{ $title }} {{ $index+1 }}"
                                 class="thumb {{ $index == 0 ? 'active' : '' }}">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- التفاصيل + صندوق التواصل --}}
            <div class="details-section">
                <div class="details-box">
                    <h4>{{ $lang == 'ar' ? 'الوصف التفصيلي' : 'Detailed description' }}</h4>
                    @if($description)
                        <div class="details-text">
                            @if($description)
    {!! $description !!}
@endif
                        </div>
                    @endif

                    @if(!empty($features))
                        <h4>{{ $lang == 'ar' ? 'مميزات إضافية' : 'Additional features' }}</h4>
                        <ul class="features-list">
                            @foreach($features as $f)
                                <li>
                                    <i class="fa-solid fa-circle-check"></i> {{ $f }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <aside class="contact-box">
                    <h3>{{ $lang == 'ar' ? 'هل أعجبك العقار؟' : 'Interested in this property?' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'تواصل الآن لحجز معاينة أو معرفة تفاصيل أكثر عن أنظمة السداد.'
                            : 'Contact us now to book a visit or know more about payment options.'
                        }}
                    </p>

                    <div class="contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <div>
                            <span>{{ $lang == 'ar' ? 'اتصل بنا' : 'Call us' }}</span>
                            <a href="tel:{{ $phone }}">{{ $phone }}</a>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="fa-brands fa-whatsapp"></i>
                        <div>
                            <span>{{ $lang == 'ar' ? 'واتساب مباشر' : 'Direct WhatsApp' }}</span>
                            <a href="https://wa.me/{{ $whatsapp }}" target="_blank">
                                {{ $lang == 'ar' ? 'راسلنا عبر واتساب' : 'Chat on WhatsApp' }}
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('front.contact').'?property='.$property->id }}"
                       class="btn btn-primary full-width" id="bookVisitBtn">
                        {{ $lang == 'ar' ? 'حجز معاينة للعقار' : 'Book a property visit' }}
                    </a>

                    <p class="note">
                        {{ $lang == 'ar'
                            ? '* المعاينة مجانية تماماً وبدون أي التزام بالشراء.'
                            : '* Viewing is completely free with no obligation to buy.'
                        }}
                    </p>
                </aside>
            </div>
        </div>

        {{-- معلومات إضافية --}}
        <div class="extra-info">
            @if($location)
                <div class="extra-card">
                    <h4>
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $lang == 'ar' ? 'موقع العقار' : 'Property location' }}
                    </h4>
                    <p>{{ $location }}</p>
                    @if($area)
                        <p>{{ $area }}</p>
                    @endif
                </div>
            @endif

            @if($legal)
                <div class="extra-card">
                    <h4>
                        <i class="fa-solid fa-file-contract"></i>
                        {{ $lang == 'ar' ? 'الحالة القانونية' : 'Legal status' }}
                    </h4>
                    <p>{{ $legal }}</p>
                </div>
            @endif

            @if($payment)
                <div class="extra-card">
                    <h4>
                        <i class="fa-solid fa-money-check-alt"></i>
                        {{ $lang == 'ar' ? 'أنظمة السداد' : 'Payment plans' }}
                    </h4>
                    <p>{!! nl2br(e($payment)) !!}</p>
                </div>
            @endif
        </div>
    </div>
</section>

@include('front.layouts.footer')

<script src="{{ asset('front/js/script.js') }}"></script>
<script src="{{ asset('front/js/property-details.js') }}"></script>

<script>
// جاليري بسيط للصور
document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('mainImage');
    const thumbs    = document.querySelectorAll('.gallery-thumbs .thumb');
    const prevBtn   = document.getElementById('prevImage');
    const nextBtn   = document.getElementById('nextImage');

    if (!mainImage || !thumbs.length) return;

    let current = 0;

    function setImage(index) {
        current = index;
        mainImage.src = thumbs[current].src;
        thumbs.forEach((t, i) => t.classList.toggle('active', i === current));
    }

    thumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', () => setImage(index));
    });

    prevBtn?.addEventListener('click', () => {
        current = (current - 1 + thumbs.length) % thumbs.length;
        setImage(current);
    });

    nextBtn?.addEventListener('click', () => {
        current = (current + 1) % thumbs.length;
        setImage(current);
    });
});
</script>

</body>
</html>
