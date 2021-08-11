<?php

namespace App\Http\Livewire\MultiStepForm;

use Livewire\Component;

class Complete extends Component
{
    public function mount()
    {
        if(empty(session()->get('posts'))){
            return redirect()->route('multi-step-form-input');
        }

        // セッションクリア
        session()->flush();
    }
    public function render()
    {
        return view('livewire.multi-step-form.complete')
            ->layout('layouts.form');
    }
}
