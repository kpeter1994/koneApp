<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function index()
    {
        $images = Storage::disk('public')->files('images');
        return response()->json($images);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048', // Max 2MB
        ]);

        $file = $request->file('file');
        $imageName = time().'.'.$file->extension();
        $file->storeAs('images', $imageName, 'public'); // Módosított tárolási útvonal

        $imagePath = Storage::disk('public')->url('images/'.$imageName);

        return response()->json(['imagePath' => $imagePath]);
    }
}
