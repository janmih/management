<?php

namespace App\Jobs;

use App\Mail\SendMailForMission;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailer;

class SendMailForMissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to;
    public $fullName;
    public $date_debut;
    public $date_fin;
    public $lieu;
    public $observations;

    /**
     * Create a new job instance.
     */
    public function __construct($to, $fullName, $date_debut, $date_fin, $lieu, $observations)
    {
        $this->to = $to;
        $this->fullName = $fullName;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->lieu = $lieu;
        $this->observations = $observations;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->to)
            ->bcc('cacsu.mg@gmail.com')
            ->send(new SendMailForMission($this->fullName, $this->date_debut, $this->date_fin, $this->lieu, $this->observations));
    }
}
