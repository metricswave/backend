<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BetaAccessMail extends Mailable
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
            from: 'victor@notifywave.com',
            subject: 'You can access now to our beta version! 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.beta_access',
            with: [
                'leadUuid' => $this->lead->uuid,
            ],
        );
    }
}
