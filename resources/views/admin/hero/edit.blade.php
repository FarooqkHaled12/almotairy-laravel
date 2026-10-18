@extends('admin.layouts.app')

@section('title', 'قسم الهيرو')

@section('page-title', 'قسم الهيرو')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6 animate-pulse">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 ml-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- العناوين والكلمات المميزة -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    العناوين والكلمات المميزة
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- العنوان الأول عربي -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            العنوان الأول (عربي)
                        </label>
                        <input 
                            type="text" 
                            name="title_ar" 
                            value="{{ old('title_ar', $hero->title_ar) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title_ar') border-red-500 @enderror"
                            placeholder="مثال: مرحباً بك في"
                        >
                        @error('title_ar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- الكلمة المميزة الأولى عربي -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            الكلمة المميزة الأولى (عربي)
                        </label>
                        <input 
                            type="text" 
                            name="highlight_word_1_ar" 
                            value="{{ old('highlight_word_1_ar', $hero->highlight_word_1_ar) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('highlight_word_1_ar') border-red-500 @enderror"
                            placeholder="مثال: المطيري"
                        >
                        @error('highlight_word_1_ar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- العنوان الثاني عربي -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            العنوان الثاني (عربي)
                        </label>
                        <input 
                            type="text" 
                            name="subtitle_ar" 
                            value="{{ old('subtitle_ar', $hero->subtitle_ar) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('subtitle_ar') border-red-500 @enderror"
                            placeholder="مثال: نحن نقدم أفضل"
                        >
                        @error('subtitle_ar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                </div>
            </div>

            <!-- الوصف -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    الوصف
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- الوصف عربي -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            الوصف (عربي)
                        </label>
                        <textarea 
                            name="description_ar" 
                            rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description_ar') border-red-500 @enderror"
                            placeholder="اكتب وصف مختصر عن الخدمات..."
                        >{{ old('description_ar', $hero->description_ar) }}</textarea>
                        @error('description_ar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- صورة الهيرو -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    صورة الهيرو
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <!-- رفع الصورة -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            اختر صورة جديدة
                        </label>
                        <input 
                            type="file" 
                            name="image" 
                            accept="image/*"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('image') border-red-500 @enderror"
                            onchange="previewImage(event)"
                        >
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            الحد الأقصى: 2 ميجابايت | الأنواع المسموحة: JPEG, PNG, JPG, GIF, WEBP
                        </p>
                    </div>

                    <!-- معاينة الصورة -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            الصورة الحالية
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                            @if($hero->image)
                                <img 
                                    id="image-preview" 
                                    src="{{ asset('storage/' . $hero->image) }}" 
                                    alt="Hero Image" 
                                    class="w-full h-48 object-cover rounded-lg"
                                >
                            @else
                                <div id="image-preview" class="flex items-center justify-center h-48 bg-gray-100 rounded-lg">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-sm">لا توجد صورة</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- أزرار الحفظ -->
            <div class="flex items-center justify-end space-x-4 space-x-reverse">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition duration-200">
                    إلغاء
                </a>
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-[1.02] transition-all duration-200 shadow-lg"
                >
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('image-preview');
                preview.innerHTML = `<img src="${reader.result}" alt="Preview" class="w-full h-48 object-cover rounded-lg">`;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
