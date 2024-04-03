<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function tableName(): string
    {
        return config('visits.table', 'visits');
    }

    public function up(): void
    {
        Schema::table($this->tableName(), function (Blueprint $table) {
            $table->index(['primary_key', 'expired_at']);
            $table->index(['primary_key']);
            $table->index(['expired_at']);
        });
    }

    public function down(): void
    {
        Schema::table($this->tableName(), function (Blueprint $table) {
            $table->dropIndex(['primary_key', 'expired_at']);
            $table->dropIndex(['primary_key']);
            $table->dropIndex(['expired_at']);
        });
    }
};
