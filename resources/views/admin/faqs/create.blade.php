@extends('admin.layouts.app')

@section('title', 'إضافة سؤال جديد')

@section('page-title', 'إضافة سؤال جديد')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.faq.store') }}" class="bg-white p-6 rounded-lg shadow-md border border-gray-300 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">السؤال (عربي)</label>
            <input type="text" name="question_ar" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">السؤال (English)</label>
            <input type="text" name="question_en" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">الإجابة (عربي)</label>
            <textarea name="answer_ar" rows="4" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">الإجابة (English)</label>
            <textarea name="answer_en" rows="4" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" required></textarea>
        </div>

        <div class="text-right">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ السؤال
            </button>
        </div>
    </form>
</div>
@endsection
