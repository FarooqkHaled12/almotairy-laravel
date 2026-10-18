<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurStoryController extends Controller
{
    public function edit()
    {
        $story = OurStory::first();
        if (!$story) {
            $story = OurStory::create([]);
        }
        return view('admin.story.edit', compact('story'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'position_ar' => 'nullable|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $story = OurStory::first();

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($story->image && Storage::disk('public')->exists($story->image)) {
                Storage::disk('public')->delete($story->image);
            }
            $data['image'] = $request->file('image')->store('story', 'public');
        }

        $story->update($data);

        return back()->with('success', '✅ تم تحديث قسم قصتنا بنجاح');
    }
}
