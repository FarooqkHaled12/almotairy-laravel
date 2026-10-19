@php
    use App\Models\AboutSection;
    use App\Models\Statistic;

    $lang = session('locale', 'ar');
    $about = AboutSection::first();
    $homeStats = Statistic::orderBy('id')->take(6)->get()->filter(fn ($stat) => trim((string) ($lang === 'ar' ? $stat->title_ar : $stat->title_en)) !== '' && trim((string) $stat->number) !== '');
@endphp

@if($about)
    @php
        $title1 = $lang == 'ar' ? $about->title_1_ar : $about->title_1_en;
        $title2 = $lang == 'ar' ? $about->title_2_ar : $about->title_2_en;
        $desc = $lang == 'ar' ? $about->description_ar : $about->description_en;
        $features = $lang == 'ar' ? ($about->features_ar ?? []) : ($about->features_en ?? []);
        $signature = $lang == 'ar' ? $about->signature_ar : $about->signature_en;
    @endphp
    <section class="about home-about section-padding" id="about">
        <div class="container">
            <div class="home-about-layout">
                <div class="home-about-copy">
                    @if($title1)<h4 class="section-subtitle">{{ $title1 }}</h4>@endif
                    @if($title2)<h2 class="section-title">{{ $title2 }}</h2>@endif
                    @if($desc)<div class="home-about-description">{!! $desc !!}</div>@endif

                    @if($homeStats->isNotEmpty())
                        <div class="home-about-stats" aria-label="{{ $lang == 'ar' ? '???????? ???????' : 'Almotairy in numbers' }}">
                            @foreach($homeStats as $stat)
                                <div class="home-about-stat"><strong>{{ $stat->number }}</strong><span>{{ $lang == 'ar' ? $stat->title_ar : $stat->title_en }}</span></div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($features))
                        <ul class="home-about-features">
                            @foreach($features as $feature)
                                <li><span class="home-about-feature-icon" aria-hidden="true">✓</span><span>{{ $feature }}</span></li>
                            @endforeach
                        </ul>
                    @endif

                    @if($signature)<p class="home-about-signature">{{ $signature }}</p>@endif
                </div>

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
