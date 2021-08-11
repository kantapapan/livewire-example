<?php

namespace App\Http\Livewire\OrderForm;

use Livewire\Component;

class Input extends Component
{
    public $posts;
    public $prefectures;
    public $areas;
    public $targetPref;
    
    protected $rules = [
        'posts.prefecture' => 'required',
        'posts.area' => 'required',
    ];

    protected $messages = [
        'posts.*.required' => '必須項目です',
    ];

    public function mount()
    {
        // @NOTE: debug
        $this->targetPref = 'None';

        $this->posts = session()->get('posts');

        $this->prefectures = config('orderform.prefectures');

        if (empty($this->posts["prefecture"])) {
            $this->areas = config('orderform.areas');
            return;
        }

        if ($this->posts["prefecture"] === "1") {
            // 北海道
            $this->areas = config('orderform.hokkaido_areas');
        } else if ($this->posts["prefecture"] === "40") {
            // 福岡
            $this->areas = config('orderform.fukuoka_areas');
        }
    }

    /**
     * 都道府県プルダウン変更イベント処理
     */
    public function onChangePref()
    {

        // @NOTE: debug
        $this->targetPref = $this->posts["prefecture"];

        // NOTE: 北海道の場合
        if ($this->posts["prefecture"] === "1") {
            $this->areas = config('orderform.hokkaido_areas');
            return;
        }
        
        // NOTE: 福岡の場合
        if ($this->posts["prefecture"] === "40") {
            $this->areas = config('orderform.fukuoka_areas');
            return;
        }
    }

    /**
     * 確認
     */
    public function confirm()
    {
        $this->validate();

        session()->put('posts', $this->posts);

        return redirect()->route('order-form-confirm');
    }


    /**
     * レンダリング
     */
    public function render()
    {
        return view('livewire.order-form.input')
            ->layout('layouts.form');
    }
}
