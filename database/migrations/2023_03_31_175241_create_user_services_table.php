<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('service_id');
            $table->jsonb('service_data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_services');
    }
};
