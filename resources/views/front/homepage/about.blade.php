@php
    use App\Models\AboutSection;

    $lang  = session('locale','ar');
    $about = AboutSection::first();
@endphp

@if($about)
<section class="about section-padding" id="about">
    <div class="container">
        <div class="row">

            {{-- عمود الصورة --}}
            <div class="col-image">
                <div class="about-img-wrapper">
                    @php
                        $imageUrl = $about->image
                            ? asset('storage/'.$about->image)
                            : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
                    @endphp

                    <img src="{{ $imageUrl }}" alt="{{ $lang == 'ar' ? 'المهندس محمود المطيري' : 'Eng. Mahmoud Al‑Mutairi' }}">

                    <div class="experience-badge">
                        <span>15+</span>
                        <p>{{ $lang == 'ar' ? 'سنة خبرة' : 'Years Experience' }}</p>
                    </div>
                </div>
            </div>

            {{-- عمود النص --}}
            <div class="col-text">
                @php
                    $title1    = $lang == 'ar' ? $about->title_1_ar : $about->title_1_en;
                    $title2    = $lang == 'ar' ? $about->title_2_ar : $about->title_2_en;
                    $desc      = $lang == 'ar' ? $about->description_ar : $about->description_en;
                    $features  = $lang == 'ar' ? ($about->features_ar ?? []) : ($about->features_en ?? []);
                    $signature = $lang == 'ar' ? $about->signature_ar : $about->signature_en;
                @endphp

                <h4 class="section-subtitle">
                    {{ $title1 ?: ($lang == 'ar' ? 'من أنا؟' : 'Who am I?') }}
                </h4>

                <h2 class="section-title">
                    {{ $title2 ?: ($lang == 'ar'
                        ? 'شريكك الموثوق في رحلة البحث عن المنزل المثالي'
                        : 'Your trusted partner in finding the perfect home'
                    ) }}
                </h2>

                {{-- الوصف الرئيسي من TinyMCE أو نص افتراضي --}}
                @if($desc)
                    {!! $desc !!}
                @else
                    @if($lang == 'ar')
                        <p class="about-desc">
                            مرحباً، أنا <strong>المهندس محمود المطيري</strong>، خبير ومطور عقاري متخصص في منطقتي الهرم والتجمع الخامس.
                            أؤمن أن العقار ليس مجرد جدران، بل هو استثمار العمر ومكان لصنع الذكريات.
                        </p>
                        <p class="about-desc">
                            بفضل الله، ساعدت الكثير من العائلات في العثور على وحداتهم المثالية سواء بإطلالة على الأهرامات
                            أو في قلب التجمع الخامس، مع شفافية كاملة وخيارات قانونية آمنة.
                        </p>
                    @else
                        <p class="about-desc">
                            Welcome, I am <strong>Eng. Mahmoud Al‑Mutairi</strong>, a real estate expert focused on El‑Haram and Fifth Settlement areas.
                            Real estate for me is not just walls; it is a lifetime investment and a place for memories.
                        </p>
                        <p class="about-desc">
                            By the grace of God, I have helped many families find their ideal homes, whether overlooking the pyramids
                            or in the heart of Fifth Settlement, with full transparency and safe legal options.
                        </p>
                    @endif
                @endif

                {{-- المميزات (features) --}}
                <ul class="about-features">
                    @if(!empty($features))
                        @foreach($features as $feature)
                            <li><i class="fa-solid fa-check-circle"></i> {{ $feature }}</li>
                        @endforeach
                    @else
                        @if($lang == 'ar')
                            <li><i class="fa-solid fa-check-circle"></i> عقود قانونية مسجلة.</li>
                            <li><i class="fa-solid fa-check-circle"></i> معاينات مجانية طوال الأسبوع.</li>
                            <li><i class="fa-solid fa-check-circle"></i> تسهيلات في السداد تصل إلى 5 سنوات.</li>
                            <li><i class="fa-solid fa-check-circle"></i> تشطيبات ألترا سوبر لوكس.</li>
                        @else
                            <li><i class="fa-solid fa-check-circle"></i> Registered legal contracts.</li>
                            <li><i class="fa-solid fa-check-circle"></i> Free property viewings all week.</li>
                            <li><i class="fa-solid fa-check-circle"></i> Flexible payment plans up to 5 years.</li>
                            <li><i class="fa-solid fa-check-circle"></i> Ultra super‑lux finishes.</li>
                        @endif
                    @endif
                </ul>

                {{-- التوقيع --}}
                <div class="signature">
                    <p>
                        {{ $signature ?: ($lang == 'ar' ? 'م. محمود المطيري' : 'Eng. Mahmoud Al‑Mutairi') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
@endif
