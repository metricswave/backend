<?php

namespace MetricsWave\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use MetricsWave\Teams\Team;

class TeamsWithoutEventsMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $uuid;

    public function __construct(private readonly Team $team)
    {
        $this->uuid = $this->team->triggers()->first()->uuid;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'victor@metricswave.com',
            to: $this->team->owner->email,
            subject: 'Do you need help?',
        );
    }

    public function content(): Content
    {
        return (new Content(
            text: 'mail.team_without_events',
        ))
            ->with('uuid', $this->uuid)
            ->with('name', $this->team->owner->name)
            ->with('domain', $this->team->domain);
    }
}
