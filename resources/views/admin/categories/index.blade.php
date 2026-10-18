@extends('admin.layouts.app')

@section('title', 'تصنيفات العقارات')
@section('page-title', 'تصنيفات العقارات')

@section('content')
<div class="max-w-5xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6 text-green-700 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">التصنيفات الرئيسية</h2>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:opacity-90">
            + إضافة تصنيف
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300">
        @forelse($categories as $category)
            <div class="flex justify-between items-center border-b border-gray-200 py-3">
                <div>
                    <p class="text-gray-900 font-semibold">{{ $category->name_ar }}</p>
                    <p class="text-gray-600 text-sm">{{ $category->name_en }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 font-bold hover:underline">تعديل</a>
                    <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 font-bold hover:underline">حذف</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">لا توجد تصنيفات بعد.</p>
        @endforelse
    </div>
</div>
@endsection
