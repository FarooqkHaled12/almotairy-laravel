@extends('admin.layouts.app')

@section('title', 'قسم قصتنا')

@section('page-title', 'قسم قصتنا')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6">
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.story.update') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md border border-gray-300 space-y-8">
        @csrf

        <!-- العنوان -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (عربي)</label>
                <input type="text" name="title_ar" value="{{ old('title_ar', $story->title_ar) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (English)</label>
                <input type="text" name="title_en" value="{{ old('title_en', $story->title_en) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
            </div>
        </div>

        <!-- الوصف -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (عربي)</label>
                <textarea id="desc_ar" name="description_ar" rows="6">{{ old('description_ar', $story->description_ar) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (English)</label>
                <textarea id="desc_en" name="description_en" rows="6">{{ old('description_en', $story->description_en) }}</textarea>
            </div>
        </div>

        <!-- الاسم والمسمى -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الاسم (عربي)</label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $story->name_ar) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الاسم (English)</label>
                <input type="text" name="name_en" value="{{ old('name_en', $story->name_en) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">المسمى الوظيفي (عربي)</label>
                <input type="text" name="position_ar" value="{{ old('position_ar', $story->position_ar) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">المسمى الوظيفي (English)</label>
                <input type="text" name="position_en" value="{{ old('position_en', $story->position_en) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>
        </div>

        <!-- الصورة -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">الصورة</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" onchange="previewImage(event)">
            <div class="mt-4">
                @if($story->image)
                    <img id="image-preview" src="{{ asset('storage/' . $story->image) }}" class="w-48 rounded-lg shadow">
                @else
                    <img id="image-preview" class="hidden w-48 rounded-lg shadow">
                @endif
            </div>
        </div>

        <!-- حفظ -->
        <div class="text-right">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>

<!-- محرر TinyMCE -->
<script src="https://cdn.tiny.cloud/1/ascnx1pwxl194b6bas6zme3qxot3i6c2s6ugly7shcctp2u0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#desc_ar, #desc_en',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | align | bullist numlist | link image media | code',
        height: 300,
        language: 'ar',
        branding: false
    });

    function previewImage(e) {
        const reader = new FileReader();
        reader.onload = () => {
            const img = document.getElementById('image-preview');
            img.src = reader.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(e.target.files[0]);
    }
</script>
@endsection
