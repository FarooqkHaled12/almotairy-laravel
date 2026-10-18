@php
    use App\Models\Cta;

    $lang = session('locale','ar');
    $cta  = Cta::first();
@endphp

<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            @php
                $title = $lang == 'ar' ? ($cta->title_ar ?? null) : ($cta->title_en ?? null);
                $desc  = $lang == 'ar' ? ($cta->description_ar ?? null) : ($cta->description_en ?? null);
                $btn1_text = $lang == 'ar' ? ($cta->button_1_text_ar ?? null) : ($cta->button_1_text_en ?? null);
                $btn2_text = $lang == 'ar' ? ($cta->button_2_text_ar ?? null) : ($cta->button_2_text_en ?? null);
                $btn1_link = $cta->button_1_link ?? null;
                $btn2_link = $cta->button_2_link ?? null;
            @endphp

            <h2>
                {{ $title ?: ($lang == 'ar'
                    ? 'جاهز لبدء رحلة البحث عن منزل أحلامك؟'
                    : 'Ready to start your search for the perfect home?'
                ) }}
            </h2>

            <p>
                {{ $desc ?: ($lang == 'ar'
                    ? 'تواصل معنا الآن واحصل على استشارة مجانية من فريقنا المتخصص.'
                    : 'Contact us now and get a free consultation from our expert team.'
                ) }}
            </p>

            <div class="cta-buttons">
                {{-- الزر الأول --}}
                <a href="{{ $btn1_link ?: '#contact' }}" class="btn btn-primary">
                    {{ $btn1_text ?: ($lang == 'ar' ? 'تواصل معنا' : 'Contact us') }}
                </a>

                {{-- الزر الثاني --}}
                <a href="{{ $btn2_link ?: '#properties' }}" class="btn btn-outline">
                    {{ $btn2_text ?: ($lang == 'ar' ? 'تصفح العقارات' : 'Browse properties') }}
                </a>
            </div>
        </div>
    </div>
</section>
