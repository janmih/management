<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\ArticleNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ArticleNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $personnel;
    public $materiels_valider;
    public $materiels_refuser;
    /**
     * Create a new job instance.
     */
    public function __construct($personnel, $materiels_valider, $materiels_refuser)
    {
        $this->personnel = $personnel;
        $this->materiels_valider = $materiels_valider;
        $this->materiels_refuser = $materiels_refuser;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->personnel->email)
            ->cc('cacsu.mg@gmail.com')
            ->send(new ArticleNotification($this->personnel->full_name, collect($this->materiels_valider), collect($this->materiels_refuser)));
    }
}
