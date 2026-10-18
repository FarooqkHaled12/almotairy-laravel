@extends('admin.layouts.app')

@section('title', 'الأسئلة الشائعة')

@section('page-title', 'عرض الأسئلة الشائعة')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6">
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">كل الأسئلة</h2>
        <a href="{{ route('admin.faq.create') }}" 
           class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold px-4 py-2 rounded-md hover:from-purple-700 hover:to-indigo-700 transition">
           + إضافة سؤال جديد
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-300">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <th class="p-3 border-b border-gray-300">#</th>
                    <th class="p-3 border-b border-gray-300">السؤال بالعربية</th>
                    <th class="p-3 border-b border-gray-300">السؤال بالإنجليزية</th>
                    <th class="p-3 border-b border-gray-300 text-center">خيارات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($faqs as $faq)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3 border-b border-gray-200">{{ $faq->id }}</td>
                        <td class="p-3 border-b border-gray-200">{{ $faq->question_ar }}</td>
                        <td class="p-3 border-b border-gray-200">{{ $faq->question_en }}</td>
                        <td class="p-3 border-b border-gray-200 text-center">
                            <a href="{{ route('admin.faq.edit', $faq->id) }}"
                               class="text-blue-600 font-semibold hover:underline">تعديل</a>
                            <form action="{{ route('admin.faq.delete', $faq->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')" 
                                        class="text-red-600 font-semibold hover:underline ml-2">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-gray-500 py-6">لا توجد أسئلة بعد</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $faqs->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
