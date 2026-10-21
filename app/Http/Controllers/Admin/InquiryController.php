<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => 'nullable|in:new,contacted,follow_up,closed',
            'q' => 'nullable|string|max:100',
        ]);

        $inquiries = Inquiry::query()
            ->with(['property:id,name_ar,name_en', 'preferredCategory:id,name_ar,name_en'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['q'] ?? null, function ($query, $term) {
                $term = trim($term);
                $query->where(function ($search) use ($term) {
                    $search->where('name', 'like', "%{$term}%")
                        ->orWhere('phone', 'like', "%{$term}%")
                        ->orWhere('message', 'like', "%{$term}%")
                        ->orWhere('preferred_location', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statusCounts = Inquiry::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.inquiries.index', compact('inquiries', 'statusCounts', 'filters'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,follow_up,closed',
        ]);

        $inquiry->update($validated);

        return back()->with('success', 'تم تحديث حالة الطلب.');
    }
}
