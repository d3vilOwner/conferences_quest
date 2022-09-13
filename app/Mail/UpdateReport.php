<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateReport extends Mailable
{
    use Queueable, SerializesModels;

    protected $conference_title;
    protected $username;
    protected $topic;
    protected $report_start;
    protected $report_end;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conference_title, $username, $topic, $report_start, $report_end)
    {
        $this->conference_title = $conference_title;
        $this->username = $username;
        $this->topic = $topic;
        $this->report_start = $report_start;
        $this->report_end = $report_end;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.update_report_email')->with([ 
            'conference_title' => $this->conference_title,
            'username' => $this->username,
            'topic' => $this->topic,
            'report_start' => $this->report_start,
            'report_end' => $this->report_end,
        ]);
    }
}
