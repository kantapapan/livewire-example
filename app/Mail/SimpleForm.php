<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimpleForm extends Mailable
{
    use Queueable, SerializesModels;

    public $posts;
    public $requestList;
    public $prefectures;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($posts)
    {
        $this->requestList = config('contact.requests');
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
        return $this->text('email.simpleform');
    }
}
