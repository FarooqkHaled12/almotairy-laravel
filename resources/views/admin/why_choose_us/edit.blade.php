@extends('admin.layouts.app')

@section('title', 'لماذا تختارنا')
@section('page-title', 'قسم لماذا تختارنا')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.why.update') }}" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-md border border-gray-300 space-y-8">
        @csrf

        <!-- الكلمة المميزة والعنوان -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الكلمة المميزة (عربي)</label>
                <input type="text" name="highlight_word_ar" value="{{ old('highlight_word_ar', $data->highlight_word_ar) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الكلمة المميزة (English)</label>
                <input type="text" name="highlight_word_en" value="{{ old('highlight_word_en', $data->highlight_word_en) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (عربي)</label>
                <input type="text" name="title_ar" value="{{ old('title_ar', $data->title_ar) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (English)</label>
                <input type="text" name="title_en" value="{{ old('title_en', $data->title_en) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
            </div>
        </div>

        <!-- النقاط الأربع -->
        <h3 class="text-lg font-bold text-purple-700 mt-6 mb-3">النقاط المميزة</h3>

        @for($i = 1; $i <= 4; $i++)
            <div class="border border-gray-200 rounded-lg p-4 mb-4 bg-gray-50">
                <h4 class="font-bold text-gray-700 mb-4">النقطة رقم {{ $i }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (عربي)</label>
                        <input type="text" name="point_{{ $i }}_title_ar"
                               value="{{ old('point_'.$i.'_title_ar', $data->{'point_'.$i.'_title_ar'}) }}"
                               class="w-full border border-gray-400 rounded-lg p-3 bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (English)</label>
                        <input type="text" name="point_{{ $i }}_title_en"
                               value="{{ old('point_'.$i.'_title_en', $data->{'point_'.$i.'_title_en'}) }}"
                               class="w-full border border-gray-400 rounded-lg p-3 bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (عربي)</label>
                        <textarea name="point_{{ $i }}_desc_ar" rows="3"
                                  class="w-full border border-gray-400 rounded-lg p-3 bg-white">{{ old('point_'.$i.'_desc_ar', $data->{'point_'.$i.'_desc_ar'}) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (English)</label>
                        <textarea name="point_{{ $i }}_desc_en" rows="3"
                                  class="w-full border border-gray-400 rounded-lg p-3 bg-white">{{ old('point_'.$i.'_desc_en', $data->{'point_'.$i.'_desc_en'}) }}</textarea>
                    </div>
                </div>
            </div>
        @endfor

        <!-- الصورة -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">الصورة</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50"
                   onchange="previewImage(event)">
            <div class="mt-4">
                @if($data->image)
                    <img id="image-preview" src="{{ asset('storage/' . $data->image) }}"
                         class="w-48 rounded-lg shadow">
                @else
                    <img id="image-preview" class="hidden w-48 rounded-lg shadow">
                @endif
            </div>
        </div>

        <!-- حفظ -->
        <div class="text-right mt-8">
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('image-preview');
            preview.src = reader.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
