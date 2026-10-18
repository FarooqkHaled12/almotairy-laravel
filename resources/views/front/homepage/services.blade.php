@php
    use App\Models\Service;

    $lang     = session('locale','ar');
    $services = Service::orderBy('id')->take(4)->get();
@endphp

<section class="services section-padding" id="services">
    <div class="container">
        <div class="section-header text-center">
            <h4 class="section-subtitle">
                {{ $lang == 'ar' ? 'لماذا تختارنا؟' : 'Why choose us?' }}
            </h4>
            <h2 class="section-title">
                {{ $lang == 'ar' ? 'خدمات عقارية متكاملة' : 'Comprehensive real estate services' }}
            </h2>
        </div>
        
        <div class="services-grid">

            @forelse($services as $index => $service)
                @php
                    $title = $lang == 'ar' ? $service->title_ar : $service->title_en;
                    $desc  = $lang == 'ar' ? $service->description_ar : $service->description_en;

                    // أيقونات ثابتة لأول 4 خدمات (نفس اللي في التصميم)
                    $icons = [
                        'fa-solid fa-hand-holding-dollar',
                        'fa-solid fa-file-contract',
                        'fa-solid fa-paint-roller',
                        'fa-solid fa-key',
                    ];
                    $iconClass = $icons[$index] ?? 'fa-solid fa-star';
                @endphp

                <div class="service-box">
                    <div class="icon"><i class="{{ $iconClass }}"></i></div>
                    <h3>{{ $title }}</h3>
                    {{-- الوصف من TinyMCE يسمح بالـ HTML --}}
                    {!! $desc !!}
                </div>
            @empty
                {{-- لو مفيش بيانات في الجدول نعرض النص الثابت اللي كنت كاتبه --}}
                <div class="service-box">
                    <div class="icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                    <h3>{{ $lang == 'ar' ? 'تثمين عقاري' : 'Property valuation' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'نقيم عقارك بأعلى دقة وفقاً لأسعار السوق الحالية في المنطقة لضمان أفضل سعر بيع.'
                            : 'We evaluate your property according to current market prices to ensure the best selling price.'
                        }}
                    </p>
                </div>

                <div class="service-box">
                    <div class="icon"><i class="fa-solid fa-file-contract"></i></div>
                    <h3>{{ $lang == 'ar' ? 'استشارات قانونية' : 'Legal consulting' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'فريق قانوني متخصص لمراجعة كافة أوراق الملكية والتسلسل لضمان عملية شراء آمنة.'
                            : 'A specialized legal team reviews ownership documents and history for a safe purchase.'
                        }}
                    </p>
                </div>

                <div class="service-box">
                    <div class="icon"><i class="fa-solid fa-paint-roller"></i></div>
                    <h3>{{ $lang == 'ar' ? 'تشطيبات وديكور' : 'Finishing & interior design' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'نستلم وحدتك "طوب أحمر" ونسلمك إياها "على المفتاح" بأرقى التصميمات الهندسية.'
                            : 'We receive your unit as a shell and deliver it ready with premium interior designs.'
                        }}
                    </p>
                </div>

                <div class="service-box">
                    <div class="icon"><i class="fa-solid fa-key"></i></div>
                    <h3>{{ $lang == 'ar' ? 'إدارة أملاك' : 'Property management' }}</h3>
                    <p>
                        {{ $lang == 'ar'
                            ? 'نقوم بتأجير وحدتك ومتابعة تحصيل الإيجارات وصيانتها نيابة عنك.'
                            : 'We manage renting your unit, collecting payments, and handling maintenance for you.'
                        }}
                    </p>
                </div>
            @endforelse

        </div>
    </div>
</section>
