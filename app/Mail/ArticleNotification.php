<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ArticleNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $personnel;
    public $materiels_valider;
    public $materiels_refuser;

    /**
     * Create a new message instance.
     */
    public function __construct($personnel, $materiels_valider, $materiels_refuser)
    {
        $this->personnel = $personnel;
        $this->materiels_valider = $materiels_valider;
        $this->materiels_refuser = $materiels_refuser;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification CACSU',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.article-notification',
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
