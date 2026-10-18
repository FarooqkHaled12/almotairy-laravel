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

        <h1 class="hero-title">
            {!! $title !!}
            <br>
            <span>{{ $h1_word_1 }}</span>
        </h1>

        @if($subtitle)
            <p class="hero-subtitle">{{ $subtitle }}</p>
        @endif

        @if($desc)
            <p class="hero-description">{{ $desc }}</p>
        @endif

    </div>
</section>
@endif
