<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:png|max:2048',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        $banner = Banner::create([
            'name' => $request->name,
            'image' => $path,
        ]);

        return response()->json(['success' => 'Banner created successfully', 'banner' => $banner]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png|max:2048',
        ]);

        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->name = $request->name;
        $banner->save();

        return response()->json(['success' => 'Banner updated successfully', 'banner' => $banner]);
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        Storage::disk('public')->delete($banner->image);
        $banner->delete();

        return response()->json(['success' => 'Banner deleted successfully']);
    }
}
