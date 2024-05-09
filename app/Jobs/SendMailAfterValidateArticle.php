<?php

namespace App\Jobs;

use App\Mail\HeloMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMailAfterValidateArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $listMaterielValider;

    /**
     * Constructs a new instance of the class.
     *
     * @param mixed $listMaterielValider The list of materials to validate.
     */
    public function __construct($listMaterielValider)
    {
        $this->listMaterielValider = $listMaterielValider;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to(['cacsu.mg@gmail.com'])
            ->send(new HeloMail($this->listMaterielValider, $this->listMaterielValider->count()));
    }
}
