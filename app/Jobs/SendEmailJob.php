<?php

namespace App\Jobs;

use App\Mail\DemoMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailData = [
            'title' => 'Naslov',
            'body' => 'Sadrzaj',
            'subject' => 'Schedule test: '.date("d.m.y"),
            'pdf' => '',
            'filenamepdf'=>'ostvarene_zarade_'.date("d.m.y")
        ];

        Mail::to('dimitrijevicm1997@gmail.com')->send(new DemoMail($mailData));
    }
}
