<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class EditAnswer extends Component
{
    public $answer;
    public $content;

    protected $rules = [
        'content' => 'required|min:10',
    ];

    public function mount(Answer $answer)
    {
        $this->answer = $answer;
        $this->content = $answer->content;
    }

    public function updateAnswer()
    {
        $this->validate();

        if (Auth::id() !== $this->answer->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $this->answer->update(['content' => $this->content]);

        session()->flash('message', 'Answer updated successfully.');

        return redirect()->to(url()->previous());
    }

    public function render()
    {
        return view('livewire.edit-answer');
    }
}
