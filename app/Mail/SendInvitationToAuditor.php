<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvitationToAuditor extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $fullName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $fullName=null)
    {
        $this->url = $url;
        $this->fullName = $fullName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.auditor.invitation');
    }
}
