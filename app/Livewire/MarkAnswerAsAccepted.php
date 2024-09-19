<?php

namespace App\Livewire;

use Livewire\Component;

class MarkAnswerAsAccepted extends Component
{
    public $post;
    public $answer;

    public function mount($post, $answer)
    {
        $this->post = $post;
        $this->answer = $answer;
    }

    public function markAsAccepted()
    {
        // Logic untuk mark answer sebagai accepted
        $this->post->answers()->update(['is_accepted' => false]);
        $this->answer->update(['is_accepted' => true]);
    }

    public function render()
    {
        return view('livewire.mark-answer-as-accepted');
    }
}
