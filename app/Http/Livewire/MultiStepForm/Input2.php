<?php

namespace App\Http\Livewire\MultiStepForm;

use Livewire\Component;

class Input2 extends Component
{
    public $posts;
    public $requestList2;
    
    protected $rules = [
        'posts.request2' => 'required|array',
    ];

    protected $messages = [
        //'posts.*.required' => '必須項目です',
        'posts.request2.required' => '必須項目です',
    ];

    public function mount()
    {
        $this->requestList2 = config('multistepform.requests2');
        $this->posts = session()->get('posts');
    }

    public function confirm()
    {
        $this->validate();

        session()->put('posts', $this->posts);

        return redirect()->route('multi-step-form-confirm');
    }


    public function render()
    {
        return view('livewire.multi-step-form.input2')
            ->layout('layouts.form');
    }
}
