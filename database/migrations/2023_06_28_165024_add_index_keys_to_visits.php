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

            // Try to add indexes, skip if they already exist (table was created with new schema)
            try {
                Schema::connection('visits')->table($table, function (Blueprint $table) {
                    $table->index(['primary_key', 'expired_at']);
                });
            } catch (\Illuminate\Database\QueryException $e) {
                // Index already exists, skip
            }

            try {
                Schema::connection('visits')->table($table, function (Blueprint $table) {
                    $table->index(['primary_key']);
                });
            } catch (\Illuminate\Database\QueryException $e) {
                // Index already exists, skip
            }

            try {
                Schema::connection('visits')->table($table, function (Blueprint $table) {
                    $table->index(['expired_at']);
                });
            } catch (\Illuminate\Database\QueryException $e) {
                // Index already exists, skip
            }
        }
    }

    public function down(): void
    {
        foreach (Visit::tables() as $table) {
            Schema::connection('visits')->table($table, function (Blueprint $table) {
                $table->dropIndex(['primary_key', 'expired_at']);
                $table->dropIndex(['primary_key']);
                $table->dropIndex(['expired_at']);
            });
        }
    }
};
