<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $object;
    public $token;
    public $url; 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($object, $token)
    {
        $this->object = $object;
        $this->token = $token;
        $this->url = $url = url('recovery?token='.$token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.reset_passwords');
    }
}