<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Display top questions based on views.
     */
    public function topQuestions()
    {
        $topPosts = Post::orderBy('views', 'desc')->take(10)->get();
        return view('home', compact('topPosts'));
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
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'try_and_expect' => 'required|string',
            'tags-hidden' => 'required|string', // Tag yang dipilih disimpan dalam hidden field
        ]);

        // Simpan post
        $post = new Post();
        $post->title = $request->input('title');
        $post->details = $request->input('details');
        $post->try_and_expect = $request->input('try_and_expect');
        $post->user_id = Auth::user()->id; // Ambil ID user yang sedang login
        $post->save(); // Simpan post ke database

        // Proses tags
        $tags = explode(',', $request->input('tags-hidden'));
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]); // Cari atau buat tag baru
            $post->tags()->attach($tag); // Hubungkan post dengan tag di tabel pivot
        }

        // Redirect setelah berhasil menyimpan
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Tambah views setiap kali pertanyaan diakses
        $post->increment('views');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'try_and_expect' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => 'string|distinct'
        ]);

        // Simpan perubahan pada post
        $post->update([
            'title' => $validated['title'],
            'details' => $validated['details'],
            'try_and_expect' => $validated['try_and_expect'],
        ]);

        // Proses tags
        $newTags = array_unique($validated['tags']);
        $newTagIds = [];
        foreach ($newTags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $newTagIds[] = $tag->id;
        }

        // Ambil tags lama sebelum di-sync
        $oldTagIds = $post->tags()->pluck('id')->toArray();

        // Sync tags baru dengan post
        $post->tags()->sync($newTagIds);

        // Update used_count: Tambahkan untuk tag baru, kurangi untuk tag yang dihapus
        foreach (array_diff($newTagIds, $oldTagIds) as $newTagId) {
            Tag::where('id', $newTagId)->increment('used_count');
        }

        foreach (array_diff($oldTagIds, $newTagIds) as $oldTagId) {
            Tag::where('id', $oldTagId)->decrement('used_count');
        }

        return redirect()->route('posts.index')->with('status', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        foreach ($post->tags as $tag) {
            $tag->decrement('used_count');
        }

        // Hapus post
        $post->tags()->detach();
        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Pertanyaan berhasil dihapus.');
    }
}
