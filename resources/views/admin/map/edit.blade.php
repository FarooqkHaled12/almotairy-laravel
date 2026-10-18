@extends('admin.layouts.app')

@section('title', 'الخريطة')
@section('page-title', 'خريطة الموقع')

@section('content')
<div class="max-w-5xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6 font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.map.update') }}" class="bg-white p-8 rounded-lg shadow-md border border-gray-300 space-y-6">
        @csrf

        <label class="block text-sm font-bold text-gray-700 mb-2">كود تضمين الخريطة من Google Maps</label>
        <textarea name="map_embed" rows="5"
                  class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50"
                  placeholder="انسخ كود الـ iframe من Google Maps وضعه هنا">{{ old('map_embed', $map->map_embed) }}</textarea>

        <div class="text-right">
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:opacity-90 transition">
                حفظ الخريطة
            </button>
        </div>
    </form>

    @if($map->map_embed)
        <div class="mt-8">
            <h2 class="text-lg font-bold text-purple-700 mb-3">معاينة الخريطة</h2>
            <div class="border border-gray-300 rounded-lg overflow-hidden shadow">
                {!! $map->map_embed !!}
            </div>
        </div>
    @endif
</div>
@endsection
