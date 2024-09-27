<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class DeleteAnswer extends Component
{
    public $answer;

    public function mount(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function deleteAnswer()
    {
        if (Auth::id() !== $this->answer->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $this->answer->delete();

        session()->flash('message', 'Answer deleted successfully.');

        return redirect()->to(url()->previous());
    }

    public function render()
    {
        return view('livewire.delete-answer');
    }
}
