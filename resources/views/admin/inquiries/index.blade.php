@extends('admin.layouts.app')

@section('title', 'طلبات العملاء')
@section('page-title', 'طلبات العملاء')

@section('content')
    @php
        $statusLabels = [
            'new' => 'جديد',
            'contacted' => 'تم التواصل',
            'follow_up' => 'متابعة لاحقة',
            'closed' => 'مكتمل',
        ];
        $interestLabels = [
            'buy' => 'شراء عقار',
            'rent' => 'إيجار',
            'sell' => 'عرض عقار للبيع',
            'invest' => 'استثمار عقاري',
        ];
    @endphp

    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-bold text-teal-700">إدارة العملاء المحتملين</p>
                <h2 class="mt-1 text-2xl font-extrabold text-slate-800">طلبات التواصل</h2>
                <p class="mt-2 text-sm text-slate-500">تابع الطلبات الجديدة وحدّث حالتها بعد التواصل مع العميل.</p>
            </div>
            <a href="{{ route('front.contact') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 hover:border-teal-400">
                معاينة نموذج التواصل <span class="mr-2" aria-hidden="true">↗</span>
            </a>
        </div>

        @if(session('success'))
            <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
            @foreach($statusLabels as $status => $label)
                <a href="{{ route('admin.inquiries.index', ['status' => $status]) }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-teal-300">
                    <span class="text-sm font-semibold text-slate-500">{{ $label }}</span>
                    <strong class="mt-2 block text-2xl font-extrabold text-slate-800">{{ number_format($statusCounts->get($status, 0)) }}</strong>
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('admin.inquiries.index') }}" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
            <label class="sr-only" for="inquiry-search">ابحث بالاسم أو الهاتف أو الرسالة</label>
            <input id="inquiry-search" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="ابحث بالاسم أو الهاتف أو الرسالة" class="min-w-0 flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-100">
            <label class="sr-only" for="inquiry-status">حالة الطلب</label>
            <select id="inquiry-status" name="status" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-teal-500 focus:outline-none">
                <option value="">كل الحالات</option>
                @foreach($statusLabels as $status => $label)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-700">تطبيق</button>
            @if(!empty($filters['q']) || !empty($filters['status']))
                <a href="{{ route('admin.inquiries.index') }}" class="rounded-xl px-4 py-2.5 text-center text-sm font-bold text-slate-500 hover:bg-slate-50">مسح الفلاتر</a>
            @endif
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h3 class="font-extrabold text-slate-800">قائمة الطلبات</h3>
                <span class="text-sm text-slate-500">{{ number_format($inquiries->total()) }} طلب</span>
            </div>

            @forelse($inquiries as $inquiry)
                @php
                    $waPhone = preg_replace('/\D+/', '', $inquiry->phone);
                    if (str_starts_with($waPhone, '0')) {
                        $waPhone = '20'.substr($waPhone, 1);
                    }
                @endphp
                <article class="grid gap-4 border-b border-slate-100 p-5 last:border-b-0 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="font-extrabold text-slate-800">{{ $inquiry->name }}</h4>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">{{ $statusLabels[$inquiry->status] ?? $inquiry->status }}</span>
                            @if($inquiry->interest)
                                <span class="rounded-full bg-teal-50 px-2.5 py-1 text-xs font-bold text-teal-800">{{ $interestLabels[$inquiry->interest] ?? $inquiry->interest }}</span>
                            @endif
                        </div>
                        <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-500">
                            <a dir="ltr" href="tel:{{ $inquiry->phone }}" class="font-semibold text-slate-700 hover:text-teal-700">{{ $inquiry->phone }}</a>
                            <span>{{ $inquiry->created_at?->format('Y/m/d - H:i') }}</span>
                            @if($inquiry->preferred_visit_at)
                                <span class="rounded-lg bg-amber-50 px-2.5 py-1 font-bold text-amber-800">معاينة مفضلة: {{ $inquiry->preferred_visit_at->format('Y/m/d - H:i') }}</span>
                            @endif
                            @if($inquiry->property)
                                <a href="{{ route('admin.properties.edit', $inquiry->property_id) }}" class="font-semibold text-teal-700 hover:underline">العقار: {{ $inquiry->property->name_ar ?: $inquiry->property->name_en }}</a>
                            @endif
                        </div>
                        @if($inquiry->message)
                            <p class="mt-3 whitespace-pre-line break-words text-sm leading-7 text-slate-600">{{ $inquiry->message }}</p>
                        @endif
                        @if($inquiry->preferred_location || $inquiry->preferredCategory || $inquiry->budget_min !== null || $inquiry->budget_max !== null || $inquiry->area_min !== null || $inquiry->area_max !== null)
                            <div class="mt-3 flex flex-wrap gap-2 rounded-xl bg-slate-50 p-3 text-xs text-slate-600">
                                <span class="w-full font-extrabold text-slate-700">احتياجات العميل</span>
                                @if($inquiry->preferred_location)<span class="rounded-full bg-white px-2.5 py-1">المنطقة: {{ $inquiry->preferred_location }}</span>@endif
                                @if($inquiry->preferredCategory)<span class="rounded-full bg-white px-2.5 py-1">النوع: {{ $inquiry->preferredCategory->name_ar ?: $inquiry->preferredCategory->name_en }}</span>@endif
                                @if($inquiry->budget_min !== null || $inquiry->budget_max !== null)<span class="rounded-full bg-white px-2.5 py-1">الميزانية: {{ $inquiry->budget_min !== null ? number_format($inquiry->budget_min) : '—' }} – {{ $inquiry->budget_max !== null ? number_format($inquiry->budget_max) : '—' }} جنيه</span>@endif
                                @if($inquiry->area_min !== null || $inquiry->area_max !== null)<span class="rounded-full bg-white px-2.5 py-1">المساحة: {{ $inquiry->area_min !== null ? number_format($inquiry->area_min) : '—' }} – {{ $inquiry->area_max !== null ? number_format($inquiry->area_max) : '—' }} م²</span>@endif
                            </div>
                        @endif
                        <div class="mt-3 flex gap-2">
                            <a href="tel:{{ $inquiry->phone }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50">اتصال</a>
                            @if($waPhone)
                                <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800 hover:bg-emerald-100">واتساب</a>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.inquiries.status', $inquiry) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <label class="sr-only" for="status-{{ $inquiry->id }}">حالة طلب {{ $inquiry->name }}</label>
                        <select id="status-{{ $inquiry->id }}" name="status" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm">
                            @foreach($statusLabels as $status => $label)
                                <option value="{{ $status }}" @selected($inquiry->status === $status)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="rounded-lg bg-teal-700 px-3 py-2 text-sm font-bold text-white hover:bg-teal-800">حفظ</button>
                    </form>
                </article>
            @empty
                <div class="px-5 py-16 text-center">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-slate-100 text-2xl text-slate-400" aria-hidden="true">✉</div>
                    <p class="mt-4 font-bold text-slate-700">لا توجد طلبات تطابق البحث.</p>
                    <p class="mt-1 text-sm text-slate-500">ستظهر هنا الطلبات المرسلة من نموذج التواصل.</p>
                </div>
            @endforelse
        </div>

        <div>{{ $inquiries->links() }}</div>
    </div>
@endsection
