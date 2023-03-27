<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RoadmapMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly Lead $lead)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->lead->email,
            subject: 'Our roadmap is ready 🗺️',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.roadmap',
            with: [
                'leadUuid' => $this->lead->uuid,
                'hasLicense' => $this->lead->paid_price > 0,
            ],
        );
    }
}
