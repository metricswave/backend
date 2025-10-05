<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MetricsWave\Metrics\Models\Visit;

return new class extends Migration
{
    public function up(): void
    {
        foreach (Visit::tables() as $table) {
            if (! Schema::connection('visits')->hasTable($table)) {
                continue;
            }

            // Try to update the unique index, skip if it doesn't exist (table was created with new schema)
            try {
                Schema::connection('visits')->table($table, function (Blueprint $table) {
                    $table->dropUnique(['primary_key', 'secondary_key']);
                    $table->unique(['primary_key', 'secondary_key', 'expired_at']);
                });
            } catch (\Illuminate\Database\QueryException $e) {
                // Index doesn't exist, skip
            }
        }
    }

    public function down(): void
    {
        foreach (Visit::tables() as $table) {
            Schema::connection('visits')->table($table, function (Blueprint $table) {
                $table->dropUnique(['primary_key', 'secondary_key', 'expired_at']);
                $table->unique(['primary_key', 'secondary_key']);
            });
        }
    }
};
