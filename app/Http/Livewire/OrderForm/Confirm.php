<?php

namespace App\Http\Livewire\OrderForm;

use Livewire\Component;
//use Illuminate\Support\Facades\Mail;
//use App\Mail\SimpleForm;
//use Illuminate\Support\Arr;

class Confirm extends Component
{
    public $posts;
    public $prefectures;
    public $areas;

    public function mount()
    {
        $this->prefectures = config('orderform.prefectures');
        $this->areas = config('orderform.areas');
        $this->posts = session()->get('posts');
        if(empty($this->posts)){
            return redirect()->route('order-form-input');
        }
    }

    public function submit()
    {
        // メール送信
        /*
        $recipients = [ 
            Arr::get($this->posts, 'mail'),
            config('app.admin_address')
        ];
        foreach ($recipients as $recipient) {
            Mail::to($recipient)->send(new SimpleForm($this->posts));
        }
         */

        // 完了画面へ
        return redirect()->route('order-form-complete');
    }

    /**
     * wire:click="back"から呼ばれる
     *
     */
    public function back()
    {
        // 入力画面へ戻る
        return redirect()->route('order-form-input');
    }

    public function render()
    {
        return view('livewire.order-form.confirm')
            ->layout('layouts.form');
    }
}
