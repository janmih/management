<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailForMission extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $fullName;
    protected $date_debut;
    protected $date_fin;
    protected $lieu;
    protected $observations;
    /**
     * Create a new message instance.
     */
    public function __construct($fullName, $date_debut, $date_fin, $lieu, $observations)
    {
        $this->fullName = $fullName;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->lieu = $lieu;
        $this->observations = $observations;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mission',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.mission',
            with: [
                'fullName' => $this->fullName,
                'date_debut' => $this->date_debut,
                'date_fin' => $this->date_fin,
                'lieu' => $this->lieu,
                'observations' => $this->observations
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
