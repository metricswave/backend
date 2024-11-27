<?php

namespace MetricsWave\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeamsWithoutEventsMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        private ?string $triggerUuid,
        private string $ownerName,
        private string $ownerEmail,
        private string $domain,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'victor@metricswave.com',
            to: $this->ownerEmail,
            subject: 'Do you need help?',
        );
    }

    public function content(): Content
    {
        return (new Content(
            text: 'mail.team_without_events',
        ))
            ->with('uuid', $this->triggerUuid)
            ->with('name', $this->ownerName)
            ->with('domain', $this->domain);
    }
}
