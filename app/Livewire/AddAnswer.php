<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AddAnswer extends Component
{
    public $post;
    public $content = '';

    protected $rules = [
        'content' => 'required|string|max:255',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function addAnswer()
    {
        $this->validate();

        Answer::create([
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'content' => $this->content,
        ]);

        Log::info('Answer created', ['post_id' => $this->post->id, 'user_id' => Auth::id(), 'content' => $this->content]);

        $this->content = '';
        $this->dispatch('answerAdded');
    }


    public function render()
    {
        return view('livewire.add-answer');
    }
}
