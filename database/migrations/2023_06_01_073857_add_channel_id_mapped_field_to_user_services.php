<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_services', function (Blueprint $table) {
            $table->string('channel_id')->virtualAs("service_data->>'$.configuration.channel_id'")->nullable();
            $table->index(['channel_id']);
        });
    }

    public function down(): void
    {
        Schema::table('user_services', function (Blueprint $table) {
            $table->dropIndex(['channel_id']);
            $table->dropColumn('channel_id');
        });
    }
};
