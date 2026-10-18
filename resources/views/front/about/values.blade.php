@php
    use App\Models\Value;

    $lang   = session('locale','ar');
    $values = Value::orderBy('id')->take(4)->get();
@endphp

<section class="our-values section-padding bg-light">
    <div class="container">
        <div class="section-header text-center">
            <h4 class="section-subtitle">
                {{ $lang == 'ar' ? 'قيمنا الأساسية' : 'Our core values' }}
            </h4>
            <h2 class="section-title">
                {{ $lang == 'ar' ? 'المبادئ التي نعمل بها' : 'The principles we work by' }}
            </h2>
        </div>
        
        <div class="values-grid">
            @forelse($values as $value)
                @php
                    $title = $lang == 'ar' ? $value->title_ar : $value->title_en;
                    $desc  = $lang == 'ar' ? $value->description_ar : $value->description_en;
                    $icon  = $value->icon ?: 'fa-solid fa-star';
                @endphp

                <div class="value-card">
                    <div class="value-icon">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <h3>{{ $title }}</h3>
                    {!! $desc !!}
                </div>
            @empty
                {{-- لو مفيش بيانات في الجدول نعرض القيم الافتراضية اللي كانت في الـ HTML --}}
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3>{{ $lang == 'ar' ? 'الأمانة والشفافية' : 'Honesty & transparency' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'نعمل بنزاهة تامة مع كل عميل، ولا نخفي أي تفاصيل قانونية أو فنية عن العقار.'
                            : 'We work with complete integrity and never hide any legal or technical details about the property.'
                        }}
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h3>{{ $lang == 'ar' ? 'الالتزام بالمواعيد' : 'Commitment to time' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'نحترم وقتك، ونلتزم بكل المواعيد المتفق عليها في المعاينات والإجراءات.'
                            : 'We respect your time and commit to all agreed appointments and procedures.'
                        }}
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-medal"></i>
                    </div>
                    <h3>{{ $lang == 'ar' ? 'الجودة والتميز' : 'Quality & excellence' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'نختار لك فقط العقارات التي تستحق استثمارك، بأعلى معايير الجودة.'
                            : 'We select only properties that truly deserve your investment, with top quality standards.'
                        }}
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h3>{{ $lang == 'ar' ? 'الابتكار المستمر' : 'Continuous innovation' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'نواكب أحدث التقنيات والحلول لتسهيل تجربة البحث والشراء على عملائنا.'
                            : 'We adopt the latest technologies and solutions to simplify the search and buying experience.'
                        }}
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</section>
