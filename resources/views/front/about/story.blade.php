@php
    use App\Models\OurStory;

    $lang  = session('locale','ar');
    $story = OurStory::first();
@endphp

@if($story)
<section class="our-story section-padding">
    <div class="container">
        <div class="row align-center">
            <div class="col-text">
                <h4 class="section-subtitle">
                    {{ $lang == 'ar' ? 'قصتنا' : 'Our Story' }}
                </h4>

                @php
                    $title = $lang == 'ar' ? $story->title_ar : $story->title_en;
                    $desc  = $lang == 'ar' ? $story->description_ar : $story->description_en;
                    $name  = $lang == 'ar' ? $story->name_ar : $story->name_en;
                    $pos   = $lang == 'ar' ? $story->position_ar : $story->position_en;
                @endphp

                <h2 class="section-title">
                    {{ $title ?: ($lang == 'ar'
                        ? 'رحلة بدأت بحلم... واستمرت بإنجازات'
                        : 'A journey that started with a dream and grew with achievements'
                    ) }}
                </h2>

                {{-- الوصف من محرر TinyMCE أو النص الافتراضي --}}
                @if($desc)
                    {!! $desc !!}
                @else
                    @if($lang == 'ar')
                        <p class="story-text">
                            في عام <strong>2009</strong>، بدأ المهندس محمود المطيري مسيرته في عالم العقارات بشغف كبير ورؤية واضحة:
                            مساعدة العائلات المصرية في إيجاد منزل أحلامها بأعلى معايير الشفافية والمصداقية.
                        </p>
                        <p class="story-text">
                            من مكتب صغير إلى مئات الوحدات السكنية والتجارية في أرقى مناطق القاهرة الكبرى،
                            نجحنا في بناء سمعة قوية تقوم على الثقة والجودة والالتزام.
                        </p>
                        <p class="story-text">
                            اليوم، نحن لسنا مجرد وسطاء عقاريين، بل شركاء حقيقيون في رحلة البحث عن الاستثمار الأمثل
                            والعقار المناسب لكل عميل.
                        </p>
                    @else
                        <p class="story-text">
                            In <strong>2009</strong>, Eng. Mahmoud Al‑Mutairi started his journey in real estate with a clear vision:
                            helping families find their dream homes with full transparency and integrity.
                        </p>
                        <p class="story-text">
                            From a small office to hundreds of residential and commercial units in prime areas of Greater Cairo,
                            we have built a strong reputation based on trust, quality, and commitment.
                        </p>
                        <p class="story-text">
                            Today, we are not just real estate brokers, but real partners in your search
                            for the best investment and the right property.
                        </p>
                    @endif
                @endif

                <div class="story-signature">
                    <div>
                        <p><strong>{{ $name ?: ($lang == 'ar' ? 'م. محمود المطيري' : 'Eng. Mahmoud Al‑Mutairi') }}</strong></p>
                        <span>
                            {{ $pos ?: ($lang == 'ar' ? 'المؤسس والمدير التنفيذي' : 'Founder & CEO') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-image">
                <div class="story-image-grid">
                    @php
                        $imageUrl = $story->image
                            ? asset('storage/'.$story->image)
                            : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400';
                    @endphp

                    <img src="{{ $imageUrl }}" alt="{{ $lang == 'ar' ? 'قصتنا' : 'Our Story' }}">
                </div>
            </div>
        </div>
    </div>
</section>
@endif
