<?php

namespace App\Jobs;

use App\Mail\ReportDeleted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReportDeletedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $conference_title;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conference_title, $email)
    {
        $this->conference_title = $conference_title;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('prudnyk_da@groupbwt.com')->send(new ReportDeleted($this->conference_title));
    //    Mail::to($email)->send(new ReportDeleted($this->conference_title));
    }
}
