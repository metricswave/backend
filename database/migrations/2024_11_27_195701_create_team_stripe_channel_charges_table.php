<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_stripe_channel_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('team_id');
            $table->string('charge_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_stripe_channel_charges');
    }
};
