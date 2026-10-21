@extends('admin.layouts.app')

@section('title', 'شقق العمارة')
@section('page-title', 'إدارة شقق العمارة')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    @if(session('success'))
        <div class="rounded-lg border-r-4 border-green-500 bg-green-50 p-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.properties.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">← العودة إلى العقارات</a>
                <h2 class="mt-2 text-2xl font-bold text-slate-900">{{ $property->name_ar }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $property->location_ar ?: $property->area_ar }}</p>
            </div>
            <a href="{{ route('admin.properties.units.create', $property) }}" class="rounded-lg bg-teal-600 px-5 py-3 font-bold text-white shadow-sm hover:bg-teal-700">+ إضافة شقة</a>
        </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h3 class="font-bold text-slate-900">الشقق التابعة للعمارة</h3>
            <span class="rounded-full bg-teal-50 px-3 py-1 text-sm font-bold text-teal-800">{{ $units->count() }} شقة</span>
        </div>
        @forelse($units as $unit)
            <article class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 px-6 py-5 last:border-0">
                <div class="flex min-w-0 items-center gap-4">
                    @if($unit->image_1)
                        <img src="{{ asset('storage/'.$unit->image_1) }}" alt="" class="h-16 w-20 rounded-lg object-cover">
                    @else
                        <div class="grid h-16 w-20 place-items-center rounded-lg bg-slate-100 text-slate-400">شقة</div>
                    @endif
                    <div class="min-w-0">
                        <h4 class="truncate font-bold text-slate-900">{{ $unit->name_ar }}</h4>
                        <p class="mt-1 text-sm text-slate-500">{{ $unit->area_ar ?: 'المساحة غير محددة' }} @if($unit->location_ar) · {{ $unit->location_ar }} @endif</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.properties.edit', $unit) }}" class="font-semibold text-blue-700 hover:underline">تعديل الشقة</a>
                    <form action="{{ route('admin.properties.delete', $unit) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذه الشقة؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-semibold text-red-600 hover:underline">حذف</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="px-6 py-14 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-teal-50 text-2xl text-teal-700">⌂</div>
                <h4 class="mt-4 font-bold text-slate-900">لسه مفيش شقق مضافة</h4>
                <p class="mt-1 text-sm text-slate-500">أضف الشقق هنا، وستظهر للعميل عند فتح صفحة العمارة.</p>
                <a href="{{ route('admin.properties.units.create', $property) }}" class="mt-5 inline-flex rounded-lg bg-teal-600 px-5 py-3 font-bold text-white hover:bg-teal-700">إضافة أول شقة</a>
            </div>
        @endforelse
    </section>
</div>
@endsection
