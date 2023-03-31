<?php

namespace App\Mail;

use App\Models\Lead;
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

    public function __construct(private readonly Lead $lead, private readonly Entry $article)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->lead->email,
            subject: $this->article->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.blog_article',
            with: [
                'leadUuid' => $this->lead->uuid,
                'article' => $this->article,
            ],
        );
    }
}
