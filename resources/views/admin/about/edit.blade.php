@extends('admin.layouts.app')

@section('title', 'قسم من أنا')

@section('page-title', 'قسم من أنا')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6">
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- الصورة -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">الصورة</h3>
            <input type="file" name="image" accept="image/*" class="w-full border-gray-300 rounded-lg" onchange="previewImage(event)">
            <div class="mt-4">
                @if($about->image)
                    <img id="image-preview" src="{{ asset('storage/' . $about->image) }}" alt="About Image" class="w-48 rounded-lg shadow">
                @else
                    <img id="image-preview" class="w-48 hidden rounded-lg shadow">
                @endif
            </div>
        </div>

        <!-- العناوين -->
        <div class="bg-white rounded-lg shadow-md p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان الأول (عربي)</label>
                <input type="text" name="title_1_ar" value="{{ $about->title_1_ar }}" class="w-full border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان الأول (English)</label>
                <input type="text" name="title_1_en" value="{{ $about->title_1_en }}" class="w-full border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان الثاني (عربي)</label>
                <input type="text" name="title_2_ar" value="{{ $about->title_2_ar }}" class="w-full border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان الثاني (English)</label>
                <input type="text" name="title_2_en" value="{{ $about->title_2_en }}" class="w-full border-gray-300 rounded-lg">
            </div>
        </div>

        <!-- الوصف -->
        <div class="bg-white rounded-lg shadow-md p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (عربي)</label>
                <textarea id="desc_ar" name="description_ar">{{ $about->description_ar }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (English)</label>
                <textarea id="desc_en" name="description_en">{{ $about->description_en }}</textarea>
            </div>
        </div>

        <!-- المميزات -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">المميزات</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div id="features-ar">
                    <label class="font-bold">المميزات (عربي)</label>
                    @foreach($about->features_ar ?? [''] as $feature)
                        <input type="text" name="features_ar[]" value="{{ $feature }}" class="mt-2 w-full border border-gray-300 rounded-lg">
                    @endforeach
                    <button type="button" onclick="addFeature('features-ar', 'features_ar[]')" class="mt-3 px-3 py-1 bg-purple-600 text-white rounded">+</button>
                </div>

                <div id="features-en">
                    <label class="font-bold">المميزات (English)</label>
                    @foreach($about->features_en ?? [''] as $feature)
                        <input type="text" name="features_en[]" value="{{ $feature }}" class="mt-2 w-full border border-gray-300 rounded-lg">
                    @endforeach
                    <button type="button" onclick="addFeature('features-en', 'features_en[]')" class="mt-3 px-3 py-1 bg-purple-600 text-white rounded">+</button>
                </div>
            </div>
        </div>

        <!-- التوقيع -->
        <div class="bg-white rounded-lg shadow-md p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">التوقيع (عربي)</label>
                <input type="text" name="signature_ar" value="{{ $about->signature_ar }}" class="w-full border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">التوقيع (English)</label>
                <input type="text" name="signature_en" value="{{ $about->signature_en }}" class="w-full border-gray-300 rounded-lg">
            </div>
        </div>

        <!-- زر الحفظ -->
        <div class="text-right">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>

<!-- محرر TinyMCE بالـ API -->
<script src="https://cdn.tiny.cloud/1/ascnx1pwxl194b6bas6zme3qxot3i6c2s6ugly7shcctp2u0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#desc_ar, #desc_en',
        directionality: 'rtl',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | align | bullist numlist | link image media | code',
        branding: false,
        height: 300,
        language: 'ar',
        images_upload_url: '/upload', // ممكن تضيف هنا لو عندك Upload للسيرفر
    });

    function addFeature(containerId, name) {
        const container = document.getElementById(containerId);
        const input = document.createElement('input');
        input.className = 'mt-2 w-full border-gray-300 rounded-lg';
        input.setAttribute('type', 'text');
        input.setAttribute('name', name);
        container.insertBefore(input, container.lastElementChild);
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('image-preview');
            preview.src = reader.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
