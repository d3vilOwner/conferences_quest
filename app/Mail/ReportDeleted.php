<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportDeleted extends Mailable
{
    use Queueable, SerializesModels;

    protected $conference_title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conference_title)
    {
        $this->conference_title = $conference_title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.report_deleted_email')->with([ 'conference_title' => $this->conference_title ]);
    }
}
