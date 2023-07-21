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
            subject: 'Your tracking code is not working! 😱',
        );
    }

    public function content(): Content
    {
        $triggerUuid = $this->user->triggers()->first()->uuid;

        return new Content(
            markdown: 'mail.user_without_triggers',
            with: [
                'user' => $this->user,
                'script' => '<script defer
    event-uuid="'.$triggerUuid.'"
    src="https://tracker.metricswave.com/js/visits.js">
</script>',
            ],
        );
    }
}
