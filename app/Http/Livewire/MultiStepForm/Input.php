<?php

namespace App\Http\Livewire\MultiStepForm;

use Livewire\Component;

class Input extends Component
{

    public $posts;
    public $requestList;
    public $prefectures;
    
    protected $rules = [
        'posts.name' => 'required',
        'posts.mail' => 'required|email',
        'posts.request' => 'required|array',
    ];

    protected $messages = [
        'posts.*.required' => '必須項目です',
        'posts.mail.email' => '正しいメールアドレスを入力ください',
    ];

    public function mount()
    {
        $this->requestList = config('multistepform.requests');
        $this->prefectures = config('multistepform.prefectures');
        $this->posts = session()->get('posts');
    }

    public function input2()
    {
        $this->validate();

        session()->put('posts', $this->posts);

        return redirect()->route('multi-step-form-input2');
    }

    public function updatedPosts()
    {
        if (empty($this->posts['request'])) {
            return null;
        }

        $this->posts['request'] = array_filter(
            $this->posts['request'],
            function ($value) {
                return $value !== false;
            }
        );
    }

    public function render()
    {
        return view('livewire.multi-step-form.input')
            ->layout('layouts.form');
    }
}
