<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('triggers', function (Blueprint $table) {
            $table->string('time')->virtualAs("configuration->>'$.fields.time'")->nullable();
            $table->string('weekdays')->virtualAs("configuration->>'$.fields.weekdays'")->nullable();
            $table->index('trigger_type_id');
            $table->index(['time', 'weekdays']);
        });
    }

    public function down(): void
    {
        Schema::table('triggers', function (Blueprint $table) {
            $table->dropIndex(['time', 'weekdays']);
            $table->dropIndex('trigger_type_id');
            $table->dropColumn('weekdays');
            $table->dropColumn('time');
        });
    }
};
