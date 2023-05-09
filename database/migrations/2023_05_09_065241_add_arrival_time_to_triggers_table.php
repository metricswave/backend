<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('triggers', function (Blueprint $table) {
            $table->string('arrival_time')->virtualAs("configuration->>'$.fields.arrival_time'")->nullable();
            $table->index(['arrival_time', 'weekdays']);
        });
    }

    public function down(): void
    {
        Schema::table('triggers', function (Blueprint $table) {
            $table->dropIndex(['arrival_time', 'weekdays']);
            $table->dropColumn('arrival_time');
        });
    }
};
