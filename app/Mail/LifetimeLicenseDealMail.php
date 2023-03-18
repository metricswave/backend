<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LifetimeLicenseDealMail extends Mailable
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
            subject: 'Lifetime License Deal Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.lifetime_license_deal',
            with: [
                'leadUuid' => $this->lead->uuid,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
