@php
    use App\Models\Faq;

    $lang = session('locale','ar');
    $faqs = Faq::orderBy('id')->get();
@endphp

<section class="faq section-padding bg-light" id="faq">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                {{ $lang == 'ar' ? 'الأسئلة الأكثر شيوعاً' : 'Most common questions' }}
            </h2>
        </div>
        
        <div class="faq-container">
            @forelse($faqs as $faq)
                @php
                    $question = $lang == 'ar' ? $faq->question_ar : $faq->question_en;
                    $answer   = $lang == 'ar' ? $faq->answer_ar   : $faq->answer_en;
                @endphp

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>{{ $question }}</h3>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        {!! $answer !!}
                    </div>
                </div>
            @empty
                {{-- الأسئلة الافتراضية لو الجدول فاضي --}}
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>{{ $lang == 'ar' ? 'هل العقارات مسجلة شهر عقاري؟' : 'Are the properties officially registered?' }}</h3>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>
                            {{ $lang == 'ar'
                                ? 'نعم، جميع العقارات التي نقوم بتسويقها يتم مراجعة أوراقها قانونياً، وتتنوع بين مسجلة شهر عقاري أو لها صحة توقيع ونفاذ وحصة في الأرض.'
                                : 'Yes, all properties we market are legally reviewed and range from fully registered titles to notarized contracts with land share.'
                            }}
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>{{ $lang == 'ar' ? 'ما هي أنظمة السداد المتاحة؟' : 'What payment plans are available?' }}</h3>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>
                            {{ $lang == 'ar'
                                ? 'نقدم أنظمة سداد متنوعة، منها الكاش بخصومات كبيرة، ومنها التقسيط المباشر مع المالك حتى 3 سنوات، أو تقسيط مع شركات التطوير العقاري حتى 8 سنوات.'
                                : 'We offer various plans: cash with discounts, direct installments with the owner up to 3 years, or with developers up to 8 years.'
                            }}
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>{{ $lang == 'ar' ? 'هل يوجد رسوم للمعاينة؟' : 'Are there viewing fees?' }}</h3>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>
                            {{ $lang == 'ar'
                                ? 'لا، المعاينات مجانية تماماً طوال أيام الأسبوع بالتنسيق المسبق معنا.'
                                : 'No, viewings are completely free throughout the week with prior coordination.'
                            }}
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>{{ $lang == 'ar' ? 'هل تعملون في مناطق أخرى غير الهرم والتجمع؟' : 'Do you work in other areas?' }}</h3>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>
                            {{ $lang == 'ar'
                                ? 'تركيزنا الأساسي وخبرتنا الأكبر في الهرم والتجمع، ولكن لدينا تعاقدات خاصة في الشيخ زايد والعاصمة الإدارية أيضاً.'
                                : 'Our main focus is El‑Haram and Fifth Settlement, but we also have special agreements in Sheikh Zayed and the New Administrative Capital.'
                            }}
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.faq-item');

    items.forEach(item => {
        const question = item.querySelector('.faq-question');
        const icon     = item.querySelector('.faq-question i');
        const answer   = item.querySelector('.faq-answer');

        question.addEventListener('click', () => {
            const isOpen = item.classList.contains('active');

            document.querySelectorAll('.faq-item').forEach(i => {
                i.classList.remove('active');
                i.querySelector('.faq-answer').style.maxHeight = null;
                i.querySelector('.faq-question i').classList.remove('rotated');
            });

            if (!isOpen) {
                item.classList.add('active');
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.classList.add('rotated');
            }
        });
    });
});
</script>

<style>
.faq-container{
    max-width:800px;
    margin:0 auto;
}
.faq-item{
    background:#fff;
    border-radius:8px;
    margin-bottom:10px;
    box-shadow:0 1px 3px rgba(0,0,0,.06);
    overflow:hidden;
}
.faq-question{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 20px;
    cursor:pointer;
}
.faq-question h3{
    margin:0;
    font-size:1rem;
}
.faq-question i{
    transition:.3s;
}
.faq-question i.rotated{
    transform:rotate(180deg);
}
.faq-answer{
    padding:0 20px;
    max-height:0;
    overflow:hidden;
    transition:max-height .3s ease;
}
.faq-answer p{
    margin:10px 0 15px;
}
</style>
