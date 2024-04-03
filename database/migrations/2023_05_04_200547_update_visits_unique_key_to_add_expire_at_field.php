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
            $table->dropUnique(['primary_key', 'secondary_key']);
            $table->unique(['primary_key', 'secondary_key', 'expired_at']);
        });
    }

    public function down(): void
    {
        Schema::table($this->tableName(), function (Blueprint $table) {
            $table->dropUnique(['primary_key', 'secondary_key', 'expired_at']);
            $table->unique(['primary_key', 'secondary_key']);
        });
    }
};
