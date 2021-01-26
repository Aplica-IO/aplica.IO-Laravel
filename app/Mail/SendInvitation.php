<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $residence;
    public $auditor;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($residence,$auditor,$url)
    {
        $this->residence = $residence;
        $this->auditor = $auditor;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.invitation')->subject('¡Invitación a Aplica.io!');
    }
}