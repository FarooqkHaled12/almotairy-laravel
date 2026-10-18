@extends('admin.layouts.app')

@section('title', 'قسم الخدمات')

@section('page-title', 'قسم الخدمات')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6">
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('admin.services.update') }}" method="POST" class="space-y-10">
        @csrf

        @foreach($services as $index => $service)
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold text-purple-700 mb-4">
                    الخدمة رقم {{ $index + 1 }}
                </h3>

                <input type="hidden" name="services[{{ $service->id }}][id]" value="{{ $service->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">عنوان الخدمة (عربي)</label>
                        <input name="services[{{ $service->id }}][title_ar]" value="{{ $service->title_ar }}" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">عنوان الخدمة (English)</label>
                        <input name="services[{{ $service->id }}][title_en]" value="{{ $service->title_en }}" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (عربي)</label>
                        <textarea name="services[{{ $service->id }}][description_ar]" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ $service->description_ar }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">الوصف (English)</label>
                        <textarea name="services[{{ $service->id }}][description_en]" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ $service->description_en }}</textarea>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-right">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>
@endsection
