@extends('admin.layouts.app')

@section('title', 'إضافة تصنيف')
@section('page-title', 'إضافة تصنيف جديد')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md border border-gray-300 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">اسم التصنيف (عربي)</label>
            <input type="text" name="name_ar" required class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">اسم التصنيف (English)</label>
            <input type="text" name="name_en" required class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
        </div>

        <div class="text-right">
            <button class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg font-bold hover:opacity-90 transition">
                حفظ
            </button>
        </div>
    </form>
</div>
@endsection
