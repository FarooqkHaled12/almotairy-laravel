@extends('admin.layouts.app')

@section('title', 'قسم الإحصائيات')
@section('page-title', 'قسم الإحصائيات')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 text-green-700 font-semibold p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.statistics.update') }}" class="space-y-8">
        @csrf

        @foreach($stats as $index => $stat)
        <div class="bg-white border border-gray-300 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-purple-700 mb-4">الإحصائية رقم {{ $index + 1 }}</h3>

            <input type="hidden" name="stats[{{ $stat->id }}][id]" value="{{ $stat->id }}">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- الأيقونة -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">الأيقونة</label>
                    <select name="stats[{{ $stat->id }}][icon]" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                        @foreach($icons as $key => $label)
                            <option value="{{ $key }}" {{ $stat->icon == $key ? 'selected' : '' }}>{{ $label }} ({{ $key }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- الرقم -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">الرقم</label>
                    <input 
                        type="text" 
                        name="stats[{{ $stat->id }}][number]" 
                        value="{{ $stat->number }}" 
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>

                <!-- العنوان (عربي) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">العنوان (عربي)</label>
                    <input 
                        type="text" 
                        name="stats[{{ $stat->id }}][title_ar]" 
                        value="{{ $stat->title_ar }}" 
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>

                <!-- العنوان (إنجليزي) -->
                <div class="md:col-span-3">
                    <label class="block text-sm font-bold text-gray-700 mb-1">العنوان (English)</label>
                    <input 
                        type="text" 
                        name="stats[{{ $stat->id }}][title_en]" 
                        value="{{ $stat->title_en }}" 
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
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
