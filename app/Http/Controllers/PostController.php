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
        $posts = Post::with('tags') // Ambil data dengan relasi tags jika ada
            ->orderBy('created_at', 'desc') // Mengurutkan data berdasarkan waktu dibuat
            ->paginate(100); // Pagination dengan 100 data per halaman

        return view('posts.index', compact('posts'));
    }

    /**
     * Display top questions based on views.
     */
    public function topQuestions(Request $request)
    {
        $filter = $request->query('filter', 'interesting'); // Default filter is 'interesting'

        switch ($filter) {
            case 'week':
                $topPosts = Post::where('created_at', '>=', now()->subWeek())
                    ->orderBy('views', 'desc')
                    ->paginate(100);
                break;

            case 'month':
                $topPosts = Post::where('created_at', '>=', now()->subMonth())
                    ->orderBy('views', 'desc')
                    ->paginate(100);
                break;

            default: // 'interesting' filter
                $topPosts = Post::orderBy('views', 'desc')->withCount('answers')
                    ->paginate(100);
                break;
        }

        return view('home', compact('topPosts', 'filter'));
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
            'tags-hidden' => 'required|string',
        ]);

        // Simpan post
        $post = new Post();
        $post->title = $request->input('title');
        $post->details = $request->input('details');
        $post->try_and_expect = $request->input('try_and_expect');
        $post->user_id = Auth::user()->id;
        $post->save();

        // Proses tags
        $tags = explode(',', $request->input('tags-hidden'));
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            $tag->used_count += 1;
            $tag->save();

            $post->tags()->attach($tag);
        }

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

    // fitur vote
    public function vote(Request $request, Post $post)
    {
        $vote = $request->input('vote');

        if ($vote === 'up') {
            $post->increment('votes');
        } elseif ($vote === 'down') {
            $post->decrement('votes');
        }

        return redirect()->back()->with('status', 'Vote berhasil diproses.');
    }

    public function downvote(Request $request, Post $post)
    {
        $vote = $request->input('vote');

        if ($vote === 'down') {
            $post->decrement('votes');
        }

        return redirect()->back()->with('status', 'Downvote berhasil diproses.');
    }
}
