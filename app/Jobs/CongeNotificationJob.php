<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\CongeNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CongeNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;
    /**
     * Create a new job instance.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('dratsiambakaina@yahoo.fr')
            ->cc(['cacsu.mg@gmail.com', $this->name->email])
            ->send(new CongeNotification($this->name->full_name));
    }
}
