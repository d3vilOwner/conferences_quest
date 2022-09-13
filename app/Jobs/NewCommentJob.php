<?php

namespace App\Jobs;

use App\Mail\NewComment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $conference_title;
    protected $username;
    protected $topic;
    protected $report_author;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conference_title, $username, $topic, $report_author)
    {
        $this->conference_title = $conference_title;
        $this->username = $username;
        $this->topic = $topic;
        $this->report_author = $report_author;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    //    $user = User::find($report_author);

        Mail::to('prudnyk_da@groupbwt.com')->send(new NewComment($this->conference_title, $this->username, $this->topic));
    //    Mail::to($user->email)->send(new NewComment($this->conference_title, $this->username, $this->topic));
    }
}
