<?php

namespace App\Jobs;

use App\Mail\NewReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $conference_title;
    protected $username;
    protected $topic;
    protected $report_start;
    protected $report_end;
    protected $conference_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conference_title, $username, $topic, $report_start, $report_end, $conference_id)
    {
        $this->conference_title = $conference_title;
        $this->username = $username;
        $this->topic = $topic;
        $this->report_start = $report_start;
        $this->report_end = $report_end;
        $this->conference_id = $conference_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $listereners = UserConference::with('user')->where('conference_id', $this->conferencee_id)->get();
        // foreach($listereners as $listerener) {
        //     if($listerener->user->role === 'Listener') {
        //         Mail::to($listerener->user->email)->send(new NewReport($this->conference_title, $this->username, $this->topic, $this->report_start, $this->report_end));
        //     }
        // }

        Mail::to('prudnyk_da@groupbwt.com')->send(new NewReport($this->conference_title, $this->username, $this->topic, $this->report_start, $this->report_end));
    }
}
