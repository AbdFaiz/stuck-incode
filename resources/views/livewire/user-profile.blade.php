<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfile extends Component
{
    public $user;

    public function mount()
    {
        // Mendapatkan data pengguna yang sedang login
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
