@php
    use App\Models\ContactInfo;

    $lang    = session('locale','ar');
    $contact = ContactInfo::first();
@endphp

<section class="contact section-padding" id="contact">
    <div class="container">
        <div class="contact-wrapper">

            {{-- معلومات التواصل --}}
            <div class="contact-info">
                <h2 class="section-title text-white">
                    {{ $lang == 'ar' ? 'تواصل معنا الآن' : 'Contact us now' }}
                </h2>
                <p class="text-white-50">
                    {{ $lang == 'ar'
                        ? 'جاهزون للرد على استفساراتكم وتحديد مواعيد المعاينة.'
                        : 'Ready to answer your questions and schedule property viewings.'
                    }}
                </p>

                <div class="info-item">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <h4>{{ $lang == 'ar' ? 'اتصل بنا' : 'Call us' }}</h4>
                        <p>{{ $contact?->phone ?? '+20 100 000 0000' }}</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <h4>{{ $lang == 'ar' ? 'البريد الإلكتروني' : 'Email' }}</h4>
                        <p>{{ $contact?->email ?? 'info@example.com' }}</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>
                        <h4>{{ $lang == 'ar' ? 'المكتب الرئيسي' : 'Head office' }}</h4>
                        <p>
                            {{ $contact
                                ? ($lang == 'ar' ? $contact->address_ar : $contact->address_en)
                                : ($lang == 'ar' ? 'المريوطية، الهرم، الجيزة' : 'Al‑Mariouteya, El‑Haram, Giza')
                            }}
                        </p>
                    </div>
                </div>

                <div class="social-links">
                    @if($contact?->facebook)
                        <a href="{{ $contact->facebook }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    @endif
                    @if($contact?->instagram)
                        <a href="{{ $contact->instagram }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if($contact?->youtube)
                        <a href="{{ $contact->youtube }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    @endif
                    @if($contact?->whatsapp)
                        <a href="https://wa.me/{{ $contact->whatsapp }}" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    @endif
                </div>
            </div>

            {{-- نموذج التواصل --}}
            <div class="contact-form-box">
                <form method="POST" action="{{ route('front.contact.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">
                            {{ $lang == 'ar' ? 'الاسم بالكامل' : 'Full name' }}
                        </label>
                        <input type="text" name="name" id="name" class="form-control"
                               placeholder="{{ $lang == 'ar' ? 'أدخل اسمك' : 'Enter your name' }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">
                            {{ $lang == 'ar' ? 'رقم الهاتف' : 'Phone number' }}
                        </label>
                        <input type="tel" name="phone" id="phone" class="form-control"
                               placeholder="{{ $lang == 'ar' ? '01xxxxxxxxx' : '01xxxxxxxxx' }}" required>
                    </div>

                    <div class="form-group">
                        <label for="interest">
                            {{ $lang == 'ar' ? 'مهتم بـ' : 'Interested in' }}
                        </label>
                        <select name="interest" id="interest" class="form-control">
                            @if($lang == 'ar')
                                <option value="buy">شراء عقار</option>
                                <option value="rent">إيجار</option>
                                <option value="sell">عرض عقار للبيع</option>
                                <option value="invest">استثمار عقاري</option>
                            @else
                                <option value="buy">Buying a property</option>
                                <option value="rent">Rent</option>
                                <option value="sell">List a property</option>
                                <option value="invest">Real estate investment</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">
                            {{ $lang == 'ar' ? 'الرسالة' : 'Message' }}
                        </label>
                        <textarea name="message" id="message" rows="4" class="form-control"
                                  placeholder="{{ $lang == 'ar' ? 'تفاصيل طلبك...' : 'Describe your request...' }}"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary full-width">
                        {{ $lang == 'ar' ? 'إرسال الطلب' : 'Send request' }}
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
