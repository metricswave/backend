<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Models\MailLog;
use App\Models\Price;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MigratePocketbaseCommand extends Command
{
    protected $signature = 'app:migrate:poketbase';

    protected $description = 'Migrate data from Pocketbase data to the new database.';

    public function handle(): void
    {
        $items = Http::get('https://notifywave.pockethost.io/api/collections/leads/records?perPage=9999')
            ->json('items');

        $this->info('Migrating ' . count($items) . ' leads...');
        $this->withProgressBar($items, function ($item) {
            Lead::updateOrCreate(
                ['email' => $item['email']],
                [
                    'uuid' => $item['id'],
                    'paid_price' => $item['paid_price'],
                    'paid_at' => $item['paid_at'] === '' ? null : $item['paid_at'],
                    'form_filled' => $item['responses'] !== null,
                ]
            );
        });
        $this->line('');
        $this->line('');

        $prices = Http::get('https://notifywave.pockethost.io/api/collections/prices/records?perPage=9999')
            ->json('items');

        $this->info('Migrating ' . count($prices) . ' prices...');
        $this->withProgressBar($prices, function ($item) {
            Price::updateOrCreate(
                ['price' => $item['price']],
                [
                    'remaining' => $item['remaining'],
                    'total_available' => $item['total'],
                ]
            );
        });
        $this->line('');
        $this->line('');

        $mailLogs = Http::get('https://notifywave.pockethost.io/api/collections/mail_logs/records?perPage=9999')
            ->json('items');

        $this->info('Migrating ' . count($mailLogs) . ' mail logs...');
        $this->withProgressBar($mailLogs, function ($item) {
            MailLog::updateOrCreate(
                [
                    'mail' => $item['email'],
                    'type' => $item['mail_type'],
                ]
            );
        });
        $this->line('');
        $this->line('');

        $this->info('✅ Done!');
    }
}
