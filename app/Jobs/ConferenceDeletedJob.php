<?php

namespace App\Jobs;

use App\Mail\ConferenceDeleted;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ConferenceDeletedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $conference_title;
    protected $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conference_title, $user_id)
    {
        $this->conference_title = $conference_title;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    //    $user = User::find($this->user_id);
        // Mail::to($user->email)->send(new ConferenceDeleted($this->conference_title));
        Mail::to('prudnyk_da@groupbwt.com')->send(new ConferenceDeleted($this->conference_title));
    }
}
