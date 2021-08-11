<?php

namespace App\Http\Livewire\MultiStepForm;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\MultiStepForm;
use Illuminate\Support\Arr;

class Confirm extends Component
{

    public $posts;
    public $requestList;
    public $requestList2;
    public $prefectures;

    public function mount()
    {
        $this->requestList = config('multistepform.requests');
        $this->requestList2 = config('multistepform.requests2');
        $this->prefectures = config('multistepform.prefectures');
        $this->posts = session()->get('posts');
        if(empty($this->posts)){
            return redirect()->route('multi-step-form-input');
        }
    }

    public function submit()
    {
        // メール送信
        $recipients = [ 
            Arr::get($this->posts, 'mail'),
            config('app.admin_address')
        ];
        foreach ($recipients as $recipient) {
            Mail::to($recipient)->send(new MultiStepForm($this->posts));
        }

        // 完了画面へ
        return redirect()->route('multi-step-form-complete');
    }

    /**
     * wire:click="back"から呼ばれる
     *
     */
    public function back()
    {
        // 入力画面へ戻る
        return redirect()->route('multi-step-form-input2');
    }

    public function render()
    {
        return view('livewire.multi-step-form.confirm')
            ->layout('layouts.form');
    }
}
