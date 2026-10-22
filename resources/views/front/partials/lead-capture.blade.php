@php
    $leadLang = session('locale', 'ar');
    $leadPropertyId = old('property_id') ?: (isset($property) ? $property->id : request()->query('property'));
    $leadCategories = \App\Models\PropertyCategory::orderBy('id')->get();
    $leadHasPreferences = old('preferred_location') || old('preferred_category_id') || old('budget_min') || old('budget_max') || old('area_min') || old('area_max');
    // صفحة التواصل تعرض نتيجة الإرسال داخل نموذجها، فلا نفتح النافذة المنبثقة بنفس الرسالة مرتين
    $leadHasFeedback = !request()->routeIs('front.contact') && (session()->has('success') || $errors->any());
@endphp

<button class="lead-fab" type="button" data-lead-open aria-haspopup="dialog" aria-controls="lead-dialog">
    <i class="fa-solid fa-comment-dots" aria-hidden="true"></i>
    <span>{{ $leadLang === 'ar' ? 'تحدث مع مستشار عقاري' : 'Talk to a property advisor' }}</span>
</button>

<div class="lead-dialog" id="lead-dialog" data-lead-dialog @if(!$leadHasFeedback) hidden @endif>
    <button class="lead-dialog__backdrop" type="button" data-lead-close aria-label="{{ $leadLang === 'ar' ? 'إغلاق' : 'Close' }}"></button>
    <section class="lead-dialog__panel" role="dialog" aria-modal="true" aria-labelledby="lead-dialog-title" tabindex="-1">
        <button class="lead-dialog__close" type="button" data-lead-close aria-label="{{ $leadLang === 'ar' ? 'إغلاق النموذج' : 'Close form' }}"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        <span class="lead-dialog__eyebrow"><i class="fa-solid fa-house" aria-hidden="true"></i> {{ $leadLang === 'ar' ? 'خطوتك القادمة تبدأ هنا' : 'Your next step starts here' }}</span>
        <h2 id="lead-dialog-title">{{ $leadLang === 'ar' ? 'خلّينا نساعدك تلاقي عقارك' : 'Let us help you find your property' }}</h2>
        <p>{{ $leadLang === 'ar' ? 'اترك رقمك وسيتواصل معك مستشارنا لمناقشة احتياجك وترتيب معاينة.' : 'Leave your number and an advisor will help with your search or arrange a viewing.' }}</p>

        @if(session('success'))
            <div class="lead-dialog__notice lead-dialog__notice--success" role="status">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="lead-dialog__notice lead-dialog__notice--error" role="alert">{{ $errors->first() }}</div>
        @endif

        <form class="lead-dialog__form" method="POST" action="{{ route('front.contact.submit') }}">
            @csrf
            @if($leadPropertyId)
                <input type="hidden" name="property_id" value="{{ $leadPropertyId }}" data-lead-property>
            @else
                <input type="hidden" name="property_id" value="" data-lead-property>
            @endif
            <label>
                <span>{{ $leadLang === 'ar' ? 'الاسم' : 'Your name' }}</span>
                <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="255" required placeholder="{{ $leadLang === 'ar' ? 'اكتب اسمك' : 'Enter your name' }}">
            </label>
            <label>
                <span>{{ $leadLang === 'ar' ? 'رقم الهاتف' : 'Phone number' }}</span>
                <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" maxlength="50" required placeholder="01xxxxxxxxx">
            </label>
            <label>
                <span>{{ $leadLang === 'ar' ? 'موعد المعاينة المفضل (اختياري)' : 'Preferred viewing time (optional)' }}</span>
                <input type="datetime-local" name="preferred_visit_at" data-lead-visit value="{{ old('preferred_visit_at') }}">
            </label>
            <label>
                <span>{{ $leadLang === 'ar' ? 'كيف نقدر نساعدك؟' : 'How can we help?' }}</span>
                <select name="interest">
                    <option value="buy" @selected(old('interest', 'buy') === 'buy')>{{ $leadLang === 'ar' ? 'أبحث عن عقار للشراء' : 'I want to buy' }}</option>
                    <option value="rent" @selected(old('interest') === 'rent')>{{ $leadLang === 'ar' ? 'أبحث عن عقار للإيجار' : 'I want to rent' }}</option>
                    <option value="sell" @selected(old('interest') === 'sell')>{{ $leadLang === 'ar' ? 'أريد عرض عقاري للبيع' : 'I want to sell' }}</option>
                    <option value="invest" @selected(old('interest') === 'invest')>{{ $leadLang === 'ar' ? 'مهتم بالاستثمار العقاري' : 'I am interested in investing' }}</option>
                </select>
            </label>
            <details class="lead-dialog__preferences" data-lead-preferences @if($leadHasPreferences) open @endif>
                <summary>{{ $leadLang === 'ar' ? 'أضف تفضيلاتك لتحصل على ترشيحات أدق' : 'Add preferences for better matches' }}</summary>
                <div class="lead-dialog__preference-grid">
                    <label>
                        <span>{{ $leadLang === 'ar' ? 'المنطقة المطلوبة' : 'Preferred location' }}</span>
                        <input type="text" name="preferred_location" data-lead-location value="{{ old('preferred_location') }}" maxlength="255" placeholder="{{ $leadLang === 'ar' ? 'مثال: الهرم، الجيزة' : 'e.g. Haram, Giza' }}">
                    </label>
                    <label>
                        <span>{{ $leadLang === 'ar' ? 'نوع العقار' : 'Property type' }}</span>
                        <select name="preferred_category_id" data-lead-category>
                            <option value="">{{ $leadLang === 'ar' ? 'أي نوع' : 'Any type' }}</option>
                            @foreach($leadCategories as $leadCategory)
                                <option value="{{ $leadCategory->id }}" @selected((string) old('preferred_category_id') === (string) $leadCategory->id)>{{ $leadLang === 'ar' ? $leadCategory->name_ar : $leadCategory->name_en }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>{{ $leadLang === 'ar' ? 'الميزانية من (جنيه)' : 'Budget from (EGP)' }}</span>
                        <input type="number" name="budget_min" data-lead-budget-min min="0" step="10000" inputmode="numeric" value="{{ old('budget_min') }}">
                    </label>
                    <label>
                        <span>{{ $leadLang === 'ar' ? 'الميزانية إلى (جنيه)' : 'Budget up to (EGP)' }}</span>
                        <input type="number" name="budget_max" data-lead-budget-max min="0" step="10000" inputmode="numeric" value="{{ old('budget_max') }}">
                    </label>
                    <label>
                        <span>{{ $leadLang === 'ar' ? 'المساحة من (م²)' : 'Area from (sqm)' }}</span>
                        <input type="number" name="area_min" data-lead-area-min min="0" step="5" inputmode="numeric" value="{{ old('area_min') }}">
                    </label>
                    <label>
                        <span>{{ $leadLang === 'ar' ? 'المساحة إلى (م²)' : 'Area up to (sqm)' }}</span>
                        <input type="number" name="area_max" data-lead-area-max min="0" step="5" inputmode="numeric" value="{{ old('area_max') }}">
                    </label>
                </div>
            </details>
            <label>
                <span>{{ $leadLang === 'ar' ? 'تفاصيل إضافية (اختياري)' : 'Additional details (optional)' }}</span>
                <textarea name="message" rows="3" maxlength="5000" placeholder="{{ $leadLang === 'ar' ? 'المنطقة أو الميزانية أو موعد المعاينة...' : 'Area, budget, or preferred viewing time...' }}">{{ old('message') }}</textarea>
            </label>
            <button class="lead-dialog__submit" type="submit"><span>{{ $leadLang === 'ar' ? 'اطلب تواصل المستشار' : 'Request a call' }}</span><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button>
            <small>{{ $leadLang === 'ar' ? 'بياناتك تستخدم للتواصل معك بخصوص طلبك فقط.' : 'Your details will only be used to respond to your request.' }}</small>
        </form>
    </section>
</div>

<script>
(() => {
    const dialog = document.querySelector('[data-lead-dialog]');
    const panel = dialog?.querySelector('.lead-dialog__panel');
    const openButtons = document.querySelectorAll('[data-lead-open]');
    const propertyField = dialog?.querySelector('[data-lead-property]');
    const initialPropertyId = propertyField?.value || '';
    const visitField = dialog?.querySelector('[data-lead-visit]');
    const preferences = dialog?.querySelector('[data-lead-preferences]');
    const preferenceFields = {
        location: dialog?.querySelector('[data-lead-location]'),
        category: dialog?.querySelector('[data-lead-category]'),
        budgetMin: dialog?.querySelector('[data-lead-budget-min]'),
        budgetMax: dialog?.querySelector('[data-lead-budget-max]'),
        areaMin: dialog?.querySelector('[data-lead-area-min]'),
        areaMax: dialog?.querySelector('[data-lead-area-max]'),
    };
    const initialPreferences = Object.fromEntries(Object.entries(preferenceFields).map(([key, field]) => [key, field?.value || '']));
    if (!dialog || !panel || !openButtons.length) return;
    let previousFocus = null;
    const open = event => {
        previousFocus = document.activeElement;
        if (propertyField) propertyField.value = event.currentTarget.dataset.leadPropertyId || initialPropertyId;
        const trigger = event.currentTarget;
        if (trigger.hasAttribute('data-lead-save-search')) {
            if (preferenceFields.location) preferenceFields.location.value = document.getElementById('locationSearch')?.value || '';
            if (preferenceFields.category) preferenceFields.category.value = document.getElementById('categorySearch')?.value?.replace('cat-', '') || '';
            if (preferenceFields.budgetMin) preferenceFields.budgetMin.value = '';
            if (preferenceFields.budgetMax) preferenceFields.budgetMax.value = '';
            if (preferenceFields.areaMin) preferenceFields.areaMin.value = document.getElementById('areaMin')?.value || '';
            if (preferenceFields.areaMax) preferenceFields.areaMax.value = document.getElementById('areaMax')?.value || '';
            if (preferences) preferences.open = true;
        } else if (trigger.dataset.leadPropertyId) {
            if (preferenceFields.location) preferenceFields.location.value = trigger.dataset.leadLocation || '';
            if (preferenceFields.category) preferenceFields.category.value = trigger.dataset.leadCategoryId || '';
            if (preferenceFields.budgetMin) preferenceFields.budgetMin.value = '';
            if (preferenceFields.budgetMax) preferenceFields.budgetMax.value = '';
            if (preferenceFields.areaMin) preferenceFields.areaMin.value = trigger.dataset.leadArea || '';
            if (preferenceFields.areaMax) preferenceFields.areaMax.value = trigger.dataset.leadArea || '';
            if (preferences) preferences.open = true;
        } else {
            Object.entries(preferenceFields).forEach(([key, field]) => {
                if (field) field.value = initialPreferences[key];
            });
            if (preferences) preferences.open = Boolean(Object.values(initialPreferences).some(Boolean));
        }
        dialog.hidden = false;
        document.body.classList.add('lead-dialog-open');
        panel.focus();
    };
    const close = () => {
        dialog.hidden = true;
        document.body.classList.remove('lead-dialog-open');
        previousFocus?.focus();
    };
    openButtons.forEach(button => button.addEventListener('click', open));
    dialog.querySelectorAll('[data-lead-close]').forEach(button => button.addEventListener('click', close));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !dialog.hidden) close();
    });
    if (visitField) {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        visitField.min = now.toISOString().slice(0, 16);
    }
    if (!dialog.hidden) panel.focus();
})();
</script>
