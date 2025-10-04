<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MetricsWave\Metrics\Models\Visit;

class CreateVisitsTable extends Migration
{
    public function up(): void
    {
        foreach (Visit::tables() as $table) {
            if (! Schema::connection('visits')->hasTable($table)) {
                Schema::connection('visits')->create($table, function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->string('primary_key');
                    $table->string('secondary_key')->nullable();
                    $table->unsignedBigInteger('score');
                    $table->json('list')->nullable();
                    $table->timestamp('expired_at')->nullable();
                    $table->timestamps();
                    $table->unique(['primary_key', 'secondary_key', 'expired_at']);
                    $table->index(['primary_key', 'expired_at']);
                    $table->index(['primary_key']);
                    $table->index(['expired_at']);
                });
            }
        }
    }

    public function down(): void
    {
        foreach (Visit::tables() as $table) {
            Schema::connection('visits')->dropIfExists($table);
        }
    }
}
