<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    // Menyimpan jawaban baru
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $answer = Answer::create([
            'content' => $validated['content'],
            'post_id' => $post->id,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('status', 'Jawaban berhasil ditambahkan.');
    }

    // Voting untuk jawaban
    public function vote(Request $request, Answer $answer)
    {
        if ($request->input('vote') === 'up') {
            $answer->votes += 1;
        } else {
            $answer->votes -= 1;
        }

        $answer->save();

        return redirect()->back()->with('status', 'Voting jawaban berhasil diperbarui.');
    }

    // Menandai jawaban sebagai solusi
    public function markAsAccepted(Answer $answer)
    {
        $post = $answer->post;

        // Pastikan hanya penanya yang bisa menandai jawaban
        if (Auth::user()->id === $post->user_id) {
            $post->answers()->update(['is_accepted' => false]);
            $answer->is_accepted = true;
            $answer->save();

            return redirect()->back()->with('status', 'Jawaban berhasil ditandai sebagai solusi terbaik.');
        }

        return redirect()->back()->with('error', 'Hanya penanya yang bisa menandai jawaban.');
    }

    // Menghapus jawaban
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return redirect()->back()->with('status', 'Jawaban berhasil dihapus.');
    }
}
