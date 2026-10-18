@extends('admin.layouts.app')

@section('title', 'تعديل التصنيف')
@section('page-title', 'تعديل التصنيف')

@section('content')
<div class="max-w-3xl mx-auto">

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md border border-gray-300 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">اسم التصنيف (عربي)</label>
            <input type="text" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}"
                   required class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">اسم التصنيف (English)</label>
            <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}"
                   required class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
        </div>

        <div class="text-right">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg font-bold hover:opacity-90 transition">
                حفظ التعديلات
            </button>
        </div>
    </form>
</div>
@endsection
