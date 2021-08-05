<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Complete extends Component
{
    public function mount()
    {
        if(empty(session()->get('posts'))){
            return redirect()->route('home');
        }

        // セッションクリア
        session()->flush();
    }
    public function render()
    {
        return view('livewire.complete');
    }
}
