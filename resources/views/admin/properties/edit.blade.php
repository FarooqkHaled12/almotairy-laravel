@extends('admin.layouts.app')

@section('title', 'تعديل العقار')
@section('page-title', 'تعديل بيانات العقار')

@section('content')
<div class="max-w-6xl mx-auto">
<form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-8 rounded-lg shadow-md border border-gray-300 space-y-8">
@csrf

<!-- التصنيف -->
<div>
    <label class="font-bold text-gray-700 mb-2 block">التصنيف</label>
    <select name="category_id" required class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $property->category_id == $cat->id ? 'selected' : '' }}>
                {{ $cat->name_ar }} - {{ $cat->name_en }}
            </option>
        @endforeach
    </select>
</div>

<!-- نصوص -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div><label>اسم الشقة (عربي)</label><input name="name_ar" value="{{ $property->name_ar }}" required class="input"></div>
    <div><label>اسم الشقة (English)</label><input name="name_en" value="{{ $property->name_en }}" required class="input"></div>
    <div><label>المنطقة (عربي)</label><input name="area_ar" value="{{ $property->area_ar }}" class="input"></div>
    <div><label>المنطقة (English)</label><input name="area_en" value="{{ $property->area_en }}" class="input"></div>
</div>

<!-- الموقع -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div><label>موقع الشقة (عربي)</label><input name="location_ar" value="{{ $property->location_ar }}" class="input"></div>
    <div><label>موقع الشقة (English)</label><input name="location_en" value="{{ $property->location_en }}" class="input"></div>
</div>

<!-- الوصف -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div><label>الوصف (عربي)</label><textarea id="desc_ar" name="description_ar">{{ $property->description_ar }}</textarea></div>
    <div><label>الوصف (English)</label><textarea id="desc_en" name="description_en">{{ $property->description_en }}</textarea></div>
</div>

<!-- المميزات -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
@foreach(['ar'=>'عربي','en'=>'English'] as $lang=>$label)
<div>
<label>المميزات ({{ $label }})</label>
<div id="feat_{{ $lang }}">
@foreach($property->{'features_'.$lang} ?? [''] as $f)
<input type="text" name="features_{{ $lang }}[]" value="{{ $f }}" class="input mb-2">
@endforeach
</div>
<button type="button" onclick="addFeature('feat_{{ $lang }}','features_{{ $lang }}[]')" class="px-3 py-1 bg-purple-600 text-white rounded">+</button>
</div>
@endforeach
</div>

<!-- التواصل -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div><label>رقم الهاتف</label><input name="phone" value="{{ $property->phone }}" class="input"></div>
<div><label>واتساب</label><input name="whatsapp" value="{{ $property->whatsapp }}" class="input"></div>
</div>

<!-- الحالة وأنظمة السداد -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div><label>الحالة القانونية (عربي)</label><input name="legal_status_ar" value="{{ $property->legal_status_ar }}" class="input"></div>
<div><label>الحالة القانونية (English)</label><input name="legal_status_en" value="{{ $property->legal_status_en }}" class="input"></div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div><label>أنظمة السداد (عربي)</label><textarea name="payment_system_ar" rows="3" class="input">{{ $property->payment_system_ar }}</textarea></div>
<div><label>أنظمة السداد (English)</label><textarea name="payment_system_en" rows="3" class="input">{{ $property->payment_system_en }}</textarea></div>
</div>

<!-- الصور -->
<h3 class="font-bold text-purple-700">صور العقار</h3>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
@for($i=1;$i<=4;$i++)
@php $img='image_'.$i; @endphp
<div>
    <label>صورة {{ $i }}</label>
    <input type="file" name="{{ $img }}" accept="image/*" class="input" onchange="previewImage(event,'img_{{ $i }}')">
    @if($property->$img)
        <img id="img_{{ $i }}" src="{{ asset('storage/'.$property->$img) }}" class="w-40 h-40 rounded-lg mt-2 shadow">
    @else
        <img id="img_{{ $i }}" class="hidden w-40 h-40 rounded-lg mt-2 shadow">
    @endif
</div>
@endfor
</div>

<!-- حفظ -->
<div class="text-right">
<button class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:opacity-90 transition">حفظ التعديلات</button>
</div>
</form>
</div>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/ascnx1pwxl194b6bas6zme3qxot3i6c2s6ugly7shcctp2u0/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
selector:'#desc_ar,#desc_en',
plugins:'link image lists media table wordcount fullscreen',
toolbar:'undo redo | blocks | bold italic underline | align | bullist numlist | link image media | table fullscreen',
height:300,
branding:false
});
function addFeature(c,n){const x=document.getElementById(c);const i=document.createElement('input');i.type='text';i.name=n;i.className='input mb-2';x.appendChild(i);}
function previewImage(e,id){const r=new FileReader();r.onload=()=>{const i=document.getElementById(id);i.src=r.result;i.classList.remove('hidden');};r.readAsDataURL(e.target.files[0]);}
</script>

<style>
.input{width:100%;border:1px solid #9ca3af;border-radius:.5rem;padding:.75rem;background:#f9fafb}
</style>
@endsection
