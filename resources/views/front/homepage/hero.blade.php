@php
    use App\Models\HeroSection;

    $lang = session('locale','ar');
    $hero = HeroSection::first();
@endphp

@if($hero)
<section class="hero" id="home" @if($hero->image) style="background-image: url('{{ asset('storage/'.$hero->image) }}');" @endif>
    <div class="hero-overlay"></div>
    <div class="container hero-content">

        {{-- العنوان الرئيسي --}}
        @php
            $title      = $lang == 'ar' ? $hero->title_ar : $hero->title_en;
            $h1_word_1  = $lang == 'ar' ? $hero->highlight_word_1_ar : $hero->highlight_word_1_en;
            $subtitle   = $lang == 'ar' ? $hero->subtitle_ar : $hero->subtitle_en;
            $desc       = $lang == 'ar' ? $hero->description_ar : $hero->description_en;
        @endphp

        <div class="hero-copy">
            <h1 class="hero-title">
                {!! $title !!}
                @if($h1_word_1 && trim(strip_tags($title ?? '')) !== trim($h1_word_1))
                    <br><span>{{ $h1_word_1 }}</span>
                @endif
            </h1>

            @if($subtitle)
                <p class="hero-subtitle">{{ $subtitle }}</p>
            @endif

            @if($desc)
                <p class="hero-description">{{ $desc }}</p>
            @endif

        </div>

        <div class="hero-browse-wrap">
            <a class="hero-browse-tab" href="#properties">{{ $lang == 'ar' ? 'التصنيفات' : 'Categories' }}</a>
            <div class="hero-browse">
                <div class="hero-browse-copy">
                    <strong>{{ $lang == 'ar' ? 'العقارات المتاحة' : 'Available properties' }}</strong>
                    <span>{{ $lang == 'ar' ? 'تصفح العقارات والتصنيفات المتاحة' : 'Browse available properties and categories' }}</span>
                </div>
                <a class="hero-link" href="{{ route('front.properties') }}">{{ $lang == 'ar' ? 'عرض كل العقارات' : 'View all properties' }}</a>
            </div>
        </div>
    </div>
</section>
@endif
