<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewComment extends Mailable
{
    use Queueable, SerializesModels;

    protected $conference_title;
    protected $username;
    protected $topic;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conference_title, $username, $topic)
    {
        $this->conference_title = $conference_title;
        $this->username = $username;
        $this->topic = $topic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_comment_email')->with([ 
            'conference_title' => $this->conference_title ,
            'username' => $this->username,
            'topic' => $this->topic 
        ]);
    }
}
