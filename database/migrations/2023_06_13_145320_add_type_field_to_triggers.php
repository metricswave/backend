<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('triggers', function (Blueprint $table) {
            $table->string('type')->virtualAs("configuration->>'$.type'")->nullable();
            $table->index(['type']);
        });
    }

    public function down(): void
    {
        Schema::table('triggers', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropColumn('type');
        });
    }
};
