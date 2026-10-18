@extends('admin.layouts.app')

@section('title', 'بيانات الاتصال 2')
@section('page-title', 'بيانات الاتصال 2')

@section('content')
<div class="max-w-5xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.contact2.update') }}" class="bg-white p-6 rounded-lg shadow-md border border-gray-300 space-y-6">
        @csrf

        <!-- مواعيد العمل -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">مواعيد العمل</label>
            <input type="text" name="working_hours" value="{{ old('working_hours', $contact->working_hours) }}"
                   class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="مثال: من الأحد إلى الخميس 9 ص - 5 م">
        </div>

        <!-- رقمين تليفون -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف الأول</label>
                <input type="text" name="phone_1" value="{{ old('phone_1', $contact->phone_1) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="+9665xxxxxxx">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف الثاني</label>
                <input type="text" name="phone_2" value="{{ old('phone_2', $contact->phone_2) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="+9665xxxxxxx">
            </div>
        </div>

        <!-- 3 إيميلات -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني الأول</label>
                <input type="email" name="email_1" value="{{ old('email_1', $contact->email_1) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="example1@email.com">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني الثاني</label>
                <input type="email" name="email_2" value="{{ old('email_2', $contact->email_2) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="example2@email.com">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني الثالث</label>
                <input type="email" name="email_3" value="{{ old('email_3', $contact->email_3) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="example3@email.com">
            </div>
        </div>

        <!-- العنوان -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (عربي)</label>
                <input type="text" name="address_ar" value="{{ old('address_ar', $contact->address_ar) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="العنوان باللغة العربية">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (English)</label>
                <input type="text" name="address_en" value="{{ old('address_en', $contact->address_en) }}"
                       class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="Address in English">
            </div>
        </div>

        <!-- رقم واتساب -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">رقم الواتساب</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp', $contact->whatsapp) }}"
                   class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50" placeholder="+9665xxxxxxx">
        </div>

        <!-- زر الحفظ -->
        <div class="text-right">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:opacity-90 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>
@endsection
