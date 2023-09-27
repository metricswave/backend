<?php

namespace MetricsWave\Users\Console\Commands;

use App\Console\Commands\LeadMailCommand;
use App\Console\Commands\UserMailCommand;
use App\Mail\BlogArticleMail;
use App\Models\Lead;
use App\Models\MailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use MetricsWave\Users\User;
use Statamic\Entries\Entry;

class MailArticleToUsersCommand extends Command
{
    use LeadMailCommand;
    use UserMailCommand;

    protected $signature = 'app:mail:article {articleId} {email?}';

    protected $description = 'Send blog article to users who have not read it yet.';

    public function handle(): void
    {
        $article = Entry::query()->where('collection', 'articles')->find($this->argument('articleId'));

        $this->mailUsers($article);
        $this->mailLeads($article);
    }

    private function mailUsers($article): void
    {
        $users = $this->getMailableUsers($this->argument('email'), $this->mailType());

        $this->info('Sending to '.count($users).' users.');
        $this->newLine();

        $this->withProgressBar($users, function (User $user) use ($article) {
            Mail::queue(new BlogArticleMail(
                $user->email,
                $article,
                md5($user->email),
            ));

            MailLog::create(['mail' => $user->email, 'type' => $this->mailType()]);
        });

        $this->newLine(2);
    }

    protected function mailType(): string
    {
        return 'blog-article-'.$this->argument('articleId');
    }

    private function mailLeads($article): void
    {
        $leads = $this->getMailableLeads($this->argument('email'), $this->mailType(), avoidUsers: true);

        $this->info('Sending to '.count($leads).' leads.');
        $this->newLine();

        $this->withProgressBar($leads, function (Lead $lead) use ($article) {
            Mail::queue(new BlogArticleMail(
                $lead->email,
                $article,
            ));

            MailLog::create(['mail' => $lead->email, 'type' => $this->mailType()]);
        });
        $this->newLine(2);
    }
}
