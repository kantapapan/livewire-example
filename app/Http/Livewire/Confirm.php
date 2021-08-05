<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;
use Illuminate\Support\Arr;

class Confirm extends Component
{

    public $posts;
    public $requestList;
    public $prefectures;

    public function mount()
    {
        $this->requestList = config('contact.requests');
        $this->prefectures = config('contact.prefectures');
        $this->posts = session()->get('posts');
        if(empty($this->posts)){
            return redirect()->route('home');
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
            Mail::to($recipient)->send(new Contact($this->posts));
        }

        // 完了画面へ
        return redirect()->route('complete');
    }

    public function back()
    {
        // 入力画面へ戻る
        return redirect()->route('home');
    }
    
    public function render()
    {
        return view('livewire.confirm');
    }
}
