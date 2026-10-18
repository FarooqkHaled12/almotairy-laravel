@php
    use App\Models\Map;

    $lang = session('locale','ar');
    $map  = Map::first();
@endphp

<section class="map-section" id="map">
    <div class="container-fluid">
        <div class="section-header text-center">
            <h2 class="section-title">
                {{ $lang == 'ar' ? 'موقعنا على الخريطة' : 'Our location on the map' }}
            </h2>
            <p>
                {{ $lang == 'ar'
   
                }}
            </p>
        </div>

        <div class="map-container">
            @if($map && $map->map_embed)
                {!! $map->map_embed !!}
            @else
                {{-- كود افتراضي لو لسه ما حفظتش خريطة في لوحة التحكم --}}
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3456.123456789!2d31.1234567!3d29.9876543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjnCsDU5JzE1LjYiTiAzMcKwMDcnMjQuNCJF!5e0!3m2!1sen!2seg!4v1234567890123!5m2!1sen!2seg"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            @endif
        </div>
    </div>
</section>
