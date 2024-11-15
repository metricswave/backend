<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function tables(): array
    {
        return ['notifications_1989', 'notifications_'.now()->year];
    }

    public function up(): void
    {
        if (app()->environment('production')) {
            return;
        }

        foreach ($this->tables() as $table) {
            Schema::create($table, function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->json('data');
                $table->string('user_parameter')->virtualAs("data->>'$.user_parameter'")->nullable();
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (app()->environment('production')) {
            return;
        }

        foreach ($this->tables() as $table) {
            Schema::dropIfExists($table);
        }
    }
};
