@extends('front.layouts.app')

@php
    $heroImg = asset('front/img/contact-imgs/' . rawurlencode('conatct img.png'));

    $inquiries = [
        ['value' => 'buy',     'icon' => 'fa-solid fa-house',           'title' => __('Buy a Property'),  'desc' => __('Find your ideal home')],
        ['value' => 'invest',  'icon' => 'fa-regular fa-building',      'title' => __('Investment'),      'desc' => __('Explore opportunities')],
        ['value' => 'sell',    'icon' => 'fa-regular fa-handshake',     'title' => __('Sell a Property'), 'desc' => __('List your property with us')],
        ['value' => 'general', 'icon' => 'fa-regular fa-comments',      'title' => __('General Inquiry'), 'desc' => __('Ask any question')],
    ];
    $selectedInquiry = old('interest', 'buy');

    $reasons = [
        ['icon' => 'fa-regular fa-user',      'title' => __('Personalized Support'),    'desc' => __('Tailored advice based on your needs.')],
        ['icon' => 'fa-solid fa-shield-halved','title' => __('Trusted Guidance'),       'desc' => __('Honest and transparent communication.')],
        ['icon' => 'fa-solid fa-chart-column', 'title' => __('Market Expertise'),       'desc' => __('In-depth knowledge of Egypt’s real estate market.')],
        ['icon' => 'fa-solid fa-user-group',   'title' => __('Long-Term Relationship'), 'desc' => __('We’re here for your future goals.')],
    ];
@endphp

@section('title', __('Contact Us') . ' - ' . __('Al-Motairy Real Estate'))

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/css/page-base.css') }}?v={{ file_exists(public_path('front/css/page-base.css')) ? filemtime(public_path('front/css/page-base.css')) : '1' }}">
    <link rel="stylesheet" href="{{ asset('front/css/contact.css') }}?v={{ file_exists(public_path('front/css/contact.css')) ? filemtime(public_path('front/css/contact.css')) : '1' }}">
@endpush

@section('content')
<div class="ab-page ct-page">

    {{-- الهيرو --}}
    <section class="ct-hero" style="--ct-hero-img: url('{{ $heroImg }}')">
        <div class="container ct-hero-inner">
            <div class="ct-hero-copy">
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Contact Us') }}</span>
                <h1 class="ct-hero-title">{{ __('Let’s Build Your Next Opportunity') }}</h1>
                <p class="ct-hero-text">{{ __('Get in touch with our team for expert guidance, personalized consultation, or any inquiries.') }}</p>
                <ul class="ct-hero-points">
                    <li><i class="fa-regular fa-handshake" aria-hidden="true"></i>{{ __('Direct & Personal Support') }}</li>
                    <li><i class="fa-regular fa-clock" aria-hidden="true"></i>{{ __('Quick Response') }}</li>
                    <li><i class="fa-regular fa-lightbulb" aria-hidden="true"></i>{{ __('Tailored Recommendations') }}</li>
                </ul>
            </div>
            <p class="ct-hero-note">{{ __('Your goals.') }}<br>{{ __('Our guidance.') }}<br>{{ __('A better tomorrow.') }}</p>
        </div>
    </section>

    {{-- نموذج التواصل --}}
    <section class="ab-section ct-form-section" id="contact-form">
        <div class="container ct-form-grid">
            <div>
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Send Us a Message') }}</span>
                <h2 class="ab-title ab-title--serif">{{ __('How Can We Help You?') }}</h2>
                <p class="ab-text">{{ __('Whether you’re looking to buy, invest, or simply explore your options, our team is here to provide the right support.') }}</p>

                <div class="ct-inquiries" role="group" aria-label="{{ __('Inquiry Type') }}">
                    @foreach($inquiries as $inquiry)
                        <button type="button" class="ct-inquiry {{ $selectedInquiry === $inquiry['value'] ? 'is-active' : '' }}" data-inquiry="{{ $inquiry['value'] }}" aria-pressed="{{ $selectedInquiry === $inquiry['value'] ? 'true' : 'false' }}">
                            <i class="{{ $inquiry['icon'] }} ct-inquiry-icon" aria-hidden="true"></i>
                            <span class="ct-inquiry-text">
                                <strong>{{ $inquiry['title'] }}</strong>
                                <span>{{ $inquiry['desc'] }}</span>
                            </span>
                            <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="ct-form-card">
                <div class="ct-form-head">
                    <div>
                        <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Your Details') }}</span>
                        <h2 class="ab-title ab-title--serif ab-title--light">{{ __('Send Us a Message') }}</h2>
                    </div>
                    <p>{{ __('Our team will get back to you as soon as possible.') }}</p>
                </div>

                @if(session('success'))
                    <div class="ct-alert ct-alert--success" role="status">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="ct-alert ct-alert--error" role="alert">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('front.contact.submit') }}" class="ct-form">
                    @csrf
                    <label class="ct-field ct-field--full">
                        <i class="fa-regular fa-user" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('Full Name') }}</span>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('Full Name') }}" autocomplete="name" required>
                    </label>
                    <label class="ct-field">
                        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('Email Address') }}</span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email Address') }}" autocomplete="email">
                    </label>
                    <label class="ct-field">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('Phone Number') }}</span>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="{{ __('Phone Number') }}" autocomplete="tel" required>
                    </label>
                    <label class="ct-field ct-field--full ct-field--select">
                        <i class="fa-regular fa-comments" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('Inquiry Type') }}</span>
                        <select name="interest" id="ct-interest">
                            @foreach($inquiries as $inquiry)
                                <option value="{{ $inquiry['value'] }}" @selected($selectedInquiry === $inquiry['value'])>{{ $inquiry['title'] }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="ct-field ct-field--full ct-field--textarea">
                        <i class="fa-regular fa-message" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('Your Message (Optional)') }}</span>
                        <textarea name="message" rows="4" placeholder="{{ __('Your Message (Optional)') }}">{{ old('message') }}</textarea>
                    </label>
                    <button type="submit" class="ab-btn ab-btn--gold ct-submit">{{ __('Send Message') }} <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i></button>
                    <p class="ct-secure"><i class="fa-solid fa-lock" aria-hidden="true"></i> {{ __('Your information is secure and will only be used to respond to your inquiry.') }}</p>
                </form>
            </div>
        </div>
    </section>

    {{-- طرق التواصل المباشر --}}
    <section class="ct-direct">
        <div class="container">
            <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Other Ways to Reach Us') }}</span>
            <h2 class="ab-title ab-title--serif">{{ __('Direct Contact') }}</h2>
            <ul class="ct-direct-grid">
                <li>
                    <i class="fa-solid fa-phone ct-direct-icon" aria-hidden="true"></i>
                    <div>
                        <strong>{{ __('Call Us') }}</strong>
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $contact['phone']) }}" dir="ltr">{{ $contact['phone'] }}</a>
                        <span>{{ $contact['hours'] }}</span>
                    </div>
                </li>
                <li>
                    <i class="fa-regular fa-envelope ct-direct-icon" aria-hidden="true"></i>
                    <div>
                        <strong>{{ __('Email Us') }}</strong>
                        <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
                        <span>{{ __('We reply within 24 hours') }}</span>
                    </div>
                </li>
                <li>
                    <i class="fa-brands fa-whatsapp ct-direct-icon" aria-hidden="true"></i>
                    <div>
                        <strong>{{ __('WhatsApp') }}</strong>
                        <a href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener" dir="ltr">+{{ $contact['whatsapp'] }}</a>
                        <span>{{ __('Chat with our team') }}</span>
                    </div>
                </li>
                <li>
                    <i class="fa-solid fa-location-dot ct-direct-icon" aria-hidden="true"></i>
                    <div>
                        <strong>{{ __('Visit Us') }}</strong>
                        <a href="#ct-map">{{ $contact['address'] }}</a>
                        <span>{{ __('Our main office') }}</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    {{-- الموقع والخريطة --}}
    <section class="ab-section ct-location" id="ct-map">
        <div class="container ct-location-grid">
            <div>
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Our Location') }}</span>
                <h2 class="ab-title ab-title--serif">{{ __('Visit Our Office') }}</h2>
                <p class="ab-text">{{ __('We’d love to welcome you to our office. Meet our team in person and discuss your goals.') }}</p>

                <ul class="ct-location-list">
                    <li>
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <div><strong>{{ __('Address') }}</strong><span>{{ $contact['address'] }}</span></div>
                    </li>
                    <li>
                        <i class="fa-regular fa-clock" aria-hidden="true"></i>
                        <div><strong>{{ __('Working Hours') }}</strong><span>{{ $contact['hours'] }}</span></div>
                    </li>
                    <li>
                        <a href="{{ $directionsUrl }}" target="_blank" rel="noopener" class="ct-directions">
                            <i class="fa-solid fa-car" aria-hidden="true"></i>
                            <div><strong>{{ __('Get Directions') }}</strong><span>{{ __('Open in Google Maps') }}</span></div>
                            <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="ct-map">
                @if($mapEmbed)
                    {!! $mapEmbed !!}
                @else
                    <iframe src="{{ $mapSrc }}" title="{{ __('Our office location on Google Maps') }}" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                @endif
            </div>
        </div>
    </section>

    {{-- لماذا تتواصل معنا --}}
    <section class="ct-reasons">
        <div class="container ct-reasons-grid">
            <div class="ct-reasons-head">
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Why Contact Us') }}</span>
                <h2 class="ab-title ab-title--serif ab-title--light">{{ __('More Than Just a Message') }}</h2>
            </div>
            @foreach($reasons as $reason)
                <div class="ct-reason">
                    <i class="{{ $reason['icon'] }}" aria-hidden="true"></i>
                    <h3>{{ $reason['title'] }}</h3>
                    <p>{{ $reason['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- دعوة أخيرة --}}
    <section class="ct-cta" style="--ct-hero-img: url('{{ $heroImg }}')">
        <div class="container">
            <div class="ct-cta-copy">
                <span class="ab-eyebrow ab-eyebrow--gold">{{ __('Get in Touch') }}</span>
                <h2 class="ab-title ab-title--serif ab-title--light">{{ __('Let’s Turn Your Plans into Reality') }}</h2>
                <p>{{ __('Whether you’re searching for your next home or a promising investment, our team is here to help you take the next step.') }}</p>
                <a href="#contact-form" class="ab-btn ab-btn--gold">{{ __('Contact Our Team') }} <i class="fa-solid fa-arrow-right ab-arrow" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('front/js/contact.js') }}?v={{ file_exists(public_path('front/js/contact.js')) ? filemtime(public_path('front/js/contact.js')) : '1' }}"></script>
@endpush
