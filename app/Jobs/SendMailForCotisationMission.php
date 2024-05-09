<?php

namespace App\Jobs;

use App\Mail\CotisationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMailForCotisationMission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to;
    public $dates;
    public $montant;
    public $names;
    /**
     * Create a new job instance.
     */
    public function __construct($to, $dates, $montant, $names)
    {
        $this->to = $to;
        $this->dates = $dates;
        $this->montant = $montant;
        $this->names = $names;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->to)
            ->bcc('cacsu.mg@gmail.com')
            ->send(new CotisationMail($this->dates, $this->montant, $this->names));
    }
}
