<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Answer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AnswerList extends Component
{
    public $post;
    public $answers = []; // Menyimpan jawaban yang bisa diedit oleh user
    public $message;

    protected $listeners = ['answerAdded' => 'refreshAnswers']; // Dengarkan event

    public function mount(Post $post)
    {
        $this->post = $post;

        // Inisialisasi jawaban untuk editing
        foreach ($post->answers as $answer) {
            $this->answers[$answer->id] = $answer->content;
        }
    }

    // Method untuk merefresh daftar jawaban
    public function refreshAnswers()
    {
        $this->post->load('answers');
    }

    // Method untuk mengupdate jawaban
    public function updateAnswer($answerId)
    {
        // Validasi jawaban
        $this->validate([
            'answers.' . $answerId => 'required|string|max:5000',
        ]);

        // Cari jawaban yang akan diupdate
        $answer = Answer::findOrFail($answerId);

        // Cek apakah user adalah pemilik jawaban
        if (Auth::id() !== $answer->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Simpan perubahan jawaban
        $answer->content = $this->answers[$answerId];
        $answer->save();

        // Flash message sukses
        session()->flash('message', 'Jawaban berhasil diperbarui.');
    }

    // Method untuk menghapus jawaban
    public function deleteAnswer($answerId)
    {
        // Cari jawaban yang akan dihapus
        $answer = Answer::findOrFail($answerId);

        // Cek apakah user adalah pemilik jawaban
        if (Auth::id() !== $answer->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus jawaban
        $answer->delete();

        // Flash message sukses
        session()->flash('message', 'Jawaban berhasil dihapus.');

        // Refresh daftar jawaban
        $this->refreshAnswers();
    }

    public function render()
    {
        return view('livewire.answer-list', [
            'answers' => $this->post->answers()->latest()->get(),
        ]);
    }
}
