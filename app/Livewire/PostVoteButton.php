<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostVoteButton extends Component
{
    public $post;
    public $votes;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->votes = $post->votes;
    }

    public function upvote()
    {
        $this->post->increment('votes');
        $this->votes = $this->post->votes;
    }

    public function downvote()
    {
        $this->post->decrement('votes');
        $this->votes = $this->post->votes;
    }

    public function render()
    {
        return view('livewire.post-vote-button');
    }
}
