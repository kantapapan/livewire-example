<?php

namespace App\Http\Livewire\SimpleForm;

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
        $this->requestList = config('simpleform.requests');
        $this->prefectures = config('simpleform.prefectures');
        $this->posts = session()->get('posts');
    }

    public function confirm()
    {
        $this->validate();

        session()->put('posts', $this->posts);

        return redirect()->route('simple-form-confirm');
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
        return view('livewire.simple-form.input')
            ->layout('layouts.form');
    }
}
