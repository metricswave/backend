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
            Schema::table($table, function (Blueprint $table) {
                $table->dropUnique(['primary_key', 'secondary_key']);
                $table->unique(['primary_key', 'secondary_key', 'expired_at']);
            });
        }
    }

    public function down(): void
    {
        foreach (Visit::tables() as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropUnique(['primary_key', 'secondary_key', 'expired_at']);
                $table->unique(['primary_key', 'secondary_key']);
            });
        }
    }
};
