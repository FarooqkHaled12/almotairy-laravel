<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function edit()
    {
        $map = Map::first();
        if (!$map) {
            $map = Map::create([]);
        }

        return view('admin.map.edit', compact('map'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'map_embed' => 'nullable|string',
        ]);

        $map = Map::first();
        $map->update($validated);

        return back()->with('success', '✅ تم حفظ الخريطة بنجاح');
    }
}
