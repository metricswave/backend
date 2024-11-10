<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_limits', function (Blueprint $table) {
            $table->id();
            $table->integer('team_id');
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();

            $table->unique(['team_id', 'month', 'year']);
            $table->index(['team_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_limits');
    }
};
