@php
    use App\Models\Faq;

    $lang = session('locale', 'ar');
    $faqs = Faq::orderBy('id')->get();
@endphp

<section class="home-faq" id="faq">
    <div class="container home-faq__inner">
        <div class="home-faq__heading">
            <h2>{{ $lang == 'ar' ? 'نربطك بعقارك المميز' : 'Connecting You to Premium Properties' }}</h2>
            <p>{{ $lang == 'ar' ? 'اكتشف إجابات واضحة تساعدك على اتخاذ قرارك العقاري بثقة.' : 'Discover answers that help you make your next real-estate decision with confidence.' }}</p>
        </div>

        <div class="home-faq__layout">
            <div class="home-faq__list">
                @forelse($faqs as $faq)
                    @php
                        $question = $lang == 'ar' ? $faq->question_ar : $faq->question_en;
                        $answer = $lang == 'ar' ? $faq->answer_ar : $faq->answer_en;
                    @endphp
                    <details class="home-faq__item" name="homepage-faq">
                        <summary>
                            <span>{{ $question }}</span>
                            <span class="home-faq__arrow" aria-hidden="true">&#8250;</span>
                        </summary>
                        <div class="home-faq__answer">{!! $answer !!}</div>
                    </details>
                @empty
                    <p class="home-faq__empty">{{ $lang == 'ar' ? 'لا توجد أسئلة شائعة حالياً.' : 'There are no frequently asked questions yet.' }}</p>
                @endforelse
            </div>
            <div class="home-faq__visual">
                <img src="{{ asset('front/img/logo.png') }}" alt="{{ $lang == 'ar' ? 'المطيري للعقارات' : 'Al-Motairy Real Estate' }}" loading="lazy">
            </div>
        </div>
    </div>
</section>
