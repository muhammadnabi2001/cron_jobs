<?php

namespace App\Jobs;

use App\Mail\SendCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Mail;

class SendMessage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $user;
    public $code;
    public function __construct($user,$code)
    {
        $this->code=$code;
        $this->user=$user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new SendCode($this->code));
    }
}
