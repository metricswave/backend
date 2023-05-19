<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_calendars', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('service_id');
            $table->string('calendar_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('background_color')->nullable();
            $table->string('foreground_color')->nullable();
            $table->string('time_zone');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_calendars');
    }
};
