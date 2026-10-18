@extends('admin.layouts.app')

@section('title', 'قسم CTA')
@section('page-title', 'قسم Call To Action')

@section('content')
<div class="max-w-5xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.cta.update') }}" class="bg-white p-8 rounded-lg shadow-md border border-gray-300 space-y-8">
        @csrf

        <!-- العنوان والوصف -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (عربي)</label>
                <input type="text" name="title_ar" value="{{ old('title_ar', $cta->title_ar) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (English)</label>
                <input type="text" name="title_en" value="{{ old('title_en', $cta->title_en) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (عربي)</label>
                <textarea name="description_ar" rows="4" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>{{ old('description_ar', $cta->description_ar) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (English)</label>
                <textarea name="description_en" rows="4" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>{{ old('description_en', $cta->description_en) }}</textarea>
            </div>
        </div>

        <!-- الأزرار -->
        <h3 class="text-lg font-bold text-purple-700 mt-8 mb-4">الأزرار</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- الزر الأول -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-bold text-gray-700 mb-3">الزر الأول</h4>
                <label class="block text-sm font-bold text-gray-700 mb-2">عنوان الزر (عربي)</label>
                <input type="text" name="button_1_text_ar" value="{{ old('button_1_text_ar', $cta->button_1_text_ar) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                <label class="block text-sm font-bold text-gray-700 mb-2 mt-4">عنوان الزر (English)</label>
                <input type="text" name="button_1_text_en" value="{{ old('button_1_text_en', $cta->button_1_text_en) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                <label class="block text-sm font-bold text-gray-700 mb-2 mt-4">رابط الزر</label>
                <input type="text" name="button_1_link" value="{{ old('button_1_link', $cta->button_1_link) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="https://...">
            </div>

            <!-- الزر الثاني -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-bold text-gray-700 mb-3">الزر الثاني</h4>
                <label class="block text-sm font-bold text-gray-700 mb-2">عنوان الزر (عربي)</label>
                <input type="text" name="button_2_text_ar" value="{{ old('button_2_text_ar', $cta->button_2_text_ar) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                <label class="block text-sm font-bold text-gray-700 mb-2 mt-4">عنوان الزر (English)</label>
                <input type="text" name="button_2_text_en" value="{{ old('button_2_text_en', $cta->button_2_text_en) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                <label class="block text-sm font-bold text-gray-700 mb-2 mt-4">رابط الزر</label>
                <input type="text" name="button_2_link" value="{{ old('button_2_link', $cta->button_2_link) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="https://...">
            </div>
        </div>

        <div class="text-right mt-8">
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>
@endsection
