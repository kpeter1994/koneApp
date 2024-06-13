<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Alapértelmezett keresési érték
        $search = $request->query('search') ? $request->query('search')[0] : null;

        // Keresési eredmények Eloquent használatával
        $query = Post::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%");
        }

        // Keresési eredmények lekérése kapcsolódó modellekkel együtt
        $posts = $query->with('user')->get();

        return Inertia::render('Posts/Index', compact('posts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:posts',
            'body' => 'required',
            'image' => 'max:2048',
        ];

        $validatedData = $request->validate($rules);

        Post::create([
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
            'body' => $validatedData['body'],
            'user_id' => auth()->user()->id,
            'image' => $validatedData['image'],

            // Ha az 'image' mezőt is menteni szeretnéd, azt is hozzá kell adnod itt
        ]);

        return redirect()->route('posts.index')->with('success', 'A poszt sikeresen létrehozva!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $post = Post::with('user')->where('slug', $slug)->firstOrFail();

        return Inertia::render('Posts/Show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        return Inertia::render('Posts/Edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:posts,slug,'.$post->id,
            'body' => 'required',
            'image' => 'max:2048',
        ];

        $validatedData = $request->validate($rules);

        $post->update([
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
            'body' => $validatedData['body'],
            'image' => $validatedData['image'],
        ]);

        return redirect()->route('posts.index')->with('success', 'A poszt sikeresen frissítve!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'A poszt sikeresen törölve!');
    }
}
