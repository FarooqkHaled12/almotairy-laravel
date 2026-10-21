@php
    use App\Models\AboutSection;

    $lang = session('locale', 'ar');
    $about = AboutSection::first();
@endphp

@if($about)
    @php
        $title1 = $lang == 'ar' ? $about->title_1_ar : $about->title_1_en;
        $title2 = $lang == 'ar' ? $about->title_2_ar : $about->title_2_en;
        $desc = $lang == 'ar' ? $about->description_ar : $about->description_en;
        // The homepage design has room for a short introduction. Keep longer CMS
        // biographies on the full About page and use a clean preview here.
        $descText = html_entity_decode(strip_tags($desc ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $descPreview = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', $descText)), 190, '…');
        $features = $lang == 'ar' ? ($about->features_ar ?? []) : ($about->features_en ?? []);
        $signature = $lang == 'ar' ? $about->signature_ar : $about->signature_en;
    @endphp
    <section class="about home-about section-padding" id="about">
        <div class="container">
            <div class="home-about-layout{{ $about->image ? '' : ' home-about-layout--no-image' }}">
                <div class="home-about-copy">
                    @if($title1)<h4 class="section-subtitle">{{ $title1 }}</h4>@endif
                    @if($title2)<h2 class="section-title">{{ $title2 }}</h2>@endif
                    @if($descPreview)<div class="home-about-description">{{ $descPreview }}</div>@endif

                    @if($desc)
                        <a class="home-about-cta" href="{{ route('front.about') }}">
                            <span>{{ $lang == 'ar' ? 'المزيد عنا' : 'More About Us' }}</span>
                            <i class="fa-solid fa-arrow-{{ $lang == 'ar' ? 'left' : 'right' }}" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>

                @if(!empty($features))
                    @php
                        $featureIcons = ['fa-gem', 'fa-shield-halved', 'fa-users', 'fa-handshake'];
                        $featureDescriptions = $lang === 'ar'
                            ? ['معرفة عميقة بالقاهرة الجديدة والقاهرة الكبرى', 'معلومات واضحة ونصائح صادقة', 'نساعدك في العثور على الوحدة المناسبة لاحتياجاتك', 'إجراءات مباشرة دون تعقيدات غير ضرورية']
                            : ['Deep knowledge of New Cairo and Greater Cairo', 'Clear information and honest advice', 'We help you find the right unit based on your needs', 'No unnecessary complications'];
                    @endphp
                    <ul class="home-about-features">
                        @foreach($features as $index => $feature)
                            @php
                                $featureParts = array_map('trim', explode('|', (string) $feature, 2));
                                $featureTitle = $featureParts[0] ?? '';
                                $featureDescription = $featureParts[1] ?? (count($features) >= 4 ? ($featureDescriptions[$index] ?? '') : '');
                            @endphp
                            <li>
                                <span class="home-about-feature-icon" aria-hidden="true"><i class="fa-solid {{ $featureIcons[$index] ?? 'fa-star' }}"></i></span>
                                <span class="home-about-feature-copy"><strong>{{ $featureTitle }}</strong>@if($featureDescription)<small>{{ $featureDescription }}</small>@endif</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if($about->image)
                    <div class="home-about-visual">
                        <div class="home-about-image">
                            <img src="{{ asset('storage/'.$about->image) }}" alt="{{ $lang == 'ar' ? 'المهندس محمود المطيري' : 'Eng. Mahmoud Al‑Mutairi' }}" loading="lazy">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
