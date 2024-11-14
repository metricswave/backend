<?php

namespace MetricsWave\Metrics\Console\Commands;

use DB;
use Illuminate\Console\Command;

class CreateVisitsTableCommand extends Command
{
    protected $signature = 'visits:create-table {year?}
                            { --execute : Don\'t execute the query }';

    protected $description = 'Create yearly visits table';

    public function handle(): int
    {
        // Get the source and destination table names from the command arguments
        $sourceTable = config('visits.table');
        $destinationTable = config('visits.table_without_year').($this->argument('year') ?? now()->addYearWithOverflow()->format('Y'));

        // Check if the source table exists
        if (! DB::getSchemaBuilder()->hasTable($sourceTable)) {
            $this->error("The source table '{$sourceTable}' does not exist.");

            return self::FAILURE;
        }

        if (DB::getSchemaBuilder()->hasTable($destinationTable)) {
            $this->error("The destination table '{$destinationTable}' already exist.");

            return self::FAILURE;
        }

        // Use raw SQL to create the new table with the same structure
        $sql = "CREATE TABLE {$destinationTable} LIKE {$sourceTable}";

        // Execute the SQL query
        if ($this->option('execute') === true) {
            DB::statement($sql);
            $this->info("Table '{$destinationTable}' created successfully with the structure of '{$sourceTable}'.");
        } else {
            $this->info($sql);
            $this->info('Query not executed');
        }

        return self::SUCCESS;
    }
}
