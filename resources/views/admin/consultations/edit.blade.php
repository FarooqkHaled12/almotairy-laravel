@extends('admin.layouts.app')

@section('title', 'قسم الاستشارات')
@section('page-title', 'قسم الاستشارات')

@section('content')
<div class="max-w-7xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-lg mb-6 font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.consultations.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf

        @foreach($consultations as $consult)
        <div class="bg-white border border-gray-300 rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-purple-700 mb-6">{{ $consult->type }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- عنوان -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">العنوان (عربي)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][title_ar]"
                        value="{{ $consult->title_ar }}"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-2">العنوان (English)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][title_en]"
                        value="{{ $consult->title_en }}"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>

                <!-- وصف -->
                <div class="md:col-span-2">
                    <label class="block font-bold text-gray-700 mb-2">الوصف (عربي)</label>
                    <textarea name="consultations[{{ $consult->id }}][description_ar]" rows="4"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">{{ $consult->description_ar }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block font-bold text-gray-700 mb-2">الوصف (English)</label>
                    <textarea name="consultations[{{ $consult->id }}][description_en]" rows="4"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">{{ $consult->description_en }}</textarea>
                </div>

                <!-- عنوان المميزات -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">عنوان المميزات (عربي)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][feature_title_ar]"
                        value="{{ $consult->feature_title_ar }}"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-2">عنوان المميزات (English)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][feature_title_en]"
                        value="{{ $consult->feature_title_en }}"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>

                <!-- المميزات -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">المميزات (عربي)</label>
                    <div id="feat_ar_{{ $consult->id }}">
                        @foreach($consult->features_ar ?? [''] as $feature)
                            <input type="text" name="consultations[{{ $consult->id }}][features_ar][]"
                                value="{{ $feature }}" class="w-full border border-gray-400 rounded-lg p-3 bg-white mb-2">
                        @endforeach
                    </div>
                    <button type="button"
                        onclick="addFeature('feat_ar_{{ $consult->id }}', 'consultations[{{ $consult->id }}][features_ar][]')"
                        class="mt-2 px-3 py-1 bg-purple-600 text-white rounded">+</button>
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-2">المميزات (English)</label>
                    <div id="feat_en_{{ $consult->id }}">
                        @foreach($consult->features_en ?? [''] as $feature)
                            <input type="text" name="consultations[{{ $consult->id }}][features_en][]"
                                value="{{ $feature }}" class="w-full border border-gray-400 rounded-lg p-3 bg-white mb-2">
                        @endforeach
                    </div>
                    <button type="button"
                        onclick="addFeature('feat_en_{{ $consult->id }}', 'consultations[{{ $consult->id }}][features_en][]')"
                        class="mt-2 px-3 py-1 bg-purple-600 text-white rounded">+</button>
                </div>

                <!-- باقي التفاصيل -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">نوع الخدمة (عربي)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][service_type_ar]"
                        value="{{ $consult->service_type_ar }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-2">نوع الخدمة (English)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][service_type_en]"
                        value="{{ $consult->service_type_en }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-2">مدة الجلسة (عربي)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][session_duration_ar]"
                        value="{{ $consult->session_duration_ar }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-2">مدة الجلسة (English)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][session_duration_en]"
                        value="{{ $consult->session_duration_en }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-2">مناسبة لـ (عربي)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][suitable_for_ar]"
                        value="{{ $consult->suitable_for_ar }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-2">مناسبة لـ (English)</label>
                    <input type="text" name="consultations[{{ $consult->id }}][suitable_for_en]"
                        value="{{ $consult->suitable_for_en }}" class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                </div>

                <div class="md:col-span-2">
                    <label class="block font-bold text-gray-700 mb-2">نص المميزات (عربي)</label>
                    <textarea name="consultations[{{ $consult->id }}][feature_text_ar]" rows="3"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">{{ $consult->feature_text_ar }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block font-bold text-gray-700 mb-2">نص المميزات (English)</label>
                    <textarea name="consultations[{{ $consult->id }}][feature_text_en]" rows="3"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">{{ $consult->feature_text_en }}</textarea>
                </div>

                <!-- صورة -->
                <div class="md:col-span-2">
                    <label class="block font-bold text-gray-700 mb-2">الصورة</label>
                    <input type="file" name="consultations[{{ $consult->id }}][image]" onchange="previewImage(event,'img-{{ $consult->id }}')"
                        class="w-full border border-gray-400 rounded-lg p-3 bg-gray-50">
                    <div class="mt-2">
                        @if($consult->image)
                            <img id="img-{{ $consult->id }}" src="{{ asset('storage/' . $consult->image) }}" class="w-48 rounded-lg shadow">
                        @else
                            <img id="img-{{ $consult->id }}" class="hidden w-48 rounded-lg shadow">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="text-right">
            <button type="submit"
                class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>

<script>
function addFeature(containerId, name) {
    const container = document.getElementById(containerId);
    const input = document.createElement('input');
    input.type = 'text';
    input.name = name;
    input.className = 'w-full border border-gray-400 rounded-lg p-3 bg-white mb-2';
    container.appendChild(input);
}

function previewImage(e, id) {
    const reader = new FileReader();
    reader.onload = function() {
        const img = document.getElementById(id);
        img.src = reader.result;
        img.classList.remove('hidden');
    };
    reader.readAsDataURL(e.target.files[0]);
}
</script>
@endsection
