<?php

namespace App\Jobs;

use App\Mail\NewListener;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewListenerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $conference_title;
    protected $username;
    protected $conference_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conference_title, $username, $conference_id)
    {
        $this->conference_title = $conference_title;
        $this->username = $username;
        $this->conference_id = $conference_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $reports = Report::with('user')->where('conference_id', $this->conference_id)->get();
        // foreach($reports as $report) {
        //     Mail::to($report->user->email)->send(new NewListener($this->conference_title, $this->username));
        // }
        
        Mail::to('prudnyk_da@groupbwt.com')->send(new NewListener($this->conference_title, $this->username));
    }
}
