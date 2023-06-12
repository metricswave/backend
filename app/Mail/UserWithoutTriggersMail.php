<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserWithoutTriggersMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'victor@metricswave.com',
            to: $this->user->email,
            subject: 'You have not created any trigger yet! 😱',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.user_without_triggers',
        );
    }
}
