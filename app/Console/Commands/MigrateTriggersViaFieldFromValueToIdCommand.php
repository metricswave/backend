<?php

namespace App\Console\Commands;

use App\Models\Trigger;
use Illuminate\Console\Command;
use MetricsWave\Users\UserService;

class MigrateTriggersViaFieldFromValueToIdCommand extends Command
{
    protected $signature = 'app:triggers-via-field-from-value-to-id';

    protected $description = 'Migrate triggers via field from value to id';

    private array $errors = [];

    public function handle(): int
    {
        $this->info('Migrating triggers via field from value to id');

        $this->withProgressBar(
            Trigger::cursor(),
            function (Trigger $trigger) {
                $viaField = collect($trigger->via)
                    ->map(function ($via) {
                        if (! isset($via['value'])) {
                            return $via;
                        }

                        if ($via['type'] === 'telegram') {
                            $us = UserService::query()->where('channel_id', $via['value'])->first();

                            if (! $us) {
                                $this->errors[] = "User service with channel_id {$via['value']} not found";

                                return $via;
                            }

                            unset($via['value']);
                            $via['id'] = $us->id;
                        }

                        if ($via['type'] === 'mail') {
                            $via['id'] = 0;
                            unset($via['value']);
                        }

                        return $via;
                    });

                $trigger->via = $viaField->toArray();
                $trigger->save();
            }
        );

        $this->newLine(2);

        if (count($this->errors)) {
            $this->error('Errors:');
            foreach ($this->errors as $erro) {
                $this->error($erro);
            }
        } else {
            $this->info('All triggers migrated successfully');
        }

        return self::SUCCESS;
    }
}
