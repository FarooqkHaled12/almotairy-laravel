@php
    use App\Models\Statistic;

    $lang  = session('locale','ar');
    $stats = Statistic::orderBy('id')->take(4)->get();
@endphp

<section class="achievements section-padding">
    <div class="container">
        <div class="achievements-grid">

            @forelse($stats as $stat)
                @php
                    // القيمة المخزَّنة في الداتابيس: fa-heart, fa-star, fa-chart-line ...
                    $iconName = $stat->icon ?: 'fa-star';
                    // نضيف الـ prefix بتاع فاونت أويسم
                    $icon  = 'fa-solid '.$iconName;
                    $num   = $stat->number ?: 0;
                    $title = $lang == 'ar' ? $stat->title_ar : $stat->title_en;
                @endphp

                <div class="achievement-item">
                    <div class="achievement-icon">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <h3 class="achievement-number" data-target="{{ $num }}">0</h3>
                    <p>{{ $title ?: ($lang == 'ar' ? 'إحصائية' : 'Statistic') }}</p>
                </div>
            @empty
                {{-- لو مفيش بيانات في الجدول نعرض الإعداد الافتراضي --}}
                <div class="achievement-item">
                    <div class="achievement-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <h3 class="achievement-number" data-target="250">0</h3>
                    <p>{{ $lang == 'ar' ? 'عقار تم بيعه' : 'Properties sold' }}</p>
                </div>

                <div class="achievement-item">
                    <div class="achievement-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="achievement-number" data-target="500">0</h3>
                    <p>{{ $lang == 'ar' ? 'عميل سعيد' : 'Happy clients' }}</p>
                </div>

                <div class="achievement-item">
                    <div class="achievement-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3 class="achievement-number" data-target="15">0</h3>
                    <p>{{ $lang == 'ar' ? 'سنة خبرة' : 'Years of experience' }}</p>
                </div>

                <div class="achievement-item">
                    <div class="achievement-icon">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <h3 class="achievement-number" data-target="98">0</h3>
                    <p>{{ $lang == 'ar' ? 'نسبة الرضا %' : 'Satisfaction rate %' }}</p>
                </div>
            @endforelse

        </div>
    </div>
</section>

<script>
// أنيميشن عدّاد الأرقام عند ظهور القسم
document.addEventListener('DOMContentLoaded', function () {
    const counters = document.querySelectorAll('.achievement-number');
    if (!counters.length) return;

    const options = { threshold: 0.4 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const el = entry.target;
            const target = +el.getAttribute('data-target');
            let current = 0;
            const step = Math.max(1, Math.floor(target / 100));

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = current;
            }, 20);

            observer.unobserve(el);
        });
    }, options);

    counters.forEach(c => observer.observe(c));
});
</script>
