<?php

namespace MetricsWave\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use MetricsWave\Users\User;

class UsersWithoutEventsMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $uuid;

    public function __construct(private readonly User $user)
    {
        $this->uuid = $this->user->triggers()->first()->uuid;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'victor@metricswave.com',
            to: $this->user->email,
            subject: 'Do you need help?',
        );
    }

    public function content(): Content
    {
        return (new Content(
            text: 'mail.user_without_events',
        ))
            ->with('uuid', $this->uuid)
            ->with('name', $this->user->first_name);
    }
}
