<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    // Menyimpan jawaban baru
    // public function store(Request $request, Post $post)
    // {
    //     $validated = $request->validate([
    //         'content' => 'required|string',
    //     ]);

    //     Answer::create([
    //         'content' => $validated['content'],
    //         'post_id' => $post->id,
    //         'user_id' => Auth::user()->id,
    //     ]);

    //     return redirect()->route('posts.show', $post->id)->with('status', 'Jawaban berhasil ditambahkan.');
    // }

    // // Voting untuk jawaban
    // public function vote(Request $request, Answer $answer)
    // {
    //     $vote = $request->input('vote');

    //     if ($vote === 'up') {
    //         $answer->increment('votes');
    //     } elseif ($vote === 'down') {
    //         $answer->decrement('votes');
    //     }

    //     return redirect()->back()->with('status', 'Vote berhasil diproses.');
    // }

    // public function downvote(Request $request, Answer $answer)
    // {
    //     $vote = $request->input('vote');

    //     if ($vote === 'down') {
    //         $answer->decrement('votes');
    //     }

    //     return redirect()->back()->with('status', 'Downvote berhasil diproses.');
    // }

    // // Menandai jawaban sebagai solusi
    // public function markAsAccepted(Request $request, Post $post, Answer $answer)
    // {
    //     // Jika post atau answer tidak ditemukan, redirect kembali dengan pesan error
    //     if (!$post) {
    //         return redirect()->back()->with('error', 'Post tidak ditemukan.');
    //     }

    //     if (!$answer) {
    //         return redirect()->back()->with('error', 'Jawaban tidak ditemukan.');
    //     }

    //     // Validasi user
    //     if (Auth::user()->id === $post->user_id) {
    //         // Set semua jawaban pada post menjadi tidak diterima
    //         $post->answers()->update(['is_accepted' => false]);

    //         // Tandai jawaban yang dipilih sebagai diterima
    //         $answer->is_accepted = true;
    //         $answer->save();

    //         return redirect()->route('posts.show', $post->id)->with('status', 'Jawaban berhasil ditandai sebagai solusi terbaik.');
    //     }

    //     return redirect()->back()->with('error', 'Hanya penanya yang bisa menandai jawaban.');
    // }


    // Menghapus jawaban
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return redirect()->back()->with('status', 'Jawaban berhasil dihapus.');
    }
}
