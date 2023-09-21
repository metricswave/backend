<?php

namespace MetricsWave\Teams\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use MetricsWave\Teams\TeamInvite;

class TeamInvitedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(readonly public TeamInvite $invite)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💌 You have been invited to '.$this->invite->team->domain.' - MetricsWave',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.team_invite.invited',
        );
    }
}
