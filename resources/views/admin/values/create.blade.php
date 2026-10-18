@extends('admin.layouts.app')

@section('title', 'إضافة قيمة جديدة')
@section('page-title', 'إضافة قيمة جديدة')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.values.store') }}" class="bg-white p-6 rounded-lg shadow-md border border-gray-300 space-y-6">
        @csrf

        <h2 class="text-lg font-bold text-purple-700 mb-4">بيانات القيمة الجديدة</h2>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">اختر أيقونة</label>
            <select name="icon" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                @foreach(config('icons') as $key => $label)
                    <option value="{{ $key }}">{{ $label }} ({{ $key }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">العنوان (عربي)</label>
                <input name="title_ar" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">العنوان (English)</label>
                <input name="title_en" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">الوصف (عربي)</label>
                <textarea name="description_ar" rows="3" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">الوصف (English)</label>
                <textarea name="description_en" rows="3" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required></textarea>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ القيمة
            </button>
        </div>
    </form>
</div>
@endsection
