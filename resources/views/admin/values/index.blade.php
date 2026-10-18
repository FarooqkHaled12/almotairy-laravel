@extends('admin.layouts.app')

@section('title', 'كل القيم')
@section('page-title', 'قسم القيم')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6 text-green-700 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">كل القيم</h2>
        <a href="{{ route('admin.values.create') }}" 
           class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:from-purple-700 hover:to-indigo-700 transition">
           + إضافة قيمة
        </a>
    </div>

    <div class="bg-white p-6 border rounded-lg shadow-md">
        @forelse($values as $value)
            <div class="border border-gray-200 rounded-lg p-4 mb-4 flex justify-between items-start">
                <div class="flex gap-3">
                    <span class="text-3xl">{!! config('icons')[$value->icon] ?? '❔' !!}</span>
                    <div>
                        <p class="font-bold text-gray-800">{{ $value->title_ar }}</p>
                        <p class="text-sm text-gray-600">{{ $value->description_ar }}</p>
                    </div>
                </div>

                <div class="space-x-3 space-x-reverse">
                    <a href="{{ route('admin.values.edit', $value->id) }}" class="text-blue-600 font-semibold hover:underline">تعديل</a>
                    <form action="{{ route('admin.values.delete', $value->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟')" class="text-red-600 font-semibold hover:underline">حذف</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">لا توجد قيم بعد.</p>
        @endforelse
    </div>
</div>
@endsection
