<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class AnswerList extends Component
{
    public $post;

    protected $listeners = ['answerAdded' => 'refreshAnswers']; // Dengarkan event

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function refreshAnswers()
    {
        $this->post->load('answers');
    }

    public function render()
    {
        return view('livewire.answer-list', [
            'answers' => $this->post->answers()->latest()->get(),
        ]);
    }
}
