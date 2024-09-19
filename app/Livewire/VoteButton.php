<?php

namespace App\Livewire;

use App\Models\Answer;
use Livewire\Component;

class VoteButton extends Component
{
    public $answer;
    public $votes;

    public function mount(Answer $answer)
    {
        $this->answer = $answer;
        $this->votes = $answer->votes;
    }

    public function upvote()
    {
        $this->answer->increment('votes');
        $this->votes = $this->answer->votes;
    }

    public function downvote()
    {
        $this->answer->decrement('votes');
        $this->votes = $this->answer->votes;
    }

    public function render()
    {
        return view('livewire.vote-button');
    }
}
