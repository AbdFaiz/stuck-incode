<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Tag::with('posts')->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();

        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'you_do' => 'required|string',
        'tags' => 'required|array',
        'tags.*' => 'string|distinct'
    ]);

    // Buat post baru
    $post = Post::create([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'you_do' => $validated['you_do'],
    ]);

    // Proses tag
    $tags = array_unique($validated['tags']);
    $tagIds = [];

    foreach ($tags as $tagName) {
        $tag = Tag::firstOrCreate(['name' => $tagName]);
        $tagIds[] = $tag->id;
    }

    // Menyimpan relasi post dan tag
    $post->tags()->sync($tagIds);

    return redirect()->back()->with('status', 'Berhasil membuat pertanyaan');
}


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
