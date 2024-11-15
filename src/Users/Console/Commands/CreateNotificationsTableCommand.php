<?php

namespace MetricsWave\Users\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Database\MySqlConnection;

class CreateNotificationsTableCommand extends Command
{
    protected $signature = 'users:create-notifications-table {year?}
                            { --execute : Don\'t execute the query }';

    protected $description = 'Create yearly notifications table';

    public function handle(): int
    {
        // Get the source and destination table names from the command arguments
        $sourceTable = 'notifications_'.now()->year;
        $destinationTable = 'notifications_'.($this->argument('year') ?? now()->addYearWithOverflow()->format('Y'));

        // Check if the source table exists
        if (! $this->db()->getSchemaBuilder()->hasTable($sourceTable)) {
            $this->error("The source table '{$sourceTable}' does not exist.");

            return self::FAILURE;
        }

        if ($this->db()->getSchemaBuilder()->hasTable($destinationTable)) {
            $this->error("The destination table '{$destinationTable}' already exist.");

            return self::FAILURE;
        }

        // Use raw SQL to create the new table with the same structure
        $sql = "CREATE TABLE {$destinationTable} LIKE {$sourceTable}";

        // Execute the SQL query
        if ($this->option('execute') === true) {
            $this->db()->statement($sql);
            $this->info("Table '{$destinationTable}' created successfully with the structure of '{$sourceTable}'.");
        } else {
            $this->info($sql);
            $this->info('Query not executed');
        }

        return self::SUCCESS;
    }

    private function db(): MySqlConnection
    {
        return DB::connection('visits');
    }
}
