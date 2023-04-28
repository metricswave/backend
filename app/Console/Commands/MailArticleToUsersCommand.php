<?php

namespace App\Console\Commands;

use App\Mail\BlogArticleMail;
use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Statamic\Entries\Entry;

class MailArticleToUsersCommand extends Command
{
    use LeadMailCommand;

    protected $signature = 'app:mail:article {articleId} {email?}';

    protected $description = 'Send blog article to users who have not read it yet.';

    public function handle(): void
    {
        $leads = $this->getMailableLeads($this->argument('email'), $this->mailType());
        $article = Entry::query()->where('collection', 'articles')->find($this->argument('articleId'));

        $this->withProgressBar($leads, function (Lead $lead) use ($article) {
            Mail::queue(new BlogArticleMail($lead, $article));

            MailLog::create([
                'mail' => $lead->email,
                'type' => $this->mailType(),
            ]);
        });
    }

    protected function mailType(): string
    {
        return "blog-article-".$this->argument('articleId');
    }
}
