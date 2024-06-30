<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModulImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:1024',
        ]);

        $imagePath = $request->file('image')->store('modul_images', 'public');

        return response()->json(['imagePath' => $imagePath]);
        return response()->json(['imagePath' => $imagePath]);
    }
}
