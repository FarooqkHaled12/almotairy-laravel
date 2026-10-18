@php
    use App\Models\WhyChooseUs;

    $lang = session('locale','ar');
    $why  = WhyChooseUs::first();
@endphp

@if($why)
<section class="why-us section-padding">
    <div class="container">
        <div class="row align-center">

            {{-- صورة القسم --}}
            <div class="col-image">
                @php
                    $imageUrl = $why->image
                        ? asset('storage/'.$why->image)
                        : 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600';
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $lang == 'ar' ? 'لماذا نحن' : 'Why choose us' }}">
            </div>

            {{-- النص --}}
            <div class="col-text">
                @php
                    $highlight = $lang == 'ar' ? $why->highlight_word_ar : $why->highlight_word_en;
                    $title     = $lang == 'ar' ? $why->title_ar          : $why->title_en;

                    $points = [];
                    for ($i = 1; $i <= 4; $i++) {
                        $t = $lang == 'ar' ? $why->{"point_{$i}_title_ar"}  : $why->{"point_{$i}_title_en"};
                        $d = $lang == 'ar' ? $why->{"point_{$i}_desc_ar"}   : $why->{"point_{$i}_desc_en"};
                        if ($t || $d) {
                            $points[] = ['title' => $t, 'desc' => $d];
                        }
                    }
                @endphp

                <h4 class="section-subtitle">
                    {{ $highlight ?: ($lang == 'ar' ? 'التميز في كل تفصيلة' : 'Excellence in every detail') }}
                </h4>

                <h2 class="section-title">
                    {{ $title ?: ($lang == 'ar'
                        ? 'لماذا تختار المهندس محمود المطيري؟'
                        : 'Why choose Eng. Mahmoud Al‑Mutairi?'
                    ) }}
                </h2>

                <ul class="why-list">
                    @if(count($points))
                        @foreach($points as $point)
                            <li>
                                <i class="fa-solid fa-circle-check"></i>
                                <div>
                                    @if($point['title'])
                                        <strong>{{ $point['title'] }}</strong>
                                    @endif
                                    @if($point['desc'])
                                        <p>{{ $point['desc'] }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    @else
                        {{-- النقاط الافتراضية لو مفيش داتا في الجدول --}}
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            <div>
                                <strong>{{ $lang == 'ar' ? 'خبرة محلية عميقة:' : 'Deep local expertise:' }}</strong>
                                <p>
                                    {{ $lang == 'ar'
                                        ? 'نعرف كل شارع وحي في الهرم والتجمع الخامس.'
                                        : 'We know every street and neighborhood in El‑Haram and Fifth Settlement.'
                                    }}
                                </p>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            <div>
                                <strong>{{ $lang == 'ar' ? 'شبكة علاقات واسعة:' : 'Wide connections network:' }}</strong>
                                <p>
                                    {{ $lang == 'ar'
                                        ? 'علاقات مباشرة مع كبار المطورين والملاك.'
                                        : 'Direct relationships with major developers and property owners.'
                                    }}
                                </p>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            <div>
                                <strong>{{ $lang == 'ar' ? 'خدمة ما بعد البيع:' : 'After‑sales service:' }}</strong>
                                <p>
                                    {{ $lang == 'ar'
                                        ? 'نتابع معك كل الإجراءات حتى استلام المفتاح.'
                                        : 'We assist you with all procedures until key handover.'
                                    }}
                                </p>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            <div>
                                <strong>{{ $lang == 'ar' ? 'تقييمات إيجابية:' : 'Positive reviews:' }}</strong>
                                <p>
                                    {{ $lang == 'ar'
                                        ? 'مئات التقييمات الخمس نجوم من عملاء راضين.'
                                        : 'Hundreds of five‑star reviews from satisfied clients.'
                                    }}
                                </p>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    </div>
</section>
@endif
