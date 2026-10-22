@extends('front.layouts.app')

@php
    $img = fn ($name) => asset('front/img/about-imgs/' . rawurlencode($name));

    // النصوص الافتراضية تظهر فقط لو الجداول فاضية في لوحة التحكم
    if ($stats->isEmpty()) {
        $stats = collect([
            ['icon' => 'fa-regular fa-building',   'number' => '10+',  'title' => __('Completed Projects')],
            ['icon' => 'fa-regular fa-calendar',   'number' => '7+',   'title' => __('Years of Experience')],
            ['icon' => 'fa-solid fa-user-group',   'number' => '500+', 'title' => __('Happy Clients')],
            ['icon' => 'fa-solid fa-house',        'number' => '200+', 'title' => __('Properties Available')],
            ['icon' => 'fa-solid fa-location-dot', 'number' => '6',    'title' => __('Key Locations in Egypt')],
        ]);
    }

    if ($values->isEmpty()) {
        $values = collect([
            ['icon' => 'fa-regular fa-gem',     'title' => __('Trust & Transparency'), 'desc' => __('We believe in honest communication and clear guidance at every step.')],
            ['icon' => 'fa-solid fa-award',     'title' => __('Quality & Excellence'), 'desc' => __('We focus on delivering high-quality opportunities and professional services.')],
            ['icon' => 'fa-solid fa-users',     'title' => __('Client Commitment'),    'desc' => __('We put our clients’ goals first and work to provide tailored solutions.')],
            ['icon' => 'fa-solid fa-chart-line','title' => __('Long-Term Value'),      'desc' => __('We help clients make informed decisions for a better future.')],
        ]);
    }

    if ($expertise->isEmpty()) {
        $expertise = collect([
            ['title' => __('Property Sales'),            'desc' => __('Residential, commercial and investment properties')],
            ['title' => __('Real Estate Investment'),    'desc' => __('Expert advice for high-potential opportunities')],
            ['title' => __('Property Valuation'),        'desc' => __('Accurate and professional property assessment')],
            ['title' => __('Asset Management'),          'desc' => __('Ongoing support to maximize your property’s value')],
        ]);
    }
    $expertiseIcons = ['fa-solid fa-house-chimney', 'fa-solid fa-chart-column', 'fa-solid fa-coins', 'fa-regular fa-circle-check'];

    $ctaTitle = ($lang === 'ar' ? $cta?->title_ar : $cta?->title_en) ?: __('Let’s Build Your Next Chapter.');
    $ctaDesc  = ($lang === 'ar' ? $cta?->description_ar : $cta?->description_en) ?: __('Get in touch with our team and explore the right opportunities for you.');
    $ctaBtn   = ($lang === 'ar' ? $cta?->button_1_text_ar : $cta?->button_1_text_en) ?: __('Contact Us');
    $ctaLink  = $cta?->button_1_link ?: route('front.contact');

    $storySlides = [
        ['src' => 'Reference photography.png', 'alt' => __('Luxury villa with a swimming pool at sunset')],
        ['src' => 'Original photograph.png',   'alt' => __('Modern residential street at sunset')],
        ['src' => 'house1.png',                'alt' => __('Modern apartment building at night')],
    ];
@endphp

@section('title', __('About Us') . ' - ' . __('Al-Motairy Real Estate'))

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/css/page-base.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/about-us.css') }}">
@endpush

@section('content')
<div class="ab-page">

    {{-- عن المؤسس --}}
    <section class="ab-hero" style="--ab-hero-img: url('{{ $img('main cover.png') }}')">
        <div class="container ab-hero-inner">
            <div class="ab-hero-copy">
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('About the Founder') }}</span>
                <h1 class="ab-hero-title">{{ __('Khaled AlMotairy') }}</h1>
                <p class="ab-hero-tagline">{{ __('A Vision Beyond Real Estate') }}</p>
                <p class="ab-hero-text">{{ __('With years of experience and a deep understanding of the real estate market, Khaled AlMotairy founded the company with a clear vision: to create real value, build long-term relationships, and help people find the right opportunities.') }}</p>
                <a href="#ab-story" class="ab-btn ab-btn--gold">{{ __('Discover His Story') }} <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i></a>
            </div>

            <blockquote class="ab-hero-quote">
                <p>{{ __('“Real estate is not just buildings, it’s people, trust and a better future.”') }}</p>
                <footer>— {{ __('Khaled AlMotairy') }}</footer>
                <span class="ab-signature" aria-hidden="true">{{ __('Khaled AlMotairy') }}</span>
            </blockquote>
        </div>
    </section>

    {{-- من نحن --}}
    <section class="ab-section ab-intro">
        <div class="container ab-split">
            <div class="ab-split-copy">
                <span class="ab-eyebrow">{{ __('Who We Are') }}</span>
                <h2 class="ab-title">{{ __('Building Value Beyond Properties') }}</h2>
                <p class="ab-text">{{ __('AlMotairy Real Estate is a professional real estate company specialized in property sales, investment consultancy, and real estate development. We are committed to providing reliable guidance, market insights, and tailored solutions to help our clients make informed decisions.') }}</p>
                <a href="#ab-story" class="ab-btn ab-btn--outline">{{ __('Discover Our Story') }} <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i></a>
            </div>
            <div class="ab-split-media">
                <img src="{{ $img('house1.png') }}" alt="{{ __('Modern apartment building at night') }}" loading="lazy">
            </div>
        </div>
    </section>

    {{-- قصتنا والإحصائيات --}}
    <section class="ab-section ab-story" id="ab-story">
        <div class="container ab-story-grid">
            <div class="ab-story-copy">
                <span class="ab-eyebrow">{{ __('Our Story') }}</span>
                <h2 class="ab-title">{{ __('A Vision for Better Real Estate') }}</h2>
                <p class="ab-text">{{ __('Our journey is built on a passion for real estate and a commitment to creating long-term value. We work closely with our clients to understand their needs, explore the best opportunities, and ensure a smooth and transparent experience from start to finish.') }}</p>

                <div class="ab-slider" data-ab-slider>
                    <div class="ab-slider-track">
                        @foreach($storySlides as $i => $slide)
                            <img src="{{ $img($slide['src']) }}" alt="{{ $slide['alt'] }}" class="{{ $i === 0 ? 'is-active' : '' }}" loading="lazy">
                        @endforeach
                    </div>
                    <div class="ab-slider-nav">
                        <button type="button" class="ab-slider-btn" data-ab-prev aria-label="{{ __('Previous image') }}"><i class="fa-solid fa-arrow-left ab-arrow" aria-hidden="true"></i></button>
                        <button type="button" class="ab-slider-btn" data-ab-next aria-label="{{ __('Next image') }}"><i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <div class="ab-stats-wrap">
                <ul class="ab-stats" aria-label="{{ __('AlMotairy in numbers') }}">
                    @foreach($stats as $stat)
                        <li class="ab-stat">
                            <i class="{{ $stat['icon'] }}" aria-hidden="true"></i>
                            <div>
                                <strong>{{ $stat['number'] }}</strong>
                                <span>{{ $stat['title'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('front.properties') }}" class="ab-link">{{ __('View Our Projects') }} <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>

    {{-- قيمنا --}}
    <section class="ab-values">
        <div class="container">
            <div class="ab-values-head">
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Our Values') }}</span>
                <h2 class="ab-title ab-title--light">{{ __('The Values Behind Everything We Do') }}</h2>
            </div>
            <div class="ab-values-grid">
                @foreach($values as $value)
                    <div class="ab-value">
                        <i class="{{ $value['icon'] }} ab-value-icon" aria-hidden="true"></i>
                        <h3>{{ $value['title'] }}</h3>
                        <div class="ab-value-desc">{!! $value['desc'] !!}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- رؤيتنا --}}
    <section class="ab-section ab-vision">
        <div class="container ab-split">
            <div class="ab-split-copy">
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Our Vision') }}</span>
                <h2 class="ab-title ab-title--serif">{{ __('Shaping Better Real Estate Opportunities') }}</h2>
                <p class="ab-text">{{ __('Khaled AlMotairy’s vision is to be a trusted real estate partner, helping individuals and investors find the right opportunities and create lasting value across Egypt’s most promising locations.') }}</p>
                <a href="#ab-expertise" class="ab-btn ab-btn--gold">{{ __('Explore Our Approach') }} <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i></a>
            </div>
            <div class="ab-split-media ab-split-media--wide">
                <img src="{{ $img('Original photograph.png') }}" alt="{{ __('Modern residential street at sunset') }}" loading="lazy">
            </div>
        </div>
    </section>

    {{-- اقتباس --}}
    <section class="ab-quote" style="--ab-quote-img: url('{{ $img('cover section.png') }}')">
        <div class="container">
            <blockquote>
                <p>{{ __('“My goal has always been to build more than properties, I want to build opportunities and better lives.”') }}</p>
                <footer>— {{ __('Khaled AlMotairy') }}</footer>
            </blockquote>
        </div>
    </section>

    {{-- خبراتنا --}}
    <section class="ab-section ab-expertise" id="ab-expertise">
        <div class="container ab-expertise-grid">
            <div>
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Our Expertise') }}</span>
                <h2 class="ab-title ab-title--serif">{{ __('Real Estate Guidance You Can Rely On') }}</h2>
                <p class="ab-text">{{ __('With a strong market understanding and a client-first approach, we provide expert guidance across all real estate needs.') }}</p>
            </div>
            <ul class="ab-expertise-list">
                @foreach($expertise as $i => $item)
                    <li>
                        <i class="{{ $expertiseIcons[$i % count($expertiseIcons)] }}" aria-hidden="true"></i>
                        <div>
                            @if($item['title'])<strong>{{ $item['title'] }}</strong>@endif
                            @if($item['desc'])<span>{{ $item['desc'] }}</span>@endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- دعوة للتواصل --}}
    <section class="ab-cta" style="--ab-cta-img: url('{{ $img('cover section2.png') }}')">
        <div class="container ab-cta-inner">
            <div class="ab-cta-copy">
                <h2 class="ab-title ab-title--serif ab-title--light">{{ $ctaTitle }}</h2>
                <p>{{ $ctaDesc }}</p>
                <a href="{{ $ctaLink }}" class="ab-btn ab-btn--gold">{{ $ctaBtn }} <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i></a>
            </div>
            <p class="ab-cta-note">{{ __('Your goals.') }}<br>{{ __('Our guidance.') }}<br>{{ __('A better tomorrow.') }}</p>
        </div>
    </section>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('front/js/about-us.js') }}"></script>
@endpush
