@php $lang = session('locale','ar'); @endphp

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                @if($lang == 'ar')
                    <h3 class="footer-logo">المطيري<span>.للعقارات</span></h3>
                    <p>
                        نسعى لتقديم تجربة عقارية استثنائية مبنية على الثقة والشفافية.
                        نوفر لك أفضل الفرص في الهرم والتجمع الخامس.
                    </p>
                @else
                    <h3 class="footer-logo">AlMotairy<span>.Real Estate</span></h3>
                    <p>
                        We strive to provide an exceptional real estate experience based on trust and transparency,
                        offering the best opportunities in El‑Haram and Fifth Settlement.
                    </p>
                @endif
            </div>

            <div class="footer-col">
                @if($lang == 'ar')
                    <h3>روابط سريعة</h3>
                    <ul>
                        <li><a href="{{ route('front.home') }}">الرئيسية</a></li>
                        <li><a href="{{ route('front.about') }}">من نحن</a></li>
                        <li><a href="{{ route('front.properties') }}">العقارات</a></li>
                        <li><a href="{{ route('front.contact') }}">اتصل بنا</a></li>
                    </ul>
                @else
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('front.home') }}">Home</a></li>
                        <li><a href="{{ route('front.about') }}">About Us</a></li>
                        <li><a href="{{ route('front.properties') }}">Properties</a></li>
                        <li><a href="{{ route('front.contact') }}">Contact Us</a></li>
                    </ul>
                @endif
            </div>

            <div class="footer-col">
                @if($lang == 'ar')
                    <h3>مناطق الخدمة</h3>
                    <ul>
                        <li><a href="#">شارع الهرم</a></li>
                        <li><a href="#">المريوطية</a></li>
                        <li><a href="#">حدائق الأهرام</a></li>
                        <li><a href="#">التجمع الخامس</a></li>
                        <li><a href="#">بيت الوطن</a></li>
                    </ul>
                @else
                    <h3>Service Areas</h3>
                    <ul>
                        <li><a href="#">El‑Haram Street</a></li>
                        <li><a href="#">Maryotia</a></li>
                        <li><a href="#">Hadayek Al‑Ahram</a></li>
                        <li><a href="#">Fifth Settlement</a></li>
                        <li><a href="#">Beit Al‑Watan</a></li>
                    </ul>
                @endif
            </div>

            <div class="footer-col">
                @if($lang == 'ar')
                    <h3>النشرة البريدية</h3>
                    <p>اشترك ليصلك أحدث العروض العقارية فور نزولها.</p>
                    <form class="newsletter-form" method="POST" action="{{ route('front.contact.submit') }}">
                        @csrf
                        <input type="hidden" name="form_type" value="newsletter">
                        <input type="email" name="email" placeholder="بريدك الإلكتروني" autocomplete="email" required>
                        <button type="submit" aria-label="الاشتراك في النشرة البريدية"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                @else
                    <h3>Newsletter</h3>
                    <p>Subscribe to receive the latest real estate offers as soon as they are available.</p>
                    <form class="newsletter-form" method="POST" action="{{ route('front.contact.submit') }}">
                        @csrf
                        <input type="hidden" name="form_type" value="newsletter">
                        <input type="email" name="email" placeholder="Your email address" autocomplete="email" required>
                        <button type="submit" aria-label="Subscribe to the newsletter"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                @endif
            </div>
        </div>

        <div class="footer-bottom">
            @if($lang == 'ar')
                <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} - المهندس محمود المطيري.</p>
                <p>التصميم والتطوير بواسطة <a href="https://www.linkedin.com/in/farooq-khaled-50811626b/" target="_blank" rel="noopener noreferrer">Farooq Khaled</a></p>
            @else
                <p>All rights reserved &copy; {{ date('Y') }} - Eng. Mahmoud Al‑Mutairi.</p>
                <p>Designed and developed by <a href="https://www.linkedin.com/in/farooq-khaled-50811626b/" target="_blank" rel="noopener noreferrer">Farooq Khaled</a></p>
            @endif
        </div>
    </div>
</footer>

@php
    $floatingContact = \App\Models\ContactInfo::first();
    $floatingWhatsapp = preg_replace('/[^0-9]/', '', $floatingContact?->whatsapp ?? '');
    if (preg_match('/^01[0125][0-9]{8}$/', $floatingWhatsapp)) {
        $floatingWhatsapp = '20'.substr($floatingWhatsapp, 1);
    }
@endphp
@if($floatingContact && ($floatingContact->facebook || $floatingWhatsapp))
    <div class="site-social-float" role="navigation" aria-label="{{ $lang === 'ar' ? 'روابط التواصل الاجتماعي' : 'Social media links' }}">
        @if($floatingContact->facebook)
            <a class="site-social-float__link site-social-float__link--facebook" href="{{ $floatingContact->facebook }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $lang === 'ar' ? 'تابعنا على فيسبوك' : 'Follow us on Facebook' }}"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
        @endif
        @if($floatingWhatsapp)
            <a class="site-social-float__link site-social-float__link--whatsapp" href="https://wa.me/{{ $floatingWhatsapp }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $lang === 'ar' ? 'تواصل معنا عبر واتساب' : 'Contact us on WhatsApp' }}"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
        @endif
    </div>
@endif

@include('front.partials.lead-capture')
