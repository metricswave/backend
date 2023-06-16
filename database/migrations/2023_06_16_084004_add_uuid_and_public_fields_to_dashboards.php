<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('dashboards', function (Blueprint $table) {
            $table->after('name', function (Blueprint $table) {
                $table->string('uuid')->nullable();
                $table->boolean('public')->default(false);
            });
        });
    }

    public function down(): void
    {
        Schema::table('dashboards', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->dropColumn('public');
        });
    }
};
