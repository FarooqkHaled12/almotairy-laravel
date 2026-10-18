@php
    use App\Models\ContactInfoTwo;

    $lang    = session('locale','ar');
    $contact = ContactInfoTwo::first();
@endphp

<section class="contact-cards section-padding">
    <div class="container">
        <div class="cards-grid">

            {{-- كارت الهاتف --}}
            <div class="contact-card">
                <div class="card-icon">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <h3>{{ $lang == 'ar' ? 'اتصل بنا' : 'Call us' }}</h3>
                <p>
                    {{ $lang == 'ar'
                        ? 'نحن متاحون من السبت للخميس'
                        : 'Available from Saturday to Thursday'
                    }}
                </p>

                @php
                    $phone1 = $contact?->phone_1;
                    $phone2 = $contact?->phone_2;
                @endphp

                @if($phone1)
                    <a href="tel:{{ $phone1 }}" class="contact-link">{{ $phone1 }}</a>
                @endif

                @if($phone2)
                    <a href="tel:{{ $phone2 }}" class="contact-link">{{ $phone2 }}</a>
                @endif

                @if(!$phone1 && !$phone2)
                    <a href="tel:+201000000000" class="contact-link">+20 100 000 0000</a>
                    <a href="tel:+201111111111" class="contact-link">+20 111 111 1111</a>
                @endif
            </div>

            {{-- كارت الإيميلات --}}
            <div class="contact-card">
                <div class="card-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3>{{ $lang == 'ar' ? 'راسلنا بريدياً' : 'Email us' }}</h3>
                <p>
                    {{ $lang == 'ar'
                        ? 'نرد على رسائلك خلال 24 ساعة'
                        : 'We typically respond within 24 hours'
                    }}
                </p>

                @php
                    $emails = [
                        $contact?->email_1,
                        $contact?->email_2,
                        $contact?->email_3,
                    ];
                    $emails = array_filter($emails);
                @endphp

                @if(count($emails))
                    @foreach($emails as $mail)
                        <a href="mailto:{{ $mail }}" class="contact-link">{{ $mail }}</a>
                    @endforeach
                @else
                    <a href="mailto:info@khaled-realestate.com" class="contact-link">info@khaled-realestate.com</a>
                    <a href="mailto:sales@khaled-realestate.com" class="contact-link">sales@khaled-realestate.com</a>
                @endif
            </div>

            {{-- كارت العنوان --}}
            <div class="contact-card">
                <div class="card-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3>{{ $lang == 'ar' ? 'زور مكتبنا' : 'Visit our office' }}</h3>

                @php
                    $address = $contact
                        ? ($lang == 'ar' ? $contact->address_ar : $contact->address_en)
                        : null;

                    $hours = $contact?->working_hours;
                @endphp

                <p>
                    {{ $address ?: ($lang == 'ar'
                        ? 'المريوطية، شارع الهرم، الجيزة'
                        : 'Al‑Mariouteya, Al‑Haram Street, Giza'
                    ) }}
                </p>

                <a href="#map" class="contact-link">
                    {{ $lang == 'ar' ? 'عرض على الخريطة' : 'View on map' }}
                </a>

                <p class="office-hours">
                    {{ $hours ?: ($lang == 'ar'
                        ? 'مواعيد العمل: 9 ص - 6 م'
                        : 'Working hours: 9 AM - 6 PM'
                    ) }}
                </p>
            </div>

            {{-- كارت واتساب --}}
            <div class="contact-card whatsapp-card">
                <div class="card-icon">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3>WhatsApp</h3>
                <p>
                    {{ $lang == 'ar' ? 'تواصل فوري ومباشر' : 'Instant and direct contact' }}
                </p>

                @php
                    $waNumber = $contact?->whatsapp ?: '201000000000';
                @endphp

                <a href="https://wa.me/{{ $waNumber }}" class="contact-link" target="_blank">
                    <i class="fa-brands fa-whatsapp"></i>
                    {{ $lang == 'ar' ? 'أرسل رسالة الآن' : 'Send a message now' }}
                </a>
            </div>

        </div>
    </div>
</section>
