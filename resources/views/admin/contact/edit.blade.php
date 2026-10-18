@extends('admin.layouts.app')

@section('title', 'بيانات التواصل')

@section('page-title', 'تعديل بيانات التواصل')

@section('content')
<div class="max-w-5xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6">
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.contact.update') }}" class="bg-white p-6 rounded-lg shadow-md border border-gray-300 space-y-6">
        @csrf

        <h2 class="text-xl font-bold text-purple-700 border-b pb-3 mb-5">المعلومات العامة</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف</label>
                <input name="phone" value="{{ old('phone', $contact->phone) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50 text-gray-900">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                <input name="email" value="{{ old('email', $contact->email) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50 text-gray-900">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (عربي)</label>
                <input name="address_ar" value="{{ old('address_ar', $contact->address_ar) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50 text-gray-900">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان (English)</label>
                <input name="address_en" value="{{ old('address_en', $contact->address_en) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50 text-gray-900">
            </div>
        </div>

        <h2 class="text-xl font-bold text-purple-700 border-b pb-3 mb-5 mt-10">روابط التواصل الاجتماعي</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Facebook</label>
                <input name="facebook" value="{{ old('facebook', $contact->facebook) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50 text-gray-900" placeholder="https://facebook.com/...">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Instagram</label>
                <input name="instagram" value="{{ old('instagram', $contact->instagram) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50 text-gray-900" placeholder="https://instagram.com/...">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">YouTube</label>
                <input name="youtube" value="{{ old('youtube', $contact->youtube) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50 text-gray-900" placeholder="https://youtube.com/...">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp</label>
                <input name="whatsapp" value="{{ old('whatsapp', $contact->whatsapp) }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50 text-gray-900" placeholder="مثال: 9665xxxxxxx">
            </div>
        </div>

        <div class="text-right mt-6">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>
@endsection
