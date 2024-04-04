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
                $table->index(['primary_key', 'expired_at']);
                $table->index(['primary_key']);
                $table->index(['expired_at']);
            });
        }
    }

    public function down(): void
    {
        foreach (Visit::tables() as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropIndex(['primary_key', 'expired_at']);
                $table->dropIndex(['primary_key']);
                $table->dropIndex(['expired_at']);
            });
        }
    }
};
