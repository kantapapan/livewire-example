<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MultiStepForm extends Mailable
{
    use Queueable, SerializesModels;

    public $posts;
    public $requestList;
    public $requestList2;
    public $prefectures;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($posts)
    {
        $this->requestList = config('contact.requests');
        $this->requestList2 = config('contact.requests2');
        $this->prefectures = config('contact.prefectures');
        $this->posts = $posts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('email.multistepform');
    }
}
