<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Statamic\Entries\Entry;

class BlogArticleMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly string $mail,
        private readonly Entry $article,
        private readonly ?string $token = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->mail,
            subject: $this->article->title.' - 🌊 MetricsWave Blog'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.blog_article',
            with: [
                'article' => $this->article,
                'token' => $this->token,
            ],
        );
    }
}
