@extends('admin.layouts.app')

@section('title', $building ? 'إضافة شقة للعمارة' : 'إضافة عقار جديد')
@section('page-title', $building ? 'إضافة شقة للعمارة' : 'إضافة عقار جديد')

@section('content')
<div class="max-w-6xl mx-auto">
    <form action="{{ $building ? route('admin.properties.units.store', $building) : route('admin.properties.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-8 rounded-lg shadow-md border border-gray-300 space-y-8">
        @csrf

        @if($building)
            <div class="rounded-lg border border-teal-200 bg-teal-50 p-4 text-teal-900">
                إضافة شقة داخل العمارة: <strong>{{ $building->name_ar }}</strong>
            </div>
            <input type="hidden" name="category_id" value="{{ $building->category_id }}">
        @else
        <!-- التصنيف -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف</label>
            <select name="category_id" required class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                <option value="">اختر التصنيف</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name_ar }} - {{ $category->name_en }}</option>
                @endforeach
            </select>
        </div>
        <label class="flex items-center gap-3 rounded-lg border border-indigo-200 bg-indigo-50 p-4 font-semibold text-indigo-900">
            <input type="checkbox" name="is_building" value="1" class="h-5 w-5 rounded border-gray-300 text-indigo-600">
            هذا العقار عمارة وبها شقق يمكن إضافتها وإدارتها من لوحة التحكم
        </label>
        @endif

        <!-- الاسم والمنطقة -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="font-bold text-gray-700 mb-2 block">{{ $building ? 'اسم الشقة (عربي)' : 'اسم العقار أو العمارة (عربي)' }}</label>
                <input name="name_ar" required class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">{{ $building ? 'اسم الشقة (English)' : 'اسم العقار أو العمارة (English)' }}</label>
                <input name="name_en" required class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">المنطقة (عربي)</label>
                <input name="area_ar" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">المنطقة (English)</label>
                <input name="area_en" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
        </div>

        <!-- الموقع -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="font-bold text-gray-700 mb-2 block">موقع الشقة (عربي)</label>
                <input name="location_ar" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="مثال: الرياض - حي العليا">
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">موقع الشقة (English)</label>
                <input name="location_en" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="e.g. Riyadh - Olaya District">
            </div>
        </div>

        <!-- الوصف -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="font-bold text-gray-700 mb-2 block">الوصف التفصيلي (عربي)</label>
                <textarea id="desc_ar" name="description_ar" rows="4"></textarea>
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">الوصف التفصيلي (English)</label>
                <textarea id="desc_en" name="description_en" rows="4"></textarea>
            </div>
        </div>

        <!-- المميزات -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="font-bold text-gray-700 mb-2 block">المميزات (عربي)</label>
                <div id="feat_ar">
                    <input type="text" name="features_ar[]" class="w-full border border-gray-400 rounded-lg p-3 bg-white mb-2">
                </div>
                <button type="button" onclick="addFeature('feat_ar','features_ar[]')" class="px-3 py-1 bg-purple-600 text-white rounded">+</button>
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">المميزات (English)</label>
                <div id="feat_en">
                    <input type="text" name="features_en[]" class="w-full border border-gray-400 rounded-lg p-3 bg-white mb-2">
                </div>
                <button type="button" onclick="addFeature('feat_en','features_en[]')" class="px-3 py-1 bg-purple-600 text-white rounded">+</button>
            </div>
        </div>

        <!-- التواصل -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="font-bold text-gray-700 mb-2 block">رقم الهاتف</label>
                <input name="phone" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">واتساب</label>
                <input name="whatsapp" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
        </div>

        <!-- الحالة القانونية + أنظمة السداد -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="font-bold text-gray-700 mb-2 block">الحالة القانونية (عربي)</label>
                <input name="legal_status_ar" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">الحالة القانونية (English)</label>
                <input name="legal_status_en" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="font-bold text-gray-700 mb-2 block">أنظمة السداد (عربي)</label>
                <textarea name="payment_system_ar" rows="3" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50"></textarea>
            </div>
            <div>
                <label class="font-bold text-gray-700 mb-2 block">أنظمة السداد (English)</label>
                <textarea name="payment_system_en" rows="3" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50"></textarea>
            </div>
        </div>

        <!-- الصور -->
        <h3 class="font-bold text-purple-700">صور الشقة (حتى 4 صور)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @for($i=1; $i<=4; $i++)
                <div>
                    <label class="text-sm font-bold text-gray-700 mb-2 block">صورة {{ $i }}</label>
                    <input type="file" name="image_{{ $i }}" accept="image/*"
                           class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>
            @endfor
        </div>

        <!-- حفظ -->
        <div class="text-right">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:opacity-90 transition">
                حفظ العقار
            </button>
        </div>
    </form>
</div>

@include('admin.partials.tinymce')
<script>
function addFeature(cont, name){
    const c=document.getElementById(cont);
    const i=document.createElement('input');
    i.type='text';i.name=name;
    i.className='w-full border border-gray-400 rounded-lg p-3 bg-white mb-2';
    c.appendChild(i);
}
</script>
@endsection
