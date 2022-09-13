<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewListener extends Mailable
{
    use Queueable, SerializesModels;

    protected $conference_title;
    protected $username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conference_title, $username)
    {
        $this->conference_title = $conference_title;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_listener_email')->with([ 'conference_title' => $this->conference_title, 'username' => $this->username ]);
    }
}
