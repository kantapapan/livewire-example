<?php

namespace App\Http\Livewire\SimpleForm;

use Livewire\Component;

class Complete extends Component
{
    public function mount()
    {
        if(empty(session()->get('posts'))){
            return redirect()->route('simple-form-input');
        }

        // セッションクリア
        session()->flush();
    }
    public function render()
    {
        return view('livewire.simple-form.complete')
            ->layout('layouts.form');
    }
}
