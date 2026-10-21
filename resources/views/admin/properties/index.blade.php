@extends('admin.layouts.app')

@section('title', 'العقارات')
@section('page-title', 'كل العقارات')

@section('content')
<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 mb-6 p-4 rounded-lg text-green-700 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">قائمة العقارات</h2>
        <a href="{{ route('admin.properties.create') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:opacity-90">
            + إضافة عقار
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300">
        @forelse($properties as $property)
            <div class="flex justify-between items-start border-b border-gray-200 py-4">
                <div>
                    <h3 class="text-gray-900 font-bold">{{ $property->name_ar }}</h3>
                    <p class="text-gray-600 text-sm">{{ $property->area_ar }}</p>
                    <p class="text-gray-500 text-xs mt-1">{{ $property->phone }}</p>
                    @if($property->is_building)
                        <span class="mt-2 inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700">عمارة · {{ $property->units_count }} شقة</span>
                    @endif
                </div>
                <div class="flex gap-3">
                    @if($property->is_building)
                        <a href="{{ route('admin.properties.units', $property) }}" class="rounded-lg bg-teal-600 px-3 py-2 text-sm font-bold text-white hover:bg-teal-700">إدارة الشقق</a>
                    @endif
                    <a href="{{ route('admin.properties.edit', $property->id) }}" class="text-blue-600 font-bold hover:underline">تعديل</a>
                    <form action="{{ route('admin.properties.delete', $property->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 font-bold hover:underline">حذف</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-6">لا توجد عقارات بعد.</p>
        @endforelse
    </div>
</div>
@endsection
