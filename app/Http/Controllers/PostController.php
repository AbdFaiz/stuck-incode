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
    public function index(Request $request, Post $post)
    {
        $filter = $request->query('filter');

        $query = Post::with('tags')
        ->withCount('answers')
        ;

        // filter
        if ($filter === 'votes') {
            $query->orderBy('votes', 'desc')
                ->withCount('answers');
        } elseif ($filter === 'views') {
            $query->orderBy('views', 'desc')
                ->withCount('answers');
        } elseif ($filter === 'newest') {
            $query->orderBy('created_at', 'desc')
                ->withCount('answers');
        } elseif ($filter === 'unanswered') {
            $query->whereDoesntHave('answers') // Mengambil post yang tidak memiliki jawaban
                ->orderBy('created_at', 'desc')
                ->withCount('answers');

        } else {
            $query->orderBy('created_at', 'desc')
                ->withCount('answers');
        }

        // Paginate result
        $posts = $query->paginate(100);

        // Return view with posts and current filter
        return view('posts.index', compact('posts', 'filter'));
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
                    ->withCount('answers') // Tambahkan ini
                    ->orderBy('views', 'desc')
                    ->paginate(100);
                break;

            case 'month':
                $topPosts = Post::where('created_at', '>=', now()->subMonth())
                    ->withCount('answers') // Tambahkan ini
                    ->orderBy('views', 'desc')
                    ->paginate(100);
                break;

            default: // 'interesting' filter
                $topPosts = Post::withCount('answers') // Pastikan ini tetap ada
                    ->orderBy('views', 'desc')
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
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'try_and_expect' => 'required|string',
            'tags-hidden' => 'required|string',
        ]);

        // Update post with validated data
        $post->update([
            'title' => $validated['title'],
            'details' => $validated['details'],
            'try_and_expect' => $validated['try_and_expect'],
        ]);

        // Proses tags
        $tags = explode(',', $validated['tags-hidden']);
        $newTagIds = [];

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $newTagIds[] = $tag->id;

            // Increment the used_count
            $tag->increment('used_count');
        }

        // Get old tag IDs before syncing
        $oldTagIds = $post->tags()->pluck('id')->toArray();

        // Sync new tags with the post
        $post->tags()->sync($newTagIds);

        // Decrement used_count for removed tags
        foreach (array_diff($oldTagIds, $newTagIds) as $oldTagId) {
            Tag::where('id', $oldTagId)->decrement('used_count');
        }

        return redirect()->route('posts.index')->with('success', 'Post berhasil diperbarui.');
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

        return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus!');
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

        return redirect()->back()->with('success', 'Vote berhasil diproses.');
    }

    public function downvote(Request $request, Post $post)
    {
        $vote = $request->input('vote');

        if ($vote === 'down') {
            $post->decrement('votes');
        }

        return redirect()->back()->with('success', 'Downvote berhasil diproses.');
    }

    public function savePost(Post $post)
    {
        if (!Auth::user()->savedPosts()->where('post_id', $post->id)->exists()) {
            Auth::user()->savedPosts()->attach($post->id);
        }

        return back()->with('success', 'Post has been saved.');
    }

    public function unsavePost(Post $post)
    {
        if (Auth::user()->savedPosts()->where('post_id', $post->id)->exists()) {
            Auth::user()->savedPosts()->detach($post->id);
        }

        return back()->with('success', 'Post has been unsaved.');
    }
}
